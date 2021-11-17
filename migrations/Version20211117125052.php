<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117125052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11FF7520C9');
        $this->addSql('DROP INDEX IDX_D79F6B11FF7520C9 ON participant');
        $this->addSql('ALTER TABLE participant CHANGE personindebt_id_id tricount_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11873D6648 FOREIGN KEY (tricount_id_id) REFERENCES tricount (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B11873D6648 ON participant (tricount_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11873D6648');
        $this->addSql('DROP INDEX IDX_D79F6B11873D6648 ON participant');
        $this->addSql('ALTER TABLE participant CHANGE tricount_id_id personindebt_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11FF7520C9 FOREIGN KEY (personindebt_id_id) REFERENCES tricount (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B11FF7520C9 ON participant (personindebt_id_id)');
    }
}
