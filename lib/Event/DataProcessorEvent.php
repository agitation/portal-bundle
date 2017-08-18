<?php

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class DataProcessorEvent extends Event
{
    private $data = [];

    public function store($area, $key, $value)
    {
        if (! isset($this->data[$area])) {
            $this->data[$area] = [];
        }

        $this->data[$area][$key] = $value;
    }

    public function getStoredData()
    {
        return $this->data;
    }
}
