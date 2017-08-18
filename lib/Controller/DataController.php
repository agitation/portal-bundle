<?php

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DataController extends Controller
{
    public function loadAction($area)
    {
        $areas = $this->container->get("agit.portal.areas")->getAreas();

        if (! isset($areas[$area])) {
            throw new NotFoundHttpException("This area does not exist.");
        }

        // currently $areas[$area] is the required capability
        if ($areas[$area] && ! $this->container->get("agit.user")->currentUserCan($areas[$area])) {
            throw new AccessDeniedHttpException("You are not allowed to access this page.");
        }

        $data = $this->container->get("agit.portal.cache")->loadAsJson($area);
        $response = new Response($data, 200);
        $response->headers->set("Content-Type", "application/json; charset=UTF-8");
        $response->headers->set("Expires", "Mon, 7 Apr 1980 05:00:00 GMT");
        $response->headers->set("Cache-Control", "no-cache, must-revalidate, max-age=0", true);
        $response->headers->set("Pragma", "no-store", true);

        return $response;
    }
}
