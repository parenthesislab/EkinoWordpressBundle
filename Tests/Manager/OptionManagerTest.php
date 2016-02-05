<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Tests\Manager;

use Doctrine\ORM\EntityManager;
use Parenthesis\WPBundle\Manager\OptionManager;
use Parenthesis\WPBundle\Repository\OptionRepository;

/**
 * Class OptionManagerTest.
 *
 * @author Xavier Coureau <xav.is@2cool4school.fr>
 */
class OptionManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var OptionRepository
     */
    protected $repository;

    /**
     * @var OptionManager
     */
    protected $manager;

    /**
     * Sets up a OptionManager instance.
     */
    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $this->repository = $this->getMockBuilder('Parenthesis\WPBundle\Repository\OptionRepository')->disableOriginalConstructor()->getMock();
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->repository));

        $this->manager = new OptionManager($this->entityManager, 'Parenthesis\WPBundle\Entity\Option');
    }

    /**
     * Test that the repository is called with the correct argument.
     */
    public function testFindOneByName()
    {
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo(['name' => 'test']));

        $this->manager->findOneByOptionName('test');
    }
}
