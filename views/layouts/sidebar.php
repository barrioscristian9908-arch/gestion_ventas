<!-- 🔹 SIDEBAR -->
<div class="col-md-2 d-none d-md-block bg-white vh-100 shadow-sm p-3">

    <h5>Menú</h5>

    <ul class="nav flex-column">

        <!-- PANEL -->
        <li class="nav-item mb-2">
            <a class="nav-link active"
               href="/gestion_ventas/index.php?action=panel">
                🏠 Panel
            </a>
        </li>


        <!-- VENTAS -->
        <li class="nav-item mb-2">
            <a class="nav-link"
               href="/gestion_ventas/index.php?action=ventas">
                🧾 Ventas
            </a>
        </li>


        <!-- REGISTRAR VENTA -->
        <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

            <li class="nav-item mb-2">
                <a class="nav-link"
                   href="/gestion_ventas/index.php?action=ventas.crear">
                    ➕ Registrar venta
                </a>
            </li>

        <?php endif; ?>


        <!-- REPORTES -->
        <?php if(
            ($_SESSION["rol"] ?? "") === "admin" ||
            ($_SESSION["rol"] ?? "") === "operador"
        ): ?>

            <li class="nav-item mb-2">
                <a class="nav-link"
                   href="/gestion_ventas/index.php?action=reportes">
                    📊 Reportes
                </a>
            </li>

        <?php endif; ?>


        <!-- COMISIONES -->
        <li class="nav-item mb-2">
            <a class="nav-link"
               href="/gestion_ventas/index.php?action=comisiones">
                💰 Comisiones
            </a>
        </li>


        <!-- USUARIOS -->
        <?php if(($_SESSION["rol"] ?? "") === "admin"): ?>

            <li class="nav-item mb-2">
                <a class="nav-link"
                   href="/gestion_ventas/index.php?action=usuarios">
                    👥 Usuarios
                </a>
            </li>

        <?php endif; ?>

    </ul>

</div>


<!-- 🔹 MENÚ MOBILE -->
<div class="offcanvas offcanvas-start"
     tabindex="-1"
     id="menuMobile">

    <div class="offcanvas-header">

        <h5 class="offcanvas-title">
            Menú
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas">
        </button>

    </div>


    <div class="offcanvas-body">

        <ul class="nav flex-column">

            <!-- PANEL -->
            <li class="nav-item mb-2">

                <a class="nav-link"
                   href="/gestion_ventas/index.php?action=panel">
                    🏠 Panel
                </a>

            </li>


            <!-- VENTAS -->
            <li class="nav-item mb-2">

                <a class="nav-link"
                   href="/gestion_ventas/index.php?action=ventas">
                    🧾 Ventas
                </a>

            </li>


            <!-- REGISTRAR VENTA -->
            <?php if(($_SESSION["rol"] ?? "") === "vendedor"): ?>

                <li class="nav-item mb-2">

                    <a class="nav-link"
                       href="/gestion_ventas/index.php?action=ventas.crear">
                        ➕ Registrar venta
                    </a>

                </li>

            <?php endif; ?>


            <!-- REPORTES -->
            <?php if(
                ($_SESSION["rol"] ?? "") === "admin" ||
                ($_SESSION["rol"] ?? "") === "operador"
            ): ?>

                <li class="nav-item mb-2">

                    <a class="nav-link"
                       href="/gestion_ventas/index.php?action=reportes">
                        📊 Reportes
                    </a>

                </li>

            <?php endif; ?>


            <!-- COMISIONES -->
            <li class="nav-item mb-2">

                <a class="nav-link"
                   href="/gestion_ventas/index.php?action=comisiones">
                    💰 Comisiones
                </a>

            </li>


            <!-- USUARIOS -->
            <?php if(($_SESSION["rol"] ?? "") === "admin"): ?>

                <li class="nav-item mb-2">

                    <a class="nav-link"
                       href="/gestion_ventas/index.php?action=usuarios">
                        👥 Usuarios
                    </a>

                </li>

            <?php endif; ?>

        </ul>

    </div>

</div>