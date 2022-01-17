<?php declare(strict_types=1);

namespace Roosky;

use Drupal\Core\DrupalKernel;
use Drupal\Core\Site\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Kernel extends DrupalKernel {

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
    // @todo support APP_ENV beyond `dev`.
    $this->serviceYamls['site'][] = '../config/services/default.yml';
    if ($this->environment === 'dev') {
      $this->serviceYamls['site'][] = '../config/services/dev.yml';
    }
  }

  /**
   * {@inheritdoc}
   *
   * This method is overridden to experiment with completely changing where
   * settings are stored.
   */
  protected function initializeSettings(Request $request) {
    // If Drupal is running tests, don't hijack the settings changes.
    if (drupal_valid_test_ua()) {
      parent::initializeSettings($request);
      return;
    }

    $site_path = static::findSitePath($request);
    $this->setSitePath($site_path);
    // Overridden so we can hijack settings.php location.
    // This says settings are in `./config` instead of `./web/sites/*`.
    Settings::initialize(dirname(__DIR__), 'config', $this->classLoader);

    // Initialize our list of trusted HTTP Host headers to protect against
    // header attacks.
    $host_patterns = Settings::get('trusted_host_patterns', []);
    if (PHP_SAPI !== 'cli' && !empty($host_patterns)) {
      if (static::setupTrustedHosts($request, $host_patterns) === FALSE) {
        throw new BadRequestHttpException('The provided host name is not valid for this server.');
      }
    }
  }

}
