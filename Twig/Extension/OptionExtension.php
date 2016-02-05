<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Twig\Extension;

use Parenthesis\WPBundle\Manager\OptionManager;

/**
 * Class OptionExtension.
 *
 * This extension provides native Wordpress functions into Twig.
 */
class OptionExtension extends \Twig_Extension
{
    /**
     * @var OptionManager
     */
    protected $optionManager;

    /**
     * @return string
     */
    public function getName()
    {
        return 'parenthesis_wp_option';
    }

    /**
     * @param OptionManager $optionManager
     */
    public function __construct(OptionManager $optionManager)
    {
        $this->optionManager = $optionManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('wp_get_option', [$this, 'getOption']),
            new \Twig_SimpleFunction('wp_is_active_sidebar', [$this, 'isActiveSidebar']),
        ];
    }

    /**
     * @param string $optionName
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    public function getOption($optionName, $defaultValue = null)
    {
        $option = $this->optionManager->findOneByOptionName($optionName);

        return $option ?: $defaultValue;
    }

    /**
     * @param string $sidebarName
     *
     * @return bool
     */
    public function isActiveSidebar($sidebarName)
    {
        return $this->optionManager->isActiveSidebar($sidebarName);
    }
}
