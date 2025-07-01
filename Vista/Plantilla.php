<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/b84470ec17.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="/imagenes/icono.png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=WDXL+Lubrifont+TC&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a, #1658A3);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #000 !important;
        }

        .nav-link {
            color: #ffcc00 !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #ffcc00 !important;
        }

        .btn-apuesta {
            background-color: #ffcc00;
            color: #000;
            font-weight: bold;
            padding: .5rem 1rem;
            font-size: 1rem;
            border-radius: 5px;
        }

        .btn-apuesta:hover {
            background-color: #e6b800;
        }

        .hero {
            background: url('/imagenes/Motovelocidad4.png') no-repeat center center;
            background-size: cover;
            padding: 3rem 1rem;
            text-align: center;
            border-bottom: 5px solid #ffcc00;
            border-radius: 30px;
        }

        .hero h1 {
            font-size: 2rem;
            color: rgb(255, 217, 0);
            text-shadow: 2px 2px 5px #000;
            font-family: 'Pacifico', cursive;
            font-weight: 700;
        }

        @media (min-width: 768px) {
            .hero {
                padding: 6rem 3rem;
            }

            .hero h1 {
                font-size: 2.5rem;
            }
        }

        @media (min-width: 1200px) {
            .hero {
                padding: 6rem 4rem;
                min-height: 400px;
            }

            .hero h1 {
                font-size: 3.5rem;
            }
        }

        .event-card {
            background: #2d2d2d;
            border: 2px solid #ffcc00;
            border-radius: 10px;
            padding: 15px;
            margin: 10px;
            transition: transform 0.3s;
        }

        .event-card:hover {
            transform: scale(1.05);
        }

        .carousel-item img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            border-radius: 20px;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
            transition: 0.3s ease-in-out;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        .dropdown-menu {
            background-color: #1a1a1a;
        }

        /* NAV-TABS PERSONALIZADO */
        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs .nav-link {
            background-color: #ffc107 !important;
            color: #000 !important;
            border: none;
            margin-right: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border-radius: 20px;
            /* Bordes redondeados */
        }

        .nav-tabs .nav-link:hover,
        .nav-tabs .nav-link:focus {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .nav-tabs .nav-link.active {
            background-color: #ffc107 !important;
            color: #000 !important;
            border: 2px solid #000 !important;
            border-radius: 20px;
        }
    </style>

</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    $listadoPaginasPrivadas = [
        'CargarCreditos',
        'Salir',
        'Perfil',
        'ApuMovi',
        'Ajustes',
        'RegistrarResultados',
        'CrearCarrera',
        'RegistrarPiloto',
        'AsignarPilotos',
        'Apostar',
        'Ganancias',
        'historial_apuestas'
    ];
    $listadoPaginasPublicas = [
        'Inicio',
        'Login',
        'Registro',
        'RecuperarContrasena',
        'ActivarCuenta',
        'Politicas',
        'Terminos',
        'Contacto',
        'ProximosEventos',
        'Resultados',
        '404',
        'exportar_ganancia_pdf'
    ];

    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];

        if (in_array($pagina, $listadoPaginasPrivadas)) {
            // Requiere privilegios
            if (isset($_SESSION['privilegios']) && in_array($_SESSION['privilegios'], ['usuario', 'admin'])) {
                $paginaVerificada = $pagina;
            } else {
                // Redirigir si no tiene sesión
                echo "<script>window.location.href = 'index.php?pagina=Login';</script>";
                exit();
            }
        } elseif (in_array($pagina, $listadoPaginasPublicas)) {
            // Acceso libre, no requiere sesión
            $paginaVerificada = $pagina;
        } else {
            // Página no reconocida
            $paginaVerificada = '404';
        }
    } else {
        // Página por defecto
        $paginaVerificada = 'Inicio';
    }
    ?>

    <div class="d-flex flex-md-row align-items-center justify-content-center text-center text-md-start">
        <img src="/imagenes/pngwing.com (5).png" alt="" class="img-fluid" style="max-width: 100px; margin-right: 15px;">
        <h1 class="display-4 mt-3 mt-md-0"
            style="font-family: 'WDXL Lubrifont TC', sans-serif; font-weight: 700; text-shadow: 2px 2px 4px #000; color: #ffc107;">
            ¡RaceStake Pro
        </h1>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        $saldoActual = FormularioControlador::obtenerSaldoUsuario($_SESSION['id']);
        $saldo = number_format($saldoActual, 0, ',', '.');
        ?>
        <h2>
            <a class="nav-link text-white fw-bold" align="right" href="?pagina=ApuMovi">
                <strong class="text-warning">
                    <i class="fa-solid fa-sack-dollar fa-bounce" style="color: #ffc107;"></i>
                    <?php echo "$saldo&nbsp;"; ?>
                </strong>
            </a>
        </h2>
    <?php } ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <!-- Logo / Nombre del sitio -->
            <a class="navbar-brand fw-bold text-warning" href="?pagina=Inicio">
                <i class="fas fa-flag-checkered me-1"></i>RaceStake Pro
            </a>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler border-warning" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido colapsable -->
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <!-- Menú izquierdo -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="?pagina=ProximosEventos">
                            <i class="fas fa-calendar-alt me-1"></i>Próximos Eventos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="?pagina=Resultados">
                            <i class="fas fa-trophy me-1"></i>Resultados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="?pagina=Apostar">
                            <i class="fas fa-coins me-1"></i>Apostar
                        </a>
                    </li>

                    <?php if (isset($_SESSION['privilegios']) && $_SESSION['privilegios'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="adminDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tools me-1"></i>Administrar
                            </a>
                            <ul class="dropdown-menu bg-dark border-warning" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item text-white" href="?pagina=CargarCreditos"><i
                                            class="fas fa-wallet me-1"></i>Cargar Créditos</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=CrearCarrera"><i
                                            class="fas fa-plus me-1"></i>Crear Carreras</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=RegistrarPiloto"><i
                                            class="fas fa-user-plus me-1"></i>Registrar Pilotos</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=AsignarPilotos"><i
                                            class="fas fa-users-cog me-1"></i>Asignar Pilotos</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=RegistrarResultados"><i
                                            class="fas fa-clipboard-check me-1"></i>Registrar Resultados</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=Ganancias"><i
                                            class="fas fa-clipboard-check me-1"></i>Ganancias</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Menú derecho -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['privilegios'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i><?= $_SESSION['nombre']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark border-warning"
                                aria-labelledby="userDropdown">
                                <li><a class="dropdown-item text-white" href="?pagina=Perfil"><i
                                            class="fas fa-id-badge me-1"></i>Perfil</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=historial_apuestas"><i
                                            class="fas fa-history me-1"></i>Historial de Apuestas</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=ApuMovi"><i
                                            class="fas fa-file-invoice-dollar me-1"></i>Movimientos</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=Ajustes"><i
                                            class="fas fa-cogs me-1"></i>Ajustes</a></li>
                                <li><a class="dropdown-item text-white" href="?pagina=Salir"><i
                                            class="fas fa-sign-out-alt me-1"></i>Salir</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="?pagina=Registro">
                                <i class="fas fa-user-plus me-1"></i>Registrarte
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="?pagina=Login">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container">
        <?php
        if ($paginaVerificada === 'Salir') {
            header('Location: Vista/Paginas/Salir.php');
            exit;
        } else {
            include "Vista/Paginas/$paginaVerificada.php";
        }
        ?>


</body>
<br>
</div>
<!-- Pie de página -->
<footer class="bg-dark text-white text-center mt-auto">
    <div class="container-fluid">
        <h5 class="mb-3">Métodos de Pago</h5>

        <!-- Logos de pago -->
        <div class="row justify-content-center g-3">
            <div class="col-6 col-sm-3 col-md-2">
                <img src="/imagenes/bancolombia.png" alt="Bancolombia" class="img-fluid">
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <img src="/imagenes/nequi.png" alt="Nequi" class="img-fluid">
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <img src="/imagenes/efecty.svg" alt="Efecty" class="img-fluid">
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <img src="/imagenes/PSE.png" alt="PSE" class="img-fluid">
            </div>
        </div>

        <!-- Texto legal -->
        <p class="mt-4 mb-2">&copy; RaceStake Pro. Todos los derechos reservados. 2025</p>

        <!-- Enlaces legales -->
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
            <a href="?pagina=Terminos" class="text-white text-decoration-none">Términos y Condiciones</a>
            <span class="text-white d-none d-sm-inline">|</span>
            <a href="?pagina=Politicas" class="text-white text-decoration-none">Políticas de Privacidad</a>
            <span class="text-white d-none d-sm-inline">|</span>
            <a href="?pagina=Contacto" class="text-white text-decoration-none">Contacto</a>
        </div>
    </div>
    </div>

</footer>




</html>