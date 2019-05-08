# WIP
git reset --hard origin/master
git pull

cd /home/oratta/laradock
sudo docker-compose exec workspace /usr/bin/php /var/www/pritra/artisan config:cache
#sudo docker-compose exec workspace /usr/bin/php /var/www/pritra/artisan route:cache
sudo docker-compose exec workspace /usr/bin/php /var/www/pritra/artisan migrate
