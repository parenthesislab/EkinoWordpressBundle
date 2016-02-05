<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Model;

/**
 * Class PostMeta.
 *
 * This is the PostMeta entity
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
abstract class PostMeta implements WordpressEntityInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $key
     *
     * @return PostMeta
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param Post $post
     *
     * @return PostMeta
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param string $value
     *
     * @return PostMeta
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
