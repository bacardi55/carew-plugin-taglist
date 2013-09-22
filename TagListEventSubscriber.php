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

    public function onDocumentDecoration($event)
    {
        $this->createTagsList($event->getSubject());

        $twigGlobals = $this->twig->getGlobals();
        $globals = $twigGlobals['carew'];
        $globals->tagList = $this->tagList;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::DOCUMENT_DECORATION=> array(
                array('onDocumentDecoration', 256),
            ),
        );
    }

    protected function createTagsList($documents)
    {
        foreach ($documents as $document) {
            if ($document->getType() == Document::TYPE_UNKNOWN) {
                $name = substr($document->getFilePath(), strlen('tags/'));
                $vars = $document->getVars();
                $count = isset($vars['documents']) ?
                    count($vars['documents']) : 0;
                if ($count && $name) {
                    $this->tagList[] = array(
                        'name' => $name,
                        'nbPosts' => $count,
                        'path' => $document->getPath(),
                    );
                }
            }
        }
    }
}

