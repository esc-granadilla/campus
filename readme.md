# Escuela de Granadilla Norte

El proyecto se trata de la creación de un campus virtual en el cual tanto profesores como alumnos puedan tener una interacción respecto a todo el ámbito académico.

El proyecto es desarrollado para la Escuela Granadilla Norte.

El repositorio se divide en dos partes, una que es el Frontend y otra todo el Backend.


## Primeros Pasos

Para levantar la aplicación debes abrir una terminal en la dentro de la carpeta del proyecto laravel (Backend) así como también dentro de la carpeta de Vue.js (Frontend).

Proceder a instalar los paquetes de dependencias tanto de Composer como de Node.js con los siguientes comandos.

```
composer install
composer update
npm install
npm run build
```

Despues de completada la instalación de paquetes se debe reconfigurar el proyecto y indicar la base de datos mysql que se esta utilizando para poder activar las migraciones de las tablas con los siguientes comandos.

Borrar configuraciones anteriores de otra maquinas.
```
php artisan cache:clear 
php artisan config:clear
```

Ingresar al archivo .env las nuevas configuraciones si el archivo no existe debe crearse a partir del archivo .env.example las configuraciones a cambiar son las siguentes:

```
//////////////////////////////////////////////////////////////////////////////
APP_NAME="Campus Granadilla Norte"    ////Nombre de la aplicación
APP_ENV=local
APP_KEY=base64:z5bzNBanVtYr/3z7SyCtkylwOFildtDjZ/jqeVfceYI=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost:8000

DB_CONNECTION=mysql                //aqui se indica el tipo de base de datos a usar en este caso es mysql
DB_HOST=127.0.0.1                  //la direccion ip de la base de datos en este caso es local
DB_PORT=3306                       //el puerto de la base de datos
DB_DATABASE=esc-granadilla         //el nombre de la base de datos donde se realizara la migracion (La base debe existir)
DB_USERNAME=usuario                //el nombre de usuario de la base de datos
DB_PASSWORD=contraseña             //la contraseña de la base de datos
//////////////////////////////////////////////////////////////////////////////
```

Despues volver a configurar la aplicación con los nuevos datos indicados

```
php artisan config:cache
```

Levantar las migraciones a la base de datos.

```
php artisan migrate
```

Insertar en la base los datos por default:

```
LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Usuario','Otorga permisos a los Estudiantes',1,'2010-01-12 16:50:43',NULL),(2,'Profesor','Otroga permisos a los Maestros en el Sistema',1,'2010-01-12 18:50:43',NULL),(3,'Administrador','Otroga permisos a los Administradores en el Sistema',1,'2010-01-12 17:50:43',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
```

Por ultimo debes levantar el servidor Laravel de la aplicación para poder acceder a ella desde el navegador, esto se puede realizar con el comando.


```
php artisan serve
```


### Prerequisitos

Para probar el sistema debes de tener instalado php, Mysql, Composer, Node.js, Laravel, Vue.js



### Instalación


#### Windows Entorno Laravel

[WAMP o XAMPP](https://styde.net/creando-virtual-hosts-con-apache-en-windows-para-wamp-o-xampp/) - Creación de Virtual Hosts con Apache en Windows para WAMP o XAMPP

[Laragon](https://styde.net/laragon-un-entorno-de-desarrollo-para-laravel-en-windows/) - Laragon, un entorno de desarrollo para Laravel en Windows

#### Linux Entorno Laravel

[LAMP](https://styde.net/como-instalar-lamp-en-ubuntu-linux/) - Cómo instalar LAMP en Ubuntu 14.04 LTS

[Apache](https://styde.net/como-crear-virtual-hosts-con-apache-para-linux-y-mac/) - Creación de Virtual Hosts con Apache para Linux y Mac

#### Instalación de Node.js

[Node.js](https://nodejs.org/es/download/) - Descarga y guía de Instalación de Node.js


## Construido con

* [Laravel](https://laravel.com/docs/5.8) - The web framework used in Backend
* [Vue](https://vuejs.org/v2/guide/) - The web framework used in Frontend
* [Node](https://nodejs.org/es/docs/) - Server Environment
* [Composer](https://getcomposer.org/doc/) - Dependency Management


## Contribuir

Por favor lea [CONTRIBUTING.md](CONTRIBUTING.md) para detalles acerca de la conducta, y procesos para submitting pull requests en el proyecto.


## Versión

El versionamiento utilizado es el Versionado Semántico la aplicación se encuentra en su versión 1.0


## Autores

* **David Campos** - *Initial work* - [Dabakura](https://github.com/Dabakura)
* **Aldo Herrera** - *Initial work* - [AldoHA1](https://github.com/AldoHA1)
* **Franklin Perez** - *Initial work* - [perezcf](https://github.com/perezcf)

Ver toda la lista de [Contribuidores](https://github.com/esc-granadilla/campus/graphs/contributors) quienes han participado en el proyecto.


## Licencia

Este proyecto está bajo la licencia de Fidelitas License  - ver el [LICENSE.md](LICENSE) archivo para más detalles.

