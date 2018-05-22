# Forum

This is the version v2 of my forum

## Instlation

### Step 1.

> To run this project you must have PHP 7 installed as a prerequisite.

> This project using ide helper package so 2 files will be added after install composer dependencies you are free to add them in `.gitignore` file.
> If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart). 


Begin by cloning this repository to your machine, and  install all composer dependencies.

```bash
git clone https://github.com/alaaDragneel/forum-v2.git
cd "forum-v2" && composer install && npm install
php artisan forumV2:install
npm run dev
```

### Step 2

Next, start the server and visit your forum. If using a tool like Laravel Valet, of course the URL will default to `http://forum-v2.test`. 

1. Visit: `http://forum-v2.test/register` to register a new forum account.
2. Edit: `config/forum-v2.php`, and add any email address that should be for an administrator.
3. Visit: `http://forum-v2.test/admin/channels` to create channels for your forum.