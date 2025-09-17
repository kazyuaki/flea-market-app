// public/js/transaction.js

(() => {
  // 取引IDごとにドラフトを分ける
  const root = document.getElementById("transaction-root");
  if (!root) return;

  const txId = root.getAttribute("data-transaction-id") || "unknown";
  const userId = root.getAttribute("data-user-id") || "guest";
  const KEY = `txDraft:${txId}:${userId}`; 

  const form = document.getElementById("transaction-form");
  const input = document.getElementById("message-input");
  if (!form || !input) return;

  // ===== 復元 =====
  const serverOld = (input.value || "").trim();
  if (!serverOld) {
    const draft = localStorage.getItem(KEY);
    if (draft !== null) {
      input.value = draft;
    }
  }

  // ===== 保存 =====
  let t = null;
  const saveDraft = () => {
    try {
      localStorage.setItem(KEY, input.value);
    } catch {}
  };
  const onInput = () => {
    if (t) clearTimeout(t);
    t = setTimeout(saveDraft, 200);
  };
  input.addEventListener("input", onInput);

  // Enter で送信したい場合の補助（Shift+Enter で改行したいならここを調整）
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter" && !e.shiftKey) {
      // 1行入力なのでデフォは送信、改行は Shift+Enter
      e.preventDefault();
      form.requestSubmit();
    }
  });

  // ===== 送信時はドラフトを削除 =====
  form.addEventListener("submit", () => {
    try {
      localStorage.removeItem(KEY);
    } catch {}
  });

  // ページ離脱時も最新を保存
  window.addEventListener("beforeunload", saveDraft);
})();

// ===== モーダル外クリックで閉じる =====
// ===== モーダル外クリックで閉じる =====
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('complete-modal');
  if (!modal) return;

  modal.addEventListener('click', (e) => {
    const dialog = modal.querySelector('.modal__dialog');
    // ダイアログ外（= 背景）をクリックしたときだけ閉じる
    if (!dialog || !dialog.contains(e.target)) {
      // 方法1: ハッシュを空にして :target を外す（hashchange が発生）
      if (location.hash) {
        location.hash = '';              // まず hash をクリア
        // （オプション）URLをきれいに戻したい場合は replaceState で “#” も除去
        setTimeout(() => {
          history.replaceState(null, document.title, location.pathname + location.search);
        }, 0);
      }
      // 代替案: 存在しないIDへ（例: "#!"）→ :target マッチなし
      // location.hash = '#!';
    }
  });
});