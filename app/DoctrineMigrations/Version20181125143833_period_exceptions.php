<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181125143833_period_exceptions extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE period_exception (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, reason_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, type VARCHAR(255) NOT NULL, recurrence VARCHAR(255) NOT NULL, INDEX IDX_AB17F5BFBE04EA9 (job_id), INDEX IDX_AB17F5BF5200282E (formation_id), INDEX IDX_AB17F5BF59BB1592 (reason_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period_exception_reason (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE period_exception ADD CONSTRAINT FK_AB17F5BFBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE period_exception ADD CONSTRAINT FK_AB17F5BF5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE period_exception ADD CONSTRAINT FK_AB17F5BF59BB1592 FOREIGN KEY (reason_id) REFERENCES period_exception_reason (id)');

        $this->addSql('INSERT INTO period_exception_reason (name) VALUES ("Autre")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE period_exception DROP FOREIGN KEY FK_AB17F5BF59BB1592');
        $this->addSql('DROP TABLE period_exception');
        $this->addSql('DROP TABLE period_exception_reason');
    }
}
