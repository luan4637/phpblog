# create database
CREATE DATABASE phpblog_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'phpblog_user'@'localhost' IDENTIFIED BY 'phpblog_password';
GRANT ALL PRIVILEGES ON phpblog_db.* TO 'phpblog_user'@'localhost';
FLUSH PRIVILEGES;

# migrate database
php artisan migrate

# create user admin
php artisan db:seed

login email: luan4637@gmail.com
login password: admin

# start server
php artisan serve

# screenshoots
![screenshot](client.png)
![screenshot](clientAdmin.png)