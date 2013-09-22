<?php

namespace Carew\Plugin\TagList;

use Carew\ExtensionInterface;
use Carew\Carew;

class TagListExtension implements ExtensionInterface
{
    public function register(Carew $carew)
    {
        $eventDispatcher = $carew->getEventDispatcher() ->addSubscriber(
            new TagListEventSubscriber(
                $carew->getContainer()->offsetGet('twig')
            )
        );
    }
}
