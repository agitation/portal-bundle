<?php

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Service;

use Doctrine\Common\Cache\FilesystemCache;

class CacheService
{
    const CACHE_DIR = "agit/portal";

    private $cache;

    public function __construct($cacheDir)
    {
        $this->cache = new FilesystemCache($cacheDir . "/" . self::CACHE_DIR);
    }

    public function save($data)
    {
        foreach ($data as $area => $values) {
            $this->cache->save($area, $values);
        }
    }

    public function load($area)
    {
        return $this->cache->fetch($area) ?: [];
    }

    public function loadAsJson($area)
    {
        return json_encode($this->load($area), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_OBJECT_AS_ARRAY);
    }
}
