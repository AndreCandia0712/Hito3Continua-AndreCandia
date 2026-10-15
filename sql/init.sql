CREATE DATABASE IF NOT EXISTS db_minimarket_pro413;
USE db_minimarket_pro413;

CREATE TABLE IF NOT EXISTS Producto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    proveedor VARCHAR(100) NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    precio DECIMAL(10,2) NOT NULL CHECK (precio >= 0),
    stock INT NOT NULL CHECK (stock >= 0),
    eliminado TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;