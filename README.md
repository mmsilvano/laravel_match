# LaravelMatch

Proof-of-concept dating-style app built with Laravel 13, PHP 8.3, MySQL, Blade, Tailwind CSS v4, Vite, Laravel Breeze, Laravel Sail, Pest.

## Stack

- PHP 8.3
- Laravel 13
- MySQL
- Blade
- Tailwind CSS v4
- Vite
- Laravel Breeze
- Laravel Sail
- Pest

## Sail Setup

Recommended if you want Docker-based local setup.

### 1. Clone repo

```bash
git clone <your-repo-url> laravelmatch
cd laravelmatch
```

### 2. Install PHP deps

```bash
composer install
```

### 3. Configure env

```bash
cp .env.example .env
```

Use Sail DB settings in `.env`:

```env
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravelmatch
DB_USERNAME=root
DB_PASSWORD=admin123
```

### 4. Start Sail

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
```

### 5. Install frontend deps + build

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### 6. Migrate + seed

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Open:

- `http://localhost`

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
DB_PASSWORD=admin123
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

- `http://localhost:8000`

If using `php artisan serve`, keep `APP_URL=http://localhost:8000` in `.env`.

## One-shot Setup

Project ships with shell setup script for non-Sail local setup:

Before run `setup.sh`, set DB username/password in `.env`:

```env
DB_USERNAME=root
DB_PASSWORD=admin123
```

```bash
chmod +x setup.sh
./setup.sh
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

Run tests in Sail:

```bash
./vendor/bin/sail artisan test --compact
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
