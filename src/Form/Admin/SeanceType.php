<?php

namespace App\Form\Admin;

use App\Entity\Seance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('price', NumberType::class, [
				'label' => 'Prix',
			])
			->add('showingDate', DateType::class, [
				'label' => 'Date de mise en ligne',
				'html5' => true,
				'model_timezone' => 'Africa/Porto-Novo',
				'view_timezone' => 'Africa/Porto-Novo',
				'widget' => 'single_text',
			])
			->add('endAt', TimeType::class, [
				'label' => 'Heure de fin',
				'widget' => 'single_text',
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Seance::class,
		]);
	}
}
