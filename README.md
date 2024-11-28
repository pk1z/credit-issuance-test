#### Test task DDD application with Symfony 7 and PHP 8.3 

### initial setup

 - ```docker-compose up --build -d``` Startup docker containers
 - ```docker-compose exec php composer install``` Install composer requirements
 - ```docker-compose exec php bin/console doctrine:migration:migrate``` Setup database
 - ```docker-compose exec php vendor/bin/phpunit``` Run unit tests

### usage
 - http://127.0.0.1:8080/api/doc - REST API swagger panel
 - http://127.0.0.1:15672/ - RabbitMQ control panel
