<?php
namespace Viva\SMSMailerBundle\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EsendexSMSType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('accountref', 'text', array(
			'label' => 'Account reference'
		));
		$builder->add('username', 'email', array(
			'label' => 'Username'
		));
		$builder->add('password', 'text', array(
			'label' => 'Password'
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		));
	}

	public function getName()
	{
		return 'settings_esendexsms';
	}
}