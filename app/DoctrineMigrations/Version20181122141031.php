<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122141031 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE period_exception (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE period ADD exception_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECE61F652ED FOREIGN KEY (exception_id) REFERENCES period_exception (id)');
        $this->addSql('CREATE INDEX IDX_C5B81ECE61F652ED ON period (exception_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE period DROP FOREIGN KEY FK_C5B81ECE61F652ED');
        $this->addSql('DROP TABLE period_exception');
        $this->addSql('DROP INDEX IDX_C5B81ECE61F652ED ON period');
        $this->addSql('ALTER TABLE period DROP exception_id');
    }
}
