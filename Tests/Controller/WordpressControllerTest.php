<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Tests\Controller;

/**
 * Class WordpressControllerTest.
 *
 * This is the Wordpress bundle controller test
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class WordpressControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $wp_query;

    /**
     * @var \Parenthesis\WPBundle\Wordpress\Wordpress
     */
    protected $wordpress;

    /**
     * Set up required mocks for Wordpress controller class.
     */
    protected function setUp()
    {
        // Set up Wordpress instance mock
        $this->wordpress = $this->getWordpressMock();

        $this->wordpress->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('<html><body>My fake Wordpress content</body></html>'));

        $this->wordpress->initialize();
    }

    /**
     * Test catchAllAction() method.
     */
    public function testCatchAllAction()
    {
        $controller = $this->getMock('\Parenthesis\WPBundle\Controller\WordpressController', ['getWordpress']);
        $controller->expects($this->any())->method('getWordpress')->will($this->returnValue($this->wordpress));

        $response = $controller->catchAllAction();

        $this->assertInstanceOf('\Parenthesis\WPBundle\Wordpress\WordpressResponse', $response, 'Should returns a WordpressResponse instance');
    }

    /**
     * Returns a mock of Wordpress class.
     *
     * @return \Parenthesis\WPBundle\Wordpress\Wordpress
     */
    protected function getWordpressMock()
    {
        $kernel = $this->getKernelMock();

        return $this->getMock('\Parenthesis\WPBundle\Wordpress\Wordpress', ['getContent'], [$kernel, ['wp_test_global1', 'wp_test_global2']]);
    }

    /**
     * Returns a mock of Symfony kernel.
     *
     * @return \Symfony\Component\HttpKernel\Kernel
     */
    protected function getKernelMock()
    {
        return $this->getMockBuilder('\Symfony\Component\HttpKernel\Kernel')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
