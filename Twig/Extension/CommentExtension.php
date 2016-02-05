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

use Parenthesis\WPBundle\Manager\CommentManager;
use Parenthesis\WPBundle\Model\Comment;

/**
 * Class CommentExtension.
 *
 * This extension provides native Wordpress functions into Twig.
 *
 * @author Xavier Coureau <xav@takeatea.com>
 */
class CommentExtension extends \Twig_Extension
{
    /**
     * @var CommentManager
     */
    protected $commentManager;

    /**
     * @param CommentManager $commentManager
     */
    public function __construct(CommentManager $commentManager)
    {
        $this->commentManager = $commentManager;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'parenthesis_wp_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('wp_get_comment_author_link', [$this, 'getCommentAuthorLink'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param Comment $comment
     *
     * @return string
     */
    public function getCommentAuthorLink(Comment $comment)
    {
        if (!$user = $comment->getUser()) {
            if ((!$authorUrl = $comment->getAuthorUrl()) || !preg_match('/^http(s)?:\/\/.+$/', $authorUrl)) {
                return $comment->getAuthor();
            }

            return sprintf('<a href="%s" rel="nofollow" target="_new">%s</a>', $authorUrl, $comment->getAuthor());
        }

        if ((!$userUrl = $user->getUrl()) || !preg_match('/^http(s)?:\/\/.+$/', $userUrl)) {
            return $user->getDisplayName();
        }

        return sprintf('<a href="%s" rel="nofollow" target="_new">%s</a>', $userUrl, $user->getDisplayName());
    }
}
