<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Manager;

use Parenthesis\WPBundle\Entity\Post;
use Parenthesis\WPBundle\Entity\PostMeta;
use Parenthesis\WPBundle\Repository\PostMetaRepository;

/**
 * Class PostMetaManager.
 *
 * This is the PostMeta entity manager
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class PostMetaManager extends BaseManager
{
    /**
     * @var PostMetaRepository
     */
    protected $repository;

    /**
     * @param int    $postId         A post identifier
     * @param string $metaName       A meta name
     * @param bool   $fetchOneResult Use fetchOneOrNullResult() method instead of getResult()?
     *
     * @return array|\Parenthesis\WPBundle\Entity\PostMeta
     */
    public function getPostMeta($postId, $metaName, $fetchOneResult = false)
    {
        $query = $this->repository->getPostMetaQuery($postId, $metaName);

        return $fetchOneResult ? $query->getOneOrNullResult() : $query->getResult();
    }

    /**
     * @param Post $post
     *
     * @return PostMeta|null
     */
    public function getThumbnailPostId(Post $post)
    {
        return $this->getPostMeta($post->getId(), '_thumbnail_id', true);
    }
}
