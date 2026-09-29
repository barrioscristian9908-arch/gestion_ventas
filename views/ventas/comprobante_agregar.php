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


                    <!-- 🔹 ENCABEZADO -->
                    <div class="mb-4">

                        <a href="/gestion_ventas/index.php?action=ventas"
                           class="text-decoration-none text-muted small">

                            ← Volver a ventas

                        </a>


                        <h4 class="mt-2 mb-1">

                            📎 Agregar comprobante

                        </h4>


                        <p class="text-muted mb-0">

                            Adjuntá el comprobante correspondiente a esta venta.

                        </p>

                    </div>


                    <!-- 🔹 VENTA -->
                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-4 p-md-5">


                            <div class="text-center mb-4">

                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 75px; height: 75px; font-size: 2rem;">

                                    📎

                                </div>


                                <h5 class="mt-3 mb-1">

                                    Comprobante de venta

                                </h5>


                                <small class="text-muted">

                                    Venta #<?= (int)$venta['id']; ?>

                                </small>

                            </div>


                            <!-- 🔹 DATOS DEL CLIENTE -->
                            <div class="bg-light rounded p-3 mb-4">

                                <div class="fw-semibold">

                                    <?= htmlspecialchars($venta['cliente_nombre']); ?>

                                </div>


                                <small class="text-muted">

                                    $<?= number_format(
                                        $venta['monto'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?>

                                    ·

                                    <?= htmlspecialchars($venta['medio_pago']); ?>

                                </small>

                            </div>


                            <!-- 🔹 FORMULARIO -->
                            <form action="/gestion_ventas/index.php?action=ventas.comprobante.store"
                                  method="POST"
                                  enctype="multipart/form-data">


                                <input type="hidden"
                                       name="venta_id"
                                       value="<?= (int)$venta['id']; ?>">


                                <div class="mb-4">

                                    <label for="comprobante"
                                           class="form-label fw-semibold">

                                        Seleccionar comprobante

                                    </label>


                                    <input type="file"
                                           id="comprobante"
                                           name="comprobante"
                                           class="form-control form-control-lg"
                                           accept=".jpg,.jpeg,.png,.webp,.pdf"
                                           required>


                                    <div class="form-text">

                                        Formatos permitidos: JPG, JPEG, PNG, WEBP y PDF.
                                        Máximo 10 MB.

                                    </div>

                                </div>


                                <div class="d-flex flex-column gap-2">

                                    <button type="submit"
                                            class="btn btn-success btn-lg">

                                        📤 Subir comprobante

                                    </button>


                                    <a href="/gestion_ventas/index.php?action=ventas"
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