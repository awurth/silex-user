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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormEvent extends Event
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * Constructor.
     *
     * @param FormInterface $form
     * @param Request       $request
     * @param Response|null $response
     */
    public function __construct(FormInterface $form, Request $request, Response $response = null)
    {
        $this->form = $form;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
