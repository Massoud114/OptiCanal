<?php

namespace App\Form\Admin;

use App\Entity\Film;
use App\Entity\Seance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('title', TextType::class, [
				'label' => 'Titre',
			])
			->add('picture', TextType::class, [
				'label' => 'Image de couverture du film',
				'attr' => [
					'placeholder' => "Entrer l'url de l'image"
				]
			])
			->add('duration', NumberType::class, [
				'label' => 'Durée du film',
				'attr' => [
					'placeholder' => "En Minutes"
				]
			])
			->add('synopsis', TextareaType::class, [
				'label' => 'Synopsis',
				'attr' => [
					'rows' => 3
				]
			])
			->add('seance', EntityType::class, [
				'class' => Seance::class,
				'label' => 'Titre',
				'attr' => [
					'placeholder' => false
				]
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Film::class,
		]);
	}
}
