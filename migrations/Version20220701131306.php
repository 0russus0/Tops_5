<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701131306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'color and icon nullable';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tops CHANGE icon icon VARCHAR(255) DEFAULT NULL, CHANGE color color INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `tops` CHANGE icon icon VARCHAR(255) NOT NULL, CHANGE color color INT NOT NULL');
    }
}
