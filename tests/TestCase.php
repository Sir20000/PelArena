<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  protected function setUp(): void
{
    parent::setUp();

    $this->withoutVite(); // Disables asset compilation lookups during feature tests
}
}
