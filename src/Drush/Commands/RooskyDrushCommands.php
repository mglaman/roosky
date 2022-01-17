<?php declare(strict_types=1);

namespace Roosky\Drush\Commands;

use Drupal\Component\Utility\Crypt;
use Drush\Attributes as CLI;
use Drush\Commands\DrushCommands;
use Drush\Drush;

final class RooskyDrushCommands extends DrushCommands {

  #[CLI\Command(name: 'roosky:env:generate', aliases: ['env:generate'])]
  #[CLI\Option(name: 'sqlite', description: 'Set the DB_CONNECTION to SQLite by default')]
  public function helloWorld(array $options = ['sqlite' => false]): void {
    $boot_manager = Drush::bootstrapManager();
    $app_path = $boot_manager->getComposerRoot();

    $envPath = $app_path . '/.env';
    if (!file_exists($envPath)) {
      copy($app_path . '/.env.example', $envPath);
    }

    $key = Crypt::randomBytesBase64(55);
    $existingKey = $_ENV['DRUPAL_HASH_SALT'] ?? '';
    $escapedHashSalt = preg_quote('=' . $existingKey, '/');

    $patterns = ["/^DRUPAL_HASH_SALT{$escapedHashSalt}/m"];
    $replacements = ['DRUPAL_HASH_SALT='.$key];

    if ($options['sqlite']) {
      $patterns[] = "/^DB_CONNECTION=mysql/m";
      $replacements[] = 'DB_CONNECTION=sqlite';
    }

    file_put_contents($envPath, preg_replace(
      $patterns,
      $replacements,
      file_get_contents($envPath)
    ));
  }

}
