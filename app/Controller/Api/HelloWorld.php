<?php declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

final class HelloWorld {

  public function __invoke()
  {
    return new JsonResponse([
      'message' => 'hello world!',
    ]);
  }

}
