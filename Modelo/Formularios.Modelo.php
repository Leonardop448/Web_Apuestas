<?php
require("Conexion.php");
class ModeloFormularios
{

    static public function registroUsuarios($datos)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare("CALL RegistrarUsuario(:nombre,:contrasena,:cedula,:telefono,:email)");
        $stmt->bindParam(":nombre", $datos[0], PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $datos[1], PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $datos[2], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos[3], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos[4], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // ✅ CIERRA el resultado del procedimiento

            if ($usuario && isset($usuario['id'])) {
                // Obtener el token del usuario recién insertado
                $query = $pdo->prepare("SELECT tokenUsuario FROM usuarios WHERE id = :id");
                $query->bindParam(":id", $usuario['id'], PDO::PARAM_INT);
                $query->execute();
                $token = $query->fetchColumn();

                $usuario['tokenUsuario'] = $token;



                return $usuario;
            }
        }

        return null;
    }

    static public function activarCuenta($token)
    {
        $stmt = new Conexion();
        $stmt = $stmt->conectar();

        // Buscar el usuario por token
        $query = $stmt->prepare("SELECT activo FROM usuarios WHERE tokenUsuario = :token");
        $query->bindParam(":token", $token, PDO::PARAM_STR);
        $query->execute();
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return 'invalido'; // Token no encontrado
        }

        if ($usuario['activo'] == 1) {
            return 'ya_activado'; // Ya estaba activado
        }

        // Activar la cuenta (sin eliminar el token)
        $update = $stmt->prepare("UPDATE usuarios SET activo = 1 WHERE tokenUsuario = :token");
        $update->bindParam(":token", $token, PDO::PARAM_STR);
        if ($update->execute()) {
            return 'activado';
        }

        return 'error';
    }

    static public function buscarUsuarioPorToken($token)
    {
        $stmt = new Conexion();
        $stmt = $stmt->conectar();

        $stmt = $stmt->prepare("SELECT * FROM usuarios WHERE tokenUsuario = :token");
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    ////Verificacion de usuarios

    static public function verificarUsuarios($datos)
    {
        $stmt = new Conexion();
        $stmt = $stmt->conectar();
        $stmt = $stmt->prepare('CALL Login(:email)');
        $stmt->bindParam(":email", $datos[0], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    //////////Funcion para hacer las recargas
    static public function verificarRecargas($datos)
    {

        //stmt significa estamento hacemos la conexion a la base de datos clase Conexion, funcion conectar

        $stmt = new Conexion();
        $stmt = $stmt->conectar();
        // prepare prepara la conexion, call registro llamamos el procedimiento almacenado en la base de datos
        // los dos puntos antes de cada valor significa que estan protegidos.
        $stmt = $stmt->prepare('CALL verificarRecargas(:cedula, :cantidad)');

        // bindParam desencapsula los datos llegados en el array $datos y evita inyeccion sql
        $stmt->bindParam(":cedula", $datos[0], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos[1], PDO::PARAM_INT);



        //$query->execute(array("nombre"=>$nombre,"pass"=>$pass));
        $stmt->execute();

        return $stmt->fetch();

        /////////////////////////




    }

    //////////Funcion para hacer las recargas
    static public function recargas($datos)
    {
        try {
            $stmt = new Conexion();
            $conexion = $stmt->conectar();

            $query = $conexion->prepare("CALL Recargar(:tokenUsuario, :cantidad, :gestor)");
            $query->bindParam(":tokenUsuario", $datos["tokenUsuario"], PDO::PARAM_STR);
            $query->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
            $query->bindParam(":gestor", $datos["gestor"], PDO::PARAM_STR);

            if ($query->execute()) {
                // El procedimiento no devuelve resultados, solo hacemos un select para verificar saldo?
                // Para que devuelva algo hacemos un select aquí si quieres.
                return true;
            } else {
                $errorInfo = $query->errorInfo();
                echo "Error en ejecución: " . $errorInfo[2];
                return false;
            }
        } catch (PDOException $e) {
            echo "Excepción: " . $e->getMessage();
            return false;
        }
    }

    //////////Funcion para el balances
    static public function balances($datos)
    {
        $stmt = new Conexion();
        $conexion = $stmt->conectar();  // Obtenemos el objeto PDO

        $query = $conexion->prepare('CALL Balance(:token)');
        $query->bindParam(':token', $datos[0], PDO::PARAM_STR);

        $query->execute();

        return $query->fetch();
    }

    // Función para obtener movimientos con paginación
    static public function movimientos($datos)
    {
        $stmt = new Conexion();
        $db = $stmt->conectar();

        // Llamamos al procedimiento almacenado que recibe token, pagina y porPagina
        $stmt = $db->prepare('CALL Movimientos(:token, :paginas, :porPagina)');

        $stmt->bindParam(":token", $datos[0], PDO::PARAM_STR);
        $stmt->bindParam(":paginas", $datos[1], PDO::PARAM_INT);
        $stmt->bindParam(":porPagina", $datos[2], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Función para contar total de movimientos
    static public function contarMovimientos($datos)
    {
        $stmt = new Conexion();
        $db = $stmt->conectar();

        $stmt = $db->prepare('CALL ContarMovimientos(:token)');

        $stmt->bindParam(":token", $datos[0], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }



    static public function actualizarUsuarios($datos)
    {


        //stmt significa estamento hacemos la conexion a la base de datos clase Conexion, funcion conectar

        $stmt = new Conexion();
        $stmt = $stmt->conectar();
        // prepare prepara la conexion, call registro llamamos el procedimiento almacenado en la base de datos
        // los dos puntos antes de cada valor significa que estan protegidos.
        $stmt = $stmt->prepare('CALL ActualizarUsuarios(:nombre,:telefono,:email,:token)');

        // bindParam desencapsula los datos llegados en el array $datos y evita inyeccion sql
        $stmt->bindParam(":nombre", $datos[0], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos[1], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos[2], PDO::PARAM_STR);
        $stmt->bindParam(":token", $datos[3], PDO::PARAM_STR);

        //$query->execute(array("nombre"=>$nombre,"pass"=>$pass));
        //$stmt->execute();

        $stmt->execute();
        return $stmt->rowCount();

    }
}