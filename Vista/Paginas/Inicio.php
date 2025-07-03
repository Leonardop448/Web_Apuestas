<title>Inicio</title>

<body>

  <!-- Hero principal -->
  <div class="container mt-3">
    <div class="hero d-flex flex-column align-items-center justify-content-center text-center py-5 px-3">
      <h1 class="fw-bold mb-4">
        ¡La emoción de las carreras<br> y las apuestas en un solo lugar!
      </h1>
      <a href="?pagina=Apostar" class="btn btn-apuesta">¡Apuesta Ahora!</a>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="container mt-4">
    <?php if ($paginaVerificada == "Inicio") { ?>
      <h2 class="text-center"
        style="font-size: 4rem; text-shadow: 5px 5px 4px rgb(0, 0, 0); font-family: 'Pacifico', sans-serif; font-weight: 700;">
        Próximas Carreras Destacadas
      </h2>

      <div class="row row-cols-1 row-cols-md-3 g-3 mt-3">
        <div class="col">
          <div class="event-card h-100">
            <h3>Valida Nacional de Cartago</h3>
            <p><i class="fa-solid fa-calendar"></i> 15 de Diciembre, 2025</p>
            <p><i class="fa-solid fa-location-dot"></i> Circuito Callejero La Estación</p>
          </div>
        </div>
        <div class="col">
          <div class="event-card h-100">
            <h3>Carreras Roldanillo</h3>
            <p><i class="fa-solid fa-calendar"></i> 22 de Diciembre, 2025</p>
            <p><i class="fa-solid fa-location-dot"></i> Circuito Callejero Roldanillo</p>
          </div>
        </div>
        <div class="col">
          <div class="event-card h-100">
            <h3>Carreras Dosquebradas</h3>
            <p><i class="fa-solid fa-calendar"></i> 30 de Diciembre, 2025</p>
            <p><i class="fa-solid fa-location-dot"></i> Pista Dosquebradas</p>
          </div>
        </div>
      </div>

      <!-- Carrusel -->
      <div id="carouselInicio" class="carousel slide mt-5 mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="imagenes/carrera1.jpg" class="d-block w-100 img-fluid" alt="Carrera 1">
          </div>
          <div class="carousel-item">
            <img src="imagenes/carrera2.jpg" class="d-block w-100 img-fluid" alt="Carrera 2">
          </div>
          <div class="carousel-item">
            <img src="imagenes/carrera3.jpg" class="d-block w-100 img-fluid" alt="Carrera 3">
          </div>
          <div class="carousel-item">
            <img src="imagenes/carrera4.jpg" class="d-block w-100 img-fluid" alt="Carrera 4">
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
      <div class="container mt-3">
        <?php include("Vista/Paginas/$paginaVerificada.php"); ?>
      </div>
    <?php } ?>
  </div>

</body>

</html>