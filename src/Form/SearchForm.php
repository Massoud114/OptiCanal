<?php

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('startShowingDate', DateTimeType::class, [
				'label' => false,
				'required' => false,
				'widget' => 'single_text',
				'html5' => false,
				'attr' => ['class' => 'flatpickrDate'],
			])
			->add('endShowingDate', DateTimeType::class, [
				'label' => false,
				'required' => false,
				'widget' => 'single_text',
				'html5' => false,
				'attr' => ['class' => 'flatpickrDate'],
			])
			->add('minPrice', NumberType::class, [
				'label' => false,
				'required' => false,
				'attr' => [
					'placeholder' => 'Prix minimum'
				]
			])
			->add('maxPrice', NumberType::class, [
				'label' => false,
				'required' => false,
				'attr' => [
					'placeholder' => 'Prix maximum'
				]
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => SearchData::class,
			'method' => 'GET',
			'csrf_protection' => false,
			'allow_extra_fields' => true
		]);
	}

	public function getBlockPrefix(): string
	{
		return '';
	}

}
