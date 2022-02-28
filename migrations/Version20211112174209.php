<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112174209 extends AbstractMigration
{
	public function getDescription(): string
	{
		return '';
	}

	public function up(Schema $schema): void
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql('DROP INDEX IDX_8244BE22E3797A94');
		$this->addSql('CREATE TEMPORARY TABLE __temp__film AS SELECT id, seance_id, title, picture, duration, synopsis FROM film');
		$this->addSql('DROP TABLE film');
		$this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, seance_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, picture VARCHAR(255) NOT NULL COLLATE BINARY, duration INTEGER NOT NULL, synopsis CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_8244BE22E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
		$this->addSql('INSERT INTO film (id, seance_id, title, picture, duration, synopsis) SELECT id, seance_id, title, picture, duration, synopsis FROM __temp__film');
		$this->addSql('DROP TABLE __temp__film');
		$this->addSql('CREATE INDEX IDX_8244BE22E3797A94 ON film (seance_id)');
	}

	public function down(Schema $schema): void
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql('DROP INDEX IDX_8244BE22E3797A94');
		$this->addSql('CREATE TEMPORARY TABLE __temp__film AS SELECT id, seance_id, title, picture, duration, synopsis FROM film');
		$this->addSql('DROP TABLE film');
		$this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, seance_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, duration TIME NOT NULL, synopsis CLOB DEFAULT NULL)');
		$this->addSql('INSERT INTO film (id, seance_id, title, picture, duration, synopsis) SELECT id, seance_id, title, picture, duration, synopsis FROM __temp__film');
		$this->addSql('DROP TABLE __temp__film');
		$this->addSql('CREATE INDEX IDX_8244BE22E3797A94 ON film (seance_id)');
	}
}
