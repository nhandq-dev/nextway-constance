<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221221090138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_option (id INT NOT NULL, question_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, weight SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5DDB2FB81E27F6BF ON question_option (question_id)');
        $this->addSql('CREATE TABLE response_detail (id INT NOT NULL, questionnaire_response_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, question VARCHAR(255) NOT NULL, options JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_457D58BC72D7F260 ON response_detail (questionnaire_response_id)');
        $this->addSql('CREATE TABLE tbl_activity (id INT NOT NULL, owner_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, activity_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_repeat BOOLEAN DEFAULT NULL, repeat_amount INT DEFAULT NULL, repeat_unit VARCHAR(255) DEFAULT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB47EF777E3C61F9 ON tbl_activity (owner_id)');
        $this->addSql('CREATE TABLE tbl_community (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, active BOOLEAN NOT NULL, is_default BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5EE82FA05E237E06 ON tbl_community (name)');
        $this->addSql('CREATE TABLE tbl_question (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, is_primary BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tbl_questionnaire (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(125) NOT NULL, is_publish BOOLEAN NOT NULL, publish_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, flated_questionnaire JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tbl_questionnaire_question (id INT NOT NULL, questionnaire_id INT DEFAULT NULL, question_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6E1C4487CE07E8FF ON tbl_questionnaire_question (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_6E1C44871E27F6BF ON tbl_questionnaire_question (question_id)');
        $this->addSql('CREATE TABLE tbl_questionnaire_response (id INT NOT NULL, questionnaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, activity_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_finished BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6900632CE07E8FF ON tbl_questionnaire_response (questionnaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6900632A76ED395 ON tbl_questionnaire_response (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E690063281C06096 ON tbl_questionnaire_response (activity_id)');
        $this->addSql('CREATE TABLE tbl_team (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, active BOOLEAN NOT NULL, is_default BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_71C0F3F75E237E06 ON tbl_team (name)');
        $this->addSql('CREATE TABLE tbl_user (id INT NOT NULL, team_id INT DEFAULT NULL, community_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, avatar BYTEA DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B383A1E7927C74 ON tbl_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B383A1444F97DD ON tbl_user (phone)');
        $this->addSql('CREATE INDEX IDX_38B383A1296CD8AE ON tbl_user (team_id)');
        $this->addSql('CREATE INDEX IDX_38B383A1FDA7B0BF ON tbl_user (community_id)');
        $this->addSql('CREATE TABLE user_wellness (id INT NOT NULL, person_id INT DEFAULT NULL, rate INT NOT NULL, reason TEXT NOT NULL, context_type VARCHAR(255) DEFAULT NULL, context_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_81BB1687217BBB47 ON user_wellness (person_id)');
        $this->addSql('ALTER TABLE question_option ADD CONSTRAINT FK_5DDB2FB81E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE response_detail ADD CONSTRAINT FK_457D58BC72D7F260 FOREIGN KEY (questionnaire_response_id) REFERENCES tbl_questionnaire_response (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_activity ADD CONSTRAINT FK_FB47EF777E3C61F9 FOREIGN KEY (owner_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_question ADD CONSTRAINT FK_6E1C4487CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES tbl_questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_question ADD CONSTRAINT FK_6E1C44871E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_response ADD CONSTRAINT FK_E6900632CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES tbl_questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_response ADD CONSTRAINT FK_E6900632A76ED395 FOREIGN KEY (user_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_response ADD CONSTRAINT FK_E690063281C06096 FOREIGN KEY (activity_id) REFERENCES tbl_activity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_user ADD CONSTRAINT FK_38B383A1296CD8AE FOREIGN KEY (team_id) REFERENCES tbl_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_user ADD CONSTRAINT FK_38B383A1FDA7B0BF FOREIGN KEY (community_id) REFERENCES tbl_community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_wellness ADD CONSTRAINT FK_81BB1687217BBB47 FOREIGN KEY (person_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE question_option DROP CONSTRAINT FK_5DDB2FB81E27F6BF');
        $this->addSql('ALTER TABLE response_detail DROP CONSTRAINT FK_457D58BC72D7F260');
        $this->addSql('ALTER TABLE tbl_activity DROP CONSTRAINT FK_FB47EF777E3C61F9');
        $this->addSql('ALTER TABLE tbl_questionnaire_question DROP CONSTRAINT FK_6E1C4487CE07E8FF');
        $this->addSql('ALTER TABLE tbl_questionnaire_question DROP CONSTRAINT FK_6E1C44871E27F6BF');
        $this->addSql('ALTER TABLE tbl_questionnaire_response DROP CONSTRAINT FK_E6900632CE07E8FF');
        $this->addSql('ALTER TABLE tbl_questionnaire_response DROP CONSTRAINT FK_E6900632A76ED395');
        $this->addSql('ALTER TABLE tbl_questionnaire_response DROP CONSTRAINT FK_E690063281C06096');
        $this->addSql('ALTER TABLE tbl_user DROP CONSTRAINT FK_38B383A1296CD8AE');
        $this->addSql('ALTER TABLE tbl_user DROP CONSTRAINT FK_38B383A1FDA7B0BF');
        $this->addSql('ALTER TABLE user_wellness DROP CONSTRAINT FK_81BB1687217BBB47');
        $this->addSql('DROP TABLE question_option');
        $this->addSql('DROP TABLE response_detail');
        $this->addSql('DROP TABLE tbl_activity');
        $this->addSql('DROP TABLE tbl_community');
        $this->addSql('DROP TABLE tbl_question');
        $this->addSql('DROP TABLE tbl_questionnaire');
        $this->addSql('DROP TABLE tbl_questionnaire_question');
        $this->addSql('DROP TABLE tbl_questionnaire_response');
        $this->addSql('DROP TABLE tbl_team');
        $this->addSql('DROP TABLE tbl_user');
        $this->addSql('DROP TABLE user_wellness');
    }
}
