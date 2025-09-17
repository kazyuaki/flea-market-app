# アプリケーション名
**「coachtech フリマアプリ」**

## 環境構築

#### Docker のビルド
  1. リポジトリをクローン  
    `
    git clone git@github.com:kazyuaki/contact-form-test.git
    `

  2. コンテナをビルド&起動  
    `
    docker-compose up -d --build
    `

  ※MySQL は、OS によって起動しない場合があるので、それぞれの PC に合わせて.  `docker-compose.yml` ファイルを編集してください

#### Laravel 環境構築

1. コンテナに入る
   
    `docker-compose exec php bash`

2. 依存パッケージをインストール
   
    `composer install`

3. 環境変数ファイルをコピー
   
    `cp .env.example env` 

4. アプリケーションキーを生成
   
    `php artisan key:generate`
  
5. マイグレーション
   
    `php artisan migrate`

6. シーディング
   
    `php artisan db:seed`

7. キャッシュクリア・再生成  
   （環境変数や設定を変更した際は実行してください）

    ```
    php artisan config:clear
    php artisan cache:clear
    php artisan config:cache
    ```

#### サンプルアカウント
シーディング後、以下のアカウントでログインできます。

1. 管理者  
   - email: admin@example.com  
   - password: password  

2. ユーザーA（出品者）  
   - email: sellerA@example.com  
   - password: password  <br>
   ※ダミーデータ（商品1〜5の出品者）

1. ユーザーB（出品者）  
   - email: sellerB@example.com  
   - password: password  <br>
   ※ダミーデータ（商品6〜10の出品者）

1. ユーザーC（閲覧専用）  
   - email: viewer@example.com  
   - password: password  <br>
   ※出品商品なし


#### メール認証(Mailhog)

1. .env のメール設定
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```
2. 会員登録後のメール認証画面から 認証メールを送信


3. Mailhog サーバー上で 届いたメールを認証する
- サーバーURL：http://localhost:8025

#### 決済(Stripe)
1. Stripeにサインイン
- 決済(Stripe): https://stripe.com/jp

1. 「開発者タブ」→ APIキーから公開可能キーとシークレットキーを取得
   
2. `.env` に設定
    ```
    STRIPE_KEY="パブリックキー"
    STRIPE_SECRET="シークレットキー"
    ```

以下のリンクは公式ドキュメントです。<br>
https://docs.stripe.com/payments/checkout?locale=ja-JP

## 使用技術(実行環境)
- 言語
  - PHP 8.4.5
  - JavaScript (ES6)

- フレームワーク
  - Laravel 8.x
- サーバー環境
  - MySQL 8.4.4
  - nginx 1.21.1

## テーブル仕様

### Usersテーブル
| カラム名      | 型           | primary key | unique key | not null | foreign key |
| ------------- | ------------ | ----------- | ---------- | -------- | ----------- |
| id            | bigint       | ◯           |            | ◯        |             |
| name          | varchar(255) |             |            | ◯        |             |
| post_code     | varchar(255) |             |            |          |             |
| address       | varchar(255) |             |            |          |             |
| building_name | varchar(255) |             |            |          |             |
| created_at    | timestamp    |             |            |          |             |
| updated_at    | timestamp    |             |            |          |             |


## ER 図
![ER図](./Mock-caseER.drawio.png)

## URL

- 開発環境: http://localhost/
- メール認証(Mailhog): http://localhost:8025
- 決済(Stripe): https://stripe.com/jp

