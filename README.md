# Sistema de Gestión de Productos — Minimarket

- **Backend:** Quarkus + Java + API REST
- **Base de Datos:** MySQL en contenedor Docker
- **Frontend:** PHP nativo
- **Característica Principal:** Eliminación lógica (los productos no se borran físicamente, solo se ocultan).

## Requisitos Previos

Antes de empezar, instala los siguientes programas en tu equipo (se recomienda aceptar las opciones por defecto durante la instalación):

* **Docker Desktop** (para ejecutar la base de datos MySQL)  
  [Descargar Docker Desktop](https://www.docker.com/products/docker-desktop/)
* **Java 17** (para ejecutar el servidor backend)  
  [Descargar Java 17 (Adoptium)](https://adoptium.net/)
* **Maven** (para compilar el proyecto)  
  [Descargar Apache Maven](https://maven.apache.org/download.cgi)
* **PHP 8.0 o superior** (para ejecutar el sitio web)  
  [Descargar PHP](https://www.php.net/downloads)
* **Navegador web** (Chrome, Edge, Firefox, etc.)

## Cómo Levantar el Sistema (Paso a Paso)

### Paso 1: Abrir Docker Desktop
1. Busca **Docker Desktop** en el menú Inicio de Windows y ábrelo.
2. Espera a que el indicador muestre **"Docker Desktop is running"** en color verde.
3. Déjalo abierto en segundo plano y continúa.

### Paso 2: Levantar la Base de Datos
1. Abre una terminal o Símbolo del Sistema (`Win + R`, escribe `cmd` y pulsa `Enter`).

2. Entra a la carpeta `docker` de tu proyecto:
   (En mi caso)
   cd C:\Users\Andre\OneDrive\Desktop\Proyectos\continua-rest-h3-andrecandia\docker

3. Ejecuta el contenedor de MySQL:
   docker-compose up -d

4. Verifica que esté activo corriendo:
   docker ps
   *(Debes ver una línea indicando que el contenedor de MySQL está funcionando).*

### Paso 3: Levantar el Backend
1. Abre una **NUEVA terminal** (deja la anterior abierta).

2. Entra a la carpeta principal del proyecto:
   (En mi caso)
   cd C:\Users\Andre\OneDrive\Desktop\Proyectos\continua-rest-h3-andrecandia\backend-quarkus

3. Ejecuta el servidor Quarkus:
   ./mvnw quarkus:dev

4. Espera entre 10 y 30 segundos. Cuando aparezca el siguiente mensaje, el servidor estará listo:
   > `Started continua-h3-andrecandia en ... Listening on: http://localhost:8080`
   
   *(NO cierres esta ventana).*


### Paso 4: Levantar el Frontend
1. Abre una **TERCERA terminal**.

2. Entra a la carpeta del frontend:
   (En mi caso)
   cd C:\Users\Andre\OneDrive\Desktop\Proyectos\continua-rest-h3-andrecandia\frontend

3. Inicia el servidor de desarrollo de PHP:
   php -S localhost:8000

4. Verás la confirmación:
   > `PHP 8.x.x Development Server started`  
   > `Listening on http://localhost:8000`
   
   *(NO cierres esta ventana).*

### Paso 5: Usar la Aplicación
1. Abre tu navegador web.
2. Ingresa a la siguiente dirección:
   http://localhost:8000/index.php
3. Pulsa `Enter` y ya puedes interactuar con el sistema.

## Funcionalidades

- **Listado:** Muestra únicamente los productos activos en el sistema.
- **Agregar Nuevo Producto:** Permite registrar un producto nuevo.
- **Editar:** Modifica la información existente de un producto.
- **Eliminar:** Aplica borrado lógico, ocultando el producto del listado sin eliminarlo físicamente de la base de datos.

## Verificación de la Eliminación Lógica

Cuando eliminas un producto desde la interfaz web, desaparece de la tabla del sistema pero sigue almacenado en MySQL. Puedes comprobarlo manualmente siguiendo estos pasos:

1. Elimina un producto desde el sitio web.

2. Abre la terminal y conéctate al contenedor de MySQL:
   docker exec -it minimarket_mysql mysql -u usuario_minimarket -ppass123 db_minimarket_pro413
   
3. **Ver TODOS los productos** (incluidos los eliminados):
   SELECT id, nombre, eliminado FROM Producto;
   *(El producto eliminado mostrará `eliminado = 1`).*

4. **Ver SOLO los productos activos:**
   SELECT id, nombre, eliminado FROM Producto WHERE eliminado = 0;

5. **Restaurar un producto eliminado:**
   UPDATE Producto SET eliminado = 0 WHERE id = NUMERO_DEL_PRODUCTO;
   *(Al recargar la página web, el producto volverá a aparecer).*

6. **Salir de MySQL:**
   exit;

## Solución de Problemas (ME SUCEDIERON EN EL DESARROLLO)

* **"No se pudo conectar con el servidor":**
  - Verifica que Docker esté abierto y MySQL levantado con `docker-compose up -d`.
  - Reinicia Quarkus (cierra con `Ctrl + C` y vuelve a ejecutar `mvnw.cmd quarkus:dev`).
* **No aparece nada en la página:**
  - Verifica que la terminal esté en la carpeta `frontend` donde se encuentran los archivos `index.php` y `config.php`.
* **"Connection refused":**
  - Ejecuta `docker ps`. Si no aparece MySQL, vuelve a ejecutar `docker-compose up -d`.
* **Error de conexión a la base de datos:**
  - Revisa que las credenciales de acceso coincidan en los archivos `docker-compose.yml` y `application.properties`.

## Cómo Apagar el Sistema

1. **En la ventana de PHP:** Presiona `Ctrl + C`.
2. **En la ventana de Quarkus:** Presiona `Ctrl + C`.
3. **En la ventana de Docker:** Ejecuta:
   docker-compose down
4. Cierra **Docker Desktop** desde la barra de tareas de tu sistema operativo.

## Tecnologías Utilizadas

- **Quarkus 3.40.1**
- **MySQL 8**
- **PHP 8**
- **Docker & Docker Compose**