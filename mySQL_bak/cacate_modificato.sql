-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 16, 2025 alle 22:04
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Database: `cacate_v2`
-- --------------------------------------------------------

-- ========================================================
-- Creazione della tabella `persons`
-- ========================================================
CREATE TABLE `persons` (
  `PersonID` INT(11) NOT NULL AUTO_INCREMENT,
  `numero` INT(11) NOT NULL,
  `nome` TEXT DEFAULT NULL,
  PRIMARY KEY (`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserimento dati di esempio nella tabella `persons`
INSERT INTO `persons` (`PersonID`, `numero`, `nome`) VALUES
(1, 8, 'Triglia'),
(2, 7, 'Nai'),
(3, 3, 'Sibi'),
(4, 0, 'Ali');

-- ========================================================
-- Creazione della tabella `registrazioni_cacate`
-- ========================================================
CREATE TABLE `registrazioni_cacate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `person_id` INT(11) NOT NULL,
  `data_ora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_evento` ENUM('incremento','decremento') NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`person_id`) REFERENCES `persons`(`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================================
-- Creazione del trigger: log_cacata_completo
-- Il trigger registra, per ogni incremento o decremento di `numero` in `persons`,
-- un evento in `registrazioni_cacate` per ogni unità di variazione.
-- ========================================================
DELIMITER $$

CREATE TRIGGER log_cacata_completo
AFTER UPDATE ON persons
FOR EACH ROW
BEGIN
    DECLARE diff INT DEFAULT 0;
    
    IF NEW.numero > OLD.numero THEN
        SET diff = NEW.numero - OLD.numero;
        WHILE diff > 0 DO
            INSERT INTO registrazioni_cacate (person_id, data_ora, tipo_evento)
            VALUES (NEW.PersonID, CURRENT_TIMESTAMP, 'incremento');
            SET diff = diff - 1;
        END WHILE;
        
    ELSEIF NEW.numero < OLD.numero THEN
        SET diff = OLD.numero - NEW.numero;
        WHILE diff > 0 DO
            INSERT INTO registrazioni_cacate (person_id, data_ora, tipo_evento)
            VALUES (NEW.PersonID, CURRENT_TIMESTAMP, 'decremento');
            SET diff = diff - 1;
        END WHILE;
    END IF;
END$$

DELIMITER ;

COMMIT;
