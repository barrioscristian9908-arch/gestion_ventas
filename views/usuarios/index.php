<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔹 SIDEBAR -->
        <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/alert.php"); ?>

            <!-- 🔹 TÍTULO + BOTÓN -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">

                <div>
                    <h4 class="mb-1">👥 Usuarios</h4>
                    <p class="text-muted mb-0">
                        Administrá los usuarios del sistema
                    </p>
                </div>

                <a href="/gestion_ventas/index.php?action=usuarios.crear"
                   class="btn btn-primary">
                    ➕ Nuevo usuario
                </a>

            </div>


            <!-- 🔹 LISTA DE USUARIOS -->
            <div class="card shadow-sm">

                <div class="card-body p-2 p-md-3">

                    <?php if(!empty($usuarios)): ?>

                        <div class="d-flex flex-column gap-2">

                            <?php foreach($usuarios as $u): ?>

                                <div class="border rounded-3 p-3">

                                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

                                        <!-- 🔹 INFORMACIÓN -->
                                        <div class="d-flex align-items-center gap-3">

                                            <!-- Avatar -->
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 45px; height: 45px; min-width: 45px;">

                                                <?= strtoupper(substr($u['nombre'], 0, 1)); ?>

                                            </div>


                                            <!-- Datos -->
                                            <div>

                                                <h6 class="mb-1 fw-semibold">
                                                    <?= htmlspecialchars($u['nombre']); ?>
                                                </h6>

                                                <div class="text-muted small">
                                                    @<?= htmlspecialchars($u['usuario']); ?>
                                                </div>

                                            </div>

                                        </div>


                                        <!-- 🔹 ROL + ESTADO + ACCIONES -->
                                        <div class="d-flex flex-wrap align-items-center gap-2">

                                            <!-- Rol -->
                                            <?php if($u['rol'] === 'admin'): ?>

                                                <span class="badge text-bg-primary">
                                                    Administrador
                                                </span>

                                            <?php elseif($u['rol'] === 'vendedor'): ?>

                                                <span class="badge text-bg-success">
                                                    Vendedor
                                                </span>

                                            <?php else: ?>

                                                <span class="badge text-bg-secondary">
                                                    Operador
                                                </span>

                                            <?php endif; ?>


                                            <!-- Estado -->
                                            <?php if($u['activo'] == 1): ?>

                                                <span class="badge text-bg-success">
                                                    Activo
                                                </span>

                                            <?php else: ?>

                                                <span class="badge text-bg-danger">
                                                    Inactivo
                                                </span>

                                            <?php endif; ?>

                                            <a href="/gestion_ventas/index.php?action=usuarios.editar&id=<?= $u['id']; ?>"
                                            class="btn btn-sm btn-outline-primary">
                                                ✏️ Editar
                                            </a>


                                            <!-- Acción -->
                                            <?php if($u['id'] != $_SESSION['usuario_id']): ?>

                                                <form action="/gestion_ventas/index.php?action=usuarios.estado"
                                                      method="POST"
                                                      class="d-inline">

                                                    <input type="hidden"
                                                           name="id"
                                                           value="<?= $u['id']; ?>">

                                                    <input type="hidden"
                                                           name="activo"
                                                           value="<?= $u['activo'] == 1 ? 0 : 1; ?>">

                                                    <?php if($u['activo'] == 1): ?>

                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('¿Desactivar este usuario?')">
                                                            Desactivar
                                                        </button>

                                                    <?php else: ?>

                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-success">
                                                            Activar
                                                        </button>

                                                    <?php endif; ?>

                                                </form>

                                            <?php else: ?>

                                                <span class="text-muted small">
                                                    Tu usuario
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <!-- 🔹 SIN USUARIOS -->
                        <div class="text-center py-5">

                            <div class="fs-1 mb-2">
                                👥
                            </div>

                            <h5>No hay usuarios registrados</h5>

                            <p class="text-muted mb-3">
                                Todavía no se han creado usuarios en el sistema.
                            </p>

                            <a href="/gestion_ventas/index.php?action=usuarios.crear"
                               class="btn btn-primary">
                                ➕ Crear primer usuario
                            </a>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>
</div>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>