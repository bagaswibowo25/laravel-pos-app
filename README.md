## Tentang Aplikasi

Aplikasi POS atau point of sales adalah aplikasi yang digunakan untuk mengelola transaksi pada sebuah toko atau oleh kasir. Aplikasi ini dibuat menggunakan Laravel v8.* dan minimal PHP v7.4 jadi apabila pada saat proses instalasi atau penggunaan terdapat error atau bug kemungkinan karena versi dari PHP yang tidak support.

## Akses Default:

- Superadmin: superadmin@mail.com/superadmin123
- Admin: admin@mail.com/123

## Setup Aplikasi

# Installation Requirement

## Using Docker
[Docker](https://docs.docker.com/engine/install/ubuntu/)
[Docker Compose](https://docs.docker.com/compose/install/linux/)

## Linux

PHP >= 8.1
MYSQL >= 8
Composer

# Run Application

## Using Docker

1. Edit configuration on docker-compose.yaml (Optional)
2. Run application using docker-compose `docker-compose up`
3. Access application on browser at 'localhost:8000'
4. To stop the application run `docker-compose down`

## Manually

1. Run 'composer install'
2. Set database configuration on .env file, copy it from .env.example
3. Run 'php artisan migrate'
4. Run 'php artisan db:seed'
5. Run 'php artisan key:generate'
6. Run 'php artisan storage:link'
7. Run 'php artisan serve --host=0.0.0.0'

## License

[MIT license](https://opensource.org/licenses/MIT)
