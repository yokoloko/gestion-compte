<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215083346 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE code_box (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, description VARCHAR(1023) DEFAULT NULL, UNIQUE INDEX UNIQ_E0897F905E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE code ADD code_box_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE code ADD CONSTRAINT FK_77153098A791239D FOREIGN KEY (code_box_id) REFERENCES code_box (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_77153098A791239D ON code (code_box_id)');
        $this->addSql('INSERT INTO code_box (name, description) VALUES ("Clés épicerie", "")');
        $this->addSql('UPDATE code SET code_box_id = 1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE code DROP FOREIGN KEY FK_77153098A791239D');
        $this->addSql('DROP TABLE code_box');
        $this->addSql('DROP INDEX IDX_77153098A791239D ON code');
        $this->addSql('ALTER TABLE code DROP code_box_id');
    }
}
