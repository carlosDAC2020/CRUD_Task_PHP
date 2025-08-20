# Gestor de Tareas con PHP y Docker

Un sistema web básico para la gestión de tareas, construido con un backend en PHP orientado a objetos y un frontend dinámico que se comunica vía AJAX. El proyecto está completamente containerizado con Docker para una configuración y despliegue sencillos.

![Inicio de la aplicación](/doc/image.png)

## ✨ Características

-   **Crear Tareas:** Añade nuevas tareas con título, descripción y fecha límite.
-   **Listado Dinámico:** Visualiza y actualiza la lista de tareas sin recargar la página.
-   **Cambio de Estado:** Marca tareas como `pendientes` o `completadas` con un solo clic.
-   **Eliminar Tareas:** Borra tareas de forma segura con una confirmación previa.
-   **Filtrado:** Filtra la vista de tareas para mostrar `Todas`, `Pendientes` o `Completadas`.

## 💻 Tecnologías Utilizadas

-   **Backend:** PHP 8.2 (Orientado a Objetos) y Servidor Apache.
-   **Base de Datos:** MySQL 8.0 con PDO para la conexión.
-   **Frontend:** HTML5, CSS3, JavaScript con jQuery para peticiones AJAX.
-   **Entorno:** Docker y Docker Compose.

## 🚀 Puesta en Marcha

Para ejecutar este proyecto en tu máquina local, solo necesitas tener Docker y Docker Compose instalados.

### Prerrequisitos

-   [Docker](https://www.docker.com/get-started)
-   [Docker Compose](https://docs.docker.com/compose/install/) (generalmente incluido con Docker Desktop)

### Pasos de Instalación

1.  **Clona el repositorio:**
    ```bash
    git clone https://github.com/carlosDAC2020/CRUD_Task_PHP.git
    cd CRUD_Task_PHP
    ```

2.  **Levanta los contenedores:**
    Ejecuta el siguiente comando en la raíz del proyecto. Docker se encargará de construir las imágenes y crear los contenedores necesarios.
    ```bash
    docker-compose up --build -d
    ```
    El flag `-d` ejecuta los contenedores en segundo plano (detached mode).

3.  **¡Listo! Accede a la aplicación:**
    Abre tu navegador web y visita:
    [**http://localhost:8080**](http://localhost:8080)

    La base de datos y la tabla de tareas se crearán automáticamente la primera vez que se inicie el servicio.

### Comandos Útiles

-   **Para detener la aplicación:**
    ```bash
    docker-compose down
    ```
-   **Para ver los logs en tiempo real:**
    ```bash
    docker-compose logs -f
    ```

## 📁 Estructura del Proyecto

```
.
├── backend/            # Lógica del servidor y API en PHP
├── frontend/           # Interfaz de usuario (HTML, CSS, JS)
└── docker-compose.yml  # Orquestación de los servicios de Docker
```