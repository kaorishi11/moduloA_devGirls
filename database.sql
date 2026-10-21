CREATE DATABASE IF NOT EXISTS senn_aix CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE senn_aix;

CREATE TABLE IF NOT EXISTS veiculos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  placa VARCHAR(10) NOT NULL UNIQUE,
  tipo VARCHAR(60) NOT NULL,
  capacidade_kg DECIMAL(10,2) NOT NULL DEFAULT 0,
  capacidade_volume DECIMAL(10,2) NOT NULL DEFAULT 0,
  autonomia_km DECIMAL(10,2) NOT NULL DEFAULT 0,
  status ENUM('Disponível','Em rota','Em manutenção') NOT NULL DEFAULT 'Disponível',
  proxima_manutencao DATE NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS motoristas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  categoria_cnh VARCHAR(5) NOT NULL,
  validade_cnh DATE NOT NULL,
  telefone VARCHAR(30) NULL,
  disponibilidade ENUM('Disponível','Em rota','Indisponível') NOT NULL DEFAULT 'Disponível',
  veiculo_id INT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_motorista_veiculo FOREIGN KEY (veiculo_id) REFERENCES veiculos(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS entregas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  destinatario VARCHAR(120) NOT NULL,
  endereco VARCHAR(255) NOT NULL,
  regiao VARCHAR(100) NOT NULL,
  janela_entrega DATETIME NULL,
  peso_kg DECIMAL(10,2) NOT NULL DEFAULT 0,
  volume_m3 DECIMAL(10,2) NOT NULL DEFAULT 0,
  prioridade ENUM('Baixa','Normal','Alta','Urgente') NOT NULL DEFAULT 'Normal',
  status ENUM('Pendente','A caminho','Entregue','Falha') NOT NULL DEFAULT 'Pendente',
  latitude DECIMAL(10,7) NULL,
  longitude DECIMAL(10,7) NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO entregas (destinatario,endereco,regiao,peso_kg,volume_m3,prioridade,status,latitude,longitude)
SELECT 'Exemplo - Cliente A','Praça Afonso Pena, São José dos Campos - SP','São José dos Campos',4.5,0.03,'Alta','Pendente',-23.1791,-45.8872
WHERE NOT EXISTS (SELECT 1 FROM entregas);
