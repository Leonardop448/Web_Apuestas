<?php

include("Modelo/Formularios.Modelo.php");
require_once 'Vista/Paginas/EnviarCorreo.php'; // Ruta al nuevo archivo

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

                if ($respuesta && isset($respuesta["id"]) && isset($respuesta["tokenUsuario"])) {
                    // ✅ Enviar correo con token
                    EnviarCorreo::enviarActivacion($nombre, $email, $respuesta["tokenUsuario"]);
                }

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

                if ($resultado) {
                    if (strtolower($resultado["email"]) === $email) {
                        if (!password_verify($_POST["contrasena"], $resultado["contrasena"])) {
                            echo '<div class="alert alert-danger">Contraseña incorrecta.</div>';
                            return;
                        }

                        if ($resultado["activo"] == 0) {
                            echo '<div class="alert alert-warning">Tu cuenta aún no ha sido activada. Revisa tu correo para activarla.</div>';
                            return;
                        }

                        // Si todo es correcto
                        $_SESSION['id'] = $resultado['id'];
                        $_SESSION['cedula'] = $resultado["cedula"];
                        $_SESSION['nombre'] = $resultado["nombre"];
                        $_SESSION['privilegios'] = $resultado["privilegios"];
                        $_SESSION['tokenUsuario'] = $resultado["tokenUsuario"];
                        $_SESSION['email'] = $resultado["email"];
                        $_SESSION['telefono'] = $resultado["telefono"];
                        $_SESSION['fecha_registro'] = $resultado["fecha_registro"];
                        $_SESSION['saldo'] = $resultado["saldo"];

                        echo "<script>window.location.replace('index.php?pagina=Perfil');</script>";
                        exit;
                    }
                }

                echo '<div class="alert alert-danger">Usuario no registrado o datos incorrectos.</div>';


            } else {

                echo '<div class="alert alert-danger">Error al ingresar, usuario o contraseña incorrecto</div>';
            }
        }
    }


    /// VERIFICAR RECARGA
    static public function verificarRecargar()
    {


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

                    return $resultado;
                }
            } else {

                echo '<div class="alert alert-danger">Usuario no existe!!!!</div>';
            }
        }
    }

    /// HACER RECARGA
    static public function recargar()
    {

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


                    // Cambiado: recarga automática después de 1 segundo
                    echo "<script>
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    </script>";

                    exit;
                } else {

                    echo '<div class="alert alert-danger">No se pudo realizar la recarga!!!</div>';
                }
            } else {

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
    public static function movimiento($tokenUsuario, $pagina = 1, $porPagina = 3)
    {
        // Preparamos los parámetros para el modelo
        $datos = [$tokenUsuario, $pagina, $porPagina];

        // Llamamos al modelo y devolvemos el resultado
        return ModeloFormularios::movimientos($datos);
    }

    // CONTAR MOVIMIENTOS - recibe solo token
    public static function contarMovimiento($tokenUsuario)
    {
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




    public static function crearCarrera($nombre, $fecha, $categorias)
    {
        return ModeloFormularios::crearCarrera($nombre, $fecha, $categorias);
    }




    static public function registrarPiloto($nombre)
    {
        return ModeloFormularios::registrarPiloto($nombre);
    }





    static public function obtenerPilotos()
    {
        return ModeloFormularios::obtenerPilotos();
    }




    static public function asignarPilotos($carreraId, $pilotos)
    {
        return ModeloFormularios::asignarPilotos($carreraId, $pilotos);
    }




    static public function obtenerCarrerasProgramadas()
    {
        return ModeloFormularios::carrerasPorEstado('pendiente');
    }




    static public function obtenerPilotosPorCarrera($idCarrera)
    {
        return ModeloFormularios::pilotosDeCarrera($idCarrera);
    }




    public static function registrarApuesta($id_usuario, $id_carrera, $id_piloto, $tipo_apuesta, $monto, $categoria, $ganancia_esperada)
    {
        return ModeloFormularios::registrarApuesta($id_usuario, $id_carrera, $id_piloto, $tipo_apuesta, $monto, $categoria, $ganancia_esperada);
    }


    static public function obtenerCarrerasFinalizadas()
    {
        $stmt = (new Conexion())->conectar()->prepare("SELECT * FROM carreras WHERE estado = 'finalizada' ORDER BY fecha DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function obtenerGanadoresCarrera($idCarrera)
    {
        $stmt = (new Conexion())->conectar()->prepare("
        SELECT p.nombre, r.posicion
        FROM resultados_carrera r
        JOIN pilotos p ON p.id = r.id_piloto
        WHERE r.id_carrera = :id
        ORDER BY r.posicion ASC
    ");
        $stmt->bindParam(":id", $idCarrera, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function obtenerSaldoUsuario($id_usuario)
    {
        return ModeloFormularios::obtenerSaldo($id_usuario);
    }

    public static function actualizarSaldoUsuario($id_usuario, $nuevoSaldo)
    {
        return ModeloFormularios::actualizarSaldo($id_usuario, $nuevoSaldo);
    }

    // Registrar movimiento de apuestas en Movimientos
    static public function registrarMovimiento($descripcion, $fecha, $egreso, $token, $gestor)
    {
        return ModeloFormularios::insertarMovimiento($descripcion, $fecha, $egreso, 0, $token, $gestor);
    }


    public static function obtenerCarreraPorId($id)
    {
        return ModeloFormularios::obtenerCarreraPorId($id);
    }


    public static function obtenerCarrerasConResultados()
    {
        return ModeloFormularios::obtenerCarrerasConResultados();
    }


    public static function obtenerResultadosPorCarreraYCategorias($id_carrera)
    {
        return ModeloFormularios::obtenerResultadosPorCarreraYCategorias($id_carrera);
    }

















}
