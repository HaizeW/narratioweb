<?php

namespace NarratioWeb\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NarratioWebUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
