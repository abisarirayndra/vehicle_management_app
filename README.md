<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Requirement
    - Laravel Version : 8.75
    - PHP version : 7.3
    - Bootstrap 4
    - Database Version : 5.0.12
    - If you want to see the code and download it : https://github.com/abisarirayndra/vehicle_management_app.git
    - Programming Language - Framework : PHP - Laravel 8
    - Composer : https://getcomposer.org/download/
    - XAMPP : https://www.apachefriends.org/download.html
    - Editor : https://code.visualstudio.com/download

# Username dan Password
    - Database, PDM and Activity Diagram : https://drive.google.com/file/d/1j-SofKrOIl-ewJYGnsrLPImDJxpAyiC7/view?usp=share_link
    - Username Database : root
    - Password Database : (blank)
    - List Email and Password
        - admin@gmail.com (pass. 123)
        - manager@gmail.com (pass. 123)
        - manager2@gmail.com (pass. 123)
        - manager3@gmail.com (pass. 123)
        - manager4@gmail.com (pass. 123)
        - manager5@gmail.com (pass. 123)
        - manager6@gmail.com (pass. 123)
        - manager7@gmail.com (pass. 123)
        - manager8@gmail.com (pass. 123)

## How Run The Project
    - Install all the requirements
    - Download the code from github
    - Download database : https://drive.google.com/file/d/1j-SofKrOIl-ewJYGnsrLPImDJxpAyiC7/view?usp=share_link
    - Place the project you've downloaded to C:\xampp\htdocs
    - Extract it
    - Open XAMPP (start APACHE and MySQL)
    - Open VScode
    - Open folder C:\xampp\htdocs on VScode
    - Open the VScode terminal
    - Run "composer install"
    - Run "php artisan key:generate"
    - For check the project running well, open the postman then access "http://localhost/vehicle_management_app-main/public/" method Get will return the original page of Laravel
    - Open phpmyadmin then create new database "data_vehicle_app"
    - Import with data_vehicle_app.sql
    - Open .env.example, edit configuration "DB_DATABASE = data_vehicle_app", "DB_USERNAME=[your phpmyadmin username]", "DB_PASSWORD=[your phpmyadmin password]"
    - Rename .env.example to .env
    - Open VScode Terminal, run "php artisan migrate"
    - Project ready to test

## How to Make Submission for Vehicle
    - Admin 
     - Admin login with registered account
     - Input vehicles and employees
     - Make submission to manager
     
    - Manager
     - Login with registered account
     - check the submission
     - Grant or Deny submission
     
    - Admin
     - Receiving information about granted or denied submission
    
