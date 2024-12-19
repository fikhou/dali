<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507180510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forumsponsor ADD nom_etab VARCHAR(30) NOT NULL, ADD domaine ENUM(\'IT\', \'Marketing\', \'Consulting\', \'Finance\',\'Chimie\',\'Civil\',\'Autres\'), ADD autre_domaine VARCHAR(255) DEFAULT NULL, ADD tetab ENUM(\'entreprise\', \'startup\', \'organisme\', \'institution_financière\'), ADD description VARCHAR(255) NOT NULL, ADD etat VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forumsponsor DROP nom_etab, DROP domaine, DROP autre_domaine, DROP tetab, DROP description, DROP etat');
    }
}
