# 🎥📸 Welcome to **CREATIVE EYE** Repository

     ██████╗██████╗ ███████╗ █████╗ ████████╗██╗██╗   ██╗███████╗
    ██╔════╝██╔══██╗██╔════╝██╔══██╗╚══██╔══╝██║██║   ██║██╔════╝
    ██║     ██████╔╝█████╗  ███████║   ██║   ██║██║   ██║█████╗
    ██║     ██╔══██╗██╔══╝  ██╔══██║   ██║   ██║╚██╗ ██╔╝██╔══╝
    ╚██████╗██║  ██║███████╗██║  ██║   ██║   ██║ ╚████╔╝ ███████╗
     ╚═════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝   ╚═╝   ╚═╝  ╚═══╝  ╚══════╝
   
                    ███████╗██╗   ██╗███████╗
                    ██╔════╝╚██╗ ██╔╝██╔════╝
                    █████╗   ╚████╔╝ █████╗  
                    ██╔══╝    ╚██╔╝  ██╔══╝  
                    ███████╗   ██║   ███████╗
                    ╚══════╝   ╚═╝   ╚══════╝

> _“Capturando ideas, creando visión.”_
<p align="center">Tu tienda online de cámaras, fotografía y video</p>

---

## 📚 Índice
- [🚀 Despliegue en AWS (Live Demo)](#-despliegue-en-aws-live-demo)
- [🛍️ Sobre nosotros](#️-sobre-nosotros)
- [🎨 Anteproyecto](#-anteproyecto)
  - [🏷️ Título del Proyecto](#️-título-del-proyecto)
  - [👥 Autores del Proyecto](#-autores-del-proyecto)
  - [💡 Descripción del Proyecto](#-descripción-del-proyecto)
  - [🎯 Objetivos](#-objetivos)
  - [🧰 Tecnologías Utilizadas](#-tecnologías-utilizadas)
  - [🧩 Modelo E/R (Propuesta Inicial)](#-modelo-er-propuesta-inicial)
- [🧭 Estado del proyecto](#-estado-del-proyecto)
- [📸 Galería de la Interfaz](#-galería-de-la-interfaz)
- [🛠️ Guía de Ejecución Local](#️-guía-de-ejecución-local)
- [🔗 Enlaces](#-enlaces)
- [ℹ️ Meta](#ℹ️-meta)

---
## 🚀 Despliegue en AWS (Live Demo)

El proyecto se encuentra **completamente desplegado** en una instancia EC2 de Amazon Web Services, asegurado con certificados SSL.

| Entorno | URL | Descripción |
| :--- | :--- | :--- |
| **Tienda (Frontend)** | [https://creative-eye.duckdns.org](https://creative-eye.duckdns.org) | Aplicación Cliente (Angular 18) |
| **Panel Admin (Back)** | [https://creative-eye-admin.duckdns.org](https://creative-eye-admin.duckdns.org) | API REST & Dashboard Gestión (Laravel 11) |

> **Nota:** Para acceder al panel de administración se requiere un usuario con rol `Admin` o `Almacén`.

---

## 🛍️ Sobre nosotros

**CREATIVE EYE** es una tienda online especializada en cámaras, lentes, iluminación y accesorios para fotografía y video.  
Nuestro objetivo es ayudarte a capturar tu visión con el mejor equipo y las últimas novedades del mercado.  
🧩 *Proyecto finalizado y desplegado en entorno de producción.*

---

## 🎨 Anteproyecto

### 🏷️ Título del Proyecto
**Creative Eye**

### 👥 Autores del Proyecto
- **Bárbara Colomer** (Backend - Laravel)
- **David Márquez Córdoba** (Frontend - Angular)

### 💡 Descripción del Proyecto

**Creative Eye** es una aplicación web de comercio electrónico especializada en la venta de cámaras, lentes, trípodes, micrófonos, iluminación y accesorios para fotografía y vídeo.  
El proyecto propone una solución moderna, rápida y accesible, orientada tanto a profesionales como a aficionados, con **arquitectura MVC**, **panel de administración**, **carrito de compras**, **registro de usuarios** y **gestión de pedidos**.  
El diseño será **responsive (mobile first)** y contemplará **buenas prácticas de seguridad, rendimiento y SEO**.

### 🎯 Objetivos Alcanzados

**Objetivo General** Desarrollar una tienda online especializada con foco en **experiencia de usuario**, **seguridad** y **mantenibilidad**.

**Objetivos Específicos Completados**
1. ✅ Implementación de **API RESTful** con autenticación basada en Tokens (Sanctum).
2. ✅ Desarrollo de interfaz Frontend con **Angular 18** y **Sass (BEM)**.
3. ✅ Gestión de base de datos relacional (Usuarios, Productos, Roles, Pedidos).
4. ✅ Panel de Administración híbrido (Blade) para gestión interna.
5. ✅ Despliegue en producción en **AWS EC2** con configuración de Apache y SSL.
6. ✅ Implementación de carrito de compras persistente y gestión de perfiles.

### 🧰 Tecnologías Utilizadas

| Área | Tecnologías / Herramientas |
|---|---|
| **Frontend** | 🅰️ **Angular 16+** – catálogo, filtros, ficha de producto, carrito, registro/inicio de sesión, zona privada |
| **Backend** | ⚙️ **Laravel** – API REST, autenticación (Sanctum), lógica de negocio, gestión de stock, panel de administración (CRUDs)(Blade)  |
| **Base de datos** | 🗄️ **Relacional** **MySQL** (productos, categorías, usuarios, pedidos, inventario) |
| **Documentación** | Swagger (L5-Swagger) |
| **Despliegue** | ☁️ **AWS EC2** |
| **Control de versiones** | 🧩 **GitHub y Git** (repositorio y gestión de versiones) |

### 🧩 Modelo E/R (Propuesta Inicial)
<img width="886" height="491" alt="imagen" src="https://github.com/user-attachments/assets/5b6972ee-93c7-4cea-88fe-c039ec0c8418" />

---

## 🧭 Estado del proyecto

 ✅ **COMPLETADO** 📦 **Avances alcanzados:**

### ✅ **Backend (Completado):**
- API con Laravel configurada y optimizada para producción.
- Rutas y controladores definidos con Middlewares de roles (Admin, Almacén, Cliente).
- Sistema de autenticación robusto mediante **Laravel Sanctum**.
    - **Login** y **registro** funcionando.
- Documentación de la API con **Swagger** implementada.
- Estructura de la base de datos definida y migraciones completas.
- Seeders y factories para poblar la base de datos con datos de prueba realistas.
- Completar la implementación de **migraciones** y **seeders** en el backend.

### ✅ **Frontend (Completado):**
- Proyecto Angular (Standalone Components) estructurado y configurado.
- Sistema de **Rutas** (`RouterModule`) implementado con lazy loading y guards:
    - **Rutas públicas** (`/productos`, `/home`).
    - **Rutas privadas** protegidas (`/perfil`, `/orders`).
- **Autenticación completa**:
    - **Login** (con persistencia segura de token y usuario).
    - **Logout** (limpieza de estado y redirección).
    - **AuthGuard** (protección de rutas según estado de sesión).
    - **AuthInterceptor** (inyección automática del Bearer Token en cabeceras).
- **Servicios (`HttpClient`)** optimizados para consumir la API REST:
    - `AuthService`, `ProductService`, `CartService`.
- **Catálogo de Productos** implementado:
    - Vista de **Lista** (`/productos`) con diseño responsive.
    - Vista de **Detalle** (`/producto/:id`) con manejo de errores 404.
- **Metodología BEM** aplicada rigurosamente para una maquetación CSS mantenible y modular.
- Finalizar el **diseño** del frontend y realizar pruebas de funcionalidad.

### ✅ **Infraestructura AWS (Completado):**
- **Despliegue** del backend y frontend en **AWS**.
- Instancia EC2 configurada desde cero.
- Configuración de Virtual Hosts en Apache para servir Backend y Frontend en puertos distintos/dominios distintos.
- Instalación de certificados SSL (HTTPS) para ambos subdominios.
- 
### ✅ **Otras tareas completadas:**
- Progreso en el diseño y UX/UI con wireframes iniciales.
- **Despliegue Completo:** Backend y Frontend operativos en AWS EC2 con SSL y dominio personalizado.
- Terminación de la **documentación Swagger** y **README** completo del proyecto.

---

## 📸 Galería de la Interfaz

A continuación se muestra una vista previa del funcionamiento de la aplicación en sus versiones de escritorio y móvil.

### 📱 Diseño Mobile First & Responsive
Nuestra interfaz se adapta fluidamente a cualquier dispositivo gracias al uso de Flexbox, Grid y media queries SCSS.

| Vista Móvil |
|:---:|
|<img width="327" height="711" alt="m-Landing page-registrado" src="https://github.com/user-attachments/assets/5f9398a4-33f7-4cbe-a983-d22ab61d28e8" />  <img width="328" height="716" alt="m-Login" src="https://github.com/user-attachments/assets/52324d8c-20f3-42c6-b0c0-5da858a2d676" />  <img width="328" height="717" alt="m-Tienda" src="https://github.com/user-attachments/assets/4d0a83b1-532b-4e51-bd3b-59ca800dd5aa" />  <img width="329" height="715" alt="m-detalle-producto" src="https://github.com/user-attachments/assets/2d3be77a-7c61-4b30-87e5-3dcf29499b27" />  <img width="330" height="712" alt="m-detalle-producto2" src="https://github.com/user-attachments/assets/9d8cd763-3a09-4f76-9e47-795f8aa38a88" />|

### 🖥️ Experiencia de Escritorio
Interfaz limpia y clara para facilitar la navegación del usuario.

| Vesrsión escritorio |
|:---:|
| <img width="1625" height="884" alt="Landing page-registrado" src="https://github.com/user-attachments/assets/1b43269c-67db-48c6-a794-57d3bcf0afb0" /> <img width="1445" height="710" alt="detalle-producto2" src="https://github.com/user-attachments/assets/77d438c7-aaf2-454b-be3b-727b1d9863da" />
<img width="1510" height="882" alt="Panel-admin-usuarios" src="https://github.com/user-attachments/assets/275e3af6-1299-4270-814d-612ffd233f05" /> <img width="1388" height="833" alt="Tienda" src="https://github.com/user-attachments/assets/149e01b7-6369-4f4c-afa6-6bee0015b0b7" />
<img width="1575" height="864" alt="Panel-admin-usuarios-detalle" src="https://github.com/user-attachments/assets/81cba813-d208-46f9-b3ff-fb7af3e37887" />|

### 🛒 Gestión del Carrito
<p align="center">
  <img width="1508" height="794" alt="Modal-carrito" src="https://github.com/user-attachments/assets/28b0bd80-aae8-44f8-94af-387fe5f00ab7" /> <img width="1450" height="672" alt="Carrito2" src="https://github.com/user-attachments/assets/6b88fe8a-b451-46cb-92d1-560d8ed6c861" />
  <br><em>El carrito mantiene el estado de la compra incluso si se recarga la página.</em>
</p>

---

## 🛠️ Guía de Ejecución Local

Si deseas clonar y ejecutar este proyecto en tu máquina local para desarrollo o pruebas, sigue estos pasos.

### Prerrequisitos
Asegúrate de tener instalado:
* **Node.js** (v20+) y NPM (v10)+.
* **PHP** (v8.3+) y Composer (v2.8+).
* **LARAVEL** (v12.3+).
* **MySQL** ejecutándose.
* **Angular CLI** (v18+): `npm install -g @angular/cli`

### 1. Configuración del Backend (API)

```bash
# Entra en la carpeta del backend
cd backend

# Instala las dependencias de PHP
composer install

# Configura las variables de entorno
cp .env.example .env
# IMPORTANTE: Abre el archivo .env y configura tus credenciales de BBDD (DB_DATABASE, DB_USERNAME, etc.)

# Genera la clave de encriptación
php artisan key:generate

# Ejecuta las migraciones y los seeders (datos de prueba)
php artisan migrate --seed

# Levanta el servidor local
php artisan serve

```

### 2. Configuración del Frontend (Cliente)

```bash
# Abre una nueva terminal y entra en la carpeta del frontend
cd frontend

# Instala las librerías de Node
npm install

# Inicia el servidor de desarrollo
ng serve
```
### 🔐 Acceso al Sistema
Una vez levantado el entorno, puedes registrarte como un nuevo usuario desde el formulario de registro (/registro) para probar el rol de Cliente.

## 🔗 Enlaces de Interés
- 🧱 **Anteproyecto en Notion:** [Ver Documento](https://www.notion.so/Anteproyecto-Creative-Eye-2860500081b480628336ce9c20084e42?source=copy_link)
- ⬆️ **Diseño User-Flow (FigJam):** [Ver Diagrama](https://www.figma.com/board/7Qe10sug08n89GTVjrrzBJ/UserFlow?node-id=0-1&t=mJzCm8YDNegGWkGT-1)
- 🖼️ **Diseño UI (Figma):** [Ver Prototipo](https://www.figma.com/design/dYl9XWz1XQDyvj7OmnrKw0/Proyecto-TFG?node-id=0-1&t=ZibFGd2dniqvjKd0-1)
- 📝 **Presentación PDF (Entrega Final):** [Descargar PDF](https://1drv.ms/b/c/154c4a205c4d6e44/EXH8U7NGRNBCpPtqlgRNIWkBjT1raq8gwEglBAijzGbKrw?e=rHgaYw)
- 🎬 **VÍDEO DE DEMOSTRACIÓN (10 min):** *[Inserte enlace aquí]*
---

## ℹ️ Meta
📅 **Fecha de Entrega:** 10 de Diciembre de 2025  
💼 **Autores:** Bárbara Colomer & David Márquez Córdoba  
🌐 **Sitio web:** [creative-eye.duckdns.org](https://creative-eye.duckdns.org)  
📧 **Contacto:** barbaracolomer@gmail.com, david.marquez.cordoba@gmail.com

> “Captura el momento. Crea tu visión.”









