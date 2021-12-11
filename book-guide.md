# Symfony: La via rapida.

## Paso 3  Desde cero hasta producción.
### Iniciando proyecto.

1. `symfony new project_name`
    - Crea un projecto basico, sin paquetes extra y aptop para desarrollar cualquier aplicacion.
2. `symfony new project_name --full`
    - Crea un projecto completo con todos los paquetes incluidos.
3. `symfony server:ca:install`
    - Instala el servidor de desarrollo con https.
4. `symfony server:start -d`
    - Inicia el servidor como un demonio.
5. `symfony open:local`
    - Abre el navegador en la direccion donde se esta ejectando el servidor.
6. `symfony server:log`
    - Muestra los logs del servidor

## Paso 5 Solucionando problemas.
### Paquetes para desarrollo
1. `symfony composer require profiler --dev`
    - Instala profiler-pack, util para dpurar el sitio y encontrar errores. Es la barra de abajo y se instalo solamente en entorno de deasarrollo.
2. `symfony composer require logger`
    - Permite tener un registro de eventos.
3. `symfony composer require debug --dev`
    - Obtener mas informacion de errores en entorno de desarrollo.

## TIP
1. `symfony console cache:clear --env=prod`
    - En entorno de produccion la cache se genera y cada vez q se hace una solicitud se envia esa cache, para volver a generar la cache y aceptar algun cambio q haya ocurrido se debe usar el comando anterior.

## Paso 6 Creando nuestra primera página
### Bundles necesarios.
1. `symfony composer require symfony/maker-bundle --dev`
    - Bundle util para la creacion de componentes dentro de la app
2. `symfony console list make`
    - Lista de todos los comandos disponibles con el bundle make
2. `symfony composer require annotations`
    - Bundle para manejar las rutas dentro de la app mediante anotaciones.

### Conocimiento
1. `symfony console make:controller`
    - Crea un controlador, el estandar para llamar el controlador es UpperCamelCase y se usa el prefijo Controller    
2.   `$name = $request->query->get('clave')`
    - Obtener parametro mediante la url (https://127.0.0.1:8000/conference?clave=candado)
3. `@Route("/hello/{name}", name="conference")`
    - Obtiene parametro, la funcion controladora espera el parametro `public function index( string $name ): Response`

## Paso 7 Creando una base de datos con docker.
### Luego de tener instalado docker
1. `docker pull postgres:11-alpine`
    - Descarga la version oficial de postgres con alpine(distribucion linux muy ligera)
2. `docker images`
    - Lista las imagenes descargadas.
3. Creamos el archivo docker-compose.yaml con el siguiente contenido:

        version: '3'

        services:
        database:
            image: postgres:11-alpine
            environment:
            POSTGRES_USER: main
            POSTGRES_PASSWORD: main
            POSTGRES_DB: main
            ports: [5432]

4. En la raiz del proyecto:
    - `docker-compose up -d`
        * Levanta el servicio de postgres como un demonio.
    - `docker-compose ps`
        * Muestra los procesos en ejecucion.
    - `docker-compose stop`
        * Detiene el proceso que se esta ejecutando.
    - `docker-compose start`
        * Una ves que el contenedor este creado se inicia asi.
    - `symfony run psql -c "SELECT 1 + 2"`
        * Probar el acceso a la base de datos desde synfony. Si `psql` no se reconoce como comando hay q instalar `sudo apt install postgresql postgresql-contrib`
    - `symfony var:export`
        * Lista las variables de entorno, se deben ver las credenciales de postgres.

## Paso 8 Definiendo la estrructura de datos

1. `composer require orm`
    - Instalar el paquete Doctrine:
        * Doctrine DBAl: Utilidad para conexion con diferentes motores de BBDD.
        * Doctrine ORM: Manipulacion de datos mediante objetos.
        * Doctrine Migrations: Sincronizar las tablas y sus cambios.

    - Con esta instalacion se crean varios archivos de configuracion en la carpeta config:
        * doctrine_migrations.yaml
        * doctrine.yaml

    - Se crea la carpeta 'migrations' donde vana a parar las clases de migracion.
    - Se crea en 'src' las carpetas:
        * Entity: donde se definen las clases que seran las entidades de nuestra BD.
        * 'Repository' donde estaran las clases encargadas de centralizar las sentencias sql que se realizarn.
    - En el archivo .env se crea la variable de entorno:
        * DATABASE_URL: Con la informacion necesaria para la conexion con la base de datos.

2. Actualizar la url de la BBDD.
    1. Una vez levantado el servidor de BD con docker: `docker-compose start`
    2. `symfony var:export` Lista la variable DATABASE_URL.
    3. La copiamos y actualizamos este valor en el archivo .env.
        * Como el valor del puerto en docker puede cambiar puede ser necesario tener que volver a actualizar este valor. Una solocion es anteponer nuestros comandos con **symfony**(ya conoce las variables de entorno).

3. Para crear las entidades y tablas en la BBDD.
    - `symfony console make:entity`: Crea entidades mediante un proceso al que se le dan los datos necesarios.
        * Si queremos añadir mas campos a una entidad existente se llama por su nombre, detecta que ya existe y empieza el proceso.
    - `symfony console doctrine:schema:create --dump-sql`: Muestra la consulta sql a ejecutar.
    - `symfony console make:migration`: Crea el archivo de migracion en la carpeta *"migrations"*, con los cambios que se realizaran al aplicar la migracion y al quitarla.
    - `symfony console doctrine:migrations:migrate`: Aplica la migracion.

## Paso 9 Configurar el panel de administracion.

1. `symfony composer require "admin:^2.0"`: Instala una version superior a la 2.0 pero inferior a la 3.0. La 3.0 trae mayor soporte pero el libro esta hecho utilizando la version 2.0. Creando los siguientes elementos:
    - *config/pakages/easy_admin.yaml* donde se deben identificar las entidades a ser administradas mediante el panel de administracion.
        * Tiene una sintaxis espacifica con la que se puede personalizar la forma en que se tratan los datos y son representados.
