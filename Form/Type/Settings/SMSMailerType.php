<?php
namespace Viva\SMSMailerBundle\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SMSMailerType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('driver', 'choice', array(
			'label' => 'SMS service provider',
			'choices' => array(
				'esendex' => 'Esendex',
				'packetmedia' => 'Packet Media',
				'andrewsandarnold' => 'Andrews And Arnold'
			)
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		));
	}

	public function getName()
	{
		return 'settings_smsmailer';
	}
}