SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$

-- Procedimientos
DROP PROCEDURE IF EXISTS ActualizarUsuarios $$
CREATE PROCEDURE ActualizarUsuarios (
    IN p_nombre VARCHAR(100),
    IN p_telefono VARCHAR(100),
    IN p_email VARCHAR(100),
    IN p_token VARCHAR(255)
)
BEGIN
    UPDATE usuarios
    SET 
        nombre = p_nombre,
        telefono = p_telefono,
        email = p_email
    WHERE tokenUsuario = p_token;
END $$

DROP PROCEDURE IF EXISTS Balance $$
CREATE PROCEDURE Balance (
    IN p_tokenUsuario VARCHAR(255)
)
BEGIN
    SELECT saldo
    FROM usuarios
    WHERE tokenUsuario = p_tokenUsuario;
END $$

DROP PROCEDURE IF EXISTS ContarMovimientos $$
CREATE PROCEDURE ContarMovimientos (
    IN p_token VARCHAR(255)
)
BEGIN
    SELECT COUNT(*) AS Cantidad
    FROM movimientos
    WHERE token = p_token;
END $$

DROP PROCEDURE IF EXISTS Login $$
CREATE PROCEDURE Login (
    IN p_email VARCHAR(100)
)
BEGIN
    SELECT id, nombre, email, contrasena, cedula, privilegios, tokenUsuario, telefono, fecha_registro, saldo
    FROM usuarios
    WHERE email = p_email;
END $$

DROP PROCEDURE IF EXISTS Movimientos $$
CREATE PROCEDURE Movimientos (
    IN p_token VARCHAR(255),
    IN paginas INT,
    IN porPagina INT
)
BEGIN
    DECLARE offsetPaginas INT;
    SET offsetPaginas = (paginas - 1) * porPagina;

    SELECT *
    FROM movimientos
    WHERE token = p_token
    ORDER BY fecha DESC
    LIMIT porPagina OFFSET offsetPaginas;
END $$

DROP PROCEDURE IF EXISTS Recargar $$
CREATE PROCEDURE Recargar (
    IN p_tokenUsuario VARCHAR(255),
    IN p_cantidad INT,
    IN p_gestor VARCHAR(255)
)
BEGIN
    DECLARE v_saldo_actual INT;

    SELECT saldo INTO v_saldo_actual
    FROM usuarios
    WHERE tokenUsuario = p_tokenUsuario;

    UPDATE usuarios
    SET saldo = v_saldo_actual + p_cantidad
    WHERE tokenUsuario = p_tokenUsuario;

    INSERT INTO movimientos (
        descripcion,
        fecha,
        ingresos,
        egresos,
        token,
        gestor
    ) VALUES (
        CONCAT('Recarga de ', p_cantidad),
        NOW(),
        p_cantidad,
        0,
        p_tokenUsuario,
        p_gestor
    );

    SELECT LAST_INSERT_ID() AS id_movimiento;
END $$

DROP PROCEDURE IF EXISTS RegistrarUsuario $$
CREATE PROCEDURE RegistrarUsuario (
    IN p_nombre VARCHAR(100),
    IN p_contrasena VARCHAR(255),
    IN p_cedula VARCHAR(100),
    IN p_telefono VARCHAR(100),
    IN p_email VARCHAR(100)
)
BEGIN
    DECLARE token VARCHAR(64);
    SET token = UPPER(SHA2(UUID(), 256));

    INSERT INTO usuarios (nombre, contrasena, cedula, telefono, email, tokenUsuario)
    VALUES (p_nombre, p_contrasena, p_cedula, p_telefono, p_email, token);

    SELECT LAST_INSERT_ID() AS id, token;
END $$

DROP PROCEDURE IF EXISTS verificarRecargas $$
CREATE PROCEDURE verificarRecargas (
    IN p_cedula INT,
    IN p_cantidad INT
)
BEGIN
    SELECT 
        u.tokenUsuario AS token,
        u.nombre,
        u.telefono,
        u.email,
        p_cantidad AS cantidad
    FROM usuarios u
    WHERE u.cedula = p_cedula;
END $$

DELIMITER ;

-- Tablas

CREATE TABLE IF NOT EXISTS usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  contrasena VARCHAR(255) NOT NULL,
  cedula VARCHAR(100) NOT NULL UNIQUE,
  telefono VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  privilegios VARCHAR(50) NOT NULL DEFAULT 'usuario',
  tokenUsuario VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  activo INT NOT NULL DEFAULT 0,
  saldo INT NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS carreras (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  fecha DATETIME NOT NULL,
  estado ENUM('pendiente','finalizada') DEFAULT 'pendiente',
  creada_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  categorias VARCHAR(255) NOT NULL DEFAULT 'SinCategoria',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pilotos (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS carrera_pilotos (
  id INT NOT NULL AUTO_INCREMENT,
  id_carrera INT NOT NULL,
  id_piloto INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_carrera) REFERENCES carreras(id) ON DELETE CASCADE,
  FOREIGN KEY (id_piloto) REFERENCES pilotos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS resultados_carrera (
  id INT NOT NULL AUTO_INCREMENT,
  id_carrera INT NOT NULL,
  id_piloto INT NOT NULL,
  posicion INT NOT NULL CHECK (posicion IN (1,2,3)),
  categoria VARCHAR(100) NOT NULL DEFAULT 'SinCategoria',
  PRIMARY KEY (id),
  UNIQUE KEY idx_resultado_unico (id_carrera, categoria, id_piloto),
  UNIQUE KEY idx_posicion_unica (id_carrera, categoria, posicion),
  FOREIGN KEY (id_carrera) REFERENCES carreras(id) ON DELETE CASCADE,
  FOREIGN KEY (id_piloto) REFERENCES pilotos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS movimientos (
  id INT NOT NULL AUTO_INCREMENT,
  descripcion TEXT NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ingresos INT NOT NULL DEFAULT 0,
  egresos INT NOT NULL DEFAULT 0,
  token VARCHAR(255) NOT NULL,
  gestor VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS apuestas (
  id INT NOT NULL AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  id_carrera INT NOT NULL,
  id_piloto INT NOT NULL,
  tipo_apuesta ENUM('ganador','podio') NOT NULL,
  monto INT NOT NULL,
  ganancia_esperada FLOAT NOT NULL,
  resultado ENUM('pendiente','ganada','perdida') DEFAULT 'pendiente',
  creada_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  categoria VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (id_carrera) REFERENCES carreras(id),
  FOREIGN KEY (id_piloto) REFERENCES pilotos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;