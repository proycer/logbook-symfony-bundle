<?php

namespace Proycer\LogBook\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LogBookExtension extends Extension
{
	/**
	 * @param array $configs
	 * @param ContainerBuilder $container
	 * @return array
	 * @throws Exception
	 */
	public function load(array $configs, ContainerBuilder $container): array
	{
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('logbook.xml');

		$configuration = $this->getConfiguration($configs, $container);
		$config = $this->processConfiguration($configuration, $configs);

		$definition = $container->getDefinition('log_book_list.log_list_service');
		$definition->replaceArgument(1, $config['log_files']);
		$definition->replaceArgument(2, $config['show_app_logs']);

		return $config;
	}

	public function getAlias(): string
	{
		return 'log_book';
	}


}