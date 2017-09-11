<?php
declare(strict_types=1);
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

    /**
     * @var array
     */
    private $areas;

    private $data = [];

    public function __construct(EventDispatcherInterface $eventDispatcher, CacheService $cacheService, AreaRegistrator $areaRegistrator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->cacheService = $cacheService;
        $this->areas = $areaRegistrator->getAreas();
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
        $event = new DataProcessorEvent();

        $this->eventDispatcher->dispatch('agit.portal.data', $event);

        foreach ($event->getStoredData() as $area => $data)
        {
            if (isset($this->areas[$area]))
            {
                $this->cacheService->save($area, $data);
            }
        }
    }
}
