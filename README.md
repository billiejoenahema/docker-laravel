# docker-laravel

## Build

```bash
git clone https://github.com/billiejoenahema/docker-laravel.git
cd docker-laravel/
cp backend/.env.example backend/.env
docker-compose up -d --build
docker-compose exec app bash
composer install
php artisan key:generate
chown -R www-data:www-data /work
# chmod -R 777 /work/storage
php artisan migrate --seed
npm install
npm run dev
exit
```

```bash
docker-compose exec app npm run watch
```

## Technology

- Laravel 8
- Vue 3.2
- Docker
- MySQL
- Nginx
