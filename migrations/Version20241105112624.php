<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105112624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blows (id INT AUTO_INCREMENT NOT NULL, chosen_character_id INT NOT NULL, movelist LONGTEXT NOT NULL, INDEX IDX_BED9D821D3676B09 (chosen_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE defi (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, reward LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, chosen_character_id INT NOT NULL, defi_id INT NOT NULL, achievement TINYINT(1) NOT NULL, INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24FD3676B09 (chosen_character_id), INDEX IDX_AB55E24F73F00F27 (defi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blows ADD CONSTRAINT FK_BED9D821D3676B09 FOREIGN KEY (chosen_character_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FD3676B09 FOREIGN KEY (chosen_character_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F73F00F27 FOREIGN KEY (defi_id) REFERENCES defi (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blows DROP FOREIGN KEY FK_BED9D821D3676B09');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FD3676B09');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F73F00F27');
        $this->addSql('DROP TABLE blows');
        $this->addSql('DROP TABLE defi');
        $this->addSql('DROP TABLE participation');
    }
}
