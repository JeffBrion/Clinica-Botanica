# Sistema de Gestión de Inventarios - Clínica Botánica

Este proyecto es un sistema de gestión de inventarios desarrollado para la administración de productos, proveedores y entradas en una clínica botánica. El sistema permite visualizar, registrar y gestionar productos con información detallada como precios, cantidades y proveedores asociados.
Fue creado como proyecto para titualación elaborado por Jefferson Briones, Edward Milan Y Eddy Perez 

## Funcionalidades principales

- **Gestión de inventarios**: Visualización de productos disponibles con sus cantidades, precios de compra y venta.
- **Entradas de productos**: Registro de nuevas entradas de productos con detalles como fechas de vencimiento y cantidades.
- **Paginación**: Navegación eficiente a través de grandes volúmenes de datos.
- **Búsqueda dinámica**: Barra de búsqueda para filtrar productos en tiempo real.
- **Relaciones entre entidades**: Gestión de productos vinculados a proveedores y precios.

---
## Tecnologías utilizadas
- **Framework**: Laravel 10
- **Base de datos**: MySQL
- **Frontend**: Blade Templates, Bootstrap
- **Autenticación**: Laravel Sanctum
- **Otros**: JavaScript para interactividad dinámica.

## Instalación del proyecto

Sigue los pasos a continuación para instalar y ejecutar el proyecto en tu máquina local.

### 1. Clonar el repositorio
Primero, clona el repositorio desde GitHub:
```bash
git clone https://github.com/JeffBrion/Clinica-Botanica.git
cd clinica-botanica

### 2. Instalar dependencias
Instala las dependencias de PHP y JavaScript necesarias para el proyecto:
```bash
composer install
npm install
```

### 3. Configurar el archivo `.env`
Copia el archivo de configuración de ejemplo y ajusta las variables de entorno según tu entorno local:
```bash
cp .env.example .env
```
Edita el archivo `.env` para configurar la conexión a la base de datos y otras variables necesarias.

### 4. Generar la clave de la aplicación
Ejecuta el siguiente comando para generar una clave única para la aplicación:
```bash
php artisan key:generate
```

### 5. Migrar la base de datos
Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
```bash
php artisan migrate
```

### 6. Ejecutar el servidor de desarrollo
Inicia el servidor de desarrollo para probar la aplicación localmente:
```bash
php artisan serve
```

### 7. Crear el enlace simbólico para el almacenamiento
Si necesitas acceder a archivos cargados, crea un enlace simbólico al directorio de almacenamiento ejecutando el siguiente comando:
```bash
php artisan storage:link
```
Este paso solo es necesario una vez, a menos que elimines el enlace simbólico o cambies la configuración del almacenamiento.
