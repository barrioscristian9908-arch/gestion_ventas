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

                <div class="col-12 col-lg-9 col-xl-8">


                    <!-- 🔹 ENCABEZADO -->
                    <div class="mb-4">

                        <a href="/gestion_ventas/index.php?action=ventas"
                           class="text-decoration-none text-muted small">

                            ← Volver a ventas

                        </a>


                        <h4 class="mt-2 mb-1">

                            📎 Comprobantes

                        </h4>


                        <p class="text-muted mb-0">

                            Comprobantes de la venta #<?= (int)$venta['id']; ?>

                        </p>

                    </div>


                    <!-- 🔹 DATOS DE LA VENTA -->
                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <div class="fw-semibold">

                                <?= htmlspecialchars($venta['cliente_nombre']); ?>

                            </div>


                            <div class="text-muted small mt-1">

                                💰 $<?= number_format(
                                    $venta['monto'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                                ·

                                <?= htmlspecialchars($venta['medio_pago']); ?>

                            </div>


                            <?php if(
                                ($_SESSION["rol"] ?? "") !== "vendedor"
                            ): ?>

                                <div class="text-muted small mt-1">

                                    👤 Vendedor:
                                    <?= htmlspecialchars(
                                        $venta['vendedor_nombre']
                                    ); ?>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>


                    <!-- 🔹 COMPROBANTES -->
                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-3 p-md-4">


                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>

                                    <h5 class="mb-1">

                                        Comprobantes

                                    </h5>

                                    <small class="text-muted">

                                        <?= count($comprobantes); ?>
                                        comprobante(s)

                                    </small>

                                </div>


                                <?php if(
                                    ($_SESSION["rol"] ?? "") === "vendedor"
                                ): ?>

                                    <a href="/gestion_ventas/index.php?action=ventas.comprobante.agregar&id=<?= (int)$venta['id']; ?>"
                                       class="btn btn-sm btn-success">

                                        ➕ Agregar

                                    </a>

                                <?php endif; ?>

                            </div>


                            <?php if(empty($comprobantes)): ?>

                                <div class="text-center py-5">

                                    <div style="font-size: 3rem;">
                                        📎
                                    </div>

                                    <h6 class="mt-3">

                                        No hay comprobantes

                                    </h6>

                                    <p class="text-muted mb-0">

                                        Esta venta todavía no tiene comprobantes cargados.

                                    </p>

                                </div>

                            <?php else: ?>


                                <div class="row g-3">

                                    <?php foreach($comprobantes as $comprobante): ?>

                                        <?php

                                        $extension =
                                            strtolower(
                                                pathinfo(
                                                    $comprobante["archivo"],
                                                    PATHINFO_EXTENSION
                                                )
                                            );

                                        $urlArchivo =
                                            "/gestion_ventas/uploads/comprobantes/"
                                            . rawurlencode(
                                                $comprobante["archivo"]
                                            );

                                        ?>


                                        <div class="col-12 col-md-6">

                                            <div class="border rounded p-3 h-100">


                                                <!-- IMAGEN -->
                                                <?php if(
                                                    in_array(
                                                        $extension,
                                                        [
                                                            "jpg",
                                                            "jpeg",
                                                            "png",
                                                            "webp"
                                                        ],
                                                        true
                                                    )
                                                ): ?>

                                                    <a href="<?= htmlspecialchars($urlArchivo); ?>"
                                                       target="_blank">

                                                        <img src="<?= htmlspecialchars($urlArchivo); ?>"
                                                             class="img-fluid rounded mb-3"
                                                             style="max-height: 300px; width: 100%; object-fit: contain;">

                                                    </a>


                                                <!-- PDF -->
                                                <?php elseif($extension === "pdf"): ?>

                                                    <div class="text-center py-5 bg-light rounded mb-3">

                                                        <div style="font-size: 4rem;">
                                                            📄
                                                        </div>

                                                        <div class="fw-semibold">
                                                            Documento PDF
                                                        </div>

                                                    </div>

                                                <?php endif; ?>


                                                <!-- INFORMACIÓN -->
                                                <div class="small text-muted mb-3">

                                                    📅
                                                    <?= date(
                                                        "d/m/Y H:i",
                                                        strtotime(
                                                            $comprobante["creado_en"]
                                                        )
                                                    ); ?>

                                                </div>


                                                <!-- ACCIONES -->
                                                <div class="d-flex gap-2 flex-wrap">


                                                    <a href="<?= htmlspecialchars($urlArchivo); ?>"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-primary">

                                                        👁️ Ver

                                                    </a>


                                                    <?php if(
                                                        ($_SESSION["rol"] ?? "") === "vendedor"
                                                    ): ?>

                                                        <a href="/gestion_ventas/index.php?action=ventas.comprobante.eliminar&id=<?= (int)$comprobante['id']; ?>"
                                                           class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('¿Seguro que querés eliminar este comprobante?');">

                                                            🗑️ Eliminar

                                                        </a>

                                                    <?php endif; ?>


                                                </div>


                                            </div>

                                        </div>


                                    <?php endforeach; ?>

                                </div>

                            <?php endif; ?>


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>