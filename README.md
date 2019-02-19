# Install

```bash
git clone git@github.com:gruz/multi-tenancy-voyager-tries.git multi-tenancy-voyager;
git fetch
git checkout wyzoo
git pull
bin/start
bin/login
```

Now we are inside the docker environment.

```bash
composer install;
php artisan vendor:publish --tag=tenancy

php artisan migrate --database=system

composer dump-autoload
php artisan db:seed --class=HostnamesTableSeeder
php artisan voyager:install --with-dummy
php artisan db:seed --class=HostnamesBreadSeeder
php artisan db:seed --class=PermissionRoleTableSeeder


php artisan config:clear
```
