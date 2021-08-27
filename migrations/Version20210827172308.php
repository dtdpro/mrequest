<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210827172308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bin (id INT AUTO_INCREMENT NOT NULL, ext_id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bin_entry (id INT AUTO_INCREMENT NOT NULL, bin_id INT NOT NULL, entry_headers LONGTEXT NOT NULL, entry_body LONGTEXT NOT NULL, cretaed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_906AE1EB222586DC (bin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bin_entry ADD CONSTRAINT FK_906AE1EB222586DC FOREIGN KEY (bin_id) REFERENCES bin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bin_entry DROP FOREIGN KEY FK_906AE1EB222586DC');
        $this->addSql('DROP TABLE bin');
        $this->addSql('DROP TABLE bin_entry');
    }
}
