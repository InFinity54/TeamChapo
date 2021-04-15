<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415123234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_team CHANGE champion_ban1_id champion_ban1_id INT DEFAULT NULL, CHANGE champion_ban2_id champion_ban2_id INT DEFAULT NULL, CHANGE champion_ban3_id champion_ban3_id INT DEFAULT NULL, CHANGE champion_ban4_id champion_ban4_id INT DEFAULT NULL, CHANGE champion_ban5_id champion_ban5_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_team CHANGE champion_ban1_id champion_ban1_id INT NOT NULL, CHANGE champion_ban2_id champion_ban2_id INT NOT NULL, CHANGE champion_ban3_id champion_ban3_id INT NOT NULL, CHANGE champion_ban4_id champion_ban4_id INT NOT NULL, CHANGE champion_ban5_id champion_ban5_id INT NOT NULL');
    }
}
