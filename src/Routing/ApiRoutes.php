<?php declare(strict_types=1);

namespace App\Routing;

use App\Controller\Api\HelloWorld;
use Drupal\Core\Routing\RouteObjectInterface;
use Roosky\Routing\RouteProviderInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class ApiRoutes implements RouteProviderInterface {

  public function getRouteCollection(): RouteCollection {
    $routes = new RouteCollection();

    $routes->add(
      'app.api.hello_world',
      (new Route('/hello-world'))
        ->setDefault(RouteObjectInterface::CONTROLLER_NAME, HelloWorld::class)
        ->setMethods(['GET'])
        ->setRequirement('_access', 'TRUE')
    );

    $routes->addPrefix('/api');
    $routes->addRequirements(['_format' => 'json']);
    return $routes;
  }

}
