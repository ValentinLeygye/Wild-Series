# wild-series

Project installation

1. Configure your environment
Duplicate ".env" file and rename the duplicated file ".env.local"

Customize the DATABASE_URL variable.

(Replace user & password in the example below)

DATABASE_URL=mysql://<user>:<password>@127.0.0.1:3306/wildseries?serverVersion=5.7

2. Install PHP dependencies
composer install

3. Import the datas

Remove existing database
php bin/console doctrine:database:drop --force

Create new database
php bin/console doctrine:database:create

Import the database
php bin/console doctrine:database:import db.sql

4. Install JS dependencies
yarn install

5. Build Webpack JS & CSS source files
yarn dev

6. Start dev server
symfony server:start
