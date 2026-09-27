<!doctype html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ingresar - Control Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">

    <style>

        body{
            background-image: url('/control_ventas/public/images/fondo.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

    </style>

</head>

<body>

    <div class="container d-flex justify-content-center align-items-center"
         style="height: 100vh;">

        <form action="/gestion_ventas/index.php?action=auth.login"
              method="POST"
              class="border rounded-3 p-4 bg-white shadow"
              style="width: 25rem;">

            <!-- Mensaje de alerta -->

            <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/alert.php"); ?>

            <h2 class="mb-4 text-center">Control Ventas</h2>

            <div class="mb-3">

                <label for="user" class="form-label">
                    Usuario
                </label>

                <input type="text"
                       class="form-control"
                       id="user"
                       name="user"
                       required>

            </div>

            <div class="mb-3">

                <label for="pass" class="form-label">
                    Contraseña
                </label>

                <input type="password"
                       class="form-control"
                       id="pass"
                       name="pass"
                       required>

            </div>

            <div class="d-grid">

                <button type="submit" class="btn btn-primary">
                    Ingresar
                </button>

            </div>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwxH9j09JcYn3nv7wiPVlz7YYwJrVFcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous">
    </script>

</body>

</html>