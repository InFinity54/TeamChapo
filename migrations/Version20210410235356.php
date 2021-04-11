<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410235356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pool (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_AF91A986A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pool_primary (pool_id INT NOT NULL, champion_id INT NOT NULL, INDEX IDX_27DCBA7B3406DF (pool_id), INDEX IDX_27DCBAFA7FD7EB (champion_id), PRIMARY KEY(pool_id, champion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pool_secondary (pool_id INT NOT NULL, champion_id INT NOT NULL, INDEX IDX_A71A8F117B3406DF (pool_id), INDEX IDX_A71A8F11FA7FD7EB (champion_id), PRIMARY KEY(pool_id, champion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pool_excluded (pool_id INT NOT NULL, champion_id INT NOT NULL, INDEX IDX_9E1E1F027B3406DF (pool_id), INDEX IDX_9E1E1F02FA7FD7EB (champion_id), PRIMARY KEY(pool_id, champion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pool ADD CONSTRAINT FK_AF91A986A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pool_primary ADD CONSTRAINT FK_27DCBA7B3406DF FOREIGN KEY (pool_id) REFERENCES pool (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pool_primary ADD CONSTRAINT FK_27DCBAFA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pool_secondary ADD CONSTRAINT FK_A71A8F117B3406DF FOREIGN KEY (pool_id) REFERENCES pool (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pool_secondary ADD CONSTRAINT FK_A71A8F11FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pool_excluded ADD CONSTRAINT FK_9E1E1F027B3406DF FOREIGN KEY (pool_id) REFERENCES pool (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pool_excluded ADD CONSTRAINT FK_9E1E1F02FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pool_primary DROP FOREIGN KEY FK_27DCBA7B3406DF');
        $this->addSql('ALTER TABLE pool_secondary DROP FOREIGN KEY FK_A71A8F117B3406DF');
        $this->addSql('ALTER TABLE pool_excluded DROP FOREIGN KEY FK_9E1E1F027B3406DF');
        $this->addSql('DROP TABLE pool');
        $this->addSql('DROP TABLE pool_primary');
        $this->addSql('DROP TABLE pool_secondary');
        $this->addSql('DROP TABLE pool_excluded');
    }
}
