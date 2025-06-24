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
    <link rel="icon" type="image/x-icon" href="/Imagenes/icono.png">
    <!-- Agregar Google Fonts:-->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=WDXL+Lubrifont+TC&display=swap"
        rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a, #1658A3);
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .hero {
            background: url('/Imagenes/Motovelocidad4.png') no-repeat center center;
            background-size: cover;
            padding: 100px 0;
            text-align: center;
            border-bottom: 5px solid #ffcc00;
        }

        .hero h1 {
            font-size: 4.5rem;
            color: rgb(255, 217, 0);
            text-shadow: 5px 5px 4px rgb(0, 0, 0);
            /* Asegurar Pacifico para títulos */
            font-family: 'Pacifico', sans-serif;
            font-weight: 700;

        }

        .hero p {
            font-size: 1.5rem;
            text-shadow: 1px 1px 3px #000;
        }

        .btn-apuesta {
            background-color: #ffcc00;
            color: #000;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-apuesta:hover {
            background-color: #e6b800;
        }

        .navbar {
            background-color: #000 !important;
        }

        .nav-link {
            color: #fff !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #ffcc00 !important;
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
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <?php
    $listadoPaginasPrivadas = [
        'CargarCreditos',
        'Salir',
        'Perfil',
        'ApuMovi',
        'Ajustes',
        'RegistrarResultados',     // Nuevo: para registrar resultados de carrera (solo admin)
        'CrearCarrera',            // Nuevo: para crear carreras
        'RegistrarPiloto',         // Nuevo: para registrar pilotos
        'AsignarPilotos',          // Nuevo: para asignar pilotos a carreras
        'Apostar',                 // Nuevo: para que usuarios registrados hagan apuestas
        'historial_apuestas'        // Nuevo: para ver el historial de apuestas del usuario
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
        '404'
    ];

    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];

        if (in_array($pagina, $listadoPaginasPrivadas)) {
            // Requiere privilegios
            if (isset($_SESSION['privilegios']) && in_array($_SESSION['privilegios'], ['usuario', 'admin'])) {
                $paginaVerificada = $pagina;
            } else {
                // Redirigir si no tiene sesión
                header('Location: index.php?pagina=Login');
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

    <div style="display: flex; align-items: center; justify-content: center; ">
        <img src="/Imagenes/pngwing.com (5).png" alt="" width="10%" height="auto" style="margin-right: 15px;">
        <h1 style="font-size: 4.5rem; text-shadow: 2px 2px 4px #000; font-family: 'WDXL Lubrifont TC',
    sans-serif; font-weight: 700; white-space: nowrap;">
            ¡RaceStake Pro</h1>
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
                    <?php echo "&nbsp;$saldo&nbsp;"; ?>
                </strong>
            </a>
        </h2>
    <?php } ?>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">

            <!-- Aquí iría tu logo o menú izquierdo -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold small" href="?pagina=Inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold small" href="?pagina=ProximosEventos">Próximos Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold small" href="?pagina=Resultados">Resultados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold small" href="?pagina=Apostar">Apostar</a>
                </li>
                <?php if (isset($_SESSION['privilegios']) && $_SESSION['privilegios'] === 'admin'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-white" href="#" role="button"
                            data-bs-toggle="dropdown">Administrar</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?pagina=CargarCreditos">Cargar Créditos</a></li>
                            <li><a class="dropdown-item" href="?pagina=CrearCarrera">Crear Carreras</a></li>
                            <li><a class="dropdown-item" href="?pagina=RegistrarPiloto">Registrar Pilotos</a></li>
                            <li><a class="dropdown-item" href="?pagina=AsignarPilotos">Asignar Pilotos a Carreras</a></li>
                            <li><a class="dropdown-item" href="?pagina=RegistrarResultados">Registrar Resultados</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>


            <!-- Menú derecho -->
            <ul class="navbar-nav ms-auto me-0">
                <?php if (isset($_SESSION['privilegios'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['nombre']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item small" href="?pagina=Perfil">Perfil</a></li>
                            <li><a class="dropdown-item small" href="?pagina=historial_apuestas">Historial de Apuestas</a>
                            </li>
                            <li><a class="dropdown-item small" href="?pagina=ApuMovi">Movimientos</a></li>
                            <li><a class="dropdown-item small" href="?pagina=Ajustes">Ajustes</a></li>
                            <li><a class="dropdown-item small" href="?pagina=Salir">Salir</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold small" href="?pagina=Registro">Registrarte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold small" href="?pagina=Login">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <?php
        if ($paginaVerificada === 'Salir') {
            header('Location: Vista/Paginas/Salir.php');
            exit;
        } else {
            include "Vista/Paginas/$paginaVerificada.php";
        }
        ?>
</body>
</div>
<!-- Pie de página -->
<footer class="bg-dark text-center text-white py-3">
    <h5 class="m-2">Métodos de Pago</h5>
    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
        <img src="imagenes/bancolombia.png" alt="Bancolombia" height="40">
        <img src="imagenes/nequi.png" alt="Nequi" height="40">
        <img src="imagenes/efecty.svg" alt="Efecty" height="40">
        <img src="imagenes/PSE.png" alt="PSE" height="40">
    </div>
    <p class="mt-3">&copy; RaceStake Pro. Todos los derechos reservados. 2025</p>
    <p><a href="?pagina=Terminos" class="text-white">Términos y Condiciones</a> | <a href="?pagina=Politicas"
            class="text-white">Politicas de Privacidad</a></p><a href="?pagina=Contacto" class="text-white">Contacto</a>
    </p>
</footer>



</html>