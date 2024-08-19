<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

// Obtener la lista de roles usando la clase AbmRol
$abmRoles = new AbmRol();
$roles = $abmRoles->buscar(null);

// Obtener la lista de menús usando la clase AbmMenu
$abmMenus = new AbmMenu();
$menusDisponibles = $abmMenus->buscar(null);
?>

<div class="container mt-5">
    <h2>Administración de Roles</h2>
    
    <!-- Botón para crear un nuevo rol -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearRolModal">
        Crear Rol
    </button>
    
    <!-- Tabla de roles y menús asociados -->
    <h3 class="mt-4">Roles</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Nombre del Rol</th>
                <th scope="col">Menús Asociados</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?php echo $rol->getDescripcion(); ?></td>
                    <td>
                        <?php
                        $abmMenuRol = new AbmMenuRol;
                        $menus = $abmMenuRol->buscar(['idrol' => $rol->getId()]);
                        if ($menus) {
                            $menuNombres = array_map(function($menu) {
                                return $menu->getObjMenu()->getNombre(); // Asumiendo que el objeto `Menu` tiene un método `getNombre()`
                            }, $menus);
                            echo implode(', ', $menuNombres); // Mostrar los nombres de los menús separados por comas
                        } else {
                            echo 'No hay menús asociados';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para crear un nuevo rol -->
<div class="modal fade" id="crearRolModal" tabindex="-1" aria-labelledby="crearRolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearRolModalLabel">Crear Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crearRolForm" action="procesar_creacion_rol.php" method="POST">
                    <div class="mb-3">
                        <label for="nombreRol" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombreRol" name="nombreRol" required>
                    </div>
                    <div class="mb-3">
                        <label for="opcionesMenu" class="form-label">Opciones de Menú</label>
                        <div id="opcionesMenu">
                            <!-- Generar checkboxs dinamicamente para cada menú disponible -->
                            <?php foreach ($menusDisponibles as $menu): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $menu->getId(); ?>" id="menu<?php echo $menu->getId(); ?>" name="menus[]">
                                    <label class="form-check-label" for="menu<?php echo $menu->getId(); ?>">
                                        <?php echo $menu->getNombre(); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Rol</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once "../Estructura/footer.php";
?>
