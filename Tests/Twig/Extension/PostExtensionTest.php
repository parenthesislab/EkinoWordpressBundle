<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Tests\Twig\Extension;

use Parenthesis\WPBundle\Twig\Extension\PostExtension;

class PostExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $postManager;
    protected $optionExtension;

    /**
     * @var PostExtension
     */
    protected $postExtension;

    protected function setUp()
    {
        if (!class_exists('\Twig_Extension')) {
            $this->markTestSkipped('Twig is not enabled');
        }

        $this->postManager = $this->getMockBuilder('Parenthesis\WPBundle\Manager\PostManager')->disableOriginalConstructor()->getMock();
        $this->optionExtension = $this->getMockBuilder('Parenthesis\WPBundle\Twig\Extension\OptionExtension')->disableOriginalConstructor()->getMock();

        $this->postExtension = new PostExtension($this->postManager, $this->optionExtension);
    }

    public function testGetName()
    {
        $this->assertEquals('parenthesis_wp_post', $this->postExtension->getName());
    }

    public function testGetFunctions()
    {
        $this->assertContainsOnly('\Twig_SimpleFunction', $this->postExtension->getFunctions());
    }

    public function testReplacePostArguments()
    {
        $permalinkStructure = '/%year%/%monthnum%/%day%/%post_id%-%postname%';
        $post = $this->getMock('Parenthesis\WPBundle\Entity\Post');
        $post->expects($this->once())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime()));
        $post->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('12'));
        $post->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('sample-post'));

        $result = $this->postExtension->replacePostArguments($permalinkStructure, $post);

        $this->assertEquals(date('/Y/m/d').'/12-sample-post', $result);
    }

    public function testGetPermalinkNoPost()
    {
        $this->postManager->expects($this->once())
            ->method('find')
            ->will($this->returnValue(false));

        $this->setExpectedException('\UnexpectedValueException');
        $this->postExtension->getPermalink(12);
    }

    public function testGetPermalink()
    {
        $post = $this->getMock('Parenthesis\WPBundle\Entity\Post');
        $permalinkOption = $this->getMock('Parenthesis\WPBundle\Entity\Option');

        $post->expects($this->once())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime()));
        $post->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('12'));
        $post->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('sample-post'));

        $permalinkOption->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('/%year%/%monthnum%/%day%/%post_id%-%postname%'));
        $this->postManager->expects($this->once())
            ->method('find')
            ->will($this->returnValue($post));
        $this->optionExtension->expects($this->once())
            ->method('getOption')
            ->will($this->returnValue($permalinkOption));

        $result = $this->postExtension->getPermalink(12);
        $this->assertEquals(date('/Y/m/d').'/12-sample-post', $result);
    }

    public function testGetAbsolutePermalink()
    {
        $post = $this->getMock('Parenthesis\WPBundle\Entity\Post');
        $permalinkOption = $this->getMock('Parenthesis\WPBundle\Entity\Option');
        $homeOption = $this->getMock('Parenthesis\WPBundle\Entity\Option');

        $post->expects($this->once())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime()));
        $post->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('12'));
        $post->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('sample-post'));

        $permalinkOption->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('/%year%/%monthnum%/%day%/%post_id%-%postname%'));
        $homeOption->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('http://localhost/blog/'));
        $this->postManager->expects($this->once())
            ->method('find')
            ->will($this->returnValue($post));
        $this->optionExtension->expects($this->at(0))
            ->method('getOption')
            ->will($this->returnValue($permalinkOption));
        $this->optionExtension->expects($this->at(1))
            ->method('getOption')
            ->will($this->returnValue($homeOption));

        $result = $this->postExtension->getPermalink(12, true);
        $this->assertEquals('http://localhost/blog'.date('/Y/m/d').'/12-sample-post', $result);
    }
}
