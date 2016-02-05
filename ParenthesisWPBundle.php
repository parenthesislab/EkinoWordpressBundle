<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle;

use Parenthesis\WPBundle\DependencyInjection\Compiler\RegisterMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ParenthesisWPBundle.
 *
 * This is the main Symfony bundle class
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class ParenthesisWPBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->addRegisterMappingPass($container);
    }

    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function addRegisterMappingPass(ContainerBuilder $containerBuilder)
    {
        $mappings = [
            realpath(__DIR__.'/Resources/config/doctrine-model') => 'Parenthesis\WPBundle\Model',
        ];

        $containerBuilder->addCompilerPass(RegisterMappingsPass::createOrmMappingDriver($mappings));
    }
}
