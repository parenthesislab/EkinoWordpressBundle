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

use Parenthesis\WPBundle\Entity\Comment;
use Parenthesis\WPBundle\Entity\CommentMeta;

/**
 * Class CommentMetaTest.
 *
 * This is the Wordpress comment meta entity test
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class CommentMetaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test entity getters & setters.
     */
    public function testGettersSetters()
    {
        $entity = new CommentMeta();

        $comment = new Comment();
        $comment->setContent('comment message');
        $entity->setComment($comment);

        $entity->setKey('fake key');
        $entity->setValue('fake value');

        $this->assertEquals('comment message', $entity->getComment()->getContent());
        $this->assertEquals('fake key', $entity->getKey());
        $this->assertEquals('fake value', $entity->getValue());
    }
}
