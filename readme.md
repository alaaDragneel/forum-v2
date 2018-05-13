# Forum

This is the version v2 of my forum

## Instlation

### Step 1.

> To run thiss project you must have PHP 7 installed as a prerequisite.

> This project using ide helper package so 2 files will be added after install composer dependecies you are free to add them in `.gitignore` file.

Begin by cloning this repository to your machine, and  install all composer dependencies.

```bash
git clone https://github.com/alaaDragneel/forum-v2.git
cd "forum-v2" && composer install
mv .env.example .env
php artisan key:generate
```

### Step 2.

Next, create a new database and update the `.env` file with username/pasword and database name, See example below.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forum-v2
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3.
Create any number of channels, Then clean your cache.

```bash
php artisan cache:clear
```