<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228150339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oauth2_access_token (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_454D9673C7440455 ON oauth2_access_token (client)');
        $this->addSql('COMMENT ON COLUMN oauth2_access_token.expiry IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_access_token.scopes IS \'(DC2Type:oauth2_scope)\'');
        $this->addSql('CREATE TABLE oauth2_authorization_code (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_509FEF5FC7440455 ON oauth2_authorization_code (client)');
        $this->addSql('COMMENT ON COLUMN oauth2_authorization_code.expiry IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_authorization_code.scopes IS \'(DC2Type:oauth2_scope)\'');
        $this->addSql('CREATE TABLE oauth2_client (identifier VARCHAR(32) NOT NULL, name VARCHAR(128) NOT NULL, secret VARCHAR(128) DEFAULT NULL, redirect_uris TEXT DEFAULT NULL, grants TEXT DEFAULT NULL, scopes TEXT DEFAULT NULL, active BOOLEAN NOT NULL, allow_plain_text_pkce BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('COMMENT ON COLUMN oauth2_client.redirect_uris IS \'(DC2Type:oauth2_redirect_uri)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_client.grants IS \'(DC2Type:oauth2_grant)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_client.scopes IS \'(DC2Type:oauth2_scope)\'');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier CHAR(80) NOT NULL, access_token CHAR(80) DEFAULT NULL, expiry TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_4DD90732B6A2DD68 ON oauth2_refresh_token (access_token)');
        $this->addSql('COMMENT ON COLUMN oauth2_refresh_token.expiry IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tbl_activity (id INT NOT NULL, person_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, due_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_repeat BOOLEAN DEFAULT NULL, repeat_amount INT DEFAULT NULL, repeat_unit VARCHAR(255) DEFAULT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB47EF77217BBB47 ON tbl_activity (person_id)');
        $this->addSql('CREATE TABLE tbl_activity_response (id INT NOT NULL, activity_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, rate INT DEFAULT NULL, comment VARCHAR(2048) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2070756781C06096 ON tbl_activity_response (activity_id)');
        $this->addSql('CREATE TABLE tbl_question (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, is_primary BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tbl_question_option (id INT NOT NULL, question_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, weight SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_83F77A361E27F6BF ON tbl_question_option (question_id)');
        $this->addSql('CREATE TABLE tbl_questionnaire (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(125) NOT NULL, is_publish BOOLEAN NOT NULL, publish_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, flated_questionnaire JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tbl_questionnaire_question (id INT NOT NULL, questionnaire_id INT DEFAULT NULL, question_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6E1C4487CE07E8FF ON tbl_questionnaire_question (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_6E1C44871E27F6BF ON tbl_questionnaire_question (question_id)');
        $this->addSql('CREATE TABLE tbl_questionnaire_response (id INT NOT NULL, questionnaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, activity_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_finished BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6900632CE07E8FF ON tbl_questionnaire_response (questionnaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6900632A76ED395 ON tbl_questionnaire_response (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E690063281C06096 ON tbl_questionnaire_response (activity_id)');
        $this->addSql('CREATE TABLE tbl_response_detail (id INT NOT NULL, questionnaire_response_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, question VARCHAR(255) NOT NULL, options JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9B510D3272D7F260 ON tbl_response_detail (questionnaire_response_id)');
        $this->addSql('CREATE TABLE tbl_social (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, is_active BOOLEAN NOT NULL, is_default BOOLEAN NOT NULL, type SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCC788385E237E06 ON tbl_social (name)');
        $this->addSql('CREATE TABLE tbl_user (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, avatar BYTEA DEFAULT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B383A1E7927C74 ON tbl_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B383A1444F97DD ON tbl_user (phone)');
        $this->addSql('CREATE TABLE tbl_user_daily_emotion (id INT NOT NULL, person_id INT DEFAULT NULL, question_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, question_object JSON NOT NULL, rate INT NOT NULL, reason TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F0E3375217BBB47 ON tbl_user_daily_emotion (person_id)');
        $this->addSql('CREATE INDEX IDX_2F0E33751E27F6BF ON tbl_user_daily_emotion (question_id)');
        $this->addSql('CREATE TABLE tbl_user_social (id INT NOT NULL, person_id INT DEFAULT NULL, social_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93521A22217BBB47 ON tbl_user_social (person_id)');
        $this->addSql('CREATE INDEX IDX_93521A22FFEB5B27 ON tbl_user_social (social_id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673C7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oauth2_authorization_code ADD CONSTRAINT FK_509FEF5FC7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732B6A2DD68 FOREIGN KEY (access_token) REFERENCES oauth2_access_token (identifier) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_activity ADD CONSTRAINT FK_FB47EF77217BBB47 FOREIGN KEY (person_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_activity_response ADD CONSTRAINT FK_2070756781C06096 FOREIGN KEY (activity_id) REFERENCES tbl_activity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_question_option ADD CONSTRAINT FK_83F77A361E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_question ADD CONSTRAINT FK_6E1C4487CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES tbl_questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_question ADD CONSTRAINT FK_6E1C44871E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_response ADD CONSTRAINT FK_E6900632CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES tbl_questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_response ADD CONSTRAINT FK_E6900632A76ED395 FOREIGN KEY (user_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_questionnaire_response ADD CONSTRAINT FK_E690063281C06096 FOREIGN KEY (activity_id) REFERENCES tbl_activity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_response_detail ADD CONSTRAINT FK_9B510D3272D7F260 FOREIGN KEY (questionnaire_response_id) REFERENCES tbl_questionnaire_response (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_user_daily_emotion ADD CONSTRAINT FK_2F0E3375217BBB47 FOREIGN KEY (person_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_user_daily_emotion ADD CONSTRAINT FK_2F0E33751E27F6BF FOREIGN KEY (question_id) REFERENCES tbl_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_user_social ADD CONSTRAINT FK_93521A22217BBB47 FOREIGN KEY (person_id) REFERENCES tbl_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tbl_user_social ADD CONSTRAINT FK_93521A22FFEB5B27 FOREIGN KEY (social_id) REFERENCES tbl_social (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE oauth2_access_token DROP CONSTRAINT FK_454D9673C7440455');
        $this->addSql('ALTER TABLE oauth2_authorization_code DROP CONSTRAINT FK_509FEF5FC7440455');
        $this->addSql('ALTER TABLE oauth2_refresh_token DROP CONSTRAINT FK_4DD90732B6A2DD68');
        $this->addSql('ALTER TABLE tbl_activity DROP CONSTRAINT FK_FB47EF77217BBB47');
        $this->addSql('ALTER TABLE tbl_activity_response DROP CONSTRAINT FK_2070756781C06096');
        $this->addSql('ALTER TABLE tbl_question_option DROP CONSTRAINT FK_83F77A361E27F6BF');
        $this->addSql('ALTER TABLE tbl_questionnaire_question DROP CONSTRAINT FK_6E1C4487CE07E8FF');
        $this->addSql('ALTER TABLE tbl_questionnaire_question DROP CONSTRAINT FK_6E1C44871E27F6BF');
        $this->addSql('ALTER TABLE tbl_questionnaire_response DROP CONSTRAINT FK_E6900632CE07E8FF');
        $this->addSql('ALTER TABLE tbl_questionnaire_response DROP CONSTRAINT FK_E6900632A76ED395');
        $this->addSql('ALTER TABLE tbl_questionnaire_response DROP CONSTRAINT FK_E690063281C06096');
        $this->addSql('ALTER TABLE tbl_response_detail DROP CONSTRAINT FK_9B510D3272D7F260');
        $this->addSql('ALTER TABLE tbl_user_daily_emotion DROP CONSTRAINT FK_2F0E3375217BBB47');
        $this->addSql('ALTER TABLE tbl_user_daily_emotion DROP CONSTRAINT FK_2F0E33751E27F6BF');
        $this->addSql('ALTER TABLE tbl_user_social DROP CONSTRAINT FK_93521A22217BBB47');
        $this->addSql('ALTER TABLE tbl_user_social DROP CONSTRAINT FK_93521A22FFEB5B27');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_client');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('DROP TABLE tbl_activity');
        $this->addSql('DROP TABLE tbl_activity_response');
        $this->addSql('DROP TABLE tbl_question');
        $this->addSql('DROP TABLE tbl_question_option');
        $this->addSql('DROP TABLE tbl_questionnaire');
        $this->addSql('DROP TABLE tbl_questionnaire_question');
        $this->addSql('DROP TABLE tbl_questionnaire_response');
        $this->addSql('DROP TABLE tbl_response_detail');
        $this->addSql('DROP TABLE tbl_social');
        $this->addSql('DROP TABLE tbl_user');
        $this->addSql('DROP TABLE tbl_user_daily_emotion');
        $this->addSql('DROP TABLE tbl_user_social');
    }
}
