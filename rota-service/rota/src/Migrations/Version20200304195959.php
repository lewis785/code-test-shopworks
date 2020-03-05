<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304195959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shift (id INT AUTO_INCREMENT NOT NULL, rota_id INT NOT NULL, staff_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_A50B3B459F169B8 (rota_id), INDEX IDX_A50B3B45D4D57CD (staff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rota (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, week_commence_date DATE NOT NULL, INDEX IDX_D21FD62A4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, INDEX IDX_426EF3924D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift_break (id INT AUTO_INCREMENT NOT NULL, shift_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_792B684BB70BC0E (shift_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shift ADD CONSTRAINT FK_A50B3B459F169B8 FOREIGN KEY (rota_id) REFERENCES rota (id)');
        $this->addSql('ALTER TABLE shift ADD CONSTRAINT FK_A50B3B45D4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE rota ADD CONSTRAINT FK_D21FD62A4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF3924D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE shift_break ADD CONSTRAINT FK_792B684BB70BC0E FOREIGN KEY (shift_id) REFERENCES shift (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shift_break DROP FOREIGN KEY FK_792B684BB70BC0E');
        $this->addSql('ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B459F169B8');
        $this->addSql('ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B45D4D57CD');
        $this->addSql('ALTER TABLE rota DROP FOREIGN KEY FK_D21FD62A4D16C4DD');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF3924D16C4DD');
        $this->addSql('DROP TABLE shift');
        $this->addSql('DROP TABLE rota');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE shift_break');
        $this->addSql('DROP TABLE shop');
    }
}
