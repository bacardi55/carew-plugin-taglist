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
    protected $url_absolute;

    public function __construct(Twig_Environment $twig, $config)
    {
        $this->tagList = array();
        $this->twig = $twig;
        $this->url_absolute = isset($config['site']['url_absolute']) ?
            $config['site']['url_absolute'] : '';
    }

    public function onDocuments($event)
    {
        $this->createTagsList($event->getSubject());

        $twigGlobals = $this->twig->getGlobals();
        $globals = $twigGlobals['carew'];
        $globals->tagList = $this->tagList;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::DOCUMENTS=> array(
                array('onDocuments', 256),
            ),
        );
    }

    protected function createTagsList($documents)
    {
        $list = array();
        foreach ($documents as $document) {
            $tags = $document->getTags();
            foreach ($tags as $tag) {
                if (isset($list[$tag]['nbPosts'])) {
                    ++ $list[$tag]['nbPosts'];
                }
                else {
                    $list[$tag] = array(
                        'nbPosts' => 1,
                        'path' => $this->url_absolute
                            . '/tags/' . $tag . '.html',
                        'name' => $tag,
                    );
                }
            }
        }
        $this->tagList = $list;
    }
}

