Pre requisites
- php, composer

Setup steps for lms-api    (library management system)
- Run composer install
- Check db config like host(please check port),username,pass,dbname in .env.example and setup or edit accordingly
- Rename .env.example to .env
- Run php artisan migrate
- Run php artisan db:seed
- Run php artisan serve
