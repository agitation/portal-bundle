<?php

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Event;

use Agit\PortalBundle\Service\ProcessorService;
use Symfony\Component\EventDispatcher\Event;

class DataProcessorEvent extends Event
{
    /**
     * @var ProcessorService
     */
    private $processor;

    public function __construct(ProcessorService $processor)
    {
        $this->processor = $processor;
    }

    public function store($area, $key, $data)
    {
        return $this->processor->store($area, $key, $data);
    }
}
