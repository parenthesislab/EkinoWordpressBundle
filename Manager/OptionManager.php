<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Manager;

/**
 * Class OptionManager.
 *
 * This is the Option entity manager
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class OptionManager extends BaseManager
{
    /**
     * @param string $optionName
     *
     * @return mixed
     */
    public function findOneByOptionName($optionName)
    {
        return $this->findOneBy(['name' => $optionName]);
    }

    /**
     * @param string $sidebarName
     *
     * @return bool
     */
    public function isActiveSidebar($sidebarName)
    {
        if (!$sidebarOption = $this->findOneByOptionName('sidebars_widgets')) {
            return false;
        }

        if (false === ($sidebarOption = unserialize($sidebarOption->getValue()))) {
            return false;
        }

        return isset($sidebarOption[$sidebarName]);
    }
}
