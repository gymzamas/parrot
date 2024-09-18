<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240918021938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voiture_occasion (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, annee_mise_en_circulation DATETIME NOT NULL, kilometrage INT NOT NULL, description LONGTEXT NOT NULL, image_principale VARCHAR(255) NOT NULL, galerie_images LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', equipements_options LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE voiture_occasion');
    }
}
