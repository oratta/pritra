# WIP
cd /home/oratta/laradock
sudo docker-compose exec mysql /usr/bin/mysqldump -h localhost -u root --password=root default > dump.sql
rm -f dump.sql

