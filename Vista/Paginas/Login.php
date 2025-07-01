<title>Iniciar Sesion</title>
<section class="vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <!-- Imagen -->
            <div class="col-md-6 col-lg-5 mb-4 mb-md-0 text-center">
                <img src="/imagenes/pngwing.com (6).png" class="img-fluid" alt="Login image" style="max-height: 300px;">
            </div>

            <!-- Formulario -->
            <div class="col-md-6 col-lg-5">
                <div class="card bg-dark border-warning text-white shadow-lg rounded-4">
                    <div class="card-header bg-warning text-dark text-center">
                        <h4 class="fw-bold m-0">Inicia Sesión</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?pagina=Login">

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg"
                                    placeholder="correo@ejemplo.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="contrasena" class="form-label fw-bold">Contraseña</label>
                                <input type="password" id="contrasena" name="contrasena"
                                    class="form-control form-control-lg" placeholder="******" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="recuerdame">
                                    <label class="form-check-label" for="recuerdame">Recordarme</label>
                                </div>
                                <a href="?pagina=RecuperarContrasena" class="text-white small">¿Olvidaste tu
                                    contraseña?</a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="ingresar" class="btn btn-warning fw-bold btn-lg">
                                    Ingresar
                                </button>
                            </div>

                            <p class="text-center small fw-bold mt-3 mb-0">
                                ¿No tienes una cuenta?
                                <a href="?pagina=Registro" class="link-danger">Regístrate</a>
                            </p>

                            <?php
                            $ingreso = FormularioControlador::ingreso();
                            ?>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>