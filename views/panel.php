<?php require_once("layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/sidebar.php"); ?>

        <!-- CONTENIDO -->
        <div class="col-12 col-md-10 p-4">

            <!-- HEADER -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

                <div>
                    <h3>🏠 Panel</h3>

                    <p class="text-muted mb-0">
                        Bienvenido, <?= htmlspecialchars($_SESSION["nombre"] ?? "Usuario"); ?>
                    </p>
                </div>

                <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

                    <a href="/gestion_ventas/index.php?action=ventas.crear"
                       class="btn btn-primary">
                        ➕ Registrar venta
                    </a>

                <?php endif; ?>

            </div>


            <!-- RESUMEN -->
            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-lg-4">

                    <div class="card shadow-sm h-100">
                        <div class="card-body">

                            <h6 class="text-muted">
                                <?php if($_SESSION["rol"] === "vendedor"): ?>
                                    Mis ventas
                                <?php else: ?>
                                    Total de ventas
                                <?php endif; ?>
                            </h6>

                            <h3 class="mb-0">

                                <?php

                                if($_SESSION["rol"] === "vendedor"){

                                    $totalVentas =
                                        $this->model->getTotalVentas(
                                            $_SESSION["usuario_id"]
                                        );

                                }else{

                                    $totalVentas =
                                        $this->model->getTotalVentas();

                                }

                                echo (int)$totalVentas;

                                ?>

                            </h3>

                        </div>
                    </div>

                </div>


                <div class="col-12 col-sm-6 col-lg-4">

                    <div class="card shadow-sm h-100">
                        <div class="card-body">

                            <h6 class="text-muted">
                                <?php if($_SESSION["rol"] === "vendedor"): ?>
                                    Total vendido
                                <?php else: ?>
                                    Total vendido
                                <?php endif; ?>
                            </h6>

                            <h3 class="mb-0">

                                <?php

                                if($_SESSION["rol"] === "vendedor"){

                                    $totalMonto =
                                        $this->model->getTotalMonto(
                                            $_SESSION["usuario_id"]
                                        );

                                }else{

                                    $totalMonto =
                                        $this->model->getTotalMonto();

                                }

                                echo '$ ' . number_format(
                                    $totalMonto,
                                    2,
                                    ',',
                                    '.'
                                );

                                ?>

                            </h3>

                        </div>
                    </div>

                </div>


                <div class="col-12 col-sm-6 col-lg-4">

                    <div class="card shadow-sm h-100">
                        <div class="card-body">

                            <h6 class="text-muted">
                                Rol
                            </h6>

                            <h3 class="mb-0 text-capitalize">
                                <?= htmlspecialchars($_SESSION["rol"] ?? ""); ?>
                            </h3>

                        </div>
                    </div>

                </div>

            </div>


            <!-- ACCIONES -->
            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="mb-3">
                        Acciones rápidas
                    </h5>

                    <div class="d-flex flex-wrap gap-2">

                        <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

                            <a href="/gestion_ventas/index.php?action=ventas.crear"
                               class="btn btn-primary">
                                ➕ Registrar venta
                            </a>

                            <a href="/gestion_ventas/index.php?action=ventas"
                               class="btn btn-outline-primary">
                                📋 Mis ventas
                            </a>

                        <?php endif; ?>


                        <?php if(
                            ($_SESSION["rol"] ?? "") === "admin" ||
                            ($_SESSION["rol"] ?? "") === "operador"
                        ): ?>

                            <a href="/gestion_ventas/index.php?action=ventas"
                               class="btn btn-primary">
                                📋 Ver ventas
                            </a>

                        <?php endif; ?>


                        <?php if(($_SESSION["rol"] ?? "") === "admin"): ?>

                            <a href="/gestion_ventas/index.php?action=usuarios"
                            class="btn btn-primary">
                                👥 Gestionar usuarios
                            </a>

                            <a href="/gestion_ventas/index.php?action=reportes"
                            class="btn btn-primary"> 
                                📊 Reportes
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>


            <!-- INFORMACIÓN -->
            <div class="card shadow-sm">

                <div class="card-body">

                    <h5 class="mb-3">
                        Información
                    </h5>

                    <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

                        <p class="text-muted mb-0">
                            Desde este panel podés registrar tus ventas y consultar
                            las ventas que hayas realizado.
                        </p>

                    <?php elseif(($_SESSION["rol"] ?? "") === "operador"): ?>

                        <p class="text-muted mb-0">
                            Desde este panel podés consultar y gestionar las ventas
                            registradas por los vendedores.
                        </p>

                    <?php elseif(($_SESSION["rol"] ?? "") === "admin"): ?>

                        <p class="text-muted mb-0">
                            Desde este panel podés administrar las ventas,
                            usuarios y reportes del sistema.
                        </p>

                    <?php endif; ?>

                </div>

            </div>

        </div>
    </div>
</div>


<?php require_once("layouts/footer.php"); ?>