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


    public static function crearCarrera($nombre, $fecha, $categorias)
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        $query = $pdo->prepare("INSERT INTO carreras (nombre, fecha, categorias) VALUES (:nombre, :fecha, :categorias)");
        $query->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $query->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $query->bindParam(":categorias", $categorias, PDO::PARAM_STR);

        if ($query->execute()) {
            return "ok";
        }

        return "error";
    }



    static public function registrarPiloto($nombre)
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        // Convertir el nombre a mayúsculas con soporte multibyte (UTF-8)
        $nombreMayusculas = mb_strtoupper($nombre, 'UTF-8');

        $query = $pdo->prepare("INSERT INTO pilotos (nombre) VALUES (:nombre)");
        $query->bindParam(":nombre", $nombreMayusculas, PDO::PARAM_STR);

        if ($query->execute()) {
            return "ok";
        }

        return "error";
    }




    static public function obtenerPilotos()
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        $query = $pdo->prepare("SELECT * FROM pilotos ORDER BY nombre ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }




    static public function asignarPilotos($idCarrera, $pilotos)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $yaAsignados = [];
        $asignados = [];

        foreach ($pilotos as $idPiloto) {
            // Verificar si ya está asignado
            $verificar = $pdo->prepare("SELECT COUNT(*) FROM carrera_pilotos WHERE id_carrera = :id_carrera AND id_piloto = :id_piloto");
            $verificar->bindParam(":id_carrera", $idCarrera, PDO::PARAM_INT);
            $verificar->bindParam(":id_piloto", $idPiloto, PDO::PARAM_INT);
            $verificar->execute();

            if ($verificar->fetchColumn() > 0) {
                // Obtener nombre del piloto para mostrar en el mensaje
                $query = $pdo->prepare("SELECT nombre FROM pilotos WHERE id = :id_piloto");
                $query->bindParam(":id_piloto", $idPiloto, PDO::PARAM_INT);
                $query->execute();
                $nombrePiloto = $query->fetchColumn();
                $yaAsignados[] = $nombrePiloto;
                continue;
            }

            // Insertar piloto si no está asignado
            $stmt = $pdo->prepare("INSERT INTO carrera_pilotos (id_carrera, id_piloto) VALUES (:id_carrera, :id_piloto)");
            $stmt->bindParam(":id_carrera", $idCarrera, PDO::PARAM_INT);
            $stmt->bindParam(":id_piloto", $idPiloto, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $asignados[] = $idPiloto;
            }
        }

        return [
            'exito' => !empty($asignados),
            'yaAsignados' => $yaAsignados
        ];
    }




    public static function registrarApuesta($id_usuario, $id_carrera, $id_piloto, $tipo_apuesta, $monto, $categoria, $ganancia_esperada)
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        try {
            // Iniciar transacción
            $pdo->beginTransaction();

            // Verificar saldo
            $querySaldo = $pdo->prepare("SELECT saldo, tokenUsuario, nombre FROM usuarios WHERE id = :id");
            $querySaldo->bindParam(":id", $id_usuario, PDO::PARAM_INT);
            $querySaldo->execute();
            $usuario = $querySaldo->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return "Usuario no encontrado.";
            }

            if ($usuario['saldo'] < $monto) {
                return "Saldo insuficiente para realizar la apuesta.";
            }

            // Descontar saldo
            $stmtDescontar = $pdo->prepare("UPDATE usuarios SET saldo = saldo - :monto WHERE id = :id");
            $stmtDescontar->bindParam(":monto", $monto, PDO::PARAM_INT);
            $stmtDescontar->bindParam(":id", $id_usuario, PDO::PARAM_INT);
            $stmtDescontar->execute();

            // Insertar apuesta
            $stmtApuesta = $pdo->prepare("
            INSERT INTO apuestas (id_usuario, id_carrera, id_piloto, tipo_apuesta, monto, categoria, ganancia_esperada, creada_en)
            VALUES (:id_usuario, :id_carrera, :id_piloto, :tipo_apuesta, :monto, :categoria, :ganancia_esperada, NOW())
        ");
            $stmtApuesta->execute([
                ":id_usuario" => $id_usuario,
                ":id_carrera" => $id_carrera,
                ":id_piloto" => $id_piloto,
                ":tipo_apuesta" => $tipo_apuesta,
                ":monto" => $monto,
                ":categoria" => $categoria,
                ":ganancia_esperada" => $ganancia_esperada
            ]);

            // Insertar movimiento
            // Obtener nombre de la carrera
            $queryCarrera = $pdo->prepare("SELECT nombre FROM carreras WHERE id = :id_carrera");
            $queryCarrera->bindParam(":id_carrera", $id_carrera, PDO::PARAM_INT);
            $queryCarrera->execute();
            $carrera = $queryCarrera->fetch(PDO::FETCH_ASSOC);
            $nombreCarrera = $carrera ? $carrera['nombre'] : "Carrera desconocida";

            $descripcion = "Apuesta en $nombreCarrera ($tipo_apuesta) ($categoria)";
            $stmtMov = $pdo->prepare("
            INSERT INTO movimientos (descripcion, ingresos, egresos, fecha, token, gestor)
            VALUES (:descripcion, 0, :egreso, NOW(), :token, :gestor)
        ");
            $stmtMov->execute([
                ":descripcion" => $descripcion,
                ":egreso" => $monto,
                ":token" => $usuario['tokenUsuario'],
                ":gestor" => $usuario['nombre']
            ]);

            $pdo->commit();
            return "ok";

        } catch (PDOException $e) {
            $pdo->rollBack();
            return "Error al registrar apuesta: " . $e->getMessage();
        }
    }



    public static function obtenerSaldo($id_usuario)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare("SELECT saldo FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['saldo'] : 0;
    }





    static public function procesarResultados($id_carrera, $ordenLlegada, $categoria)
    {
        $db = (new Conexion())->conectar();

        // Verificar si ya se guardaron resultados para esta carrera y categoría
        $stmtCheck = $db->prepare("SELECT COUNT(*) FROM resultados_carrera WHERE id_carrera = :id_carrera AND categoria = :categoria");
        $stmtCheck->execute([
            ':id_carrera' => $id_carrera,
            ':categoria' => $categoria
        ]);
        if ($stmtCheck->fetchColumn() > 0) {
            return false;
        }

        // Obtener el nombre de la carrera
        $stmtNombre = $db->prepare("SELECT nombre FROM carreras WHERE id = :id_carrera");
        $stmtNombre->execute([':id_carrera' => $id_carrera]);
        $carrera = $stmtNombre->fetch(PDO::FETCH_ASSOC);
        $nombreCarrera = $carrera ? $carrera['nombre'] : 'Carrera desconocida';

        // Guardar resultados
        foreach ($ordenLlegada as $posicion => $id_piloto) {
            $stmtInsert = $db->prepare("INSERT INTO resultados_carrera (id_carrera, id_piloto, posicion, categoria) 
                                    VALUES (:id_carrera, :id_piloto, :posicion, :categoria)");
            $stmtInsert->execute([
                ':id_carrera' => $id_carrera,
                ':id_piloto' => $id_piloto,
                ':posicion' => $posicion + 1,
                ':categoria' => $categoria
            ]);
        }

        // Obtener apuestas de esa carrera y categoría
        $stmtApuestas = $db->prepare("SELECT * FROM apuestas WHERE id_carrera = :id_carrera AND categoria = :categoria");
        $stmtApuestas->execute([
            ':id_carrera' => $id_carrera,
            ':categoria' => $categoria
        ]);
        $apuestas = $stmtApuestas->fetchAll(PDO::FETCH_ASSOC);

        $id_ganador = $ordenLlegada[0] ?? null;
        $id_podio = array_slice($ordenLlegada, 0, 3);

        foreach ($apuestas as $apuesta) {
            $estado = 'perdida';
            $ganancia = 0;

            if ($apuesta['tipo_apuesta'] === 'ganador' && $apuesta['id_piloto'] == $id_ganador) {
                $estado = 'ganada';
                $ganancia = $apuesta['ganancia_esperada'];
            } elseif ($apuesta['tipo_apuesta'] === 'podio' && in_array($apuesta['id_piloto'], $id_podio)) {
                $estado = 'ganada';
                $ganancia = $apuesta['ganancia_esperada'];
            }

            // Actualizar apuesta
            $stmtUpdate = $db->prepare("UPDATE apuestas SET resultado = :resultado WHERE id = :id");
            $stmtUpdate->execute([
                ':resultado' => $estado,
                ':id' => $apuesta['id']
            ]);

            // Si ganó, sumar saldo e insertar movimiento
            if ($estado === 'ganada') {
                $stmtSaldo = $db->prepare("UPDATE usuarios SET saldo = saldo + :ganancia WHERE id = :id_usuario");
                $stmtSaldo->execute([
                    ":ganancia" => $ganancia,
                    ":id_usuario" => $apuesta['id_usuario']
                ]);

                $stmtUsuario = $db->prepare("SELECT tokenUsuario, nombre FROM usuarios WHERE id = :id");
                $stmtUsuario->execute([':id' => $apuesta['id_usuario']]);
                $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

                $descripcion = 'Ganancia en carrera ' . $nombreCarrera . ' (' . ucfirst($apuesta['tipo_apuesta']) . ')';

                $stmtMov = $db->prepare("INSERT INTO movimientos (descripcion, ingresos, egresos, fecha, token, gestor)
                                     VALUES (:descripcion, :ingresos, 0, :fecha, :token, :gestor)");
                $stmtMov->execute([
                    ':descripcion' => $descripcion,
                    ':ingresos' => $ganancia,
                    ':fecha' => date('Y-m-d H:i:s'),
                    ':token' => $usuario['tokenUsuario'],
                    ':gestor' => $usuario['nombre']
                ]);
            }
        }

        // Verificar si aún quedan apuestas pendientes en la carrera
        $stmtPendientes = $db->prepare("SELECT COUNT(*) FROM apuestas WHERE id_carrera = :id AND resultado = 'pendiente'");
        $stmtPendientes->execute([':id' => $id_carrera]);
        $quedanPendientes = $stmtPendientes->fetchColumn();

        if ($quedanPendientes == 0) {
            $stmtEstado = $db->prepare("UPDATE carreras SET estado = 'finalizada' WHERE id = :id");
            $stmtEstado->execute([':id' => $id_carrera]);
        }

        return true;
    }







    static public function carrerasPorEstado($estado)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare("SELECT * FROM carreras WHERE estado = :estado ORDER BY fecha ASC");
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function pilotosDeCarrera($idCarrera)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare("
        SELECT pilotos.id, pilotos.nombre 
        FROM carrera_pilotos 
        INNER JOIN pilotos ON carrera_pilotos.id_piloto = pilotos.id 
        WHERE carrera_pilotos.id_carrera = :idCarrera
    ");
        $stmt->bindParam(":idCarrera", $idCarrera, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizarSaldo($id_usuario, $nuevoSaldo)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare("UPDATE usuarios SET saldo = :saldo WHERE id = :id");
        $stmt->bindParam(":saldo", $nuevoSaldo, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id_usuario, PDO::PARAM_INT);

        return $stmt->execute() ? "ok" : "error";
    }

    // En Formularios.Modelo.php
    static public function insertarMovimiento($descripcion, $fecha, $egreso, $ingreso, $token, $gestor)
    {
        $db = (new Conexion())->conectar();
        $stmt = $db->prepare("INSERT INTO movimientos (descripcion, fecha, egresos, ingresos, token, gestor) VALUES (:descripcion, :fecha, :egresos, :ingresos, :token, :gestor)");
        return $stmt->execute([
            ":descripcion" => $descripcion,
            ":fecha" => $fecha,
            ":egresos" => $egreso,
            ":ingresos" => $ingreso,
            ":token" => $token,
            ":gestor" => $gestor
        ]);
    }


    // Obtener estado de una carrera específica
    public static function obtenerEstadoCarrera($idCarrera)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();

        $stmt = $db->prepare("SELECT estado FROM carreras WHERE id = ?");
        $stmt->execute([$idCarrera]);
        return $stmt->fetchColumn();
    }

    // Calcular ganancias por carrera
    public static function calcularGananciaPorCarrera($idCarrera)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();

        $apostado = $db->prepare("SELECT SUM(monto) FROM apuestas WHERE id_carrera = ?");
        $apostado->execute([$idCarrera]);
        $total_apostado = $apostado->fetchColumn() ?? 0;

        $pagado = $db->prepare("SELECT SUM(ganancia_esperada) FROM apuestas WHERE id_carrera = ? AND resultado = 'ganada'");
        $pagado->execute([$idCarrera]);
        $total_pagado = $pagado->fetchColumn() ?? 0;

        return [
            'total_apostado' => (float) $total_apostado,
            'total_pagado' => (float) $total_pagado,
            'ganancia' => (float) $total_apostado - (float) $total_pagado
        ];
    }

    // Calcular ganancias por mes (formato $mes = '2024-06')
    public static function calcularGananciaPorMes($mes)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();

        $inicio = "$mes-01 00:00:00";
        $fin = date("Y-m-t 23:59:59", strtotime($inicio));

        $apostado = $db->prepare("SELECT SUM(monto) FROM apuestas WHERE creada_en BETWEEN ? AND ?");
        $apostado->execute([$inicio, $fin]);
        $total_apostado = $apostado->fetchColumn() ?? 0;

        $pagado = $db->prepare("SELECT SUM(ganancia_esperada) FROM apuestas WHERE resultado = 'ganada' AND creada_en BETWEEN ? AND ?");
        $pagado->execute([$inicio, $fin]);
        $total_pagado = $pagado->fetchColumn() ?? 0;

        return [
            'total_apostado' => (float) $total_apostado,
            'total_pagado' => (float) $total_pagado,
            'ganancia' => (float) $total_apostado - (float) $total_pagado
        ];
    }

    static public function obtenerCarrerasFinalizadas()
    {
        $stmt = (new Conexion())->conectar()->prepare("SELECT * FROM carreras WHERE estado = 'finalizada' ORDER BY fecha DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function obtenerCarreraPorId($id)
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        $query = $pdo->prepare("SELECT * FROM carreras WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }


    static public function obtenerCategoriasConApuestas($id_carrera)
    {
        $db = (new Conexion())->conectar();

        // Lista de categorías válidas
        $categoriasValidas = [
            '50cc Racer',
            'Infantil',
            'Novatos',
            'Élite',
            '150 cc',
            'Master',
            '200cc 2T',
            'Supermoto',
            'Expertos'
        ];

        // Obtener categorías únicas que tengan apuestas pendientes
        $stmt = $db->prepare("
        SELECT DISTINCT categoria
        FROM apuestas
        WHERE id_carrera = :id_carrera AND resultado = 'pendiente'
    ");
        $stmt->execute([':id_carrera' => $id_carrera]);

        $categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Filtrar solo las categorías válidas
        $categoriasFiltradas = array_filter(array_map('trim', $categorias), function ($cat) use ($categoriasValidas) {
            return in_array($cat, $categoriasValidas);
        });

        return array_unique($categoriasFiltradas);
    }


    public static function obtenerCarrerasConResultados()
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        $query = "SELECT DISTINCT c.id, c.nombre, c.fecha
              FROM carreras c
              INNER JOIN resultados_carrera r ON c.id = r.id_carrera
              ORDER BY c.fecha DESC";

        $sql = $pdo->prepare($query);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerResultadosPorCarreraYCategorias($id_carrera)
    {
        $stmt = new Conexion();
        $pdo = $stmt->conectar();

        $query = "SELECT r.posicion, p.nombre, r.categoria
              FROM resultados_carrera r
              INNER JOIN pilotos p ON r.id_piloto = p.id
              WHERE r.id_carrera = :id_carrera
              ORDER BY r.categoria, r.posicion ASC";

        $sql = $pdo->prepare($query);
        $sql->execute([':id_carrera' => $id_carrera]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }














}