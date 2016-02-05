<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class RegisterMappingsPass.
 *
 * This compiler pass registers the bundle schema with the Doctrine one
 *
 * @author Xavier Coureau <xav@takeatea.com>
 * @author David Buchmann <david@liip.ch>
 */
class RegisterMappingsPass implements CompilerPassInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Definition
     */
    private $driver;

    /**
     * @var string
     */
    private $driverPattern;

    /**
     * @var array
     */
    private $namespaces;

    /**
     * @var string
     */
    private $enabledParameter;

    /**
     * @var string
     */
    private $fallbackManagerParameter;

    /**
     * @param Definition $driver
     * @param string     $driverPattern
     * @param array      $namespaces
     * @param string     $enabledParameter
     * @param string     $fallbackManagerParameter
     */
    public function __construct($driver, $driverPattern, $namespaces, $enabledParameter, $fallbackManagerParameter)
    {
        $this->driver = $driver;
        $this->driverPattern = $driverPattern;
        $this->namespaces = $namespaces;
        $this->enabledParameter = $enabledParameter;
        $this->fallbackManagerParameter = $fallbackManagerParameter;
    }

    /**
     * Register mappings with the metadata drivers.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter($this->enabledParameter)) {
            return;
        }

        $chainDriverDefService = $this->getChainDriverServiceName($container);
        $chainDriverDef = $container->getDefinition($chainDriverDefService);

        foreach ($this->namespaces as $namespace) {
            $chainDriverDef->addMethodCall('addDriver', [$this->driver, $namespace]);
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException
     *
     * @return string
     */
    protected function getChainDriverServiceName(ContainerBuilder $container)
    {
        foreach (['parenthesis_wp.model_manager_name', $this->fallbackManagerParameter] as $param) {
            if ($container->hasParameter($param)) {
                $name = $container->getParameter($param);
                if ($name) {
                    return sprintf($this->driverPattern, $name);
                }
            }
        }

        throw new ParameterNotFoundException('None of the managerParameters resulted in a valid name');
    }

    /**
     * @param array $mappings
     *
     * @return RegisterMappingsPass
     */
    public static function createOrmMappingDriver(array $mappings)
    {
        $arguments = [$mappings, '.orm.xml'];
        $locator = new Definition('Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator', $arguments);
        $driver = new Definition('Doctrine\ORM\Mapping\Driver\XmlDriver', [$locator]);

        return new self($driver, 'doctrine.orm.%s_metadata_driver', $mappings, 'parenthesis_wp.backend_type_orm', 'doctrine.default_entity_manager');
    }
}
