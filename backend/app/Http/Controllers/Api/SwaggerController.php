<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="API de Gestión — Proyecto Integrado",
 *     version="1.0.0",
 *     description="
 *     ## 📘 Descripción general
 *     Esta API está desarrollada en **Laravel 11 + Sanctum**, y permite la gestión completa de usuarios, roles, productos, categorías y pedidos.
 *
 *     ---
 *     ## 🔒 Autenticación
 *     - Usa **Laravel Sanctum** (token tipo *Bearer*).
 *     - Para probar endpoints protegidos, primero realiza un **login** (`/api/login`) y luego haz clic en **Authorize** en la parte superior derecha de Swagger.
 *     - Introduce el token devuelto por el login con el formato:
 *
 *       ```
 *       Bearer TU_TOKEN_AQUI
 *       ```
 *
 *     ---
 *     ## 🧩 Roles y permisos
 *     El middleware `role` controla el acceso según el rol del usuario autenticado:
 *
 *     | Rol                     | ID | Permisos principales                                               |
 *     |-------------------------|----|--------------------------------------------------------------------|
 *     | 🧑‍💼 **Administrador** | 1  | Gestión completa: usuarios, roles, pedidos propios                 |
 *     | 📦 **Almacén**         | 2  | CRUD de productos, categorías y gestión de pedidos                  |
 *     | 🛍️ **Cliente**         | 3  | Puede crear y consultar sus propios pedidos                         |
 *
 *     ---
 *     ## 🚦 Códigos de respuesta comunes
 *     | Código  | Significado                                 |
 *     |---------|---------------------------------------------|
 *     | 200     | Operación exitosa                           |
 *     | 201     | Recurso creado                              |
 *     | 401     | No autenticado (sin token o token inválido) |
 *     | 403     | Acceso denegado (rol no autorizado)         |
 *     | 404     | Recurso no encontrado                       |
 *     | 422     | Error de validación de datos                |
 *     | 500     | Error interno del servidor                  |
 *     ",
 *     @OA\Contact(
 *         name="Equipo de desarrollo",
 *         email="david.marquez.cordoba@gmail.com, barbaracolomer@gmail.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor principal"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Autenticación por token Bearer (Laravel Sanctum)"
 * )
 */
class SwaggerController extends Controller {}
