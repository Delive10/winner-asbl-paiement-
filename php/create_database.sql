CREATE DATABASE IF NOT EXISTS `winner-asbl`;

USE `winner-asbl`;

CREATE TABLE IF NOT EXISTS `contact` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `sujet` VARCHAR(200) NOT NULL,
    `message` TEXT NOT NULL,
    `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `newsletter` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `date_inscription` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `actif` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rendez_vous` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telephone` VARCHAR(20) NOT NULL,
    `type_rdv` VARCHAR(50) NOT NULL,
    `date_rdv` DATE NOT NULL,
    `heure_rdv` VARCHAR(50) NOT NULL,
    `message` TEXT,
    `statut` ENUM('en_attente', 'confirme', 'annule') DEFAULT 'en_attente',
    `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_date_rdv` (`date_rdv`),
    INDEX `idx_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `dons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `montant` DECIMAL(10,2) NOT NULL,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telephone` VARCHAR(20),
    `adresse` VARCHAR(255),
    `code_postal` VARCHAR(10),
    `ville` VARCHAR(100),
    `pays` VARCHAR(100) DEFAULT 'RDC',
    `don_mensuel` TINYINT(1) DEFAULT 0,
    `newsletter` TINYINT(1) DEFAULT 0,
    `message` TEXT,
    `statut` ENUM('en_attente', 'valide', 'erreur') DEFAULT 'en_attente',
    `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`),
    INDEX `idx_statut` (`statut`),
    INDEX `idx_date_creation` (`date_creation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
