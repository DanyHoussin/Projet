<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107080226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FE19A1A8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FE20BC1A');
        $this->addSql('DROP INDEX IDX_8D93D649FE19A1A8 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649FE20BC1A ON user');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP favorite_character_id, DROP grade_id, DROP pseudo, DROP creation_date, DROP profil_photo, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user ADD favorite_character_id INT DEFAULT NULL, ADD grade_id INT NOT NULL, ADD pseudo VARCHAR(255) NOT NULL, ADD creation_date DATE NOT NULL, ADD profil_photo LONGTEXT NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FE20BC1A FOREIGN KEY (favorite_character_id) REFERENCES `character` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649FE19A1A8 ON user (grade_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FE20BC1A ON user (favorite_character_id)');
    }
}
