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

## 使用技術(実行環境)

・ PHP 8.4.5
・ Laravel 8.x
・ MySQL 8.4.4

## ER 図

![ER図](./Mock-caseER.drawio.png)

## URL

開発環境：http://localhost/
