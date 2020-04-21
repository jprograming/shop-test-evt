Prueba técnica Evertec: shop-test-evt
===

Requerimientos
===
- PHP 7.3
- PostgreSql 12.1
- Nginx / Apache



Instalación
===

1. Clonar el repositorio
	```shell
	$ git clone https://github.com/jprograming/shop-test-evt.git
	```
2. Crear archivo de entorno

	```shell
	$ cd shop-test-evt
	$ cp env-shop-test-evt .env
	```
5. Instalar la app

	```shell
	# instalar dependencias
	$ composer install
	# crear la base de datos
	$ php bin/console doctrine:database:create
	# ejecutar migraciones
	$ php bin/console doctrine:migrations:migrate 
	# ejecutar fixtures
	$ php bin/console doctrine:fixtures:load --no-interaction 
	```