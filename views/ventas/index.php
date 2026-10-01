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

                <h4 class="mb-1">
                    🧾 Ventas
                </h4>

                <p class="text-muted mb-0">
                    Consultá y administrá las ventas registradas
                </p>

            </div>


            <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

                <a href="/gestion_ventas/index.php?action=ventas.crear"
                   class="btn btn-primary">

                    ➕ Registrar venta

                </a>

            <?php endif; ?>

        </div>


        <!-- 🔹 FILTROS -->
        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="d-flex align-items-center mb-3">

                    <h6 class="mb-0 fw-semibold">
                        🔎 Buscar ventas
                    </h6>

                </div>


                <form action="/gestion_ventas/index.php"
                      method="GET">

                    <input type="hidden"
                           name="action"
                           value="ventas">


                    <div class="row g-3">


                        <!-- 🔎 BÚSQUEDA -->
                        <div class="col-12 col-md-6 col-lg-4">

                            <label for="buscar"
                                   class="form-label small fw-semibold">

                                Cliente / DNI / teléfono

                            </label>

                            <input type="text"
                                   id="buscar"
                                   name="buscar"
                                   class="form-control"
                                   placeholder="Ej: Juan Pérez o 35123456"
                                   value="<?= htmlspecialchars($_GET['buscar'] ?? ''); ?>">

                        </div>


                        <!-- 📅 DESDE -->
                        <div class="col-6 col-md-3 col-lg-2">

                            <label for="desde"
                                   class="form-label small fw-semibold">

                                Desde

                            </label>

                            <input type="date"
                                   id="desde"
                                   name="desde"
                                   class="form-control"
                                   value="<?= htmlspecialchars($_GET['desde'] ?? ''); ?>">

                        </div>


                        <!-- 📅 HASTA -->
                        <div class="col-6 col-md-3 col-lg-2">

                            <label for="hasta"
                                   class="form-label small fw-semibold">

                                Hasta

                            </label>

                            <input type="date"
                                   id="hasta"
                                   name="hasta"
                                   class="form-control"
                                   value="<?= htmlspecialchars($_GET['hasta'] ?? ''); ?>">

                        </div>


                        <!-- 💳 MEDIO DE PAGO -->
                        <div class="col-12 col-md-6 col-lg-2">

                            <label for="medio_pago"
                                   class="form-label small fw-semibold">

                                Medio de pago

                            </label>

                            <select id="medio_pago"
                                    name="medio_pago"
                                    class="form-select">

                                <option value="">
                                    Todos
                                </option>

                                <option value="Efectivo"
                                    <?= ($_GET['medio_pago'] ?? '') === 'Efectivo' ? 'selected' : ''; ?>>

                                    Efectivo

                                </option>

                                <option value="Transferencia"
                                    <?= ($_GET['medio_pago'] ?? '') === 'Transferencia' ? 'selected' : ''; ?>>

                                    Transferencia

                                </option>

                                <option value="Mercado Pago"
                                    <?= ($_GET['medio_pago'] ?? '') === 'Mercado Pago' ? 'selected' : ''; ?>>

                                    Mercado Pago

                                </option>

                                <option value="Tarjeta"
                                    <?= ($_GET['medio_pago'] ?? '') === 'Tarjeta' ? 'selected' : ''; ?>>

                                    Tarjeta

                                </option>

                                <option value="Pago combinado"
                                    <?= ($_GET['medio_pago'] ?? '') === 'Pago combinado' ? 'selected' : ''; ?>>

                                    Pago combinado

                                </option>

                            </select>

                        </div>


                        <!-- 👤 VENDEDOR -->
                        <?php if(($_SESSION["rol"] ?? "") === "admin"): ?>

                            <div class="col-12 col-md-6 col-lg-2">

                                <label for="vendedor_id"
                                       class="form-label small fw-semibold">

                                    Vendedor

                                </label>

                                <select id="vendedor_id"
                                        name="vendedor_id"
                                        class="form-select">

                                    <option value="">
                                        Todos
                                    </option>

                                    <?php if(!empty($vendedores)): ?>

                                        <?php foreach($vendedores as $v): ?>

                                            <option value="<?= $v['id']; ?>"
                                                <?= ($_GET['vendedor_id'] ?? '') == $v['id'] ? 'selected' : ''; ?>>

                                                <?= htmlspecialchars($v['nombre']); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                            </div>

                        <?php endif; ?>


                        <!-- 🔘 BOTONES -->
                        <div class="col-12">

                            <div class="d-flex flex-column flex-sm-row gap-2">

                                <button type="submit"
                                        class="btn btn-primary">

                                    🔎 Filtrar

                                </button>


                                <a href="/gestion_ventas/index.php?action=ventas"
                                   class="btn btn-light border">

                                    Limpiar

                                </a>


                                <?php if(
                                    ($_SESSION["rol"] ?? "") === "admin" ||
                                    ($_SESSION["rol"] ?? "") === "operador"
                                ): ?>

                                    <a
                                        href="/gestion_ventas/index.php?action=ventas.exportar&buscar=<?= urlencode($filtros["buscar"] ?? ""); ?>&desde=<?= urlencode($filtros["desde"] ?? ""); ?>&hasta=<?= urlencode($filtros["hasta"] ?? ""); ?>&medio_pago=<?= urlencode($filtros["medio_pago"] ?? ""); ?>&vendedor_id=<?= urlencode($filtros["vendedor_id"] ?? ""); ?>"
                                        class="btn btn-success ms-sm-auto"
                                    >
                                        📥 Exportar a Excel
                                    </a>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- 🔹 RESUMEN -->
        <div class="row g-3 mb-4">


            <!-- CANTIDAD -->
            <div class="col-12 col-sm-6 col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small">
                                    Ventas encontradas
                                </div>

                                <h4 class="mb-0 mt-1">

                                    <?= $totalVentas ?? count($ventas ?? []); ?>

                                </h4>

                            </div>

                            <div class="fs-2">
                                🧾
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- MONTO -->
            <div class="col-12 col-sm-6 col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small">
                                    Monto total
                                </div>

                                <h4 class="mb-0 mt-1">

                                    $<?= number_format($totalMonto ?? 0, 2, ',', '.'); ?>

                                </h4>

                            </div>

                            <div class="fs-2">
                                💰
                            </div>

                        </div>

                    </div>

                </div>

            </div>


        </div>


        <!-- 🔹 LISTA DE VENTAS -->
        <div class="card shadow-sm">

            <div class="card-body p-2 p-md-3">


                <?php if(!empty($ventas)): ?>


                    <div class="d-flex flex-column gap-2">


                        <?php foreach($ventas as $venta): ?>


                            <div class="border rounded-3 p-3">


                                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">


                                    <!-- 🔹 INFORMACIÓN PRINCIPAL -->
                                    <div class="d-flex align-items-start gap-3">


                                        <!-- ICONO -->
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px; min-width: 45px;">

                                            🧾

                                        </div>


                                        <!-- DATOS -->
                                        <div>

                                            <h6 class="mb-1 fw-semibold">

                                                <?= htmlspecialchars($venta['cliente_nombre']); ?>

                                            </h6>


                                            <div class="text-muted small">

                                                DNI:
                                                <?= !empty($venta['cliente_dni'])
                                                    ? htmlspecialchars($venta['cliente_dni'])
                                                    : 'Sin DNI'; ?>

                                            </div>


                                            <?php if(!empty($venta['cliente_telefono'])): ?>

                                                <div class="text-muted small">

                                                    📞
                                                    <?= htmlspecialchars($venta['cliente_telefono']); ?>

                                                </div>

                                            <?php endif; ?>

                                        </div>

                                    </div>


                                    <!-- 🔹 MONTO -->
                                    <div class="text-lg-end">

                                        <div class="text-muted small">
                                            Monto
                                        </div>

                                        <div class="fw-bold fs-5 text-success">

                                            $<?= number_format(
                                                $venta['monto'],
                                                2,
                                                ',',
                                                '.'
                                            ); ?>

                                        </div>

                                    </div>


                                </div>


                                <!-- 🔹 DETALLES -->
                                <div class="border-top mt-3 pt-3">


                                    <div class="row g-2">


                                        <!-- CHANCES -->
                                        <div class="col-6 col-md-3">

                                            <div class="text-muted small">
                                                Chances
                                            </div>

                                            <div class="fw-semibold">

                                                🎟️
                                                <?= htmlspecialchars($venta['cantidad_chances']); ?>

                                            </div>

                                        </div>


                                        <!-- MEDIO DE PAGO -->
                                        <div class="col-6 col-md-3">

                                            <div class="text-muted small">
                                                Medio de pago
                                            </div>

                                            <div class="fw-semibold">

                                                💳
                                                <?= htmlspecialchars($venta['medio_pago']); ?>

                                            </div>

                                        </div>


                                        <!-- FECHA -->
                                        <div class="col-12 col-md-3">

                                            <div class="text-muted small">
                                                Fecha
                                            </div>

                                            <div class="fw-semibold">

                                                📅
                                                <?= date(
                                                    'd/m/Y H:i',
                                                    strtotime($venta['creado_en'])
                                                ); ?>

                                            </div>

                                        </div>


                                        <!-- VENDEDOR -->
                                        <?php if(
                                            ($_SESSION["rol"] ?? "") === "admin" ||
                                            ($_SESSION["rol"] ?? "") === "operador"
                                        ): ?>

                                            <div class="col-12 col-md-3">

                                                <div class="text-muted small">
                                                    Vendedor
                                                </div>

                                                <div class="fw-semibold">

                                                    👤
                                                    <?= htmlspecialchars(
                                                        $venta['vendedor_nombre'] ?? 'Sin datos'
                                                    ); ?>

                                                </div>

                                            </div>

                                        <?php endif; ?>


                                    </div>


                                    <!-- 🔹 COMPROBANTES -->
                                    <div class="mt-3 d-flex gap-2 flex-wrap">

                                        <?php if(
                                            ($_SESSION['rol'] ?? '') === 'vendedor' &&
                                            (int)$venta['vendedor_id'] === (int)$_SESSION['usuario_id']
                                        ): ?>

                                            <a href="/gestion_ventas/index.php?action=ventas.editar&id=<?= (int)$venta['id']; ?>"
                                            class="btn btn-sm btn-outline-warning">

                                                ✏️ Editar

                                            </a>

                                        <?php endif; ?>

                                        <?php if(($venta['cantidad_comprobantes'] ?? 0) > 0): ?>

                                            <a href="/gestion_ventas/index.php?action=ventas.comprobantes&id=<?= (int)$venta['id']; ?>"
                                            class="btn btn-sm btn-outline-primary">

                                                📎 Comprobantes
                                                (<?= (int)$venta['cantidad_comprobantes']; ?>)

                                            </a>

                                        <?php endif; ?>


                                        <?php if(($_SESSION['rol'] ?? '') === 'vendedor'): ?>

                                            <a href="/gestion_ventas/index.php?action=ventas.comprobante.agregar&id=<?= (int)$venta['id']; ?>"
                                            class="btn btn-sm btn-outline-success">

                                                ➕ Agregar comprobante

                                            </a>

                                        <?php endif; ?>

                                    </div>


                                </div>


                            </div>


                        <?php endforeach; ?>


                    </div>


                <?php else: ?>


                    <!-- 🔹 SIN VENTAS -->
                    <div class="text-center py-5">

                        <div class="fs-1 mb-2">
                            🧾
                        </div>

                        <h5>
                            No hay ventas registradas
                        </h5>

                        <p class="text-muted mb-3">

                            No se encontraron ventas con los filtros seleccionados.

                        </p>


                        <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

                            <a href="/gestion_ventas/index.php?action=ventas.crear"
                            class="btn btn-primary">

                                ➕ Registrar primera venta

                            </a>

                        <?php endif; ?>


                    </div>


                <?php endif; ?>


            </div>

        </div>

    </div>

</div>
```

</div>

<script>

function exportarExcel(){

    const params = new URLSearchParams(window.location.search);

    params.set('action', 'ventas.exportar');

    window.location.href =
        '/gestion_ventas/index.php?' + params.toString();

}

</script>

<?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/footer.php"); ?>
