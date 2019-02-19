# Install

Add several domains to your hosts file.

```bash
127.0.0.1 voyager.test
127.0.0.1 react1.example.com
127.0.0.1 react1.example.com.voyager.test
127.0.0.1 react2.example.com
127.0.0.1 react2.example.com.voyager.test
```

Clone the repository

```bash
git clone git@github.com:gruz/multi-tenancy-voyager-tries.git multi-tenancy-voyager
cd multi-tenancy-voyager;
git submodule update --init --recursive;
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

Visit system domain http://voyager.test/admin

l: admin@admin.com
p: password

Add a tenant like `react1.example.com` (not like ! `react1.example.com.voyager.test` )
