<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/navbar.php"); ?>

<div class="container-fluid">

```
<div class="row">

    <!-- 🔹 SIDEBAR -->
    <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/sidebar.php"); ?>


    <!-- 🔹 CONTENIDO -->
    <div class="col-12 col-md-10 p-2 p-md-4">

        <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/alert.php"); ?>


        <div class="row justify-content-center">

            <div class="col-12 col-lg-8 col-xl-7">


                <!-- 🔹 ENCABEZADO -->
                <div class="mb-4">

                    <a href="/gestion_ventas/index.php?action=ventas"
                       class="text-decoration-none text-muted small">

                        ← Volver a ventas

                    </a>


                    <h4 class="mt-2 mb-1">

                        🧾 Registrar venta

                    </h4>


                    <p class="text-muted mb-0">

                        Completá los datos del cliente y la venta.

                    </p>

                </div>


                <!-- 🔹 TARJETA -->
                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4 p-md-5">


                        <!-- 🔹 ENCABEZADO INTERNO -->
                        <div class="text-center mb-4">

                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 75px; height: 75px; font-size: 2rem;">

                                🧾

                            </div>


                            <h5 class="mt-3 mb-1">

                                Nueva venta

                            </h5>


                            <small class="text-muted">

                                Ingresá la información solicitada

                            </small>

                        </div>


                        <!-- 🔹 FORMULARIO -->
                        <form action="/gestion_ventas/index.php?action=ventas.store"
                              method="POST"
                              enctype="multipart/form-data">


                            <!-- ================================================== -->
                            <!-- 👤 DATOS DEL CLIENTE -->
                            <!-- ================================================== -->

                            <div class="mb-4">

                                <h6 class="fw-semibold mb-3">

                                    👤 Datos del cliente

                                </h6>


                                <!-- Nombre -->
                                <div class="mb-3">

                                    <label for="cliente_nombre"
                                           class="form-label fw-semibold">

                                        Nombre completo

                                    </label>


                                    <input type="text"
                                           id="cliente_nombre"
                                           name="cliente_nombre"
                                           class="form-control form-control-lg"
                                           placeholder="Ej: Juan Pérez"
                                           autocomplete="name"
                                           required>

                                </div>


                                <!-- DNI -->
                                <div class="mb-3">

                                    <label for="cliente_dni"
                                           class="form-label fw-semibold">

                                        DNI

                                    </label>


                                    <input type="text"
                                           id="cliente_dni"
                                           name="cliente_dni"
                                           class="form-control form-control-lg"
                                           placeholder="Ej: 35123456"
                                           inputmode="numeric"
                                           required>

                                </div>


                                <!-- Teléfono -->
                                <div class="mb-3">

                                    <label for="cliente_telefono"
                                           class="form-label fw-semibold">

                                        Teléfono

                                    </label>


                                    <input type="tel"
                                           id="cliente_telefono"
                                           name="cliente_telefono"
                                           class="form-control form-control-lg"
                                           placeholder="Ej: 3704123456"
                                           autocomplete="tel"
                                           inputmode="tel"
                                           required>

                                </div>


                                <!-- Dirección -->
                                <div class="mb-3">

                                    <label for="cliente_direccion"
                                           class="form-label fw-semibold">

                                        Dirección

                                        <span class="text-muted fw-normal">
                                            (opcional)
                                        </span>

                                    </label>


                                    <input type="text"
                                           id="cliente_direccion"
                                           name="cliente_direccion"
                                           class="form-control form-control-lg"
                                           placeholder="Ej: Av. San Martín 123"
                                           autocomplete="street-address">

                                </div>

                            </div>


                            <hr class="my-4">


                            <!-- ================================================== -->
                            <!-- 🎟️ DATOS DE LA VENTA -->
                            <!-- ================================================== -->

                            <div class="mb-4">

                                <h6 class="fw-semibold mb-3">

                                    🎟️ Datos de la venta

                                </h6>


                                <!-- Cantidad de chances -->
                                <div class="mb-3">

                                    <label for="cantidad_chances"
                                           class="form-label fw-semibold">

                                        Cantidad de chances

                                    </label>


                                    <input type="number"
                                           id="cantidad_chances"
                                           name="cantidad_chances"
                                           class="form-control form-control-lg"
                                           min="1"
                                           step="1"
                                           placeholder="Ej: 3"
                                           inputmode="numeric"
                                           required>


                                    <div class="form-text">

                                        Ingresá la cantidad de chances que compró el cliente.

                                    </div>

                                </div>


                                <!-- Medio de pago -->
                                <div class="mb-3">

                                    <label for="medio_pago"
                                           class="form-label fw-semibold">

                                        Medio de pago

                                    </label>


                                    <select id="medio_pago"
                                            name="medio_pago"
                                            class="form-select form-select-lg"
                                            required>

                                        <option value="">

                                            Seleccionar medio de pago

                                        </option>


                                        <option value="Efectivo">

                                            💵 Efectivo

                                        </option>


                                        <option value="Transferencia">

                                            🏦 Transferencia

                                        </option>


                                        <option value="Mercado Pago">

                                            📱 Mercado Pago

                                        </option>


                                        <option value="Tarjeta">

                                            💳 Tarjeta

                                        </option>

                                    </select>

                                </div>


                                <!-- Monto -->
                                <div class="mb-3">

                                    <label for="monto"
                                           class="form-label fw-semibold">

                                        Monto de la venta

                                    </label>


                                    <select id="monto"
                                            name="monto"
                                            class="form-select form-select-lg"
                                            required>

                                        <option value="">

                                            Seleccionar monto

                                        </option>


                                        <option value="10000">

                                            $10.000

                                        </option>


                                        <option value="15000">

                                            $15.000

                                        </option>


                                        <option value="20000">

                                            $20.000

                                        </option>


                                        <option value="30000">

                                            $30.000

                                        </option>


                                        <option value="50000">

                                            $50.000

                                        </option>


                                        <option value="75000">

                                            $75.000

                                        </option>


                                        <option value="100000">

                                            $100.000

                                        </option>

                                    </select>


                                    <div class="form-text">

                                        Seleccioná el importe correspondiente a la venta.

                                    </div>

                                </div>

                            </div>


                            <hr class="my-4">


                            <!-- ================================================== -->
                            <!-- 📎 COMPROBANTE -->
                            <!-- ================================================== -->

                            <div class="mb-4">

                                <h6 class="fw-semibold mb-3">

                                    📎 Comprobante

                                </h6>


                                <label for="comprobante"
                                       class="form-label fw-semibold">

                                    Adjuntar comprobante

                                </label>


                                <input type="file"
                                       id="comprobante"
                                       name="comprobante"
                                       class="form-control form-control-lg"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       required>


                                <div class="form-text">

                                    Formatos permitidos: JPG, JPEG, PNG o PDF.

                                </div>

                            </div>


                            <!-- ================================================== -->
                            <!-- 🔘 BOTONES -->
                            <!-- ================================================== -->

                            <div class="d-flex flex-column gap-2">

                                <button type="submit"
                                        class="btn btn-primary btn-lg">

                                    💾 Registrar venta

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
```

</div>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>
