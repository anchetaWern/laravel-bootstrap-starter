The starter site that I use for my Laravel 4 projects. 

###Features

- signup
- login/logout
- update account settings (email, password)
- password reminder
- database backup

###Dependencies

- [Composer](https://getcomposer.org/) - for installing/updating dependencies
- [Carbon](https://github.com/briannesbitt/Carbon)
- [Laravel Backup](https://github.com/schickling/laravel-backup)


###How to Use

1. Clone the project with `git clone` or download as zip file then extract.
2. `cd` into the project directory then execute `composer install`. This will install all the dependencies
of the project.
3. `cd` into the `app` directory and configure `database.php` and `mail.php`.
4. Add `Schickling\Backup\BackupServiceProvider` to service providers on `app/config/app.php` file.
5. Execute `php artisan config:publish schickling/backup` to generate the config file for database backups. 
6. Update database backup config file.
7. Setup cron job for backing up the database by executing the following commands:

```
sudo crontab -e
0 8 * * * /usr/bin/php /home/ubuntu/www/artisan db:backup
```

If you want to upload to an amazon s3 bucket, generate the config file:

```
php artisan config:publish aws/aws-sdk-php-laravel
```

Edit the configuration file at `app/config/packages/aws/aws-sdk-php-laravel/config.php` to include your s3 bucket details:

```
return array(
    'key'         => 'YOUR_AWS_ACCESS_KEY_ID',
    'secret'      => 'YOUR_AWS_SECRET_KEY',
    'region'      => 'us-west-1',
    'config_file' => null,
);
```

If you don't know where your amazon credentials are, they are in the [security credentials](https://console.aws.amazon.com/iam/home?#security_credential) page.

Once that's done simply replace `your-bucket` with the name of your s3 bucket:

```
0 8 * * * /usr/bin/php /home/ubuntu/www/artisan db:backup --upload-s3 your-bucket
```
