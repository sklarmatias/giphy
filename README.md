# giphy
Integración con el api giphy

Este proyecto usa las siguientes tecnologías:

1) Composer
2) Laravel 10
3) MySQL
4) Docker
5) Postman (para hacer pruebas manuales con el archivo postman enviado en el email al reclutador)

Debe contarse con el software correspondiente para la ejecución del proyecto

# Pasos de ejecución del proyecto
1) Descargar el repositorio
2) Entrar en directorio giphy
3) Crear archivo .env con los siguientes datos

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:WvZ8a+/dqUxsq4crsqvsEe//NMb7q0JznjmQCvMsbvk=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
#DB_PORT=3306
DB_DATABASE=giphy
DB_USERNAME=sail
DB_PASSWORD=password
FORWARD_DB_PORT=3307

GIPHY_API_KEY=SnfUK2t9gZTA2leY6JkZ0Ma9FxCwIoRA
GIPHY_API_URL_SEARCH=https://api.giphy.com/v1/gifs/search
GIPHY_API_URL_BYID=https://api.giphy.com/v1/gifs/
GIPHY_DEFAULT_LIMIT=25
GIPHY_DEFAULT_OFFSET=0

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

4) Entrar en la consola de comandos
5) Entrar al subdirectorio giphy
6) Generar contenedor Docker con Laravel Sail

./vendor/bin/sail up -d

7) Ejecutar migraciones y generar claves passport

./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan passport:install

8) Una vez realizado esto deberíamos tener un contenedor ejecutándose con la app en el puerto 80

# Nota:
Si bien no se solicita en el test propuesto por el reclutador, yo armé un endpoint extra para poder 
crear usuarios con los cuales probar los endpoints solicitados para el examen.

Por lo tanto, los endpoints que figuran en el archivo postman tienen este extra que debería ejecutarse
en primer lugar.

/api/v1/user/create

# Diagramas DER, Casos de Uso y de Secuencia
Fueron enviados como archivos adjuntos en el email en el que aviso que el proyecto está listo.

# Postman
Se envia como archivo adjunto en el email, una colección de comandos de postman que tienen configurado
como variable global el valor del {{token}} que se obtiene al ejecutar el metodo de login.
Dicho método debe ser ejecutado antes de poder usarse los métodos de busqueda o de marcar favorito ya que
sino la applicación devolverá un error por no estar logueados.
Dicho token dura 30 minutos.
