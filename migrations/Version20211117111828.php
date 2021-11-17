<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117111828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depense (id INT AUTO_INCREMENT NOT NULL, pay_master_id INT NOT NULL, tricount_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', amount_total DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_340597573EBD646D (pay_master_id), INDEX IDX_3405975742A1724 (tricount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, personindebt_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D79F6B11FF7520C9 (personindebt_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_in_debt (id INT AUTO_INCREMENT NOT NULL, id_participant_id INT NOT NULL, tricount_id INT NOT NULL, depense_id INT NOT NULL, amount_personnal DOUBLE PRECISION NOT NULL, INDEX IDX_D39A866EA07A8D1F (id_participant_id), INDEX IDX_D39A866E42A1724 (tricount_id), UNIQUE INDEX UNIQ_D39A866E41D81563 (depense_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricount (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, devise VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depense ADD CONSTRAINT FK_340597573EBD646D FOREIGN KEY (pay_master_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE depense ADD CONSTRAINT FK_3405975742A1724 FOREIGN KEY (tricount_id) REFERENCES tricount (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11FF7520C9 FOREIGN KEY (personindebt_id_id) REFERENCES tricount (id)');
        $this->addSql('ALTER TABLE person_in_debt ADD CONSTRAINT FK_D39A866EA07A8D1F FOREIGN KEY (id_participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE person_in_debt ADD CONSTRAINT FK_D39A866E42A1724 FOREIGN KEY (tricount_id) REFERENCES tricount (id)');
        $this->addSql('ALTER TABLE person_in_debt ADD CONSTRAINT FK_D39A866E41D81563 FOREIGN KEY (depense_id) REFERENCES depense (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person_in_debt DROP FOREIGN KEY FK_D39A866E41D81563');
        $this->addSql('ALTER TABLE depense DROP FOREIGN KEY FK_340597573EBD646D');
        $this->addSql('ALTER TABLE person_in_debt DROP FOREIGN KEY FK_D39A866EA07A8D1F');
        $this->addSql('ALTER TABLE depense DROP FOREIGN KEY FK_3405975742A1724');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11FF7520C9');
        $this->addSql('ALTER TABLE person_in_debt DROP FOREIGN KEY FK_D39A866E42A1724');
        $this->addSql('DROP TABLE depense');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE person_in_debt');
        $this->addSql('DROP TABLE tricount');
        $this->addSql('DROP TABLE users');
    }
}
