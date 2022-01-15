<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt files in the "core" directory.
 */

use Dotenv\Dotenv;
use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

$autoloader = require_once 'autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$kernel = new Kernel($_ENV['APP_ENV'], $autoloader);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
