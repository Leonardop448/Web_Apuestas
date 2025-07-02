<title>Contáctanos</title>
<!-- Solo contenido, no <html>, <head> ni <body> -->
<div class="formulario-contacto mt-5">
  <img src="/imagenes/pngwing.com.png" class="img-fluid" alt="Logo RaceStake Pro"
    style="max-width: 300px; height: auto; display: block; margin: 0 auto 20px auto;">
  <h2>Contáctanos</h2>

  <form action="index.php?pagina=EnviardeContacto" method="POST">
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

<style>
  .formulario-contacto {
    max-width: 600px;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  .formulario-contacto h2 {
    margin-bottom: 20px;
    color: #343a40;
  }

  .formulario-contacto label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #495057;
  }

  .formulario-contacto input,
  .formulario-contacto textarea {
    width: 100%;
    max-width: 400px;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    box-sizing: border-box;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    display: block;
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
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  .formulario-contacto button:hover {
    background-color: #0056b3;
  }
</style>