<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205224225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allocations (id INT NOT NULL, portfolios_id INT DEFAULT NULL, shares INT NOT NULL, INDEX IDX_C0E942FE81DC659 (portfolios_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT NOT NULL, portfolio_id INT DEFAULT NULL, type VARCHAR(5) NOT NULL, completed TINYINT(1) DEFAULT NULL, payload LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_E52FFDEEB96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolios (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allocations ADD CONSTRAINT FK_C0E942FE81DC659 FOREIGN KEY (portfolios_id) REFERENCES portfolios (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolios (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allocations DROP FOREIGN KEY FK_C0E942FE81DC659');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEB96B5643');
        $this->addSql('DROP TABLE allocations');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE portfolios');
    }
}
