<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 * @ApiResource()
 */
class Seance
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="float")
	 */
	private $price;

	/**
	 * @ORM\Column(type="datetime", unique=true)
	 */
	private ?\DateTimeInterface $showingDate;

	/**
	 * @ORM\Column(type="time")
	 */
	private $endAt;

	/**
	 * @ORM\OneToMany(targetEntity=Film::class, mappedBy="seance", orphanRemoval=true)
	 */
	private $films;

	public function __construct()
	{
		$this->films = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getPrice(): ?float
	{
		return $this->price;
	}

	public function setPrice(float $price): self
	{
		$this->price = $price;

		return $this;
	}

	public function getShowingDate(): ?\DateTimeInterface
	{
		return $this->showingDate;
	}

	public function setShowingDate(\DateTimeInterface $showingDate): self
	{
		$this->showingDate = $showingDate;

		return $this;
	}

	public function getEndAt(): ?\DateTimeInterface
	{
		return $this->endAt;
	}

	public function setEndAt(\DateTimeInterface $endAt): self
	{
		$this->endAt = $endAt;

		return $this;
	}

	/**
	 * @return Collection|Film[]
	 */
	public function getFilms(): Collection
	{
		return $this->films;
	}

	public function addFilm(Film $film): self
	{
		if (!$this->films->contains($film)) {
			$this->films[] = $film;
			$film->setSeance($this);
		}

		return $this;
	}

	public function removeFilm(Film $film): self
	{
		if ($this->films->removeElement($film)) {
			// set the owning side to null (unless already changed)
			if ($film->getSeance() === $this) {
				$film->setSeance(null);
			}
		}

		return $this;
	}

	public function __toString()
	{
		return "Séance N° $this->id du " . $this->showingDate->format('j/m/y');
	}
}
