<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180411132820 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post ADD userId INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D64B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D64B64DCC ON post (userId)');
        $this->addSql('ALTER TABLE comment ADD postId INT DEFAULT NULL, ADD userId INT DEFAULT NULL, DROP post_id, DROP user_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE094D20D FOREIGN KEY (postId) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C64B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526CE094D20D ON comment (postId)');
        $this->addSql('CREATE INDEX IDX_9474526C64B64DCC ON comment (userId)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE094D20D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C64B64DCC');
        $this->addSql('DROP INDEX IDX_9474526CE094D20D ON comment');
        $this->addSql('DROP INDEX IDX_9474526C64B64DCC ON comment');
        $this->addSql('ALTER TABLE comment ADD post_id INT NOT NULL, ADD user_id INT NOT NULL, DROP postId, DROP userId');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D64B64DCC');
        $this->addSql('DROP INDEX IDX_5A8A6C8D64B64DCC ON post');
        $this->addSql('ALTER TABLE post ADD user_id INT NOT NULL, DROP userId');
    }
}
