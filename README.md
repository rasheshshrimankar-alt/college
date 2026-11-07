# Smart Campus

Laravel 12 college management website.

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

## Render deployment

See [RENDER_DEPLOYMENT.md](RENDER_DEPLOYMENT.md) for the Docker + PostgreSQL deployment guide.
