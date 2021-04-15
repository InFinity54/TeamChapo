<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415095553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_participant (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, champion_id INT NOT NULL, puuid VARCHAR(255) NOT NULL, kills INT NOT NULL, deaths INT NOT NULL, assists INT NOT NULL, item1 INT DEFAULT NULL, item2 INT DEFAULT NULL, item3 INT DEFAULT NULL, item4 INT DEFAULT NULL, item5 INT DEFAULT NULL, item6 INT DEFAULT NULL, ward INT DEFAULT NULL, lane VARCHAR(255) NOT NULL, champion_level INT NOT NULL, damage_dealt_to_buildings INT NOT NULL, damage_dealt_to_objectives INT NOT NULL, damage_dealt_to_turrets INT NOT NULL, damage_self_mitigated INT NOT NULL, baron_kills INT NOT NULL, double_kills INT NOT NULL, dragon_kills INT NOT NULL, first_blood_assist TINYINT(1) NOT NULL, first_blood_kill TINYINT(1) NOT NULL, first_tower_assist TINYINT(1) NOT NULL, first_tower_kill TINYINT(1) NOT NULL, game_ended_in_early_surrender TINYINT(1) NOT NULL, game_ended_in_surrender TINYINT(1) NOT NULL, gold_earned INT NOT NULL, gold_spent INT NOT NULL, inhibitor_kills INT NOT NULL, inhibitors_lost INT NOT NULL, killing_sprees INT NOT NULL, largest_critical_strike INT NOT NULL, largest_killing_spree INT NOT NULL, largest_multi_kill INT NOT NULL, longest_time_spent_living INT NOT NULL, magic_damage_dealt INT NOT NULL, magic_damage_dealt_to_champions INT NOT NULL, magic_damage_taken INT NOT NULL, neutral_minions_killed INT NOT NULL, nexus_kills INT NOT NULL, objectives_stolen INT NOT NULL, objectives_stolen_assists INT NOT NULL, penta_kills INT NOT NULL, perks_stats_defense INT NOT NULL, perks_stats_flex INT NOT NULL, perks_stats_offense INT NOT NULL, perks_primary_selection1 VARCHAR(255) NOT NULL, perks_primary_selection2 VARCHAR(255) NOT NULL, perks_primary_selection3 VARCHAR(255) NOT NULL, perks_primary_selection4 VARCHAR(255) NOT NULL, perks_primary_style INT NOT NULL, perks_secondary_selection1 VARCHAR(255) NOT NULL, perks_secondary_selection2 VARCHAR(255) NOT NULL, perks_secondary_style INT NOT NULL, physical_damage_dealt INT NOT NULL, physical_damage_dealt_to_champions INT NOT NULL, physical_damage_taken INT NOT NULL, quadra_kills INT NOT NULL, spell_acasts INT NOT NULL, spell_zcasts INT NOT NULL, spell_ecasts INT NOT NULL, spell_rcasts INT NOT NULL, summoner_spell1_id INT NOT NULL, summoner_spell1_casts INT NOT NULL, summoner_spell2_id INT NOT NULL, summoner_spell2_casts INT NOT NULL, team_id INT NOT NULL, total_damage_dealt INT NOT NULL, total_damage_dealt_to_champions INT NOT NULL, total_damage_shielded_on_teammates INT NOT NULL, total_damage_taken INT NOT NULL, total_heal INT NOT NULL, total_heals_on_teammates INT NOT NULL, total_minions_killed INT NOT NULL, total_time_ccdealt INT NOT NULL, total_time_spent_dead INT NOT NULL, total_units_healed INT NOT NULL, triple_kills INT NOT NULL, true_damage_dealt INT NOT NULL, true_damage_dealt_to_champions INT NOT NULL, true_damage_taken INT NOT NULL, turret_kills INT NOT NULL, unreal_kills INT NOT NULL, vision_score INT NOT NULL, vision_wards_bought_in_game INT NOT NULL, wards_killed INT NOT NULL, wards_placed INT NOT NULL, win TINYINT(1) NOT NULL, INDEX IDX_9CA2913E48FD905 (game_id), INDEX IDX_9CA2913FA7FD7EB (champion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_team (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, champion_ban1_id INT NOT NULL, champion_ban2_id INT NOT NULL, champion_ban3_id INT NOT NULL, champion_ban4_id INT NOT NULL, champion_ban5_id INT NOT NULL, team_id INT NOT NULL, first_baron TINYINT(1) NOT NULL, total_baron_kills INT NOT NULL, first_blood TINYINT(1) NOT NULL, total_champion_kills INT NOT NULL, first_dragon TINYINT(1) NOT NULL, total_dragons_kills INT NOT NULL, first_inhibitor TINYINT(1) NOT NULL, total_inhibitors_kills INT NOT NULL, first_rift_herald TINYINT(1) NOT NULL, total_rift_herald_kills INT NOT NULL, first_tower TINYINT(1) NOT NULL, total_towers_kills INT NOT NULL, win TINYINT(1) NOT NULL, INDEX IDX_2FF5CA33E48FD905 (game_id), INDEX IDX_2FF5CA333604292A (champion_ban1_id), INDEX IDX_2FF5CA3324B186C4 (champion_ban2_id), INDEX IDX_2FF5CA339C0DE1A1 (champion_ban3_id), INDEX IDX_2FF5CA331DAD918 (champion_ban4_id), INDEX IDX_2FF5CA33B966BE7D (champion_ban5_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_participant ADD CONSTRAINT FK_9CA2913E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_participant ADD CONSTRAINT FK_9CA2913FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA33E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA333604292A FOREIGN KEY (champion_ban1_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA3324B186C4 FOREIGN KEY (champion_ban2_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA339C0DE1A1 FOREIGN KEY (champion_ban3_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA331DAD918 FOREIGN KEY (champion_ban4_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA33B966BE7D FOREIGN KEY (champion_ban5_id) REFERENCES champion (id)');
        $this->addSql('ALTER TABLE game ADD start_date DATETIME NOT NULL, ADD duration VARCHAR(255) NOT NULL, ADD queue_id INT NOT NULL, ADD map_id INT NOT NULL, ADD game_version VARCHAR(255) NOT NULL, DROP game_data');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_participant');
        $this->addSql('DROP TABLE game_team');
        $this->addSql('ALTER TABLE game ADD game_data JSON NOT NULL, DROP start_date, DROP duration, DROP queue_id, DROP map_id, DROP game_version');
    }
}
