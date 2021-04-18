<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417160809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_participant ADD lane_id INT DEFAULT NULL, DROP lane');
        $this->addSql('ALTER TABLE game_participant ADD CONSTRAINT FK_9CA2913A128F72F FOREIGN KEY (lane_id) REFERENCES lane (id)');
        $this->addSql('CREATE INDEX IDX_9CA2913A128F72F ON game_participant (lane_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_participant DROP FOREIGN KEY FK_9CA2913A128F72F');
        $this->addSql('DROP INDEX IDX_9CA2913A128F72F ON game_participant');
        $this->addSql('ALTER TABLE game_participant ADD lane VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP lane_id');
    }
}
