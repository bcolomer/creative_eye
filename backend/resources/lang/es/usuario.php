<?php

return [
    // --- Mensajes de Éxito del Backend (Admin\UserController) ---
    'create_success_msg' => 'Usuario :nombre creado correctamente.',
    'update_success_msg' => 'Usuario :nombre actualizado correctamente.',
    'delete_success_msg' => 'Usuario :nombre eliminado correctamente.',

    // --- Vistas de Lista (index.blade.php) ---
    'index_title' => 'Gestión de Usuarios (Rol: Administrador)',
    'button_create_new' => 'Crear Nuevo Usuario',
    'col_id' => 'ID',
    'col_photo' => 'Foto',
    'col_name' => 'Nombre',
    'col_email' => 'Usuario (Email)',
    'col_role' => 'Rol',
    'col_actions' => 'Acciones',
    'no_photo' => 'Sin foto',
    'no_role' => 'Sin Rol',
    'button_edit' => 'Editar',
    'search_placeholder_user' => 'Buscar por nombre, email o rol...',
    'button_search' => 'Buscar',
    'no_search_results_title' => '¡Vaya! No se encontraron usuarios.',
    'no_search_results_info' => 'Intenta una búsqueda diferente por nombre, email o rol.',

    // --- Vistas de Creación y Edición (create/edit.blade.php) ---
    'create_title' => 'Crear Nuevo Usuario',
    'field_name' => 'Nombre',
    'field_email' => 'Email (Nombre de Usuario)',
    'field_email_info' => 'Email (Nombre de Usuario)',
    'field_role' => 'Rol',
    'select_role' => 'Selecciona un Rol',
    'field_password_optional' => 'Contraseña (Opcional)',
    'field_password_confirm' => 'Confirmar Contraseña',
    'field_photo_url' => 'URL de Foto de Perfil (Opcional)',
    'button_create' => 'Crear Usuario',
    'button_delete_account' => 'Eliminar Cuenta', // Para el botón de borrado en edit.blade.php
    'edit_title_prefix' => 'Editar Usuario:',
    'button_update' => 'Guardar Cambios',
    'advanced_options_title' => 'Opciones Avanzadas (Borrar Cuenta)',
    'confirm_delete_admin_title' => '¿Estás seguro de que quieres eliminar a :nombre?',
    'confirm_delete_admin_info' => 'Esta acción eliminará permanentemente al usuario y sus datos. Esta acción no se puede deshacer.',

];
