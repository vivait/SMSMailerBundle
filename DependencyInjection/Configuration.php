<?php

namespace Vivait\SMSMailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vivait_sms_mailer');

	    $rootNode
		    ->children()
		        ->enumNode('type')
			        ->values(array('packetmedia','esendex','andrewsandarnold'))
			    ->end()
			    ->scalarNode('username')
				    ->cannotBeEmpty()
				    ->isRequired()
				    ->end()
			    ->scalarNode('password')
				    ->cannotBeEmpty()
				    ->isRequired()
				    ->end()
			    ->end();
        return $treeBuilder;
    }
}
