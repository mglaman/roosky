<?php declare(strict_types=1);

namespace App\Controller\Api;

final class HelloWorld {

  public function __invoke()
  {
    return [
      'message' => 'hello world!',
    ];
  }

}
