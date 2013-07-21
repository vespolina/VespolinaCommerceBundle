<?php
/**
 * (c) 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Symfony2Bundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Vespolina\EventDispatcher\EventInterface;

class Event extends SymfonyEvent implements EventInterface
{
    protected $subject;

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}
