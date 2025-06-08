<?php

include("Modelo/Formularios.Modelo.php");

class FormularioControlador
{
    /// REGISTRAR USUARIO
    static public function registrarUsuario()
    {
        if (isset($_POST['nombre'])) {
            if (
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre"]) &&
                preg_match('/^[0-9a-zA-Z@#\-_$%^&+=§!? ]{6,50}+$/', $_POST["contrasena"]) &&
                preg_match('/^[0-9]+$/', $_POST["cedula"]) &&
                preg_match('/^[0-9]+$/', $_POST["telefono"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"])
            ) {
                $nombre = ucwords($_POST["nombre"]);
                $pass = password_hash($_POST["contrasena"], PASSWORD_BCRYPT);
                $cedula = $_POST["cedula"];
                $tel = $_POST["telefono"];
                $email = mb_strtolower($_POST["email"]);

                $datos = array($nombre, $pass, $cedula, $tel, $email);

                $respuesta = ModeloFormularios::registroUsuarios($datos);

                return $respuesta;
            }
        }
    }

    /// LOGIN DE USUARIO
static public function ingreso()
{
    $limpiaVariablesPost = '<script>
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>';

    if (isset($_POST['email'])) {
        // Validar campos
        if (
            preg_match('/^[0-9a-zA-Z@#\-_$%^&+=§!? ]{6,50}+$/', $_POST["contrasena"]) &&
            preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"])
        ) {
            $email = mb_strtolower($_POST["email"]);

            // Verificar usuario en la base de datos (solo por email)
            $resultado = ModeloFormularios::verificarUsuarios([$email]);

            if ($resultado && isset($resultado["email"])) {
                // Normalizar correo en minúsculas para comparación
                if (
                    strtolower($resultado["email"]) === $email &&
                    password_verify($_POST["contrasena"], $resultado["contrasena"])
                ) {
                    $_SESSION['cedula'] = $resultado["cedula"];
                    $_SESSION['nombre'] = $resultado["nombre"];
                    $_SESSION['privilegios'] = $resultado["privilegios"];
                    $_SESSION['tokenUsuario'] = $resultado["tokenUsuario"];
                    $_SESSION['email'] = $resultado["email"];
                    $_SESSION['telefono'] = $resultado["telefono"];

                    echo $limpiaVariablesPost;
                    echo "<script>window.location.replace('index.php?pagina=Perfil');</script>";
                    exit;
                }
            }

            echo $limpiaVariablesPost;
            echo '<div class="alert alert-danger">Error al ingresar, usuario o contraseña incorrecto</div>';
        } else {
            echo $limpiaVariablesPost;
            echo '<div class="alert alert-danger">Error al ingresar, usuario o contraseña incorrecto</div>';
        }
    }
}


    /// VERIFICAR RECARGA
    static public function verificarRecargar()
    {
        $limpiaVariablesPost = '<script>
                if(window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>';

        if (isset($_POST['cedula'])) {
            if (
                preg_match('/^[0-9]+$/', $_POST["cedula"]) &&
                preg_match('/^[0-9]+$/', $_POST["cantidad"])
            ) {
                $cedula = $_POST["cedula"];
                $cantidad = $_POST["cantidad"];

                $resultado = ModeloFormularios::verificarRecargas(array($cedula, $cantidad));

                if (isset($resultado["token"])) {
                    $token = $resultado["token"];
                    echo $limpiaVariablesPost;
                    return $resultado;
                }
            } else {
                echo $limpiaVariablesPost;
                echo '<div class="alert alert-danger">Usuario no existe!!!!</div>';
            }
        }
    }

    /// HACER RECARGA
    static public function recargar()
    {
        $limpiaVariablesPost = '<script>
                if(window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>';

        if (isset($_POST['token'])) {
            if (
                preg_match('/^[0-9A-Z]+$/', $_POST["token"]) &&
                preg_match('/^[0-9]+$/', $_POST["valor"])
            ) {
                $token = $_POST["token"];
                $cantidad = $_POST["valor"];
                $gestor = $_SESSION['tokenUsuario'];

                $resultado = ModeloFormularios::recargas(array($token, $cantidad, $gestor));

                if (isset($resultado["id_movimiento"])) {
                    echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        Su recarga por <strong>$$cantidad</strong> fue exitosa!!
                    </div>";
                    echo $limpiaVariablesPost;
                    header("Location: ?pagina=ApuMovi");
                    exit;
                }
            } else {
                echo $limpiaVariablesPost;
                echo '<div class="alert alert-danger">No se pudo realizar la recarga!!!</div>';
            }
        }
    }

    /// BALANCE
    static public function balance()
    {
        if (isset($_SESSION['tokenUsuario'])) {
            if (preg_match('/^[0-9A-Z ]+$/', $_SESSION['tokenUsuario'])) {
                $token = $_SESSION['tokenUsuario'];
                return ModeloFormularios::balances(array($token));
            }
        }
    }

    /// MOVIMIENTOS
    static public function movimiento()
    {
        $valor = isset($_GET['paginas']) ? (($_GET['paginas'] - 1) * 10) : 0;
        if (isset($_SESSION['tokenUsuario'])) {
            if (preg_match('/^[0-9A-Z ]+$/', $_SESSION['tokenUsuario'])) {
                $token = $_SESSION['tokenUsuario'];
                return ModeloFormularios::movimientos(array($token, $valor));
            }
        }
    }

    /// CONTAR MOVIMIENTOS
    static public function contarMovimiento()
    {
        if (isset($_SESSION['tokenUsuario'])) {
            if (preg_match('/^[0-9A-Z ]+$/', $_SESSION['tokenUsuario'])) {
                $token = $_SESSION['tokenUsuario'];
                return ModeloFormularios::contarMovimientos(array($token));
            }
        }
    }

    /// ACTUALIZAR USUARIO
    static public function actualizarUsuario()
    {
        if (isset($_POST['nombre'])) {
            if (
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre"]) &&
                preg_match('/^[0-9]+$/', $_POST["telefono"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo"])
            ) {
                $nombre = ucwords($_POST["nombre"]);
                $tel = $_POST["telefono"];
                $email = mb_strtolower($_POST["correo"]);
                $token = $_SESSION['tokenUsuario'];

                $datos = array($nombre, $tel, $email, $token);

                return ModeloFormularios::actualizarUsuarios($datos);
            }
        }
    }
}