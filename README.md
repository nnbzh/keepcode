## Keepcode
```
git pull
composer i
vendor/bin/sail artisan up -d
vendor/bin/sail artisan migrate
vendor/bin/sail artisan db:seed
```

Rental finish and unbooking in a job classes. Default expiry time 10 mins


```
php artisan schedule:run
php artisan queue:listen
```
