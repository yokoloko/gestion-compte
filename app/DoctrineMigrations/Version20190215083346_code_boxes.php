<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215083346_code_boxes extends AbstractMigration
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
        $this->addSql('CREATE TABLE received_sms (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, codebox_id INT DEFAULT NULL, created_at DATETIME NOT NULL, content VARCHAR(255) NOT NULL, ignored TINYINT(1) NOT NULL, INDEX IDX_16127592F675F31B (author_id), INDEX IDX_16127592BE7A8EEF (codebox_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_box_access_for_shifter (id INT AUTO_INCREMENT NOT NULL, code_box_id INT DEFAULT NULL, before_delay INT NOT NULL, after_delay INT NOT NULL, can_generate TINYINT(1) NOT NULL, slug VARCHAR(55) NOT NULL, UNIQUE INDEX UNIQ_D5F93B93A791239D (code_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE received_sms ADD CONSTRAINT FK_16127592F675F31B FOREIGN KEY (author_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE received_sms ADD CONSTRAINT FK_16127592BE7A8EEF FOREIGN KEY (codebox_id) REFERENCES code_box (id)');
        $this->addSql('ALTER TABLE code_box_access_for_shifter ADD CONSTRAINT FK_D5F93B93A791239D FOREIGN KEY (code_box_id) REFERENCES code_box (id)');
        $this->addSql('INSERT INTO code_box_access_for_shifter (before_delay, after_delay, can_generate, slug, code_box_id) VALUES (15, 60, true, "CODE", 1)');
        $this->addSql('CREATE TABLE code_box_access_by_code (id INT AUTO_INCREMENT NOT NULL, code_box_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(55) NOT NULL, INDEX IDX_8C52AAEFA791239D (code_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE code_box_access_by_code ADD CONSTRAINT FK_8C52AAEFA791239D FOREIGN KEY (code_box_id) REFERENCES code_box (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE code DROP FOREIGN KEY FK_77153098A791239D');
        $this->addSql('DROP TABLE code_box');
        $this->addSql('DROP INDEX IDX_77153098A791239D ON code');
        $this->addSql('ALTER TABLE code DROP code_box_id');
        $this->addSql('DROP TABLE received_sms');
        $this->addSql('DROP TABLE code_box_access_for_shifter');
        $this->addSql('DROP TABLE code_box_access_by_code');
    }
}
