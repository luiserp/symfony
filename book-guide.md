# Symfony: La via rapida.

## Paso 3
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

## Paso 5
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

## Paso 6
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
    
2.   `$request->query->get('clave')`
    - Obtener parametro mediante la url(https://127.0.0.1:8000/conference?clave=candado).
