<?php declare(strict_types=1);

namespace Roosky;

use Drupal\Core\DrupalKernel;

class Kernel extends DrupalKernel {

  public function __construct($environment, $class_loader, $allow_dumping = TRUE, $app_root = NULL) {
    if (drupal_valid_test_ua()) {
      $environment = 'test';
    }
    parent::__construct($environment, $class_loader, $allow_dumping, $app_root);
  }

  /**
   * {@inheritdoc}
   */
  public function discoverServiceProviders() {
    parent::discoverServiceProviders();
    // Register our provider.
    // This could be done with `settings.php` along and specifying the class in
    // `$config['container_service_providers'][] = \App\Provider::class.
    // That is how Drupal's PHPUnit tests register themselves as service
    // modifiers and providers.
    //
    $this->serviceProviderClasses['site'][] = Provider::class;
    if (class_exists(\App\Provider::class)) {
      // Allow the end user to opt in a service provider automatically.
      $this->serviceProviderClasses['site'][] = \App\Provider::class;
    }

    // Load our services.
    // This is the same as specifying the services in `settings.php`, but we
    // point to defined ones and specify ones per-env.
    // @todo base on app root, without trusting current working dir.
    $this->serviceYamls['site'][] = '../config/services/default.yml';
    if (file_exists("../config/services/{$this->environment}.yml")) {
      $this->serviceYamls['site'][] = "../config/services/{$this->environment}.yml";
    }
  }

  protected function getModulesParameter() {
    $extensions = parent::getModulesParameter();
    // This triggers UnknownExtensionException in ExtensionList.
    /*
    $extensions['roosky'] = [
      'type' => 'module',
      'pathname' => '../app/app.info.yml',
      'filename' => '../app/hooks.php',
    ];
    */
    return $extensions;
  }

}
