## PrinterOk 

- docker-compose up
- create database mobile

	host: 192.168.99.100
	user: root
	password: root

- docker-compose run phpnginx php artisan migrate
- docker-compose run phpnginx php artisan db:seed
- docker-compose run phpnginx php composer.phar self-update
- docker-compose run phpnginx php composer.phar update
- docker-compose run phpnginx php artisan l5-swagger:generate
- chmod -R 777 storage
- chmod -R 777 bootstrap/cache
- chmod -R 777 public/photos
- chmod -R 777 public/addons
