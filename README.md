# Laravel5-UrlShortener
自製短網址系統 ( 使用 Laravel 5 &amp; Bootstrap 4 )

資料庫經過測試，支援 SQLite、MySQL、SQL Server(包含 Azure SQL Database) 三種

HTTP Server 可用在 IIS、apache、nginx

目前 Laravel 使用 5.5 版本，所以 PHP 最低版本需 >= 7.0.0

## 如何開始？

從 .env.example 複製一個出來到 .env 並且正確設定資料庫登入資訊、reCAPTCHA 金鑰

`composer instll`

`php artisan key:generate`

`php artisan migrate`

`php artisan db:seed`

`php artisan passport:install`

## 開始使用吧！
預設登入帳號為：demo@domain.com

預設登入密碼為：P@ssw0rd
