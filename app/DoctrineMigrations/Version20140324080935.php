<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140324080935 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX UNIQ_1483A5E9F85E0677 ON users");
        $this->addSql("DROP INDEX UNIQ_1483A5E9E7927C74 ON users");
        $this->addSql("DROP INDEX UNIQ_1483A5E944CA4C68 ON users");
        $this->addSql("ALTER TABLE users ADD email_canonical VARCHAR(255) NOT NULL, ADD enabled TINYINT(1) NOT NULL, ADD salt VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD locked TINYINT(1) NOT NULL, ADD expired TINYINT(1) NOT NULL, ADD expires_at DATETIME DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD credentials_expired TINYINT(1) NOT NULL, ADD credentials_expire_at DATETIME DEFAULT NULL, ADD google_id VARCHAR(255) DEFAULT NULL, ADD google_access_token VARCHAR(255) DEFAULT NULL, CHANGE name username_canonical VARCHAR(255) NOT NULL, CHANGE googleid confirmation_token VARCHAR(255) DEFAULT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E976F5C865 ON users (google_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX UNIQ_1483A5E992FC23A8 ON users");
        $this->addSql("DROP INDEX UNIQ_1483A5E9A0D96FBF ON users");
        $this->addSql("DROP INDEX UNIQ_1483A5E976F5C865 ON users");
        $this->addSql("ALTER TABLE users ADD name VARCHAR(255) NOT NULL, ADD googleId VARCHAR(255) DEFAULT NULL, DROP username_canonical, DROP email_canonical, DROP enabled, DROP salt, DROP password, DROP last_login, DROP locked, DROP expired, DROP expires_at, DROP confirmation_token, DROP password_requested_at, DROP credentials_expired, DROP credentials_expire_at, DROP google_id, DROP google_access_token");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E944CA4C68 ON users (googleId)");
    }
}
