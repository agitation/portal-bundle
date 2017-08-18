<?php

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Service;

class AreaRegistrator
{
    private $areas = [];

    public function addArea($name, $access)
    {
        $this->areas[$name] = $access;
    }

    public function getAreas()
    {
        return $this->areas;
    }
}
