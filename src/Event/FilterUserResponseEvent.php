<?php

/*
 * This file is part of the awurth/silex-user package.
 *
 * (c) Alexis Wurth <awurth.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AWurth\Silex\User\Event;

use AWurth\Silex\User\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FilterUserResponseEvent extends UserEvent
{
    /**
     * @var Response
     */
    private $response;

    /**
     * Constructor.
     *
     * @param UserInterface $user
     * @param Request       $request
     * @param Response|null $response
     */
    public function __construct(UserInterface $user, Request $request, Response $response = null)
    {
        parent::__construct($user, $request);

        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
