<?php

namespace App\Interfaces;

use stdClass;

interface AppInterface
{
  public function show(string $filter = null): array;
  public function showOne(string $id): stdClass;
  public function insert(array $payload): string;
  public function update(array $payload): string;
}