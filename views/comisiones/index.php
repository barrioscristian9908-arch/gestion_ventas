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
                    💰 Comisiones
                </h3>

                <p class="text-muted mb-0">
                    Calculá las comisiones según las ventas realizadas.
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
                            value="comisiones"
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

                                💰 Calcular comisiones

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            <!-- ⚡ PERÍODOS RÁPIDOS -->

            <div class="d-flex flex-wrap gap-2 mb-4">

                <a
                    href="/gestion_ventas/index.php?action=comisiones&desde=<?= date('Y-m-d'); ?>&hasta=<?= date('Y-m-d'); ?>"
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
                    href="/gestion_ventas/index.php?action=comisiones&desde=<?= $lunes; ?>&hasta=<?= $domingo; ?>"
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
                    href="/gestion_ventas/index.php?action=comisiones&desde=<?= $primerDiaMes; ?>&hasta=<?= $ultimoDiaMes; ?>"
                    class="btn btn-outline-primary"
                >

                    Este mes

                </a>


                <a
                    href="/gestion_ventas/index.php?action=comisiones"
                    class="btn btn-outline-secondary"
                >

                    Personalizado

                </a>

            </div>


            <?php if(isset($calculado) && $calculado): ?>


                <!-- 💰 RESUMEN -->

                <div class="row g-3 mb-4">


                    <!-- TOTAL VENTAS -->

                    <div class="col-12 col-sm-6 col-xl-4">

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

                    <div class="col-12 col-sm-6 col-xl-4">

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


                    <!-- TOTAL COMISION -->

                    <div class="col-12 col-sm-6 col-xl-4">

                        <div class="card shadow-sm h-100">

                            <div class="card-body">

                                <h6 class="text-muted">
                                    Comisión total
                                </h6>

                                <h3 class="mb-0 text-success">

                                    $ <?= number_format(
                                        $resumen["total_comision"],
                                        2,
                                        ",",
                                        "."
                                    ); ?>

                                </h3>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- 📋 DETALLE DE COMISIONES -->

                <div class="card shadow-sm mb-4">

                    <div class="card-body">

                        <h5 class="mb-3">
                            📋 Detalle de comisiones
                        </h5>


                        <?php if(!empty($ventas)): ?>

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead>

                                        <tr>

                                            <th>
                                                Fecha
                                            </th>


                                            <?php if(
                                                $_SESSION["rol"] === "admin" ||
                                                $_SESSION["rol"] === "operador"
                                            ): ?>

                                                <th>
                                                    Vendedor
                                                </th>

                                            <?php endif; ?>


                                            <th>
                                                Cliente
                                            </th>


                                            <th>
                                                Venta
                                            </th>


                                            <th>
                                                Comisión
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        <?php foreach(
                                            $ventas
                                            as $venta
                                        ): ?>

                                            <tr>

                                                <td>

                                                    <?= date(
                                                        "d/m/Y H:i",
                                                        strtotime(
                                                            $venta["creado_en"]
                                                        )
                                                    ); ?>

                                                </td>


                                                <?php if(
                                                    $_SESSION["rol"] === "admin" ||
                                                    $_SESSION["rol"] === "operador"
                                                ): ?>

                                                    <td>

                                                        <?= htmlspecialchars(
                                                            $venta["vendedor_nombre"]
                                                        ); ?>

                                                    </td>

                                                <?php endif; ?>


                                                <td>

                                                    <?= htmlspecialchars(
                                                        $venta["cliente_nombre"]
                                                    ); ?>

                                                </td>


                                                <td>

                                                    $ <?= number_format(
                                                        $venta["monto"],
                                                        2,
                                                        ",",
                                                        "."
                                                    ); ?>

                                                </td>


                                                <td>

                                                    <strong class="text-success">

                                                        $ <?= number_format(
                                                            $venta["comision"],
                                                            2,
                                                            ",",
                                                            "."
                                                        ); ?>

                                                    </strong>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>


                                    <tfoot>

                                        <tr class="table-light">

                                            <th
                                                colspan="<?= (
                                                    $_SESSION["rol"] === "admin" ||
                                                    $_SESSION["rol"] === "operador"
                                                )
                                                    ? 3
                                                    : 2
                                                ?>"
                                            >

                                                TOTAL

                                            </th>


                                            <th>

                                                $ <?= number_format(
                                                    $resumen["total_monto"],
                                                    2,
                                                    ",",
                                                    "."
                                                ); ?>

                                            </th>


                                            <th class="text-success">

                                                $ <?= number_format(
                                                    $resumen["total_comision"],
                                                    2,
                                                    ",",
                                                    "."
                                                ); ?>

                                            </th>

                                        </tr>

                                    </tfoot>

                                </table>

                            </div>


                        <?php else: ?>

                            <p class="text-muted mb-0">

                                No hay ventas en este período.

                            </p>

                        <?php endif; ?>

                    </div>

                </div>


                <!-- 💵 TABLA DE COMISIONES -->

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-3">
                            💵 Valores de comisión
                        </h5>


                        <div class="row g-3">

                            <div class="col-6 col-md-4 col-xl-2">

                                <div class="border rounded p-3 text-center">

                                    <div class="text-muted">
                                        $10.000
                                    </div>

                                    <strong class="text-success">
                                        $3.000
                                    </strong>

                                </div>

                            </div>


                            <div class="col-6 col-md-4 col-xl-2">

                                <div class="border rounded p-3 text-center">

                                    <div class="text-muted">
                                        $20.000
                                    </div>

                                    <strong class="text-success">
                                        $5.000
                                    </strong>

                                </div>

                            </div>


                            <div class="col-6 col-md-4 col-xl-2">

                                <div class="border rounded p-3 text-center">

                                    <div class="text-muted">
                                        $30.000
                                    </div>

                                    <strong class="text-success">
                                        $7.500
                                    </strong>

                                </div>

                            </div>


                            <div class="col-6 col-md-4 col-xl-2">

                                <div class="border rounded p-3 text-center">

                                    <div class="text-muted">
                                        $50.000
                                    </div>

                                    <strong class="text-success">
                                        $10.000
                                    </strong>

                                </div>

                            </div>


                            <div class="col-6 col-md-4 col-xl-2">

                                <div class="border rounded p-3 text-center">

                                    <div class="text-muted">
                                        $75.000
                                    </div>

                                    <strong class="text-success">
                                        $15.000
                                    </strong>

                                </div>

                            </div>


                            <div class="col-6 col-md-4 col-xl-2">

                                <div class="border rounded p-3 text-center">

                                    <div class="text-muted">
                                        $100.000
                                    </div>

                                    <strong class="text-success">
                                        $20.000
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            <?php endif; ?>


        </div>

    </div>

</div>


<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>