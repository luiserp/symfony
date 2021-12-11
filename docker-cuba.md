# Instalacion:
    Se instala usando cualquiera de los repositorios existentes.
1. `apt install apparmor-utils apt-transport-https avahi-daemon jq network-manager socat qrencode`
2. `apt install curl net-tools ca-certificates software-properties-common dbus`
3. `apt install docker-ce docker-compose docker-ce-cli containerd.io`

# Imagenes:
1. Crear en /etc/docker/ el fichero daemon.json, nano /etc/docker/daemon.json. Agregar el siguiente contenido:
 
        { 
            "registry-mirrors": [ 
            "https://docker.uclv.cu",
            "https://rw21enj1.mirror.aliyuncs.com",
            "https://dockerhub.azk8s.cn",
            "https://reg-mirror.qiniu.com",
            "https://hub-mirror.c.163.com",
            "https://docker.mirrors.ustc.edu.cn",
            "https://1nj0zren.mirror.aliyuncs.com",
            "https://quay.io",
            "https://docker.mirrors.ustc.edu.cn",
            "http://f1361db2.m.daocloud.io",
            "https://registry.docker-cn.com"
            ]
        }

# Proxy
1. Crear la carpeta docker.service.d
 
2. mkdir -p /etc/systemd/system/docker.service.d
 
3. Creamos el fichero http-proxy.conf, nano /etc/systemd/system/docker.service.d/http-proxy.conf. Dentro agregamos:

        [Service]
        Environment="HTTP_PROXY=http://user:password@proxyip:port/"
        Environment="HTTPS_PROXY=http://user:password@proxyip:port/"
        Environment="NO_PROXY= hostname.example.com,localhost,127.0.0.1"
 
4. Recargamos la config y reinciamos el servicio:

    - `systemctl daemon-reload`
    - `systemctl restart docker`

6. `docker info`

# Comandos Utiles:
1. Corre una imagen de docker

    - `docker run`

2. Mostrar los container que están corriendo

    - `docker ps`

3. Mostrar las imágenes descargadas

    - `docker images`

4. Mostar información de la configuración de Docker

    - `docker info`

5. Traer una imagen

    - `docker pull`

6. Etiquetar una imagen

    - `docker tag`


# Descargar Imagesnes para gardar offline

Desde Github

    En la página de releases en Github https://github.com/jadolg/DockerImageSave/releases escoge el binario correspondiente a tu sistema operativo (Linux/Windows/MacOS(Darwin))
    En el caso de Linux y MacOS dale permisos de ejecución al fichero

## Descargar una imagen

Como ejemplo vamos a descargar la imagen de Alpine linux con el tag 3.9 DockerImageSave -i alpine:3.9

Este comando descargará la imagen en el directorio actual.

unzip alpine_3.9.tar.zip

docker load -i alpine\:3.9.tar

docker images