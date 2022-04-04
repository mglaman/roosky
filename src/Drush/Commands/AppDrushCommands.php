<?php declare(strict_types=1);

namespace App\Drush\Commands;

use Drush\Attributes as CLI;
use Drush\Commands\DrushCommands;

final class AppDrushCommands extends DrushCommands {

  #[CLI\Command(name: 'app:hello-world', aliases: ['hello-world'])]
  public function helloWorld(): void {
    $this->io()->write('<info>Hello world!</info>');
  }

}
