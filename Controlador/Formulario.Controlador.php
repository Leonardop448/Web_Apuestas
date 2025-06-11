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
    
    if (isset($_POST['email'])) {
        // Validar campos
        if (
            preg_match('/^[0-9a-zA-Z@#\-_$%^&+=§!? ]{6,50}$/', $_POST["contrasena"]) &&
            preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"])
        ) {
            $email = mb_strtolower($_POST["email"]);


     // Verificar usuario en la base de datos (solo por email)
    $resultado = ModeloFormularios::verificarUsuarios([$email]);
    if ($resultado && isset($resultado["email"])) {
        
        if (
            strtolower($resultado["email"]) === $email && // Normalizar correo en minúsculas para comparación
            password_verify($_POST["contrasena"], $resultado["contrasena"])
        ) {
            $_SESSION['cedula'] = $resultado["cedula"];
            $_SESSION['nombre'] = $resultado["nombre"];
            $_SESSION['privilegios'] = $resultado["privilegios"];
            $_SESSION['tokenUsuario'] = $resultado["tokenUsuario"];
            $_SESSION['email'] = $resultado["email"];
            $_SESSION['telefono'] = $resultado["telefono"];
            


            echo $_POST = array();
            echo "<script>window.location.replace('index.php?pagina=Perfil');</script>";
            exit;
        }
    }

            
} else {
            echo $_POST = array();
            echo '<div class="alert alert-danger">Error al ingresar, usuario o contraseña incorrecto</div>';
        }
    }
}


    /// VERIFICAR RECARGA
    static public function verificarRecargar()
    {
        $_POST = array();

echo '<script>
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
                    echo $_POST = array();
                    return $resultado;
                }
            } else {
                echo $_POST = array();
                echo '<div class="alert alert-danger">Usuario no existe!!!!</div>';
            }
        }
    }

    /// HACER RECARGA
    static public function recargar()
{
    $_POST = array(); 
    echo '<script>
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>';

    if (isset($_POST['token'], $_POST['valor'])) {
    
        if (
    preg_match('/^[0-9A-Z]+$/', $_POST["token"]) &&
    preg_match('/^[0-9]+$/', $_POST["valor"]) &&
    isset($_SESSION['nombre'])
) {
    $token = $_POST["token"];
    $cantidad = $_POST["valor"];
    $gestor = $_SESSION['nombre'];

    $resultado = ModeloFormularios::recargas(array(
        "tokenUsuario" => $token,
        "cantidad" => $cantidad,
        "gestor" => $gestor
    ));

    if ($resultado === true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' id='alertaRecarga'>
            Su recarga por <strong>$$cantidad</strong> fue exitosa!!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    echo $_POST = array();

    // Agregamos script para recargar al cerrar el alert
    echo "<script>
            var alerta = document.getElementById('alertaRecarga');
            alerta.addEventListener('closed.bs.alert', function () {
                window.location.reload();
            });
        </script>";
    
    exit;
} else {
        echo $_POST = array();
        echo '<div class="alert alert-danger">No se pudo realizar la recarga!!!</div>';
    }
} else {
    echo $_POST = array();
    echo '<div class="alert alert-danger">Datos no válidos o sesión sin nombre de usuario.</div>';
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

    // MOVIMIENTOS - ahora recibe token, pagina y porPagina
public static function movimiento($tokenUsuario, $pagina = 1, $porPagina = 3) {
    // Preparamos los parámetros para el modelo
    $datos = [$tokenUsuario, $pagina, $porPagina];

    // Llamamos al modelo y devolvemos el resultado
    return ModeloFormularios::movimientos($datos);
}

// CONTAR MOVIMIENTOS - recibe solo token
public static function contarMovimiento($tokenUsuario) {
    $datos = [$tokenUsuario];
    return ModeloFormularios::contarMovimientos($datos);
}

    /// ACTUALIZAR USUARIO
    static public function actualizarUsuario()
    {
        if (isset($_POST['nombre'])) {
            if (
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre"]) &&
                preg_match('/^[0-9]+$/', $_POST["telefono"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"])
            ) {
                $nombre = ucwords($_POST["nombre"]);
                $tel = $_POST["telefono"];
                $email = mb_strtolower($_POST["email"]);
                $token = $_SESSION['tokenUsuario'];

                $datos = array($nombre, $tel, $email, $token);

				

                return ModeloFormularios::actualizarUsuarios($datos);
            }
        }
    }
}