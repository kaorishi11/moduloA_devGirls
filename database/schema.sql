CREATE DATABASE IF NOT EXISTS senn_aix CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE senn_aix;

CREATE TABLE profiles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) UNIQUE NOT NULL
) ENGINE=InnoDB;
INSERT INTO profiles (name) VALUES ('admin'),('gestor'),('despachante'),('motorista');

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  profile_id INT NOT NULL,
  active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (profile_id) REFERENCES profiles(id)
) ENGINE=InnoDB;

CREATE TABLE vehicles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  plate VARCHAR(10) UNIQUE NOT NULL,
  model VARCHAR(80),
  capacity_kg DECIMAL(10,2),
  volume_m3 DECIMAL(10,2),
  autonomy_km INT,
  status ENUM('disponivel','em_uso','manutencao') DEFAULT 'disponivel',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE drivers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  name VARCHAR(120) NOT NULL,
  cnh VARCHAR(20) UNIQUE NOT NULL,
  category VARCHAR(5),
  cnh_valid_until DATE,
  contact VARCHAR(40),
  available TINYINT(1) DEFAULT 1,
  vehicle_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE deliveries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(20) UNIQUE NOT NULL,
  recipient VARCHAR(120) NOT NULL,
  address VARCHAR(255) NOT NULL,
  lat DECIMAL(10,7),
  lng DECIMAL(10,7),
  driver_id INT,
  vehicle_id INT,
  deadline DATETIME,
  priority ENUM('baixa','media','alta') DEFAULT 'media',
  status ENUM('pendente','em_andamento','concluida','atrasada','cancelada') DEFAULT 'pendente',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (status), INDEX (driver_id),
  FOREIGN KEY (driver_id) REFERENCES drivers(id) ON DELETE SET NULL,
  FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE delivery_status_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  delivery_id INT NOT NULL,
  status VARCHAR(30) NOT NULL,
  changed_by INT,
  changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (delivery_id) REFERENCES deliveries(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE proofs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  delivery_id INT NOT NULL,
  delivered_at DATETIME NOT NULL,
  lat DECIMAL(10,7),
  lng DECIMAL(10,7),
  evidence_path VARCHAR(255),
  notes TEXT,
  FOREIGN KEY (delivery_id) REFERENCES deliveries(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE routes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80),
  driver_id INT,
  vehicle_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE route_stops (
  id INT AUTO_INCREMENT PRIMARY KEY,
  route_id INT NOT NULL,
  delivery_id INT NOT NULL,
  `order` INT NOT NULL,
  FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
  FOREIGN KEY (delivery_id) REFERENCES deliveries(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE alerts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(40) NOT NULL,
  message VARCHAR(255) NOT NULL,
  severity ENUM('info','warning','critical') DEFAULT 'info',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  read_flag TINYINT(1) DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE maintenance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vehicle_id INT NOT NULL,
  description VARCHAR(255),
  started_at DATE,
  finished_at DATE,
  cost DECIMAL(10,2),
  FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE
) ENGINE=InnoDB;