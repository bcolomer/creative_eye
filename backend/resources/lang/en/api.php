<?php

return [
    // --- AUTHENTICATION (AuthController) ---
    'login_success'          => 'Login successful',
    'credentials_incorrect'  => 'Incorrect credentials',
    'register_success'       => 'User registered successfully',
    'logout_success'         => 'Session closed successfully',

    // --- USERS (UserController) ---
    'user_created'           => 'User created successfully',
    'user_not_found'         => 'User not found',
    'user_updated'           => 'User updated successfully',
    'user_deleted'           => 'User deleted successfully',

    // --- ROLES (RoleController) ---
    'role_created'           => 'Role created successfully',
    'role_not_found'         => 'Role not found',
    'role_updated'           => 'Role updated successfully',
    'role_deleted'           => 'Role deleted successfully',
    'role_name_required'     => 'The role name is required.',
    'role_name_unique'       => 'This role already exists.',
    'role_name_unique_other' => 'Another role with this name already exists.',

    // --- CATEGORIES (CategoryController) ---
    'category_created'       => 'Category created successfully',
    'category_not_found'     => 'Category not found',
    'category_updated'       => 'Category updated successfully',
    'category_deleted'       => 'Category deleted successfully',

    // --- PRODUCTS (ProductController) ---
    'product_not_found'      => 'Product not found',
    'product_deleted'        => 'Product deleted successfully',

    // --- ORDERS (OrderController) ---
    'user_not_authenticated' => 'User not authenticated',
    'order_creation_error'   => 'Error creating the order',
    'order_created'          => 'Order created successfully',
    'order_not_found'        => 'Order not found',
    'order_updated'          => 'Order updated successfully',
    'order_deleted'          => 'Order deleted successfully',
    'no_orders_found'        => 'No orders found for this user',

    // --- ORDER DETAILS (OrderProductController) ---
    'store_staff_forbidden'  => 'Warehouse staff cannot make purchases with this account.',
    'product_not_found_db'   => 'Product not found in database',
    'product_added_to_cart'  => 'Product added to cart successfully',
    'detail_not_found'       => 'Detail not found',
    'access_denied_item'     => 'Access denied: you cannot view this item.',
    'detail_updated'         => 'Detail updated successfully',
    'access_denied_order'    => 'Access denied: you cannot modify this order.',
    'detail_deleted'         => 'Detail deleted successfully',

    // --- PROFILE (ProfileController) ---
    'profile_updated'        => 'Profile updated successfully',

    // --- API HEALTH ---
    'api_status'             => 'API operational. System is working correctly.',
];
