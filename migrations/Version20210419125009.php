<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419125009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA144BA75E4E');
        $this->addSql('DROP INDEX IDX_CFBDFA144BA75E4E ON note');
        $this->addSql('ALTER TABLE note CHANGE user1_id_id user1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1456AE248B FOREIGN KEY (user1_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1456AE248B ON note (user1_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1456AE248B');
        $this->addSql('DROP INDEX IDX_CFBDFA1456AE248B ON note');
        $this->addSql('ALTER TABLE note CHANGE user1_id user1_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA144BA75E4E FOREIGN KEY (user1_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA144BA75E4E ON note (user1_id_id)');
    }
}