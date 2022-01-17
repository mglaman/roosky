<?php declare(strict_types=1);

namespace Roosky\Routing;

use Drupal\Core\Routing\RouteBuildEvent;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class RouteProvider implements EventSubscriberInterface {

  /**
   * @var array<int, \Roosky\Routing\RouteProviderInterface>
   */
  private array $providers;

  public function addProvider(RouteProviderInterface $provider): void {
    $this->providers[] = $provider;
  }

  public function onDynamicRoutes(RouteBuildEvent $event): void {
    $collection = $event->getRouteCollection();
    foreach ($this->providers as $provider) {
      $collection->addCollection($provider->getRouteCollection());
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // @todo Roosky could provide a compiler pass to run these in its own
    // event subscriber to provide routes, so everything doesn't have to have
    // this boilerplate.
    $events[RoutingEvents::DYNAMIC][] = 'onDynamicRoutes';
    return $events;
  }

}
