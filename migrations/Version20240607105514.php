<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607105514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE questionnaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer (id INT NOT NULL, text TEXT NOT NULL, position INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE answer_product_recommendations (answer_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(answer_id, product_id))');
        $this->addSql('CREATE INDEX IDX_46D694AEAA334807 ON answer_product_recommendations (answer_id)');
        $this->addSql('CREATE INDEX IDX_46D694AE4584665A ON answer_product_recommendations (product_id)');
        $this->addSql('CREATE TABLE answer_product_restrictions (answer_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(answer_id, product_id))');
        $this->addSql('CREATE INDEX IDX_F47B2797AA334807 ON answer_product_restrictions (answer_id)');
        $this->addSql('CREATE INDEX IDX_F47B27974584665A ON answer_product_restrictions (product_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, text TEXT NOT NULL, position INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question_answers (question_id INT NOT NULL, answer_id INT NOT NULL, PRIMARY KEY(question_id, answer_id))');
        $this->addSql('CREATE INDEX IDX_5E0C131B1E27F6BF ON question_answers (question_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E0C131BAA334807 ON question_answers (answer_id)');
        $this->addSql('CREATE TABLE question_answers_required (question_id INT NOT NULL, answer_id INT NOT NULL, PRIMARY KEY(question_id, answer_id))');
        $this->addSql('CREATE INDEX IDX_E3DE09FE1E27F6BF ON question_answers_required (question_id)');
        $this->addSql('CREATE INDEX IDX_E3DE09FEAA334807 ON question_answers_required (answer_id)');
        $this->addSql('CREATE TABLE questionnaire (id INT NOT NULL, slug VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE questionnaire_questions (questionnaire_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(questionnaire_id, question_id))');
        $this->addSql('CREATE INDEX IDX_194B9041CE07E8FF ON questionnaire_questions (questionnaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_194B90411E27F6BF ON questionnaire_questions (question_id)');
        $this->addSql('ALTER TABLE answer_product_recommendations ADD CONSTRAINT FK_46D694AEAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_product_recommendations ADD CONSTRAINT FK_46D694AE4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_product_restrictions ADD CONSTRAINT FK_F47B2797AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_product_restrictions ADD CONSTRAINT FK_F47B27974584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question_answers ADD CONSTRAINT FK_5E0C131B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question_answers ADD CONSTRAINT FK_5E0C131BAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question_answers_required ADD CONSTRAINT FK_E3DE09FE1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question_answers_required ADD CONSTRAINT FK_E3DE09FEAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_questions ADD CONSTRAINT FK_194B9041CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_questions ADD CONSTRAINT FK_194B90411E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE questionnaire_id_seq CASCADE');
        $this->addSql('ALTER TABLE answer_product_recommendations DROP CONSTRAINT FK_46D694AEAA334807');
        $this->addSql('ALTER TABLE answer_product_recommendations DROP CONSTRAINT FK_46D694AE4584665A');
        $this->addSql('ALTER TABLE answer_product_restrictions DROP CONSTRAINT FK_F47B2797AA334807');
        $this->addSql('ALTER TABLE answer_product_restrictions DROP CONSTRAINT FK_F47B27974584665A');
        $this->addSql('ALTER TABLE question_answers DROP CONSTRAINT FK_5E0C131B1E27F6BF');
        $this->addSql('ALTER TABLE question_answers DROP CONSTRAINT FK_5E0C131BAA334807');
        $this->addSql('ALTER TABLE question_answers_required DROP CONSTRAINT FK_E3DE09FE1E27F6BF');
        $this->addSql('ALTER TABLE question_answers_required DROP CONSTRAINT FK_E3DE09FEAA334807');
        $this->addSql('ALTER TABLE questionnaire_questions DROP CONSTRAINT FK_194B9041CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_questions DROP CONSTRAINT FK_194B90411E27F6BF');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE answer_product_recommendations');
        $this->addSql('DROP TABLE answer_product_restrictions');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_answers');
        $this->addSql('DROP TABLE question_answers_required');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_questions');
    }
}
