<?php
/**
 * (c) 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Symfony2Bundle\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;
use Vespolina\EventDispatcher\EventDispatcherInterface;
use Vespolina\EventDispatcher\EventInterface;
use Vespolina\Symfony2Bundle\EventDispatcher\Event;

class EventDispatcher implements EventDispatcherInterface
{
    protected $eventDispatcher;

    public function __construct(SymfonyEventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createEvent($subject = null)
    {
        $event = new Event();
        $event->setSubject($subject);

        return $event;
    }

    public function dispatch($eventName, EventInterface $event = null)
    {
        $this->eventDispatcher->dispatch($eventName, $event);
    }

    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->eventDispatcher->addListener($eventName, $listener, $priority);
    }

    public function addListenerService($eventName, $listener, $priority)
    {
        $this->eventDispatcher->addListenerService($eventName, $listener, $priority);
    }

    public function removeListener($eventName, $listener)
    {
        $this->eventDispatcher->removeListener($eventName, $listener);
    }

    public function getListeners($eventName = null)
    {
        $this->eventDispatcher->getListeners($eventName);
    }

    public function hasListeners($eventName = null)
    {
        $this->eventDispatcher->hasListeners($eventName);
    }
}
