<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Fulfillment\Method;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */

class AbstractDownloadMethod extends AbstractMethod
{
    public function __construct()
    {
        $this->setType(MethodInterface::VIRTUAL_FULFILLMENT);
    }

    /**
     * Locations from which can be downloaded (eg. http server, torrent, ...)
     *
     * @var
     */
    protected $locations;

    public function addLocation($location)
    {
        $this->locations[] = $location;
    }

    public function getLocations()
    {
        return $this->locations;
    }
}
