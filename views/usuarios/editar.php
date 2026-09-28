<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔹 SIDEBAR -->
        <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/sidebar.php"); ?>


        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/alert.php"); ?>


            <div class="row justify-content-center">

                <div class="col-12 col-lg-7 col-xl-6">

                    <!-- 🔹 TÍTULO -->
                    <div class="mb-4">

                        <a href="/gestion_ventas/index.php?action=usuarios"
                           class="text-decoration-none text-muted small">
                            ← Volver a usuarios
                        </a>

                        <h4 class="mt-2 mb-1">
                            ✏️ Editar usuario
                        </h4>

                        <p class="text-muted mb-0">
                            Modificá los datos de la cuenta.
                        </p>

                    </div>


                    <!-- 🔹 TARJETA -->
                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-4 p-md-5">

                            <!-- 🔹 AVATAR -->
                            <div class="text-center mb-4">

                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 75px; height: 75px; font-size: 2rem;">
                                    👤
                                </div>

                                <h5 class="mt-3 mb-1">
                                    <?= htmlspecialchars($usuario['nombre']); ?>
                                </h5>

                                <small class="text-muted">
                                    Editando información del usuario
                                </small>

                            </div>


                            <!-- 🔹 FORMULARIO -->
                            <form action="/gestion_ventas/index.php?action=usuarios.update"
                                  method="POST">

                                <!-- ID -->
                                <input type="hidden"
                                       name="id"
                                       value="<?= $usuario['id']; ?>">


                                <!-- Nombre -->
                                <div class="mb-3">

                                    <label for="nombre" class="form-label fw-semibold">
                                        Nombre completo
                                    </label>

                                    <input type="text"
                                           id="nombre"
                                           name="nombre"
                                           class="form-control form-control-lg"
                                           value="<?= htmlspecialchars($usuario['nombre']); ?>"
                                           required>

                                </div>


                                <!-- Usuario -->
                                <div class="mb-3">

                                    <label for="usuario" class="form-label fw-semibold">
                                        Nombre de usuario
                                    </label>

                                    <div class="input-group input-group-lg">

                                        <span class="input-group-text">
                                            @
                                        </span>

                                        <input type="text"
                                               id="usuario"
                                               name="usuario"
                                               class="form-control"
                                               value="<?= htmlspecialchars($usuario['usuario']); ?>"
                                               required>

                                    </div>

                                </div>


                                <!-- Contraseña -->
                                <div class="mb-3">

                                    <label for="password" class="form-label fw-semibold">
                                        Nueva contraseña
                                    </label>

                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="form-control form-control-lg"
                                           placeholder="Dejar vacío para mantener la actual"
                                           minlength="6">

                                    <div class="form-text">
                                        Solo completá este campo si querés cambiar la contraseña.
                                    </div>

                                </div>


                                <!-- Rol -->
                                <div class="mb-4">

                                    <label for="rol" class="form-label fw-semibold">
                                        Rol
                                    </label>

                                    <select id="rol"
                                            name="rol"
                                            class="form-select form-select-lg"
                                            required>

                                        <option value="vendedor"
                                            <?= $usuario['rol'] == 'vendedor' ? 'selected' : '' ?>>
                                            👤 Vendedor
                                        </option>

                                        <option value="operador"
                                            <?= $usuario['rol'] == 'operador' ? 'selected' : '' ?>>
                                            📋 Operador
                                        </option>

                                        <option value="admin"
                                            <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>
                                            🛡️ Administrador
                                        </option>

                                    </select>

                                </div>


                                <!-- 🔹 BOTONES -->
                                <div class="d-flex flex-column gap-2">

                                    <button type="submit"
                                            class="btn btn-primary btn-lg">
                                        💾 Guardar cambios
                                    </button>

                                    <a href="/gestion_ventas/index.php?action=usuarios"
                                       class="btn btn-light btn-lg border">
                                        ← Cancelar
                                    </a>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>


<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>