# Install

```bash
git clone git@github.com:gruz/multi-tenancy-voyager-tries.git multi-tenancy-voyager;
cd multi-tenancy-voyager;
git submodule update --init --recursive;
cd laradock;
cp env-example .env

# Enable PHP exif used by Voyager Media manager
sed -i "s/PHP_FPM_INSTALL_EXIF=false/PHP_FPM_INSTALL_EXIF=true/g" .env

# Run docker containers and login into the workspace container
    # > Building docker containers can take significant time for the first run.
    # > We run adminer container to have a database management UI tool.
        # Available under localhost:8080
        # System: PostgreSQL
        # Server: postgres
        # Username: default
        # Password: secret
docker-compose up -d postgres nginx adminer
docker-compose exec --user=laradock workspace bash
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
