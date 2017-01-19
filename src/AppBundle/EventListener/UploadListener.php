<?php

namespace AppBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadListener
{
    public function onUpload(PostPersistEvent $event)
    {
        $response = $event->getResponse();
        die(basename($event->getFile()));
    }
}