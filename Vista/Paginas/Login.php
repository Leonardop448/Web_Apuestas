<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicia Sesión</title>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="/Imagenes/pngwing.com (6).png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post" action="index.php?pagina=Login">

                        <div class="divider d-flex align-items-center my-4 ">
                            <p class="mx-1 mb-0">
                            <h4 class="text-center fw-bold">Inicia Sesión</h4>
                            </p>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label " for="email">
                                <h5 class=" fw-bold">Correo Electronico</h5>
                            </label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg"
                                placeholder="Ingrese su correo electronico" />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label fw-bold" for="contrasena">
                                <h5 class=" fw-bold">Contraseña</h5>
                            </label>
                            <input type="password" id="contrasena" name="contrasena"
                                class="form-control form-control-lg" placeholder="Ingrese su contraseña" />

                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" id="recuerdame" />
                                <label class="form-check-label" for="recuerdame">
                                    Recordarme
                                </label>
                            </div>
                            <a href="?location=RecuperarContrasena" class="text-body">Olvido su contraseña?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <input type="submit" class="btn btn-primary btn-lg" name="ingresar" value="Ingresar"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">
                            <p class="small fw-bold mt-2 pt-1 mb-0">No tienes una cuenta? <a href="?pagina=Registro"
                                    class="link-danger">Registrate</a></p>
                        </div>
                        <?php
                        $ingreso = FormularioControlador::ingreso();
                        ?>
                    </form>




                </div>
            </div>
        </div>

    </section>