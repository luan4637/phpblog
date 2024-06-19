#create database
CREATE DATABASE phpblog_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'phpblog_user'@'localhost' IDENTIFIED BY 'phpblog_password';
GRANT ALL PRIVILEGES ON phpblog_db.* TO 'phpblog_user'@'localhost';
FLUSH PRIVILEGES;

#migrate database
php artisan migrate

#start server
php artisan serve 