<?php

namespace Feedtags\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FeedtagsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
