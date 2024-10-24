<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241024083123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_course ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE access_course ADD CONSTRAINT FK_E415FA8BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE access_course ADD CONSTRAINT FK_E415FA8B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E415FA8BB03A8386 ON access_course (created_by_id)');
        $this->addSql('CREATE INDEX IDX_E415FA8B896DBBDE ON access_course (updated_by_id)');
        $this->addSql('ALTER TABLE cart ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7B03A8386 ON cart (created_by_id)');
        $this->addSql('CREATE INDEX IDX_BA388B7896DBBDE ON cart (updated_by_id)');
        $this->addSql('ALTER TABLE cart_item ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527B03A8386 ON cart_item (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527896DBBDE ON cart_item (updated_by_id)');
        $this->addSql('ALTER TABLE certificate ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_219CDA4AB03A8386 ON certificate (created_by_id)');
        $this->addSql('CREATE INDEX IDX_219CDA4A896DBBDE ON certificate (updated_by_id)');
        $this->addSql('ALTER TABLE course ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9B03A8386 ON course (created_by_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9896DBBDE ON course (updated_by_id)');
        $this->addSql('ALTER TABLE cursus ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cursus ADD CONSTRAINT FK_255A0C3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cursus ADD CONSTRAINT FK_255A0C3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_255A0C3B03A8386 ON cursus (created_by_id)');
        $this->addSql('CREATE INDEX IDX_255A0C3896DBBDE ON cursus (updated_by_id)');
        $this->addSql('ALTER TABLE lesson ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3B03A8386 ON lesson (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F87474F3896DBBDE ON lesson (updated_by_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CE748AB03A8386 ON reset_password_request (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7CE748A896DBBDE ON reset_password_request (updated_by_id)');
        $this->addSql('ALTER TABLE theme ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9775E708B03A8386 ON theme (created_by_id)');
        $this->addSql('CREATE INDEX IDX_9775E708896DBBDE ON theme (updated_by_id)');
        $this->addSql('ALTER TABLE user ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON user (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON user (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_course DROP FOREIGN KEY FK_E415FA8BB03A8386');
        $this->addSql('ALTER TABLE access_course DROP FOREIGN KEY FK_E415FA8B896DBBDE');
        $this->addSql('DROP INDEX IDX_E415FA8BB03A8386 ON access_course');
        $this->addSql('DROP INDEX IDX_E415FA8B896DBBDE ON access_course');
        $this->addSql('ALTER TABLE access_course DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE cursus DROP FOREIGN KEY FK_255A0C3B03A8386');
        $this->addSql('ALTER TABLE cursus DROP FOREIGN KEY FK_255A0C3896DBBDE');
        $this->addSql('DROP INDEX IDX_255A0C3B03A8386 ON cursus');
        $this->addSql('DROP INDEX IDX_255A0C3896DBBDE ON cursus');
        $this->addSql('ALTER TABLE cursus DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7B03A8386');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7896DBBDE');
        $this->addSql('DROP INDEX IDX_BA388B7B03A8386 ON cart');
        $this->addSql('DROP INDEX IDX_BA388B7896DBBDE ON cart');
        $this->addSql('ALTER TABLE cart DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708B03A8386');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708896DBBDE');
        $this->addSql('DROP INDEX IDX_9775E708B03A8386 ON theme');
        $this->addSql('DROP INDEX IDX_9775E708896DBBDE ON theme');
        $this->addSql('ALTER TABLE theme DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527B03A8386');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527896DBBDE');
        $this->addSql('DROP INDEX IDX_F0FE2527B03A8386 ON cart_item');
        $this->addSql('DROP INDEX IDX_F0FE2527896DBBDE ON cart_item');
        $this->addSql('ALTER TABLE cart_item DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9B03A8386');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9896DBBDE');
        $this->addSql('DROP INDEX IDX_169E6FB9B03A8386 ON course');
        $this->addSql('DROP INDEX IDX_169E6FB9896DBBDE ON course');
        $this->addSql('ALTER TABLE course DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3B03A8386');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3896DBBDE');
        $this->addSql('DROP INDEX IDX_F87474F3B03A8386 ON lesson');
        $this->addSql('DROP INDEX IDX_F87474F3896DBBDE ON lesson');
        $this->addSql('ALTER TABLE lesson DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B03A8386');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649896DBBDE');
        $this->addSql('DROP INDEX IDX_8D93D649B03A8386 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649896DBBDE ON user');
        $this->addSql('ALTER TABLE user DROP created_by_id, DROP updated_by_id');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AB03A8386');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748A896DBBDE');
        $this->addSql('DROP INDEX IDX_7CE748AB03A8386 ON reset_password_request');
        $this->addSql('DROP INDEX IDX_7CE748A896DBBDE ON reset_password_request');
        $this->addSql('ALTER TABLE reset_password_request DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE certificate DROP FOREIGN KEY FK_219CDA4AB03A8386');
        $this->addSql('ALTER TABLE certificate DROP FOREIGN KEY FK_219CDA4A896DBBDE');
        $this->addSql('DROP INDEX IDX_219CDA4AB03A8386 ON certificate');
        $this->addSql('DROP INDEX IDX_219CDA4A896DBBDE ON certificate');
        $this->addSql('ALTER TABLE certificate DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
