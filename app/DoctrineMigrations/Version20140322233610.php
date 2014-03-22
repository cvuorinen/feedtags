<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140322233610 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE feeds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_5A29F52FF47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE feed_items (id INT AUTO_INCREMENT NOT NULL, feed_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, published DATETIME NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_1491BAF1F47645AE (url), INDEX IDX_1491BAF151A5BC03 (feed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE feed_items ADD CONSTRAINT FK_1491BAF151A5BC03 FOREIGN KEY (feed_id) REFERENCES feeds (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE feed_items DROP FOREIGN KEY FK_1491BAF151A5BC03");
        $this->addSql("DROP TABLE feeds");
        $this->addSql("DROP TABLE feed_items");
    }
}
