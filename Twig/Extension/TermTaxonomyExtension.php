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
use Parenthesis\WPBundle\Model\TermTaxonomy;

/**
 * Class TermTaxonomyExtension.
 *
 * Provides twig functions related to term_taxonomy entities
 *
 * @author Xavier Coureau <xav@takeatea.com>
 */
class TermTaxonomyExtension extends \Twig_Extension
{
    /**
     * @var OptionManager
     */
    protected $optionManager;

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
            new \Twig_SimpleFunction('wp_get_term_link', [$this, 'getTermLink']),
        ];
    }

    /**
     * @param TermTaxonomy $termTaxonomy A term taxonomy instance
     * @param string       $type         The link type. Can be "category" or "tag"
     *
     * @return string
     */
    public function getTermLink(TermTaxonomy $termTaxonomy, $type = 'category')
    {
        $prefix = ($prefix = $this->optionManager->findOneByOptionName($type.'_base')) ? $prefix->getValue() : null;
        $output = [$termTaxonomy->getTerm()->getSlug()];

        while ($parent = $termTaxonomy->getParent()) {
            $output[] = $parent->getSlug();
            $termTaxonomy = $parent;
        }

        return ($prefix ? $prefix : '').'/'.implode('/', array_reverse($output)).(count($output) ? '/' : '');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'parenthesis_wp_term_taxonomy';
    }
}
