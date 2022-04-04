<?php declare(strict_types=1);

namespace Roosky\Routing;

use Symfony\Component\Routing\RouteCollection;

interface RouteProviderInterface {

  public function getRouteCollection(): RouteCollection;

}
