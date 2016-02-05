<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PostMetaRepository.
 *
 * This is the repository of the PostMeta entity
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class PostMetaRepository extends EntityRepository
{
    /**
     * @param int    $postId
     * @param string $metaName
     *
     * @return \Doctrine\ORM\Query
     */
    public function getPostMetaQuery($postId, $metaName)
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.post', 'p')
            ->where('m.key = :metaName')
            ->andWhere('p.id = :postId')
            ->setParameter('postId', $postId)
            ->setParameter('metaName', $metaName)
            ->getQuery();
    }
}
