<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117133919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant_users (participant_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_D5360C509D1C3019 (participant_id), INDEX IDX_D5360C5067B3B43D (users_id), PRIMARY KEY(participant_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participant_users ADD CONSTRAINT FK_D5360C509D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_users ADD CONSTRAINT FK_D5360C5067B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant DROP name');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE participant_users');
        $this->addSql('ALTER TABLE participant ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
