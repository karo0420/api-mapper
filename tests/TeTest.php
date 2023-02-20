<?php

namespace Test;

use Karo0420\ApiMapper\ApiMapper;
use Karo0420\ApiMapper\Shops\Posts\Posts;
use PHPUnit\Framework\TestCase;

class TeTest extends TestCase {
  public function test_mest()
  {
    $map = ApiMapper::make(Posts::class);
    $data = $map->posts->user(1)->all->visit();
    var_dump($data);

    ob_flush();
  }
}