<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112173902 extends AbstractMigration
{
	public function getDescription(): string
	{
		return '';
	}

	public function up(Schema $schema): void
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, seance_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, duration TIME NOT NULL, synopsis CLOB DEFAULT NULL)');
		$this->addSql('CREATE INDEX IDX_8244BE22E3797A94 ON film (seance_id)');
		$this->addSql('CREATE TABLE seance (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, showing_date DATE NOT NULL, start_at TIME NOT NULL, end_at TIME NOT NULL)');
	}

	public function down(Schema $schema): void
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql('DROP TABLE film');
		$this->addSql('DROP TABLE seance');
	}
}
