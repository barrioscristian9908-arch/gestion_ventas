<!doctype html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iniciar sesión - Gestión Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          crossorigin="anonymous">

    <style>

        body{
            min-height: 100vh;
            background-image: url('/gestion_ventas/public/images/fondo.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .login-container{
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.25);
        }

        .login-card{
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 18px;
        }

        .login-logo{
            width: 85px;
            height: 85px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .login-title{
            font-weight: 600;
        }

        .form-control{
            border-radius: 10px;
            padding: 12px 14px;
        }

        .btn-login{
            border-radius: 10px;
            padding: 12px;
            font-weight: 500;
        }

    </style>

</head>


<body>

    <div class="login-container d-flex justify-content-center align-items-center p-3">

        <div class="card login-card shadow-lg">

            <div class="card-body p-4 p-md-5">


                <!-- 🔹 LOGO -->
                <div class="text-center mb-4">

                    <img src="/gestion_ventas/public/images/logo.png"
                         alt="Logo"
                         class="login-logo">

                    <h3 class="login-title mb-1">
                        Iniciar sesión
                    </h3>

                    <p class="text-muted mb-0">
                        Gestión Ventas
                    </p>

                </div>


                <!-- 🔹 ALERTA -->
                <?php require_once("c://xampp/htdocs/gestion_ventas/views/layouts/alert.php"); ?>


                <!-- 🔹 FORMULARIO -->
                <form action="/gestion_ventas/index.php?action=auth.login"
                      method="POST">


                    <!-- Usuario -->
                    <div class="mb-3">

                        <label for="user" class="form-label">
                            Usuario
                        </label>

                        <input type="text"
                               class="form-control"
                               id="user"
                               name="user"
                               placeholder="Ingresá tu usuario"
                               autocomplete="username"
                               required>

                    </div>


                    <!-- Contraseña -->
                    <div class="mb-4">

                        <label for="pass" class="form-label">
                            Contraseña
                        </label>

                        <input type="password"
                               class="form-control"
                               id="pass"
                               name="pass"
                               placeholder="Ingresá tu contraseña"
                               autocomplete="current-password"
                               required>

                    </div>


                    <!-- Botón -->
                    <div class="d-grid">

                        <button type="submit"
                                class="btn btn-primary btn-login">
                            Ingresar
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>