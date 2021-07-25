# Introduction

This project was implemented using interfaces to be able to switch the character provider without breaking the system.
It's a small proof of what can be done using laravel + livewire, a powerful tool.

# Prerequisites

-   PHP 8.0+
-   Node 16+
-   Yarn

# Installation

1. Create a (Marvel Developer account)[https://developer.marvel.com/documentation/getting_started]
2. Run "cp .env.example .env"
3. Get the developer keys and put on .env file
4. Configure laravel (cache driver)[https://laravel.com/docs/8.x/cache]
5. Run "composer install"
6. Run "php artisan key:generate"
7. Run "yarn dev" to compile assets
8. Run "php artisan serve" to start server
