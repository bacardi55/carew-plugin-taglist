<?php

namespace Carew\Plugin\TagList;

use Carew\Event\Events;
use Carew\Document;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig_Environment;

class TagListEventSubscriber implements EventSubscriberInterface
{
    protected $twig;
    protected $tagList;

    public function __construct(Twig_Environment $twig)
    {
        $this->tagList = array();
        $this->twig = $twig;
    }

    public function onTags($event)
    {
        $this->twig->addGlobal(
            'tagList',
            $this->createTagsList($event->getSubject())
        );
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::TAGS => array(
                array('onTags', 256),
            ),
        );
    }

    protected function createTagsList($tags)
    {
        foreach ($tags as $tag) {
            $vars = $tag->getVars();
            if (isset($vars['tag'])) {
                $this->tagList[] = array(
                    'name' => $vars['tag'],
                    'nbPosts' => isset($vars['posts']) ? count($vars['posts']) : 0,
                    'path' => $tag->getPath(),
                );
            }

        }

        return $this->tagList;
    }
}

