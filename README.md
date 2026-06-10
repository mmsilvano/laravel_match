# LaravelMatch

Proof-of-concept dating-style app built with Laravel 13, PHP 8.3, MySQL, Blade, Tailwind CSS v4, Vite, Laravel Breeze, Pest.

## Stack

- PHP 8.3
- Laravel 13
- MySQL
- Blade
- Tailwind CSS v4
- Vite
- Laravel Breeze
- Pest

## Local Install

### 1. Clone repo

```bash
git clone <your-repo-url> laravelmatch
cd laravelmatch
```

### 2. Install deps

```bash
composer install
npm install
```

### 3. Configure env

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` for local MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelmatch
DB_USERNAME=root
DB_PASSWORD=
```

Create DB first:

```sql
CREATE DATABASE laravelmatch;
```

### 4. Build assets

```bash
npm run build
```

### 5. Migrate + seed

```bash
php artisan migrate:fresh --seed
```

### 6. Run app

```bash
php artisan serve
```

Open:

- `http://127.0.0.1:8000`

If using Herd / Valet / custom local vhost, keep `APP_URL=http://laravelmatch.local` and open:

- `http://laravelmatch.local`

## One-shot Setup

Project also ships with Composer setup script:

```bash
composer run setup
php artisan migrate:fresh --seed
php artisan serve
```

## Demo Account

- Email: `demo@laravelmatch.test`
- Password: `password`

Seeder also prints demo login after `php artisan migrate:fresh --seed`.

## Dev Commands

Run full dev stack:

```bash
composer run dev
```

Run tests:

```bash
php artisan test --compact
```

Run formatter:

```bash
vendor/bin/pint --dirty --format agent
```

## CI/CD

GitHub Actions workflow in `.github/workflows/ci-cd.yml` runs:

- Composer install
- Laravel test suite via `php artisan test --compact`

## Troubleshooting

If frontend changes not visible:

```bash
npm run build
```

If Vite manifest error appears:

```bash
npm run build
```
