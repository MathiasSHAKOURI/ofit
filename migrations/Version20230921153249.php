<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921153249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD article_category_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6688C5F785 FOREIGN KEY (article_category_id) REFERENCES article_category (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6688C5F785 ON article (article_category_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('ALTER TABLE exercice ADD muscular_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D35EE0B43 FOREIGN KEY (muscular_group_id) REFERENCES muscular_group (id)');
        $this->addSql('CREATE INDEX IDX_E418C74D35EE0B43 ON exercice (muscular_group_id)');
        $this->addSql('ALTER TABLE workout_parameter ADD exercice_id INT NOT NULL, ADD workout_program_id INT NOT NULL');
        $this->addSql('ALTER TABLE workout_parameter ADD CONSTRAINT FK_84DF64489D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('ALTER TABLE workout_parameter ADD CONSTRAINT FK_84DF644529C4880 FOREIGN KEY (workout_program_id) REFERENCES workout_program (id)');
        $this->addSql('CREATE INDEX IDX_84DF64489D40298 ON workout_parameter (exercice_id)');
        $this->addSql('CREATE INDEX IDX_84DF644529C4880 ON workout_parameter (workout_program_id)');
        $this->addSql('ALTER TABLE workout_program ADD user_id INT NOT NULL, ADD workout_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE workout_program ADD CONSTRAINT FK_EE2B1B2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE workout_program ADD CONSTRAINT FK_EE2B1B2C1F47D393 FOREIGN KEY (workout_category_id) REFERENCES workout_category (id)');
        $this->addSql('CREATE INDEX IDX_EE2B1B2CA76ED395 ON workout_program (user_id)');
        $this->addSql('CREATE INDEX IDX_EE2B1B2C1F47D393 ON workout_program (workout_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6688C5F785');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('DROP INDEX IDX_23A0E6688C5F785 ON article');
        $this->addSql('DROP INDEX IDX_23A0E66A76ED395 ON article');
        $this->addSql('ALTER TABLE article DROP article_category_id, DROP user_id');
        $this->addSql('ALTER TABLE workout_program DROP FOREIGN KEY FK_EE2B1B2CA76ED395');
        $this->addSql('ALTER TABLE workout_program DROP FOREIGN KEY FK_EE2B1B2C1F47D393');
        $this->addSql('DROP INDEX IDX_EE2B1B2CA76ED395 ON workout_program');
        $this->addSql('DROP INDEX IDX_EE2B1B2C1F47D393 ON workout_program');
        $this->addSql('ALTER TABLE workout_program DROP user_id, DROP workout_category_id');
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D35EE0B43');
        $this->addSql('DROP INDEX IDX_E418C74D35EE0B43 ON exercice');
        $this->addSql('ALTER TABLE exercice DROP muscular_group_id');
        $this->addSql('ALTER TABLE workout_parameter DROP FOREIGN KEY FK_84DF64489D40298');
        $this->addSql('ALTER TABLE workout_parameter DROP FOREIGN KEY FK_84DF644529C4880');
        $this->addSql('DROP INDEX IDX_84DF64489D40298 ON workout_parameter');
        $this->addSql('DROP INDEX IDX_84DF644529C4880 ON workout_parameter');
        $this->addSql('ALTER TABLE workout_parameter DROP exercice_id, DROP workout_program_id');
    }
}
