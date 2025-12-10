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
- [🚨 Checkpoint (10 de Noviembre)](#-checkpoint-10-de-noviembre)
- [🛍️ Sobre nosotros](#️-sobre-nosotros)
- [🎨 Anteproyecto](#-anteproyecto)
  - [🏷️ Título del Proyecto](#️-título-del-proyecto)
  - [👥 Autores del Proyecto](#-autores-del-proyecto)
  - [💡 Descripción del Proyecto](#-descripción-del-proyecto)
  - [🎯 Objetivos](#-objetivos)
  - [🧰 Tecnologías Utilizadas](#-tecnologías-utilizadas)
  - [🧩 Modelo E/R (Propuesta Inicial)](#-modelo-er-propuesta-inicial)
- [🧭 Estado del proyecto](#-estado-del-proyecto)
- [🔗 Enlaces](#-enlaces)
- [ℹ️ Meta](#ℹ️-meta)

---
## 🚨 Checkpoint (10 de Noviembre)

Este es el entregable para la revisión del proyecto.

* **Estado:** Se ha completado el 100% de la API REST del Backend (ver `routes/api.php`) y se ha iniciado la lógica del Frontend (login/logout, carrito, catálogo, productos-detalles).
* **Bitácora (Histórico de Tareas):** https://www.notion.so/Bit-cora-de-tareas-28b35eb2301b8110837dd5badef63061?source=copy_link
* **Vídeo Explicativo (5 min):** > https://youtu.be/XC-a1BShykY

---

## 🛍️ Sobre nosotros

**CREATIVE EYE** es una tienda online especializada en cámaras, lentes, iluminación y accesorios para fotografía y video.  
Nuestro objetivo es ayudarte a capturar tu visión con el mejor equipo y las últimas novedades del mercado.  
🧩 *En desarrollo...*

---

## 🎨 Anteproyecto

### 🏷️ Título del Proyecto
**Creative Eye**

### 👥 Autores del Proyecto
- **Bárbara Colomer**  (Backend - Laravel)
- **David Márquez Córdoba** (Frontend - Angular)

### 💡 Descripción del Proyecto

**Creative Eye** es una aplicación web de comercio electrónico especializada en la venta de cámaras, lentes, trípodes, micrófonos, iluminación y accesorios para fotografía y vídeo.  
El proyecto propone una solución moderna, rápida y accesible, orientada tanto a profesionales como a aficionados, con **arquitectura MVC**, **panel de administración**, **carrito de compras**, **registro de usuarios** y **gestión de pedidos**.  
El diseño será **responsive (mobile first)** y contemplará **buenas prácticas de seguridad, rendimiento y SEO**.

### 🎯 Objetivos

**Objetivo General**  
Desarrollar una tienda online especializada con foco en **experiencia de usuario**, **seguridad** y **mantenibilidad**.

**Objetivos Específicos**
1. Implementar **arquitectura MVC** separando vistas, controladores y lógica de negocio.  
2. Diseñar **interfaz responsive (mobile first)** utilizando **Sass** para estilos escalables.  
3. Crear una **base de datos relacional** para productos, categorías, usuarios y pedidos.  
4. Desarrollar **panel de administración** con operaciones **CRUD** (productos, usuarios, categorías).  
5. Añadir **carrito de compras** y **registro/inicio de sesión** de usuarios.  
6. Aplicar **buenas prácticas de seguridad** (validación, roles, sanitización de datos, etc.).

### 🧰 Tecnologías Utilizadas

| Área | Tecnologías / Herramientas |
|---|---|
| **Frontend** | 🅰️ **Angular 16+** – catálogo, filtros, ficha de producto, carrito, registro/inicio de sesión, zona privada |
| **Backend** | ⚙️ **Laravel** – API REST, autenticación (Sanctum), lógica de negocio, gestión de stock, panel de administración (CRUDs)(Blade)  |
| **Base de datos** | 🗄️ **Relacional** **MySQL**  (productos, categorías, usuarios, pedidos, inventario) |
| **Documentación** | Swagger (L5-Swagger) |
| **Despliegue** | ☁️ **AWS EC2** |
| **Control de versiones** | 🧩 **GitHub y Git** (repositorio y gestión de versiones) |

### 🧩 Modelo E/R (Propuesta Inicial)
<img width="886" height="491" alt="imagen" src="https://github.com/user-attachments/assets/5b6972ee-93c7-4cea-88fe-c039ec0c8418" />

---

## 🧭 Estado del proyecto

🚀 **Commit inicial:** Configuración del repositorio y README.  
🔨 **Repositorio en desarrollo.**  
📦 **Avances alcanzados:**

### ✅ **Backend:**
- API con Laravel configurada.
- Rutas y controladores definidos.
- Sistema de autenticación básico:
    - **Login** y **registro** funcionando.
- Documentación de la API con **Swagger** implementada.
- Estructura de la base de datos definida y migraciones básicas realizadas.
- Seeders y factories en desarrollo.

### ✅ **Frontend:**
- Proyecto Angular (Standalone Components) estructurado y configurado.
- Sistema de **Rutas** (`RouterModule`) implementado con:
    - **Rutas públicas** (`/productos`).
    - **Rutas privadas** protegidas (`/perfil`).
- **Autenticación completa**:
    - **Login** (con guardado de token en `localStorage`).
    - **Logout** (eliminación de token).
    - **AuthGuard** (protección de rutas).
    - **AuthInterceptor** (envío del token a la API).
- **Servicios (`HttpClient`)** creados para consumir la API REST:
    - `AuthService`
    - `ProductService`
- **Catálogo de Productos** implementado:
    - Vista de **Lista** (`/productos`).
    - Vista de **Detalle** (`/producto/:id`) con manejo de 404.
- **Metodología BEM** aplicada para la maquetación HTML.

### ✅ **Otras tareas completadas:**
- Progreso en el diseño y UX/UI con wireframes iniciales.

### ❌ **Tareas por completar:**
- Configuración inicial de **AWS** pendiente de implementación.
- Completar la implementación de **migraciones** y **seeders** en el backend.
- Finalizar el **diseño** del frontend y realizar pruebas de funcionalidad.
- **Despliegue** del backend y frontend en **AWS**.
- Terminación de la **documentación Swagger** y **README** completo del proyecto.

---

## 🔗 Enlaces
- 🧱 **Anteproyecto en Notion:** https://www.notion.so/Anteproyecto-Creative-Eye-2860500081b480628336ce9c20084e42?source=copy_link
- ⬆️ **Diseño User-Flow (FigJam):** https://www.figma.com/board/7Qe10sug08n89GTVjrrzBJ/UserFlow?node-id=0-1&t=mJzCm8YDNegGWkGT-1
- 📱 **Presentación del prototipo:** https://www.figma.com/proto/dYl9XWz1XQDyvj7OmnrKw0/Proyecto-TFG?node-id=72-570&p=f&t=rtxvLnMmATTED3Yf-1&scaling=contain&content-scaling=fixed&page-id=0%3A1&starting-point-node-id=72%3A570
- 🖼️ **Diseño (Prototipo Alta/Baja Fidelidad & Átomos/UI kit):** https://www.figma.com/design/dYl9XWz1XQDyvj7OmnrKw0/Proyecto-TFG?node-id=0-1&t=ZibFGd2dniqvjKd0-1
- 📝 **Presentación PDF (Entrega Final):** https://1drv.ms/b/c/154c4a205c4d6e44/EXH8U7NGRNBCpPtqlgRNIWkBjT1raq8gwEglBAijzGbKrw?e=rHgaYw
- 📹 **Vídeo checkpoint (5 min):** https://youtu.be/XC-a1BShykY
- 🎬 **Vídeo Final (10 min):** 

---

## ℹ️ Meta
📅 **Versión:** 0.5 *(En desarrollo)*  
💼 **Autores:** Barbara Colomer, David Marquez Cordoba  
🌐 **Sitio web:** www.creative-eye.com  
📧 **Contacto:** barbaracolomer@gmail.com, david.marquez.cordoba@gmail.com  

> “Captura el momento. Crea tu visión.”



