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

use Parenthesis\WPBundle\Entity\Term;

/**
 * Class TermTest.
 *
 * This is the Wordpress term entity test
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class TermTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test entity getters & setters.
     */
    public function testGettersSetters()
    {
        $entity = new Term();

        $entity->setGroup(3);
        $entity->setName('term name');
        $entity->setSlug('term-slug');

        $this->assertEquals(3, $entity->getGroup());
        $this->assertEquals('term name', $entity->getName());
        $this->assertEquals('term-slug', $entity->getSlug());
    }
}
