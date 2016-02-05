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

use Parenthesis\WPBundle\Entity\User;
use Parenthesis\WPBundle\Entity\UserMeta;

/**
 * Class UserMetaTest.
 *
 * This is the Wordpress user meta entity test
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class UserMetaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test entity getters & setters.
     */
    public function testGettersSetters()
    {
        $entity = new UserMeta();

        $user = new User();
        $user->setDisplayName('display name');
        $entity->setUser($user);

        $entity->setKey('fake key');
        $entity->setValue('fake value');

        $this->assertEquals('display name', $entity->getUser()->getDisplayName());
        $this->assertEquals('fake key', $entity->getKey());
        $this->assertEquals('fake value', $entity->getValue());
    }
}
