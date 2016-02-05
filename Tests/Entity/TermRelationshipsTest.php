<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Tests\Entity;

use Parenthesis\WPBundle\Entity\TermRelationships;
use Parenthesis\WPBundle\Entity\TermTaxonomy;

/**
 * Class TermRelationshipsTest.
 *
 * This is the Wordpress term relationships entity test
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class TermRelationshipsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test entity getters & setters.
     */
    public function testGettersSetters()
    {
        $entity = new TermRelationships();

        $taxonomy = new TermTaxonomy();
        $taxonomy->setDescription('taxonomy description');
        $entity->setTaxonomy($taxonomy);

        $entity->setTermOrder(4);

        $this->assertEquals('taxonomy description', $entity->getTaxonomy()->getDescription());
        $this->assertEquals(4, $entity->getTermOrder());
    }
}
