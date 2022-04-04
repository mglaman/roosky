<?php declare(strict_types=1);

namespace Roosky;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceModifierInterface;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Roosky\Routing\RouteProvider;

final class Provider implements ServiceProviderInterface, ServiceModifierInterface {

  public function register(ContainerBuilder $container) {
    // Sets up a class to wrap the RoutingEvents::DYNAMIC event for providing
    // routes programmatically.
    $container->register('roosky.route_provider', RouteProvider::class)
      ->addTag('event_subscriber')
      ->addTag('service_collector', [
        'call' => 'addProvider',
        'tag' => 'roosky.route_provider',
      ]);
  }

  public function alter(ContainerBuilder $container) {

  }

}
