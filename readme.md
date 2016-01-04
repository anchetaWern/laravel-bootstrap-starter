[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=wernancheta&url=https://github.com/anchetaWern/laravel-bootstrap-starter&title=laravel-bootstrap-starter&language=php&tags=github&category=software)

###Laravel Bootstrap Starter

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
4. Execute `php artisan migrate` to create the users table and password_reminders table. Input `y` or `yes` if prompted to confirm.
5. Add `Schickling\Backup\BackupServiceProvider` to service providers on `app/config/app.php` file.
6. Execute `php artisan config:publish schickling/backup` to generate the config file for database backups. 
7. Update database backup config file.
8. Setup cron job for backing up the database by executing the following commands:

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

9. Run the server.

```
php artisan serve --port=1111
```

10. Access from your browser.

```
http://localhost:1111
```

###TODO

- upgrade to laravel 5
- add social login
- use the following packages:
  - dwightwatson/validating
  - barryvdh/laravel-dompdf
  - Xethron/migrations-generator
  - Intervention/image
  - CodeSleeve/asset-pipeline
  - mcamara/laravel-localization

##License

The MIT License (MIT) Copyright (c)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
