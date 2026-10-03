# Digital Thesis Repository

A small thesis repository project developed as a first-semester project at **Life University**.

## Features
* Search theses
* View and download PDF documents
* Submit thesis publication requests
* Approve or reject thesis requests
* Role-based access control
* Admin, Head of Department, and Student
* Thesis and system management

## Technologies
* Laravel
* PHP
* MySQL
* Blade
* HTML / CSS / JavaScript

## Installation
```bash
git clone https://github.com/your-username/thesis-repository.git
cd thesis-repository

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan storage:link

npm run dev
php artisan serve
```

## Note
This is a small version of the Digital Thesis Repository Platform developed as a first-semester project.
