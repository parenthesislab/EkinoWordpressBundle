<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Twig\Extension;

use Parenthesis\WPBundle\Manager\PostMetaManager;

/**
 * Class PostMetaExtension.
 *
 * This extension provides native Wordpress functions into Twig.
 */
class PostMetaExtension extends \Twig_Extension
{
    /**
     * @var PostMetaManager
     */
    protected $postMetaManager;

    /**
     * @param PostMetaManager $postMetaManager
     */
    public function __construct(PostMetaManager $postMetaManager)
    {
        $this->postMetaManager = $postMetaManager;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'parenthesis_wp_post_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('wp_get_post_meta', [$this, 'getPostMeta']),
            new \Twig_SimpleFunction('wp_get_image_url_from_id', [$this, 'getImageUrlFromId']),
        ];
    }

    /**
     * @param int    $postId         A post identifier
     * @param string $metaName       A meta name
     * @param bool   $fetchOneResult Use fetchOneOrNullResult() method instead of getResult()?
     *
     * @return array|\Parenthesis\WPBundle\Entity\PostMeta
     */
    public function getPostMeta($postId, $metaName, $fetchOneResult = false)
    {
        return $this->postMetaManager->getPostMeta($postId, $metaName, $fetchOneResult);
    }

    /**
     * @param int $imgId An image identifier
     */
    public function getImageUrlFromId($imgId)
    {
        return \wp_get_attachment_url($imgId);
    }
}
