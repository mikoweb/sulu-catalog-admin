<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803161254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog_categories (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tree_root BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', parent_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', banner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, indented_name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_connected TINYINT(1) DEFAULT 0 NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8FD9B4B3989D9B62 (slug), INDEX IDX_8FD9B4B3A977936C (tree_root), INDEX IDX_8FD9B4B3727ACA70 (parent_id), INDEX IDX_8FD9B4B3684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog_items (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_580D88F4989D9B62 (slug), INDEX IDX_580D88F43DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog_item_categories (item_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', category_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_F96067CD126F525E (item_id), INDEX IDX_F96067CD12469DE2 (category_id), PRIMARY KEY(item_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalog_categories ADD CONSTRAINT FK_8FD9B4B3A977936C FOREIGN KEY (tree_root) REFERENCES catalog_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE catalog_categories ADD CONSTRAINT FK_8FD9B4B3727ACA70 FOREIGN KEY (parent_id) REFERENCES catalog_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE catalog_categories ADD CONSTRAINT FK_8FD9B4B3684EC833 FOREIGN KEY (banner_id) REFERENCES me_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE catalog_items ADD CONSTRAINT FK_580D88F43DA5256D FOREIGN KEY (image_id) REFERENCES me_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE catalog_item_categories ADD CONSTRAINT FK_F96067CD126F525E FOREIGN KEY (item_id) REFERENCES catalog_items (id)');
        $this->addSql('ALTER TABLE catalog_item_categories ADD CONSTRAINT FK_F96067CD12469DE2 FOREIGN KEY (category_id) REFERENCES catalog_categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_categories DROP FOREIGN KEY FK_8FD9B4B3A977936C');
        $this->addSql('ALTER TABLE catalog_categories DROP FOREIGN KEY FK_8FD9B4B3727ACA70');
        $this->addSql('ALTER TABLE catalog_categories DROP FOREIGN KEY FK_8FD9B4B3684EC833');
        $this->addSql('ALTER TABLE catalog_items DROP FOREIGN KEY FK_580D88F43DA5256D');
        $this->addSql('ALTER TABLE catalog_item_categories DROP FOREIGN KEY FK_F96067CD126F525E');
        $this->addSql('ALTER TABLE catalog_item_categories DROP FOREIGN KEY FK_F96067CD12469DE2');
        $this->addSql('DROP TABLE catalog_categories');
        $this->addSql('DROP TABLE catalog_items');
        $this->addSql('DROP TABLE catalog_item_categories');
    }
}
