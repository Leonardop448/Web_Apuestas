<title>Inicio</title>

<head>
  <style>
    body {
      background: linear-gradient(135deg, #1a1a1a, #1658A3);
      color: #fff;
      font-family: 'Arial', sans-serif;
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
  </style>
</head>

<body>

  <!-- Sección Hero -->
  <div class="hero">
    <h1>¡La emoción de las carreras<br> y las apuestas en un solo lugar!</h1>
    <a href="?pagina=Apostar" class="btn btn-apuesta">¡Apuesta Ahora!</a>
  </div>

  <!-- Contenido Principal -->
  <div class="container mt-5">
    <?php if ($paginaVerificada == "Inicio") { ?>
      <h2 style="text-align: center; font-size: 2.5rem;
      color:rgb(255, 217, 0);
      text-shadow: 5px 5px 4px rgb(0, 0, 0);
      /* Asegurar Pacifico para títulos */
      font-family: 'Pacifico', sans-serif;
      font-weight: 700; ">Próximas Carreras Destacadas</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="event-card">
            <h3>Valida Nacional de Cartago</h3>
            <p><i class="fa-solid fa-calendar"></i> 15 de Diciembre, 2025</p>
            <p><i class="fa-solid fa-location-dot"></i> Circuito Callejero La Estacion</p>

          </div>
        </div>
        <div class="col-md-4">
          <div class="event-card">
            <h3>Carreras Roldanillo</h3>
            <p><i class="fa-solid fa-calendar"></i> 22 de Diciembre, 2025</p>
            <p><i class="fa-solid fa-location-dot"></i> Circuito Callejero Roldanillo</p>

          </div>
        </div>
        <div class="col-md-4">
          <div class="event-card">
            <h3>Carreras Dosquebradas</h3>
            <p><i class="fa-solid fa-calendar"></i> 30 de Diciembre, 2025</p>
            <p><i class="fa-solid fa-location-dot"></i> Pista Dosquebradas</p>

          </div>
        </div>
      </div>
      <!-- Carrusel de imágenes -->
      <div id="carouselInicio" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="imagenes/carrera1.jpg" class="d-block w-100" alt="Carrera 1">
          </div>
          <div class="carousel-item">
            <img src="imagenes/carrera2.jpg" class="d-block w-100" alt="Carrera 2">
          </div>
          <div class="carousel-item">
            <img src="imagenes/carrera3.jpg" class="d-block w-100" alt="Carrera 3">
          </div>
          <div class="carousel-item">
            <img src="imagenes/carrera4.jpg" class="d-block w-100" alt="Carrera 4">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselInicio" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselInicio" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>

    <?php } else { ?>
      <div class="container-fluid mt-3">
        <?php include("Vista/Paginas/$paginaVerificada.php"); ?>
      </div>
    <?php } ?>
  </div>


</body>

</html>