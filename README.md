# Travoy API

## Installation

1. Install package dependencies

    ```
    composer install
    ```

    On windows, you might want to ignore laravel horizon requirement ([reference](https://github.com/laravel-enso/enso/issues/219#issuecomment-491198253))
    ```
    composer install --ignore-platform-reqs ext-pcntl ext-posix
    ```

2. Configure Environment Variables

    Copy the example configuration file (`.env.example`) as `.env` and tweak it
    to match your local environment configuration.

3. Generate Application KEY

    ```
    php artisan key:generate
    ```

4. Run Database Migration

    ```
    php artisan migrate --seed
    ```

5. Laravel Passport Installation

    ```
    php artisan passport:install
    ```
