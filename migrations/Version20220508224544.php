<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508224544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `bans` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, motif INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_CB0C272CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `categories` (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_3AF34668D17F50A6 (uuid), UNIQUE INDEX UNIQ_3AF34668989D9B62 (slug), INDEX IDX_3AF34668F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `category_requests` (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CCFF522AF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `follow_categories` (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_401869E912469DE2 (category_id), INDEX IDX_401869E9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `follow_users` (id INT AUTO_INCREMENT NOT NULL, following_id INT DEFAULT NULL, follower_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1674F531816E3A3 (following_id), INDEX IDX_1674F53AC24F853 (follower_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `top_elements` (id INT AUTO_INCREMENT NOT NULL, top_id INT NOT NULL, author_id INT NOT NULL, rank INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E57FCD11C82CB256 (top_id), INDEX IDX_E57FCD11F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `tops` (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, color INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', collaborative TINYINT(1) NOT NULL, deadline DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_60A13DBAD17F50A6 (uuid), INDEX IDX_60A13DBAF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', google_id VARCHAR(255) DEFAULT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `votes` (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, top_id INT DEFAULT NULL, top_element_id INT DEFAULT NULL, category_request_id INT DEFAULT NULL, type INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_518B7ACFF675F31B (author_id), INDEX IDX_518B7ACFC82CB256 (top_id), INDEX IDX_518B7ACF3862A0B6 (top_element_id), INDEX IDX_518B7ACF6460E8DB (category_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `bans` ADD CONSTRAINT FK_CB0C272CA76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `categories` ADD CONSTRAINT FK_3AF34668F675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `category_requests` ADD CONSTRAINT FK_CCFF522AF675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `follow_categories` ADD CONSTRAINT FK_401869E912469DE2 FOREIGN KEY (category_id) REFERENCES `categories` (id)');
        $this->addSql('ALTER TABLE `follow_categories` ADD CONSTRAINT FK_401869E9A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `follow_users` ADD CONSTRAINT FK_1674F531816E3A3 FOREIGN KEY (following_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `follow_users` ADD CONSTRAINT FK_1674F53AC24F853 FOREIGN KEY (follower_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `top_elements` ADD CONSTRAINT FK_E57FCD11C82CB256 FOREIGN KEY (top_id) REFERENCES `tops` (id)');
        $this->addSql('ALTER TABLE `top_elements` ADD CONSTRAINT FK_E57FCD11F675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `tops` ADD CONSTRAINT FK_60A13DBAF675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `votes` ADD CONSTRAINT FK_518B7ACFF675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `votes` ADD CONSTRAINT FK_518B7ACFC82CB256 FOREIGN KEY (top_id) REFERENCES `tops` (id)');
        $this->addSql('ALTER TABLE `votes` ADD CONSTRAINT FK_518B7ACF3862A0B6 FOREIGN KEY (top_element_id) REFERENCES `top_elements` (id)');
        $this->addSql('ALTER TABLE `votes` ADD CONSTRAINT FK_518B7ACF6460E8DB FOREIGN KEY (category_request_id) REFERENCES `category_requests` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `follow_categories` DROP FOREIGN KEY FK_401869E912469DE2');
        $this->addSql('ALTER TABLE `votes` DROP FOREIGN KEY FK_518B7ACF6460E8DB');
        $this->addSql('ALTER TABLE `votes` DROP FOREIGN KEY FK_518B7ACF3862A0B6');
        $this->addSql('ALTER TABLE `top_elements` DROP FOREIGN KEY FK_E57FCD11C82CB256');
        $this->addSql('ALTER TABLE `votes` DROP FOREIGN KEY FK_518B7ACFC82CB256');
        $this->addSql('ALTER TABLE `bans` DROP FOREIGN KEY FK_CB0C272CA76ED395');
        $this->addSql('ALTER TABLE `categories` DROP FOREIGN KEY FK_3AF34668F675F31B');
        $this->addSql('ALTER TABLE `category_requests` DROP FOREIGN KEY FK_CCFF522AF675F31B');
        $this->addSql('ALTER TABLE `follow_categories` DROP FOREIGN KEY FK_401869E9A76ED395');
        $this->addSql('ALTER TABLE `follow_users` DROP FOREIGN KEY FK_1674F531816E3A3');
        $this->addSql('ALTER TABLE `follow_users` DROP FOREIGN KEY FK_1674F53AC24F853');
        $this->addSql('ALTER TABLE `top_elements` DROP FOREIGN KEY FK_E57FCD11F675F31B');
        $this->addSql('ALTER TABLE `tops` DROP FOREIGN KEY FK_60A13DBAF675F31B');
        $this->addSql('ALTER TABLE `votes` DROP FOREIGN KEY FK_518B7ACFF675F31B');
        $this->addSql('DROP TABLE `bans`');
        $this->addSql('DROP TABLE `categories`');
        $this->addSql('DROP TABLE `category_requests`');
        $this->addSql('DROP TABLE `follow_categories`');
        $this->addSql('DROP TABLE `follow_users`');
        $this->addSql('DROP TABLE `top_elements`');
        $this->addSql('DROP TABLE `tops`');
        $this->addSql('DROP TABLE `users`');
        $this->addSql('DROP TABLE `votes`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
