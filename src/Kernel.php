<?php declare(strict_types=1);

namespace Roosky;

use Drupal\Core\DrupalKernel;
use Drupal\Core\Site\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Kernel extends DrupalKernel {

  public function discoverServiceProviders() {
    parent::discoverServiceProviders();
    $this->serviceProviderClasses['site'][] = Provider::class;
    // @todo base on app root, without trusting current working dir.
    $this->serviceYamls['site'][] = '../config/services/default.yml';
    if ($this->environment === 'dev') {
      $this->serviceYamls['site'][] = '../config/services/dev.yml';
    }
  }

  protected function initializeSettings(Request $request) {
    $site_path = static::findSitePath($request);
    $this->setSitePath($site_path);

    // Overridden so we can hijack settings.php location.
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
