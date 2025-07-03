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
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5ZQJP9RJ');</script>
    <!-- End Google Tag Manager -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const temaGuardado = localStorage.getItem("tema") || "oscuro";
            document.body.classList.add(`tema-${temaGuardado}`);
        });

        function cambiarTema() {
            const body = document.body;
            if (body.classList.contains("tema-oscuro")) {
                body.classList.remove("tema-oscuro");
                body.classList.add("tema-claro");
                localStorage.setItem("tema", "claro");
            } else {
                body.classList.remove("tema-claro");
                body.classList.add("tema-oscuro");
                localStorage.setItem("tema", "oscuro");
            }
        }
    </script>

    <style>
        /* === Tema Oscuro === */
        body.tema-oscuro {
            background: linear-gradient(135deg, #1a1a1a, #1658A3);
            color: #FFC107;
            font-family: 'Arial', sans-serif;
        }

        body.tema-oscuro .piedepagina {
            background-color: #212529;
            color: #fff;
        }

        body.tema-oscuro .navbar {
            background-color: #212529 !important;
        }

        body.tema-oscuro .navbar-brand,
        body.tema-oscuro .nav-link {
            color: #ffcc00 !important;
            font-weight: bold;
        }

        body.tema-oscuro .nav-link:hover {
            color: #ffcc00 !important;
        }

        body.tema-oscuro .btn-apuesta {
            background-color: #ffcc00;
            color: #000;
        }

        body.tema-oscuro .btn-apuesta:hover {
            background-color: #e6b800;
        }

        body.tema-oscuro .hero {
            background: url('/imagenes/Motovelocidad4.png') no-repeat center center;
            background-size: cover;
            border-bottom: 5px solid #ffcc00;
            border-radius: 30px;
            padding: 3rem 1rem;
            text-align: center;
        }

        body.tema-oscuro .hero h1 {
            font-size: 5rem;
            color: rgb(255, 217, 0);
            text-shadow: 2px 2px 5px #000000;
            font-family: 'Pacifico', cursive;
            font-weight: 700;
        }

        body.tema-oscuro .event-card {
            background: #2d2d2d;
            border: 2px solid #ffcc00;
            color: #fff;
        }

        body.tema-oscuro .dropdown-menu {
            background-color: #1a1a1a;
        }

        body.tema-oscuro .menu-admin {
            background-color: #000;
            border: 2px solid #ffc107;
        }

        body.tema-oscuro .menu-admin .dropdown-item {
            color: #fff;
        }

        body.tema-oscuro .menu-admin .dropdown-item:hover {
            background-color: #ffc107;
            color: #000;
        }

        /* === Tema Claro === */
        body.tema-claro {
            background: linear-gradient(135deg, #f5f7fa, #cfd9df);
            color: #003366;
            font-family: 'Arial', sans-serif;
        }

        body.tema-claro .piedepagina {
            background-color: #f8f9fa;
            color: #212529;
        }

        body.tema-claro .piedepagina a {
            color: #0d6efd;
        }

        body.tema-claro .piedepagina a:hover {
            color: #0a58ca;
        }

        body.tema-claro .navbar {
            background-color: #ffffff !important;
        }

        body.tema-claro .navbar-brand,
        body.tema-claro .nav-link {
            color: #003366 !important;
            font-weight: bold;
        }

        body.tema-claro .nav-link:hover {
            color: #005599 !important;
        }

        body.tema-claro .btn-apuesta {
            background-color: #003366;
            color: #fff;
        }

        body.tema-claro .btn-apuesta:hover {
            background-color: #0056b3;
        }

        body.tema-claro .hero {
            background: url('/imagenes/Motovelocidad4.png') no-repeat center center;
            background-size: cover;
            border-bottom: 5px solid #007bff;
            border-radius: 30px;
            padding: 3rem 1rem;
            text-align: center;
        }

        body.tema-claro .hero h1 {
            font-size: 5rem;
            text-shadow: 2px 2px 5px rgb(255, 255, 255);
            font-family: 'Pacifico', cursive;
            font-weight: 700;
            color: #003366;

        }

        body.tema-claro .event-card {
            background: #ffffff;
            border: 2px solid #007bff;
            color: #000;
        }

        body.tema-claro .dropdown-menu {
            background-color: #ffffff;
        }

        body.tema-claro .menu-admin {
            background-color: #ffffff;
            border: 2px solid #007bff;
        }

        body.tema-claro .menu-admin .dropdown-item {
            color: #000000;
        }

        body.tema-claro .menu-admin .dropdown-item:hover {
            background-color: rgb(117, 125, 133);
            color: #000000;
        }

        /* Botón Cambiar Tema */
        .btn-cambiar-tema {
            background-color: transparent;
            color: #ffcc00;
            border: 1px solid #ffcc00;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .btn-cambiar-tema:hover {
            background-color: #ffcc00;
            color: #000;
        }

        body.tema-claro .btn-cambiar-tema {
            background-color: #003366;
            color: white;
            border: none;
        }

        body.tema-claro .btn-cambiar-tema:hover {
            background-color: #0056b3;
        }

        /* Otros elementos comunes */
        .event-card {
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

        /* NAV-TABS PERSONALIZADO */
        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs .nav-link {
            border: none;
            margin-right: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border-radius: 20px;
        }

        body.tema-oscuro .nav-tabs .nav-link {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        body.tema-oscuro .nav-tabs .nav-link:hover,
        body.tema-oscuro .nav-tabs .nav-link:focus {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        body.tema-oscuro .nav-tabs .nav-link.active {
            background-color: #ffc107 !important;
            color: #000 !important;
            border: 2px solid #000000 !important;
        }

        body.tema-claro .nav-tabs .nav-link {
            background-color: #003366 !important;
            color: #fff !important;
        }

        body.tema-claro .nav-tabs .nav-link:hover,
        body.tema-claro .nav-tabs .nav-link:focus {
            background-color: #003366 !important;
        }

        body.tema-claro .nav-tabs .nav-link.active {
            background-color: #003366 !important;
            color: #fff !important;
            border: 2px solid #000000 !important;
        }


        /* Tarjeta principal de carreras */
        .tarjeta-carreras {
            transition: background-color 0.3s, color 0.3s;
        }

        .encabezado-carreras {
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Subtarjetas de cada carrera */
        .sub-tarjeta .card-header {
            transition: background-color 0.3s, color 0.3s;
        }

        /* Estilos base (tema oscuro por defecto) */
        body.tema-oscuro .tarjeta-carreras {
            background-color: #1e1e1e;
            color: #fff;
        }

        body.tema-oscuro .encabezado-carreras {
            background-color: #ffc107;
            color: #000;
        }

        body.tema-oscuro .sub-tarjeta {
            background-color: #2d2d2d;
            color: #fff;
            border: 1px solid #ffc107;
        }

        body.tema-oscuro .sub-tarjeta .card-header {
            background-color: #000;
            color: #fff;
        }

        body.tema-oscuro .item-piloto {
            background-color: #1a1a1a;
            color: #fff;
        }

        /* Estilos para tema claro */
        body.tema-claro .tarjeta-carreras {
            background-color: #ffffff;
            color: #000;
        }

        body.tema-claro .encabezado-carreras {
            background-color: #003366;
            color: #fff;
        }

        body.tema-claro .sub-tarjeta {
            background-color: #f8f9fa;
            color: #000;
            border: 1px solid #003366;
        }

        body.tema-claro .sub-tarjeta .card-header {
            background-color: #e9ecef;
            color: #000;
        }

        body.tema-claro .item-piloto {
            background-color: #ffffff;
            color: #000;
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
        'ReestablecerContrasena',
        'ActivarCuenta',
        'EnviardeContacto',
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
        <img src="/imagenes/pngwing.com (5).png" alt="LogoWeb" class="img-fluid"
            style="max-width: 100px; margin-right: 10px; margin-top: 10px;">
        <h1 class="display-4 mt-3 md-0"
            style="font-family: 'WDXL Lubrifont TC', sans-serif; font-weight: 700; text-shadow: 5px 5px 4px rgb(0, 0, 0) ">
            ¡RaceStake Pro!
        </h1>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZQJP9RJ" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        $saldoActual = FormularioControlador::obtenerSaldoUsuario($_SESSION['id']);
        $saldo = number_format($saldoActual, 0, ',', '.');
        ?>

        <h2>
            <a class="nav-link fw-bold" align="right" href="?pagina=ApuMovi">
                <strong class="text-success">
                    <i class="fa-solid fa-sack-dollar fa-bounce" style="color: #198754;"></i>
                    <?php echo "$saldo&nbsp;"; ?>
                </strong>
            </a>
        </h2>
    <?php } ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <!-- Logo / Nombre del sitio -->
            <a class="navbar-brand fw-bold" href="?pagina=Inicio">
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
                            <ul class="dropdown-menu menu-admin" id="menuAdminDropdown" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item " href="?pagina=CargarCreditos"><i
                                            class="fas fa-wallet me-1"></i>Cargar Créditos</a></li>
                                <li><a class="dropdown-item " href="?pagina=CrearCarrera"><i
                                            class="fas fa-plus me-1"></i>Crear Carreras</a></li>
                                <li><a class="dropdown-item " href="?pagina=RegistrarPiloto"><i
                                            class="fas fa-user-plus me-1"></i>Registrar Pilotos</a></li>
                                <li><a class="dropdown-item " href="?pagina=AsignarPilotos"><i
                                            class="fas fa-users-cog me-1"></i>Asignar Pilotos</a></li>
                                <li><a class="dropdown-item " href="?pagina=RegistrarResultados"><i
                                            class="fas fa-clipboard-check me-1"></i>Registrar Resultados</a></li>
                                <li><a class="dropdown-item " href="?pagina=Ganancias"><i
                                            class="fas fa-clipboard-check me-1"></i>Ganancias</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Menú derecho -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['privilegios'])): ?>
                        <button onclick="cambiarTema()" class="btn btn-cambiar-tema">
                            Cambiar Tema
                        </button>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i><?= $_SESSION['nombre']; ?>
                            </a>
                            <ul class="dropdown-menu menu-admin" id="menuAdminDropdown" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item " href="?pagina=Perfil"><i
                                            class="fas fa-id-badge me-1"></i>Perfil</a></li>
                                <li><a class="dropdown-item " href="?pagina=historial_apuestas"><i
                                            class="fas fa-history me-1"></i>Historial de Apuestas</a></li>
                                <li><a class="dropdown-item " href="?pagina=ApuMovi"><i
                                            class="fas fa-file-invoice-dollar me-1"></i>Movimientos</a></li>
                                <li><a class="dropdown-item " href="?pagina=Ajustes"><i
                                            class="fas fa-cogs me-1"></i>Ajustes</a></li>
                                <li><a class="dropdown-item " href="?pagina=Salir"><i
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
<footer class="piedepagina text-center mt-auto">
    <div class="container-fluid">
        <h6 class="mb-3 fw-bold">Métodos de Pago</h6>

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
        <p class="mt-4 mb-2 fw-bold">&copy; RaceStake Pro. Todos los derechos reservados. 2025</p>

        <!-- Enlaces legales -->
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
            <a href="?pagina=Terminos" class="text-decoration-none">Términos y Condiciones</a>
            <span class="d-none d-sm-inline"></span>
            <a href="?pagina=Politicas" class="text-decoration-none">Políticas de Privacidad</a>
            <span class="d-none d-sm-inline"></span>
            <a href="?pagina=Contacto" class="text-decoration-none">Contacto</a>
        </div>
    </div>
    </div>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4VFG5S4BL7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-4VFG5S4BL7');
    </script>

</footer>




</html>