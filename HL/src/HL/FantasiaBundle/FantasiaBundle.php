<?php

namespace HL\FantasiaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FantasiaBundle extends Bundle
{
public function getParent()
    {
	return 'FOSUserBundle';
    }
}
