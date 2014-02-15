<?php
namespace Viva\SMSMailerBundle\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PacketMediaSMSType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('username', 'text', array(
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
		return 'settings_packetmediasms';
	}
}