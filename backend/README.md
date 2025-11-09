# 🧩 API Documentation – Backend Laravel (Tienda Online)

> Proyecto Integrado - Creative Shop  
> Backend desarrollado con **Laravel 12**, **PHP 8.3**, y **Sanctum** para autenticación por token.

---

## 🔗 BASE URL

http://127.0.0.1:8000/api

---

## ❤️ Health Check

**Verifica si la API está activa.**

| Método  | Endpoint     | Autenticación | Descripción                      |
|---------|--------------|---------------|----------------------------------|
| GET     | `/health`    | ❌ No         | Devuelve el estado del servidor. |

**Ejemplo de respuesta:**
```json
{
  "ok": true,
  "app": "Laravel",
  "env": "local",
  "laravel": "12.33.0",
  "time": "2025-10-31T22:00:00Z"
}
```

---

## 🔐 Autenticación (Laravel Sanctum)

### 1️⃣ Login

| Método  | Endpoint     | Autenticación | Descripción                              |
|---------|--------------|---------------|------------------------------------------|
| POST    | `/login`     | ❌ No         | Inicia sesión y genera un token Sanctum. |

**Body (JSON):**
```json
{
  "nombre_usuario": "admin@creative.es",
  "password": "12345678"
}
```

**Respuesta exitosa (200):**
```json
{
  "message": "Inicio de sesión correcto",
  "user": {
    "usuario_id": 1,
    "nombre": "Administrador",
    "nombre_usuario": "admin@creative.es",
    "rol_id": 1
  },
  "token": "1|abcdef123456789..."
}
```

---

### 2️⃣ Logout

| Método | Endpoint     | Autenticación | Descripción |
|---------|--------------|---------------|--------------|
| POST    | `/logout`    | ✅ Sí (Token) | Cierra la sesión y elimina el token activo. |

**Headers requeridos:**
```
Authorization: Bearer {token} : "1|abcdef123456789..."
```

**Respuesta (200):**
```json
{ "message": "Sesión cerrada correctamente" }
```


### 🔒 Seguridad y autenticación

El backend usa **Laravel Sanctum** para proteger las rutas sensibles mediante tokens personales.

- Solo los usuarios autenticados pueden crear, editar o eliminar recursos.
- El token se envía en el encabezado HTTP:
```
Authorization: Bearer {token}

```
- Los intentos sin token o con token inválido devuelven:
```json
{ "message": "Unauthenticated." }

---
```
## 🛍️ Productos

| Método  | Endpoint        | Autenticación | Descripción                      |
|---------|-----------------|---------------|----------------------------------|
| GET     | `/products`     | ❌ No         | Lista todos los productos.       |
| GET     | `/products/{id}`| ❌ No         | Muestra un producto específico.  |
| POST    | `/products`     | ✅ Sí (Token) | Crea un nuevo producto.          |
| PUT     | `/products/{id}`| ✅ Sí         | Actualiza un producto existente. |
| DELETE  | `/products/{id}`| ✅ Sí         | Elimina un producto.             |

**Ejemplo POST**
```json
{
  "nombre": "Canon EOS R6 Mark II",
  "cantidad": 3,
  "precio": 2599.00,
  "codigo": "CAM-CAN-R6M2",
  "foto": "https://i.ibb.co/6JG3d98S/Canon-EOS-R6-Mark-II-cuerpo.png",
  "descripcion": "Cámara full-frame profesional.",
  "categoria_id": 1
}
```

**Ejemplo PUT**
```json
{
  "nombre": "Canon EOS R6 Mark II - Actualizado",
  "cantidad": 4,
  "precio": 2499.00
}
```

---

## 🧾 Categorías

| Método    | Endpoint           | Autenticación | Descripción                 |
|-----------|--------------------|---------------|-----------------------------|
| GET       | `/categories`      | ❌ No         | Lista todas las categorías. |
| GET       | `/categories/{id}` | ❌ No         | Muestra una categoría.      |
| POST      | `/categories`      | ✅ Sí         | Crea una categoría.         |
| PUT       | `/categories/{id}` | ✅ Sí         | Actualiza una categoría.    |
| DELETE    | `/categories/{id}` | ✅ Sí         | Elimina una categoría.      |

**Ejemplo POST**
```json
{ "nombre": "Iluminación" }
```

**Ejemplo PUT**
```json
{ "nombre": "Accesorios de iluminación" }
```

---

## 👥 Roles

| Método  | Endpoint      | Autenticación | Descripción                |
|---------|---------------|---------------|----------------------------|
| GET     | `/roles`      | ❌ No         | Lista todos los roles.     |
| GET     | `/roles/{id}` | ❌ No         | Muestra un rol específico. |
| POST    | `/roles`      | ✅ Sí         | Crea un rol nuevo.         |
| PUT     | `/roles/{id}` | ✅ Sí         | Actualiza un rol.          |
| DELETE  | `/roles/{id}` | ✅ Sí         | Elimina un rol.            |

**Ejemplo POST**
```json
{ "nombre": "Atencion al cliente" }
```

## 🧱 Estructura de la base de datos

El sistema se compone de las siguientes tablas principales:

| Tabla                 | Descripción                                         | Relación                              |
|-----------------------|-----------------------------------------------------|---------------------------------------|
| **usuarios**          | Almacena los datos de los usuarios registrados.     | 🔹 1 rol → N usuarios                 |
| **roles**             | Define los tipos de usuario (admin, cliente, etc.). |                                       |
| **categorias**        | Agrupa los productos.                               | 1 categoría → N productos             |
| **productos**         | Información de cada producto.                       | N productos ↔ N pedidos               |
| **pedidos**           | Cabecera de cada pedido.                            | 1 usuario → N pedidos                 |
| **pedidos_productos** | Tabla intermedia con cantidades y precios.          | Detalle N:N entre pedidos y productos |

> Las relaciones se implementan en los modelos de Eloquent usando `belongsTo`, `hasMany` y `belongsToMany`.
---

## 🧑‍💼 Usuarios

| Método  | Endpoint      | Autenticación | Descripción                  |
|---------|---------------|---------------|------------------------------|
| GET     | `/users`      | ✅ Sí         | Lista todos los usuarios.    |
| GET     | `/users/{id}` | ✅ Sí         | Muestra un usuario.          |
| POST    | `/users`      | ✅ Sí         | Crea un nuevo usuario.       |
| PUT     | `/users/{id}` | ✅ Sí         | Actualiza datos del usuario. |
| DELETE  | `/users/{id}` | ✅ Sí         | Elimina un usuario.          |

**Ejemplo POST**
```json
{
  "nombre": "Laura Gómez",
  "nombre_usuario": "laura@creative.es",
  "password": "12345678",
  "foto": "https://randomuser.me/api/portraits/women/15.jpg",
  "rol_id": 3
}
```

---

## 📦 Pedidos

| Método  | Endpoint       | Autenticación | Descripción                          |
|---------|----------------|---------------|--------------------------------------|
| GET     | `/orders`      | ✅ Sí         | Lista todos los pedidos.             |
| GET     | `/orders/{id}` | ✅ Sí         | Muestra un pedido con sus productos. |
| POST    | `/orders`      | ✅ Sí         | Crea un nuevo pedido.                |    
| PUT     | `/orders/{id}` | ✅ Sí         | Actualiza un pedido.                 |
| DELETE  | `/orders/{id}` | ✅ Sí         | Elimina un pedido.                   |

**Ejemplo POST**
```json
{
  "usuario_id": 1,
  "fecha_pedido": "2025-11-01",
  "total_pedido": 499.99
}
```
### ⚙️ Lógica interna del controlador de pedidos

Cada pedido se asocia automáticamente al usuario autenticado mediante el token de Sanctum (`$request->user()`).

El proceso de creación se ejecuta dentro de una **transacción** para garantizar integridad:
1. Se validan los productos enviados en el array `items`.
2. Se calcula el total (`precio × cantidad`).
3. Se crea el pedido en la tabla `pedidos`.
4. Se guardan los productos asociados en la tabla intermedia `pedidos_productos`.

Si algo falla, la transacción se revierte (`DB::rollBack()`), evitando registros incompletos.

**Ejemplo de body JSON para crear un pedido:**
```json
{
  "items": [
    { "producto_id": 6, "cantidad": 1 },
    { "producto_id": 10, "cantidad": 2 }
  ]
}


---

## 📦🔗 Pedidos_Productos (Detalle de pedido)

| Método | Endpoint               | Autenticación | Descripción                            |
|--------|------------------------|---------------|----------------------------------------|
| GET    | `/order-products`      | ✅ Sí         | Lista todos los productos por pedido. |
| POST   | `/order-products`      | ✅ Sí         | Agrega un producto a un pedido.       |
| PUT    | `/order-products/{id}` | ✅ Sí         | Modifica un detalle.                  |
| DELETE | `/order-products/{id}` | ✅ Sí         | Elimina un producto del pedido.       |

**Ejemplo POST**
```json
{
  "pedido_id": 1,
  "producto_id": 3,
  "cantidad": 2,
  "precio_unitario": 2599.00,
  "precio_total": 5198.00
}
```

---

## ⚙️ Headers necesarios en Postman

Para las rutas protegidas:
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

---

## 🧪 Usuarios de prueba

| Rol           | Usuario            | Contraseña   |
|---------------|--------------------|--------------|
| Administrador | admin@creative.es  | 12345678     |
| Almacén       | almacen@creative.es| 12345678     |
| Cliente 1     | jose@creative.es   | 12345678     |
| Cliente 2     | laura@creative.es  | 12345678     |

---

## ✅ Consejos finales

- Asegúrate de tener el servidor corriendo con:
  ```
  php artisan serve
  ```
- Si cambiaste algo en rutas o controladores:
  ```
  php artisan route:clear
  php artisan cache:clear
  ```
- Si los tokens no funcionan, haz logout y login nuevamente.
---
💡**Nota:** 
Toda la API ha sido probada con Postman y utiliza Laravel Sanctum para la autenticación de usuarios mediante tokens personales.
Los endpoints están documentados y funcionan correctamente en entorno local.

---

> ✨ **Autoría:**  
> Proyecto Integrado realizado por **Bárbara Colomer** y **David Márquez Córdoba**  
> CPIFP Alan Turing – 2025  
> 

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
