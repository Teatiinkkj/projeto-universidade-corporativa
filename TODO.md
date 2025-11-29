# TODO: Implement Admin-Only "Administrador" Role Assignment

## Tasks
- [x] Modify v1/assets/admin/html/admin.php to check current user's cargo and conditionally display "Administrador" option in edit form
- [x] Update v1/assets/api/admin/editar_usuario.php to validate that only admins can set cargo to "Administrador"
- [x] Test the implementation with admin and non-admin users
- [x] Fix gender field mapping from database values ("M"/"F") to select options ("masculino"/"feminino")
- [x] Restrict "Administrador" role assignment to admins only when creating new users
- [x] Implement dynamic role selection in new user creation form based on current user's permissions

## Progress
- [x] Analyze existing code and database schema
- [x] Create implementation plan
- [x] Get user approval for plan
- [x] Implement frontend changes
- [x] Implement backend validation
