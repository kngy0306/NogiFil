## コンテナ立ち上げ

```sh
docker-compose up -d --build
```

## Laravel

プロジェクト作成（version 8.x）

```sh
docker-compose exec api composer create-project --prefer-dist laravel/laravel sample "8.*"
```

`localhost:80`にアクセスすると Laravel のウェルカムページが表示される

## React

### 開発用サーバー起動

プロジェクト作成

```sh
docker-compose exec front npx create-react-app . --template typescript
```

```sh
docker-compose exec front yarn start
```

`localhost:3000`にアクセスすると React のウェルカムページが表示される

開発用サーバーの停止は`control + c`

## heroku へデプロイ

```sh
heroku login

heroku create

# herokuダッシュボード上でClearDBのインストール

php artisan key:generate --show

# 上記のキーをセット
heroku config:set APP_KEY=<>
```

Procfile の作成

```sh
cd api

echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile

cd ../
```

composer.json を編集

```json
    "scripts": {
        "post-root-package-install": [
            ---
        ],
        "post-create-project-cmd": [
            ---
        ],
        "post-autoload-dump": [
            ---
        ],
        # 追加
        "compile": [
            "@php -r \"file_exists('.env') || copy('.env.heroku', '.env');\""
        ]
    },
```

heroku へプッシュ

```sh
git subtree push --prefix api/ heroku master
```

MySQL の設定

```sh
# mysql://(DB_USERNAME):(DB_PASSWORD)@(DB_HOST)/(DB_DATABASE)?reconnect=true

$ heroku config:set DB_CONNECTION=mysql
$ heroku config:set DB_HOST=(DB_HOST)
$ heroku config:set DB_PORT=3306
$ heroku config:set DB_DATABASE=(DB_DATABASE)
$ heroku config:set DB_USERNAME=(DB_USERNAME)
$ heroku config:set DB_PASSWORD=(DB_PASSWORD)
```

以下ファイルを編集

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
```

### 参考

【Heroku】Laravel+MySQL で作成したアプリを公開【完全版】  
https://chigusa-web.com/blog/heroku-laravel/

Heroku スターターガイド (Laravel)  
https://devcenter.heroku.com/ja/articles/getting-started-with-laravel

Laravel を Heroku にデプロイするまでに最低限やる事。  
https://mrkmyki.com/laravel%E3%82%92heroku%E3%81%AB%E3%83%87%E3%83%97%E3%83%AD%E3%82%A4%E3%81%99%E3%82%8B%E3%80%82

環境構築からデプロイまで一通りやってみる。  
https://www.grassrunners.net/blog/%E7%92%B0%E5%A2%83%E6%A7%8B%E7%AF%89%E3%81%8B%E3%82%89%E3%83%87%E3%83%97%E3%83%AD%E3%82%A4%E3%81%BE%E3%81%A7%E4%B8%80%E9%80%9A%E3%82%8A%E3%82%84%E3%81%A3%E3%81%A6%E3%81%BF%E3%82%8B%E3%80%82/

## mysqldump

```sh
mysqldump -u nogi_fil -ppassword --no-tablespaces --databases nogi_fil > dump.sql
```

## heroku の MySQL へログイン

```sh
mysql -u (DB_USERNAME) -h (DB_HOST) -p(DB_PASSWORD)
```

collation:utf8mb4_0900_ai_ci

```sql
mysql> SELECT @@character_set_database, @@collation_database;
+--------------------------+----------------------+
| @@character_set_database | @@collation_database |
+--------------------------+----------------------+
| latin1                   | latin1_swedish_ci    |
+--------------------------+----------------------+
1 row in set (0.19 sec)

mysql> show variables like 'character\_set\_%';
+--------------------------+--------+
| Variable_name            | Value  |
+--------------------------+--------+
| character_set_client     | latin1 |
| character_set_connection | latin1 |
| character_set_database   | latin1 |
| character_set_filesystem | binary |
| character_set_results    | latin1 |
| character_set_server     | latin1 |
| character_set_system     | utf8   |
+--------------------------+--------+
7 rows in set (0.18 sec)
```

charset, collation の変更

```sql
ALTER DATABASE <db_name> CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
