<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116203740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `parcel` (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, biker_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, pick_up_address VARCHAR(255) NOT NULL, pick_off_address VARCHAR(255) NOT NULL, pick_up_date DATETIME DEFAULT NULL, delivery_date DATETIME DEFAULT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_C99B5D60F624B39D (sender_id), INDEX IDX_C99B5D6082150208 (biker_id), INDEX IDX_C99B5D607B00651C (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `parcel` ADD CONSTRAINT FK_C99B5D60F624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `parcel` ADD CONSTRAINT FK_C99B5D6082150208 FOREIGN KEY (biker_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `parcel` DROP FOREIGN KEY FK_C99B5D60F624B39D');
        $this->addSql('ALTER TABLE `parcel` DROP FOREIGN KEY FK_C99B5D6082150208');
        $this->addSql('DROP TABLE `parcel`');
    }
}
