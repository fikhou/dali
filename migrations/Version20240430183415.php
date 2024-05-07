<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430183415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nomentreprise VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_D19FA60A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, nomevent INT NOT NULL, datedebut DATE NOT NULL, datefin DATE NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forumsponsor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, demande VARCHAR(255) NOT NULL, produit VARCHAR(255) NOT NULL, monatant INT NOT NULL, numtel INT NOT NULL, INDEX IDX_60101D86A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reeser (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, nombre INT NOT NULL, nomreser VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_5A34AB9EA76ED395 (user_id), INDEX IDX_5A34AB9E71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, nombre INT NOT NULL, totale INT NOT NULL, date DATE NOT NULL, INDEX IDX_97A0ADA3A76ED395 (user_id), INDEX IDX_97A0ADA371F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, Email VARCHAR(255) NOT NULL, Password VARCHAR(255) NOT NULL, Name VARCHAR(255) NOT NULL, Age INT DEFAULT NULL, Phone INT DEFAULT NULL, Address VARCHAR(255) DEFAULT \'NULL\', Role VARCHAR(255) DEFAULT \'NULL\' NOT NULL, Image VARCHAR(255) DEFAULT \'NULL\', Status TINYINT(1) DEFAULT NULL, DatedeCreation VARCHAR(255) DEFAULT NULL, VerificationCode VARCHAR(255) DEFAULT NULL, UNIQUE INDEX Email (Email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA60A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE forumsponsor ADD CONSTRAINT FK_60101D86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reeser ADD CONSTRAINT FK_5A34AB9EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reeser ADD CONSTRAINT FK_5A34AB9E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA60A76ED395');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A4AEAFEA');
        $this->addSql('ALTER TABLE forumsponsor DROP FOREIGN KEY FK_60101D86A76ED395');
        $this->addSql('ALTER TABLE reeser DROP FOREIGN KEY FK_5A34AB9EA76ED395');
        $this->addSql('ALTER TABLE reeser DROP FOREIGN KEY FK_5A34AB9E71F7E88B');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A76ED395');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA371F7E88B');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE forumsponsor');
        $this->addSql('DROP TABLE reeser');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
    }
}
