<?php

namespace Silicone\Component\Domain;

abstract class Action
{
    static public $canCallFromExternal = true;
    static public $canCallFromInternal = true;
}
