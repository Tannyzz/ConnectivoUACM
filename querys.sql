CREATE SCHEMA IF NOT EXISTS `connective` DEFAULT CHARACTER SET utf8 ;
USE `connective` ;

-- -----------------------------------------------------
-- Table `connective`.`estudiante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `connective`.`estudiante` (
  `nombre` TEXT NULL DEFAULT NULL,
  `apellido_p` TEXT NULL DEFAULT NULL,
  `apellido_m` TEXT NULL DEFAULT NULL,
  `carrera` TEXT NULL DEFAULT NULL,
  `usuario` VARCHAR(30) NOT NULL DEFAULT '',
  `matricula` VARCHAR(11) NOT NULL,
  `correo_institucional` VARCHAR(100) NOT NULL,
  `contraseña` VARCHAR(16) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`usuario`, `matricula`, `correo_institucional`),
  UNIQUE (`matricula`,`correo_institucional`),
  INDEX `correo_institucional` (`correo_institucional` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `connective`.`tema`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `connective`.`tema` (
  `titulo` VARCHAR(100) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `simpatizantes` INT(11) NULL DEFAULT NULL,
  `id_tema` INT(11) NOT NULL AUTO_INCREMENT,
  `correo_institucional` VARCHAR(100) NOT NULL,
  `solucion` TINYINT(1) NULL,
  PRIMARY KEY (`id_tema`,`correo_institucional`),
  INDEX `ubicacion_temas` (`correo_institucional` ASC, `id_tema` ASC),
  CONSTRAINT `correoInstitucionalTema`
    FOREIGN KEY (`correo_institucional`)
    REFERENCES `connective`.`estudiante` (`correo_institucional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `connective`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `connective`.`usuario` (
  `usuario` VARCHAR(30) NOT NULL,
  `contraseña` VARCHAR(16) NULL DEFAULT NULL,
  `hora_entrada` DATETIME NULL DEFAULT NULL,
  `hora_salida` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`usuario`),
  CONSTRAINT `usuario`
    FOREIGN KEY (`usuario`)
    REFERENCES `connective`.`estudiante` (`usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `connective`.`karma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `connective`.`karma` (
  `id_tema` INT(11) NOT NULL,
  `correo_institucional` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_tema`, `correo_institucional`),
  INDEX `karmas` (`id_tema` ASC),
  CONSTRAINT `idTema`
    FOREIGN KEY (`id_tema`)
    REFERENCES `connective`.`tema` (`id_tema`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `correoInstitucional`
    FOREIGN KEY (`correo_institucional`)
    REFERENCES `connective`.`estudiante` (`correo_institucional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `connective`.`comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `connective`.`comentario` (
  `id_comentario` INT(11) NOT NULL AUTO_INCREMENT,
  `id_tema` INT(11) NULL,
  `descripcion` TEXT NULL,
  `correo_institucional` VARCHAR(100) NULL,
  PRIMARY KEY (`id_comentario`),
  INDEX `ubicar_comentarios` (`id_tema` ASC, `correo_institucional` ASC),
  CONSTRAINT `idTemaComentario`
    FOREIGN KEY (`id_tema`)
    REFERENCES `connective`.`tema` (`id_tema`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `correoInstitucionalComentario`
    FOREIGN KEY (`correo_institucional`)
    REFERENCES `connective`.`estudiante` (`correo_institucional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
