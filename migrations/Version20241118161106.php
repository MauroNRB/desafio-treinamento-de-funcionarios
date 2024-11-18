<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118161106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cafeteria (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coaching (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, rotation INT NOT NULL, UNIQUE INDEX UNIQ_CABE08CE54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coaching_people (coaching_id INT NOT NULL, people_id INT NOT NULL, INDEX IDX_1753530919706A33 (coaching_id), INDEX IDX_175353093147C936 (people_id), PRIMARY KEY(coaching_id, people_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE people (id INT AUTO_INCREMENT NOT NULL, cafeteria_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_28166A2646884829 (cafeteria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coaching ADD CONSTRAINT FK_CABE08CE54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE coaching_people ADD CONSTRAINT FK_1753530919706A33 FOREIGN KEY (coaching_id) REFERENCES coaching (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaching_people ADD CONSTRAINT FK_175353093147C936 FOREIGN KEY (people_id) REFERENCES people (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE people ADD CONSTRAINT FK_28166A2646884829 FOREIGN KEY (cafeteria_id) REFERENCES cafeteria (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE people DROP FOREIGN KEY FK_28166A2646884829');
        $this->addSql('ALTER TABLE coaching_people DROP FOREIGN KEY FK_1753530919706A33');
        $this->addSql('ALTER TABLE coaching_people DROP FOREIGN KEY FK_175353093147C936');
        $this->addSql('ALTER TABLE coaching DROP FOREIGN KEY FK_CABE08CE54177093');
        $this->addSql('DROP TABLE cafeteria');
        $this->addSql('DROP TABLE coaching');
        $this->addSql('DROP TABLE coaching_people');
        $this->addSql('DROP TABLE people');
        $this->addSql('DROP TABLE room');
    }
}
