<?php

return [
    // --- AUTENTICACIÓN (AuthController) ---
    'login_success'          => 'Inicio de sesión correcto',
    'credentials_incorrect'  => 'Credenciales incorrectas',
    'register_success'       => 'Usuario registrado correctamente',
    'logout_success'         => 'Sesión cerrada correctamente',

    // --- USUARIOS (UserController) ---
    'user_created'           => 'Usuario creado correctamente',
    'user_not_found'         => 'Usuario no encontrado',
    'user_updated'           => 'Usuario actualizado correctamente',
    'user_deleted'           => 'Usuario eliminado correctamente',

    // --- ROLES (RoleController) ---
    'role_created'           => 'Rol creado correctamente',
    'role_not_found'         => 'Rol no encontrado',
    'role_updated'           => 'Rol actualizado correctamente',
    'role_deleted'           => 'Rol eliminado correctamente',
    'role_name_required'     => 'El nombre del rol es obligatorio.',
    'role_name_unique'       => 'Este rol ya existe.',
    'role_name_unique_other' => 'Ya existe otro rol con este nombre.',

    // --- CATEGORÍAS (CategoryController) ---
    'category_created'       => 'Categoría creada correctamente',
    'category_not_found'     => 'Categoría no encontrada',
    'category_updated'       => 'Categoría actualizada correctamente',
    'category_deleted'       => 'Categoría eliminada correctamente',

    // --- PRODUCTOS (ProductController) ---
    'product_not_found'      => 'Producto no encontrado',
    'product_deleted'        => 'Producto eliminado correctamente',

    // --- PEDIDOS (OrderController) ---
    'user_not_authenticated' => 'Usuario no autenticado',
    'order_creation_error'   => 'Error al crear el pedido',
    'order_created'          => 'Pedido creado correctamente',
    'order_not_found'        => 'Pedido no encontrado',
    'order_updated'          => 'Pedido actualizado correctamente',
    'order_deleted'          => 'Pedido eliminado correctamente',
    'no_orders_found'        => 'No se encontraron pedidos para este usuario',

    // --- DETALLES DE PEDIDO (OrderProductController) ---
    'store_staff_forbidden'  => 'El personal de almacén no puede realizar compras con esta cuenta.',
    'product_not_found_db'   => 'Producto no encontrado en BBDD',
    'product_added_to_cart'  => 'Producto añadido al carrito correctamente',
    'detail_not_found'       => 'Detalle no encontrado',
    'access_denied_item'     => 'Acceso denegado: no puedes ver este item.',
    'detail_updated'         => 'Detalle actualizado correctamente',
    'access_denied_order'    => 'Acceso denegado: no puedes modificar este pedido.',
    'detail_deleted'         => 'Detalle eliminado correctamente',

    // --- PERFIL (ProfileController) ---
    'profile_updated'        => 'Perfil actualizado correctamente',

    // --- API HEALTH ---
    'api_status'             => 'API operativa. El sistema funciona correctamente.',
];
