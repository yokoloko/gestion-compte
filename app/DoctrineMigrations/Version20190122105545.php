<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190122105545 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE imap_config (id INT AUTO_INCREMENT NOT NULL, mailbox_id INT DEFAULT NULL, path VARCHAR(256) NOT NULL, login VARCHAR(128) NOT NULL, password VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_339A856766EC35CC (mailbox_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mailbox (id INT AUTO_INCREMENT NOT NULL, from_name VARCHAR(64) NOT NULL, address VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE imap_config ADD CONSTRAINT FK_339A856766EC35CC FOREIGN KEY (mailbox_id) REFERENCES mailbox (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE imap_config DROP FOREIGN KEY FK_339A856766EC35CC');
        $this->addSql('DROP TABLE imap_config');
        $this->addSql('DROP TABLE mailbox');
    }
}
