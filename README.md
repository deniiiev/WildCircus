# WildCircus

git clone https://github.com/magomeddeniev/WildCircus.git

composer install

configure .env.local

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force

php bin/console doctrine:fixtures:load

symfony server:start
