<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/navbar.php"); ?>


<div class="container-fluid">

    <div class="row">

        <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/sidebar.php"); ?>


        <!-- 🔹 CONTENIDO -->

        <div class="col-12 col-md-10 p-4">


            <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/alert.php"); ?>


            <!-- TÍTULO -->

            <div class="mb-4">

                <h3>
                    📊 Reportes
                </h3>

                <p class="text-muted mb-0">
                    Consultá las ventas según el período seleccionado.
                </p>

            </div>


            <!-- 📅 FILTROS -->

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <form
                        method="GET"
                        action="/gestion_ventas/index.php"
                        class="row g-3"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="reportes"
                        >


                        <!-- DESDE -->

                        <div class="col-12 col-md-3">

                            <label class="form-label">
                                Desde
                            </label>

                            <input
                                type="date"
                                name="desde"
                                class="form-control"
                                value="<?= htmlspecialchars($desde); ?>"
                                required
                            >

                        </div>


                        <!-- HASTA -->

                        <div class="col-12 col-md-3">

                            <label class="form-label">
                                Hasta
                            </label>

                            <input
                                type="date"
                                name="hasta"
                                class="form-control"
                                value="<?= htmlspecialchars($hasta); ?>"
                                required
                            >

                        </div>


                        <!-- VENDEDOR -->

                        <?php if(
                            $_SESSION["rol"] === "admin" ||
                            $_SESSION["rol"] === "operador"
                        ): ?>

                            <div class="col-12 col-md-3">

                                <label class="form-label">
                                    Vendedor
                                </label>

                                <select
                                    name="vendedor_id"
                                    class="form-select"
                                >

                                    <option value="">
                                        Todos los vendedores
                                    </option>


                                    <?php foreach(
                                        $vendedores
                                        as $vendedor
                                    ): ?>

                                        <option
                                            value="<?= (int)$vendedor["id"]; ?>"
                                            <?= (
                                                (string)$vendedor_id ===
                                                (string)$vendedor["id"]
                                            )
                                                ? "selected"
                                                : ""
                                            ?>
                                        >

                                            <?= htmlspecialchars(
                                                $vendedor["nombre"]
                                            ); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        <?php endif; ?>


                        <!-- BOTÓN -->

                        <div class="col-12 col-md-3 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >

                                🔎 Filtrar

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            <!-- ⚡ PERÍODOS RÁPIDOS -->

            <div class="d-flex flex-wrap gap-2 mb-4">

                <a
                    href="/gestion_ventas/index.php?action=reportes&desde=<?= date('Y-m-d'); ?>&hasta=<?= date('Y-m-d'); ?>"
                    class="btn btn-outline-primary"
                >

                    Hoy

                </a>


                <?php

                $lunes = date(
                    "Y-m-d",
                    strtotime("monday this week")
                );

                $domingo = date(
                    "Y-m-d",
                    strtotime("sunday this week")
                );

                ?>

                <a
                    href="/gestion_ventas/index.php?action=reportes&desde=<?= $lunes; ?>&hasta=<?= $domingo; ?>"
                    class="btn btn-outline-primary"
                >

                    Esta semana

                </a>


                <?php

                $primerDiaMes =
                    date("Y-m-01");

                $ultimoDiaMes =
                    date("Y-m-t");

                ?>

                <a
                    href="/gestion_ventas/index.php?action=reportes&desde=<?= $primerDiaMes; ?>&hasta=<?= $ultimoDiaMes; ?>"
                    class="btn btn-outline-primary"
                >

                    Este mes

                </a>


                <a
                    href="/gestion_ventas/index.php?action=reportes"
                    class="btn btn-outline-secondary"
                >

                    Personalizado

                </a>

            </div>


            <!-- 📊 RESUMEN -->

            <div class="row g-3 mb-4">


                <!-- TOTAL VENTAS -->

                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h6 class="text-muted">
                                Total de ventas
                            </h6>

                            <h3 class="mb-0">

                                <?= (int)$resumen["total_ventas"]; ?>

                            </h3>

                        </div>

                    </div>

                </div>


                <!-- TOTAL VENDIDO -->

                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h6 class="text-muted">
                                Total vendido
                            </h6>

                            <h3 class="mb-0">

                                $ <?= number_format(
                                    $resumen["total_monto"],
                                    2,
                                    ",",
                                    "."
                                ); ?>

                            </h3>

                        </div>

                    </div>

                </div>


                <!-- CHANCES -->

                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h6 class="text-muted">
                                Total de chances
                            </h6>

                            <h3 class="mb-0">

                                <?= (int)$resumen["total_chances"]; ?>

                            </h3>

                        </div>

                    </div>

                </div>


                <!-- PROMEDIO -->

                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h6 class="text-muted">
                                Promedio por venta
                            </h6>

                            <h3 class="mb-0">

                                $ <?= number_format(
                                    $resumen["promedio_venta"],
                                    2,
                                    ",",
                                    "."
                                ); ?>

                            </h3>

                        </div>

                    </div>

                </div>

            </div>


            <!-- 💳 MEDIOS DE PAGO -->

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="mb-3">
                        💳 Ventas por medio de pago
                    </h5>


                    <?php if(!empty($porMedioPago)): ?>

                        <div class="row g-3">

                            <?php foreach(
                                $porMedioPago
                                as $medio
                            ): ?>

                                <div class="col-12 col-md-6 col-xl-4">

                                    <div class="border rounded p-3">

                                        <div class="fw-semibold">

                                            <?= htmlspecialchars(
                                                $medio["medio_pago"]
                                            ); ?>

                                        </div>

                                        <div class="text-muted">

                                            <?= (int)$medio["cantidad"]; ?>

                                            <?= (
                                                (int)$medio["cantidad"] === 1
                                            )
                                                ? "venta"
                                                : "ventas";
                                            ?>

                                        </div>

                                        <div class="fw-bold mt-1">

                                            $ <?= number_format(
                                                $medio["total"],
                                                2,
                                                ",",
                                                "."
                                            ); ?>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <p class="text-muted mb-0">

                            No hay ventas en este período.

                        </p>

                    <?php endif; ?>

                </div>

            </div>


            <!-- 👥 VENTAS POR VENDEDOR -->

            <?php if(
                $_SESSION["rol"] === "admin" ||
                $_SESSION["rol"] === "operador"
            ): ?>

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-3">
                            👥 Ventas por vendedor
                        </h5>


                        <?php if(!empty($porVendedor)): ?>

                            <div class="row g-3">

                                <?php foreach(
                                    $porVendedor
                                    as $vendedor
                                ): ?>

                                    <div class="col-12 col-md-6 col-xl-4">

                                        <div class="border rounded p-3">

                                            <div class="fw-semibold">

                                                <?= htmlspecialchars(
                                                    $vendedor["vendedor_nombre"]
                                                ); ?>

                                            </div>

                                            <div class="text-muted">

                                                <?= (int)$vendedor["cantidad"]; ?>

                                                <?= (
                                                    (int)$vendedor["cantidad"] === 1
                                                )
                                                    ? "venta"
                                                    : "ventas";
                                                ?>

                                            </div>

                                            <div class="fw-bold mt-1">

                                                $ <?= number_format(
                                                    $vendedor["total"],
                                                    2,
                                                    ",",
                                                    "."
                                                ); ?>

                                            </div>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        <?php else: ?>

                            <p class="text-muted mb-0">

                                No hay ventas en este período.

                            </p>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endif; ?>


        </div>

    </div>

</div>


<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>