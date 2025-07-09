# アプリケーション名

coachtech フリマアプリ

## 環境構築

- Docker のビルド
  1 git clone git@github.com:kazyuaki/contact-form-test.git
  2 docker-compose up -d --build
  ※MySQL は、OS によって起動しない場合があるので、それぞれの PC に合わせて　 docker-compose.yml ファイルを編集してください。

Laravel 環境構築

1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから.env ファイルを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

メール認証 mailhog

1. .env のメール設定
  MAIL_MAILER=smtp
  MAIL_HOST=mailhog
  MAIL_PORT=1025
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS=null
  MAIL_FROM_NAME="${APP_NAME}"
2. 会員登録後のメール認証画面から 認証メールを送信
3. localhost:8025 mailhogサーバー上で 届いたメールを認証する

決済 stripe
1. https://stripe.com/jp より会員登録 サインイン
2. サイドバー下部 「開発者タブ」→ APIキー 公開可能キーとシークレットキー
3. .env にそれぞれのキーを 貼り付ける
  STRIPE_KEY=
  STRIPE_SECRET=

## 使用技術(実行環境)

・ PHP 8.4.5
・ Laravel 8.x
・ MySQL 8.4.4
・ nginx 1.21.1

## ER 図

![ER図](./Mock-caseER.drawio.png)

## URL

開発環境：http://localhost/
