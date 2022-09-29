<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927073611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alergenos (id INT AUTO_INCREMENT NOT NULL, alergeno VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, categoria VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE direccion (id INT AUTO_INCREMENT NOT NULL, calle VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, puerta_piso_escalera VARCHAR(255) NOT NULL, cod_postal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horario (id INT AUTO_INCREMENT NOT NULL, dia INT NOT NULL, apertura TIME NOT NULL, cierre TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, total DOUBLE PRECISION NOT NULL, fecha_entrega DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plato (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, imagen_url VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, logo_url VARCHAR(255) NOT NULL, imagen_url VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, destacado TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE municipios CHANGE municipio municipio VARCHAR(255) DEFAULT \'NULL\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE alergenos');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE direccion');
        $this->addSql('DROP TABLE estado');
        $this->addSql('DROP TABLE horario');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE plato');
        $this->addSql('DROP TABLE restaurante');
        $this->addSql('ALTER TABLE municipios CHANGE municipio municipio VARCHAR(255) DEFAULT NULL');
    }
}
