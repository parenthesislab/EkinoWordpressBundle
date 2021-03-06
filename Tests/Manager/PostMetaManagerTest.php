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

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Parenthesis\WPBundle\Manager\PostMetaManager;
use Parenthesis\WPBundle\Repository\PostMetaRepository;

/**
 * Class PostMetaManagerTest.
 *
 * @author Xavier Coureau <xav.is@2cool4school.fr>
 */
class PostMetaManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var PostMetaRepository
     */
    protected $repository;

    /**
     * @var PostMetaManager
     */
    protected $manager;

    /**
     * Sets up a PostMetaManager instance.
     */
    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $this->repository = $this->getMockBuilder('Parenthesis\WPBundle\Repository\PostMetaRepository')->disableOriginalConstructor()->getMock();
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->repository));

        $this->manager = new PostMetaManager($this->entityManager, 'Parenthesis\WPBundle\Entity\PostMeta');
    }

    public function testGetPostMetaCollection()
    {
        $query = $this->getMockBuilder('Parenthesis\WPBundle\Tests\Manager\QueryMock')->disableOriginalConstructor()->getMock();
        $this->repository->expects($this->once())
            ->method('getPostMetaQuery')
            ->will($this->returnValue($query));

        $query->expects($this->once())
            ->method('getResult');

        $this->manager->getPostMeta(22, 'test', false);
    }
}

class QueryMock extends AbstractQuery
{
    /**
     * Gets the SQL query that corresponds to this query object.
     * The returned SQL syntax depends on the connection driver that is used
     * by this query object at the time of this method call.
     *
     * @return string SQL query
     */
    public function getSQL()
    {
        return '';
    }

    /**
     * Executes the query and returns a the resulting Statement object.
     *
     * @return \Doctrine\DBAL\Driver\Statement The executed database statement that holds the results.
     */
    protected function _doExecute()
    {
    }
}
