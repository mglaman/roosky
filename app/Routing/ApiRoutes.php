<?php declare(strict_types=1);

namespace App\Routing;

use App\Controller\Api\HelloWorld;
use Drupal\Core\Routing\RouteBuildEvent;
use Drupal\Core\Routing\RouteObjectInterface;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class ApiRoutes implements EventSubscriberInterface {

  public function routes(RouteBuildEvent $event) {
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
    $event->getRouteCollection()->addCollection($routes);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // @todo Roosky could provide a compiler pass to run these in its own
    // event subscriber to provide routes, so everything doesn't have to have
    // this boilerplate.
    $events[RoutingEvents::DYNAMIC][] = 'routes';
    return $events;
  }

}
