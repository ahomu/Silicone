<?php

namespace Sample;

class Test extends \Silicone\Component\Domain\Action
{
    public function boot($params, $app)
    {
        return '<h1>Hello World!</h1>';
    }
}
