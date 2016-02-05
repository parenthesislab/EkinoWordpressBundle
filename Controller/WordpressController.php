<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class WordpressController.
 *
 * This is the controller to render Wordpress content
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class WordpressController extends Controller
{
    /**
     * Wordpress catch-all route action.
     *
     * @return \Parenthesis\WPBundle\Wordpress\WordpressResponse
     */
    public function catchAllAction()
    {
        return $this->getWordpress()->initialize()->getResponse();
    }

    /**
     * Returns Wordpress service.
     *
     * @return \Parenthesis\WPBundle\Wordpress\Wordpress
     */
    protected function getWordpress()
    {
        return $this->get('parenthesis.wp.wordpress');
    }
}
