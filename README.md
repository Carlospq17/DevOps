# Instalación

## Dependencias
El proyecto utiliza el manejador de dependencias ```Composer```, es requerido tenerlo instalado para bajar las dependencias del proyecto con el comando
```
composer install
```

## Base de datos Mysql

Descargue la imagen mas reciente de mysql para docker, esto lo puede realizar con el siguiente comando.
* 
```
docker run --name mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD={ingrese una contraseña} -d myql
```
Posterior a esto genere el esquema de la base de datos con la que trabajara la aplicación.
```
CREATE SCHEMA IF NOT EXISTS `{Nombre del esquema}`;
```
## Configuración del proyecto

Renombre el archivo ```.env.example``` a ```.env```, dentro del archivo deberá asignarle valor a las siguientes configuraciones.

### Configuración de base de datos
```
DB_CONNECTION=mysql
DB_HOST={Dirección IP}
DB_PORT={Puerto}
DB_DATABASE= {Nombre de la base de datos}
DB_USERNAME= {Usuario}
DB_PASSWORD= {Contraseña}
```

### Configuración del JwtToken

Proceda a correr el comando ```php artisan jwt:secret ```, esto generara el campo JWT_SECRET. Debajo de este campo agregue el siguiente atributo que controlara el tiempo de expiración de los tokens.

```
JWT_TTL= {Tiempo en minutos} 
```
## Llenar la base de datos

Proceda a ejecutar el siguiente comando para llenar la base de datos con las tablas y registros para el funcionamiento del API

```
php artisan migrate
php artisan db:seed
```

