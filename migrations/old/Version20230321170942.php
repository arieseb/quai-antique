<?php

declare(strict_types=1);

namespace DoctrineMigrations\old;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321170942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_date (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, noon_guests INT NOT NULL, evening_guests INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD booking_date_id INT NOT NULL, DROP booking_date');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEE229734B FOREIGN KEY (booking_date_id) REFERENCES booking_date (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEE229734B ON booking (booking_date_id)');
        $this->addSql('ALTER TABLE restaurant DROP current_guests');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEE229734B');
        $this->addSql('DROP TABLE booking_date');
        $this->addSql('DROP INDEX IDX_E00CEDDEE229734B ON booking');
        $this->addSql('ALTER TABLE booking ADD booking_date DATE NOT NULL, DROP booking_date_id');
        $this->addSql('ALTER TABLE restaurant ADD current_guests INT NOT NULL');
    }
}
