<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		// dd($options['data']->getId());

		$builder
			->add('subject', TextType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'subject is required',
					]),
					new Length([
						'min' => 2,
						'max' => 255,
						'minMessage' => 'subject name is too short',
						'maxMessage' => 'subject name is too long',
					])
				],
			])
			->add('email', EmailType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'email is required',
					]),
				],
				'invalid_message' => 'Not a correct form'
			])
			->add('message', TextareaType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'message is required',
					]),
				],
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Contact::class,
		]);
	}
}
