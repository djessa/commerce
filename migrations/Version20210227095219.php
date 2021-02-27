<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227095219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ligne_commande_product');
        $this->addSql('ALTER TABLE ligne_commande ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_3170B74B4584665A ON ligne_commande (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_commande_product (ligne_commande_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_A144D6B2E10FEE63 (ligne_commande_id), INDEX IDX_A144D6B24584665A (product_id), PRIMARY KEY(ligne_commande_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ligne_commande_product ADD CONSTRAINT FK_A144D6B24584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_commande_product ADD CONSTRAINT FK_A144D6B2E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B4584665A');
        $this->addSql('DROP INDEX IDX_3170B74B4584665A ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP product_id');
    }
}
