<?php

namespace App\EventSubscriber;

use App\Repository\ConferenceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $conferencesRepository;

    public function __construct(Environment $twig, ConferenceRepository $conferencesRepository)
    {   
        $this->twig = $twig;
        $this->conferencesRepository = $conferencesRepository;
    } 

    public function onControllerEvent(ControllerEvent $event)
    {
        $conferences = $this->conferencesRepository->findAll();
        $this->twig->addGlobal('conferences',
         $conferences);
    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
