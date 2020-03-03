<?php

namespace Delos\Dgp\Services\Request;

abstract class ChildRequestDecorator implements RequestInterface
{
    protected $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
}