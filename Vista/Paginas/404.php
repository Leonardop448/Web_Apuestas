<title>Error 404 - Página no encontrada</title>

<style>
  .error-container {
    text-align: center;
    padding: 40px;
    border-radius: 10px;


  }

  .error-code {
    font-size: 120px;
    font-weight: 700;
    color: #dc3545;
    /* Rojo de Bootstrap para destacar */
    line-height: 1;
    margin-bottom: 20px;
  }

  .error-message {
    font-size: 30px;
    font-weight: 500;
    margin-bottom: 20px;
  }

  .error-description {
    font-size: 18px;
    color: rgb(199, 201, 202);
    margin-bottom: 30px;
  }

  .btn-home {
    background-color: #FFC107;
    /* Azul primario de Bootstrap */
    border-color: #FFC107;
    color: #ffffff;
    padding: 12px 25px;
    font-size: 18px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .btn-home:hover {
    background-color: #e6b800;
    border-color: #e6b800;
    color: #000000;
  }
</style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="error-container">
          <div class="error-code">404</div>
          <div class="error-message">¡Oops! Página no encontrada</div>
          <div class="error-description">
            Parece que la página que estás buscando no existe o se ha movido.
            No te preocupes, puedes volver a la página de inicio.
          </div>
          <a href="?pagina=Inicio" class="btn btn-home">Volver a la página de inicio</a>
        </div>
      </div>
    </div>
  </div>



  </html>