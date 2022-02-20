<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220204653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE example (id INT AUTO_INCREMENT NOT NULL, ideogramme_id INT DEFAULT NULL, list VARCHAR(255) NOT NULL, INDEX IDX_6EEC9B9F17AF2D7E (ideogramme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ideogramme (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, logo VARCHAR(255) NOT NULL, signification VARCHAR(255) NOT NULL, stroke INT NOT NULL, kun VARCHAR(255) NOT NULL, read_on VARCHAR(255) NOT NULL, jlpt VARCHAR(50) DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_92FFC1D23DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ideogramme_ideogramme (ideogramme_source INT NOT NULL, ideogramme_target INT NOT NULL, INDEX IDX_1510BA889D7CA92E (ideogramme_source), INDEX IDX_1510BA888499F9A1 (ideogramme_target), PRIMARY KEY(ideogramme_source, ideogramme_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, alt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji (id INT NOT NULL, kanji_key_id INT DEFAULT NULL, INDEX IDX_426F9DDC13C3AE36 (kanji_key_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji_key (id INT NOT NULL, number_key INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE example ADD CONSTRAINT FK_6EEC9B9F17AF2D7E FOREIGN KEY (ideogramme_id) REFERENCES ideogramme (id)');
        $this->addSql('ALTER TABLE ideogramme ADD CONSTRAINT FK_92FFC1D23DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE ideogramme_ideogramme ADD CONSTRAINT FK_1510BA889D7CA92E FOREIGN KEY (ideogramme_source) REFERENCES ideogramme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ideogramme_ideogramme ADD CONSTRAINT FK_1510BA888499F9A1 FOREIGN KEY (ideogramme_target) REFERENCES ideogramme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji ADD CONSTRAINT FK_426F9DDC13C3AE36 FOREIGN KEY (kanji_key_id) REFERENCES kanji_key (id)');
        $this->addSql('ALTER TABLE kanji ADD CONSTRAINT FK_426F9DDCBF396750 FOREIGN KEY (id) REFERENCES ideogramme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_key ADD CONSTRAINT FK_2405C805BF396750 FOREIGN KEY (id) REFERENCES ideogramme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE example DROP FOREIGN KEY FK_6EEC9B9F17AF2D7E');
        $this->addSql('ALTER TABLE ideogramme_ideogramme DROP FOREIGN KEY FK_1510BA889D7CA92E');
        $this->addSql('ALTER TABLE ideogramme_ideogramme DROP FOREIGN KEY FK_1510BA888499F9A1');
        $this->addSql('ALTER TABLE kanji DROP FOREIGN KEY FK_426F9DDCBF396750');
        $this->addSql('ALTER TABLE kanji_key DROP FOREIGN KEY FK_2405C805BF396750');
        $this->addSql('ALTER TABLE ideogramme DROP FOREIGN KEY FK_92FFC1D23DA5256D');
        $this->addSql('ALTER TABLE kanji DROP FOREIGN KEY FK_426F9DDC13C3AE36');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBF396750');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE example');
        $this->addSql('DROP TABLE ideogramme');
        $this->addSql('DROP TABLE ideogramme_ideogramme');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE kanji');
        $this->addSql('DROP TABLE kanji_key');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
