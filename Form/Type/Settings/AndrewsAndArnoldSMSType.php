<?php
namespace Viva\SMSMailerBundle\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AndrewsAndArnoldSMSType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('accountref', 'text', array(
			'label' => 'Settings go here'
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		));
	}

	public function getName()
	{
		return 'settings_andrewsandarnoldsms';
	}
}