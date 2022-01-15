<?php declare(strict_types=1);

// Drupal has 3 entry points: web/index.php, web/core/install.php and also
// web/core/update.php. To get environment variables to load properly across
// these and Drush, we have to put environment variable loading into an
// autoloaded file.
$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();
