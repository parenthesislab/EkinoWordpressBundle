<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\Listener;

use Parenthesis\WPBundle\Wordpress\Wordpress;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class WordpressRequestListener.
 *
 * This is a listener that loads Wordpress application on kernel request
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class WordpressRequestListener
{
    /**
     * @var Wordpress
     */
    protected $wordpress;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor.
     *
     * @param Wordpress             $wordpress    A Wordpress service instance.
     * @param TokenStorageInterface $tokenStorage Symfony security token storage
     */
    public function __construct(Wordpress $wordpress, TokenStorageInterface $tokenStorage)
    {
        $this->wordpress = $wordpress;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * On kernel request method.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // Loads Wordpress source code in order to allow use of WordPress functions in Symfony.
        if ('parenthesis_wp_catchall' !== $request->attributes->get('_route')) {
            $this->wordpress->loadWordpress();
        }

        $this->checkAuthentication($request);
    }

    /**
     * Checks if a Wordpress user is authenticated and authenticate him into Symfony security context.
     *
     * @param Request $request
     */
    protected function checkAuthentication(Request $request)
    {
        if (!$request->hasPreviousSession()) {
            return;
        }

        $session = $request->getSession();

        if ($session->has('token')) {
            $token = $session->get('token');
            $this->tokenStorage->setToken($token);
        }
    }
}
