<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810172825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE intervenant (id INT AUTO_INCREMENT NOT NULL, date_passage DATETIME NOT NULL, sujet LONGTEXT NOT NULL, nickname VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, biographie LONGTEXT DEFAULT NULL, heure_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervenant_programme (intervenant_id INT NOT NULL, programme_id INT NOT NULL, INDEX IDX_F9D9D1F3AB9A1716 (intervenant_id), INDEX IDX_F9D9D1F362BB7AEE (programme_id), PRIMARY KEY(intervenant_id, programme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nouvelles LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_140AB620A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, date_heure_debut DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, nom_programme VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme_user (programme_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_94D3E42462BB7AEE (programme_id), INDEX IDX_94D3E424A76ED395 (user_id), PRIMARY KEY(programme_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervenant_programme ADD CONSTRAINT FK_F9D9D1F3AB9A1716 FOREIGN KEY (intervenant_id) REFERENCES intervenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervenant_programme ADD CONSTRAINT FK_F9D9D1F362BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE programme_user ADD CONSTRAINT FK_94D3E42462BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_user ADD CONSTRAINT FK_94D3E424A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE intervenant_programme DROP FOREIGN KEY FK_F9D9D1F3AB9A1716');
        $this->addSql('ALTER TABLE intervenant_programme DROP FOREIGN KEY FK_F9D9D1F362BB7AEE');
        $this->addSql('ALTER TABLE programme_user DROP FOREIGN KEY FK_94D3E42462BB7AEE');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620A76ED395');
        $this->addSql('ALTER TABLE programme_user DROP FOREIGN KEY FK_94D3E424A76ED395');
        $this->addSql('DROP TABLE intervenant');
        $this->addSql('DROP TABLE intervenant_programme');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE programme_user');
        $this->addSql('DROP TABLE user');
    }
}
