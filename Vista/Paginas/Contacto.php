<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulario de Contacto</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      padding: 40px;
      /* Opcional: Si quieres centrar todo verticalmente en la página, pero normalmente no es necesario para formularios */
      /* display: flex; */
      /* justify-content: center; */
      /* align-items: center; */
      /* min-height: 100vh; */
    }

    .formulario-contacto {
      max-width: 600px;
      margin: auto; /* Centra el bloque .formulario-contacto horizontalmente */
      background: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      /* NUEVO: Centra el texto y elementos inline-block dentro del formulario */
      text-align: center;
    }

    .formulario-contacto h2 {
      margin-bottom: 20px;
      color: #343a40;
      /* Como .formulario-contacto ya tiene text-align: center, este h2 se centrará. */
    }

    .formulario-contacto label {
      display: block; /* Sigue siendo display:block para que cada label esté en su propia línea */
      margin-top: 15px;
      font-weight: bold;
      color: #495057;
      /* Como display es block, necesitas auto-márgenes o text-align en su padre si lo quieres centrar individualmente.
         Con text-align: center en .formulario-contacto, el texto dentro del label se centrará. */
    }

    .formulario-contacto input,
    .formulario-contacto textarea {
      width: 400px; /* Sigue ocupando todo el ancho disponible */
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ced4da;
      border-radius: 6px;
      box-sizing: border-box;
      /* NUEVO: Centra el texto dentro de los campos de input y textarea */
      text-align: center;
    }

    .formulario-contacto button {
      margin-top: 20px;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      /* NUEVO: Para centrar el botón, si es un elemento de bloque */
      display: block; /* Asegúrate de que sea un elemento de bloque para que margin: auto funcione */
      margin-left: auto; /* Combínalo con margin-right: auto */
      margin-right: auto;
      /* Opcional: Si quieres que el botón tenga un ancho específico para centrarlo mejor */
      /* width: fit-content; */
    }

    .formulario-contacto button:hover {
      background-color: #0056b3;
    }
</style>
</head>
<body>

  <div class="formulario-contacto">
  <img src="/Imagenes/pngwing.com.png" class="img-fluid" alt="" style="max-width: 300px; height: auto; display: block; margin: 0 auto 20px auto;">> 
  <br> 
  <h2>Contáctanos</h2>
    <br>
    <form action="/Vista/Paginas/EnviardeContacto.php" method="POST">
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" required>

      <label for="asunto">Asunto:</label>
      <input type="text" id="asunto" name="asunto" required>

      <label for="mensaje">Mensaje:</label>
      <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

      <button type="submit">Enviar mensaje</button>
    </form>
  </div>

</body>
</html>
