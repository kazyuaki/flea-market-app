// public/js/transaction.js

(() => {
  // 取引IDごとにドラフトを分ける
  const root = document.getElementById("transaction-root");
  if (!root) return;

  const txId = root.getAttribute("data-transaction-id") || "unknown";
  const KEY = `txDraft:${txId}`;

  const form = document.getElementById("transaction-form");
  const input = document.getElementById("message-input");
  if (!form || !input) return;

  // ===== 復元 =====
  // Blade の old('body') が入っていなければ、localStorage のドラフトを復元
  const serverOld = (input.value || "").trim();
  if (!serverOld) {
    const draft = localStorage.getItem(KEY);
    if (draft !== null) {
      input.value = draft;
    }
  }

  // ===== 保存 =====
  // 入力イベントを監視して 200ms デバウンスで保存
  let t = null;
  const saveDraft = () => {
    try {
      localStorage.setItem(KEY, input.value);
    } catch { /* storage が埋まっている等は無視 */ }
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

  // （お好み）ページ離脱時も最新を保存
  window.addEventListener("beforeunload", saveDraft);
})();

// ===== モーダル外クリックで閉じる =====
document.addEventListener("click", (e) => {
  const modal = document.querySelector(".modal:target");
  if (!modal) return;

  const dialog = modal.querySelector(".modal__dialog");
  if (dialog && !dialog.contains(e.target)) {
    // 外側をクリックしたら閉じる（ハッシュを削除）
    history.pushState("", document.title, window.location.pathname + window.location.search);
  }
});