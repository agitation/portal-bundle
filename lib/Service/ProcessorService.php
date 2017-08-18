<?php

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Service;

use Agit\PortalBundle\Event\DataProcessorEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class ProcessorService implements CacheWarmerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var CacheService
     */
    private $cacheService;

    private $data = [];

    public function __construct(EventDispatcherInterface $eventDispatcher, CacheService $cacheService)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->cacheService = $cacheService;
    }

    public function warmUp($cacheDir)
    {
        $this->execute();
    }

    public function isOptional()
    {
        return true;
    }

    public function execute()
    {
        $this->data = [];

        $this->eventDispatcher->dispatch(
            "agit.portal.data",
            new DataProcessorEvent($this)
        );

        $this->cacheService->save($this->data);
    }

    /**
     * Allows registered services to store their processed data.
     */
    public function store($area, $key, $data)
    {
        if (! isset($this->data[$area])) {
            $this->data[$area] = [];
        }

        $this->data[$area][$key] = $data;
    }
}
