<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413103849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fichier_scategorie (fichier_id INT NOT NULL, scategorie_id INT NOT NULL, INDEX IDX_A1AB0BF6F915CFE (fichier_id), INDEX IDX_A1AB0BF6CF6A778A (scategorie_id), PRIMARY KEY(fichier_id, scategorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scategories (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichier_scategorie ADD CONSTRAINT FK_A1AB0BF6F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fichier_scategorie ADD CONSTRAINT FK_A1AB0BF6CF6A778A FOREIGN KEY (scategorie_id) REFERENCES scategorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_scategorie DROP FOREIGN KEY FK_A1AB0BF6F915CFE');
        $this->addSql('ALTER TABLE fichier_scategorie DROP FOREIGN KEY FK_A1AB0BF6CF6A778A');
        $this->addSql('DROP TABLE fichier_scategorie');
        $this->addSql('DROP TABLE scategories');
    }
}
