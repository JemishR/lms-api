Pre requisites
- php, composer

Setup steps for lms-api    (library management system)
- Run composer install
- Check db config like host(please check port),username,pass,dbname in .env and setup or edit accordingly
- Run php artisan migrate
- Run php artisan db:seed
- Run php artisan key:generate
- Run php artisan serve
