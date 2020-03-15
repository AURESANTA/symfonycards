<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309213101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE deck (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, deckname VARCHAR(255) NOT NULL, INDEX IDX_4FAC363761220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deckcard (id INT AUTO_INCREMENT NOT NULL, card_id INT NOT NULL, deck_id INT NOT NULL, INDEX IDX_BFDF6E0D4ACC9A20 (card_id), INDEX IDX_BFDF6E0D111948DC (deck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC363761220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE deckcard ADD CONSTRAINT FK_BFDF6E0D4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE deckcard ADD CONSTRAINT FK_BFDF6E0D111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deckcard DROP FOREIGN KEY FK_BFDF6E0D111948DC');
        $this->addSql('DROP TABLE deck');
        $this->addSql('DROP TABLE deckcard');
    }
}
