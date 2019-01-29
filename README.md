# CodeIgniter API REST 

Descargar o clonar el proyecto desde github.com

`https://github.com/lliccien/codeigniter-api-rest`

Tener instalado docker o un servidor web

Docker

Ejecutar 

`docker-compose up -d`

para levantar el entorno

Ejecutar

`docker-compose exec drupal bash`

para ingresar al contenedor de docker y ejecutar

`composer install`

configure los accesos a la base de datos en el archivo `application/config/database.php`

Para ejecutar la migracion use esta url en un navegador web `http://localhost/migrations`


Importar en Postman la coleccion `codeigniter.postman_collection.json` para hacer las pruebas 


Los Test Unitarios los puede ejecutar con el comando

`vendor/bin/phpunit application/tests/apiUsersTest`

