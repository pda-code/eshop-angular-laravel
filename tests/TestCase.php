<?php

  class TestCase extends Illuminate\Foundation\Testing\TestCase {

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication() {
      $app = require __DIR__ . '/../bootstrap/app.php';
      $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

      DB::enableQueryLog();

      return $app;
    }

    public function printLastQuery() {
      $queries = DB::getQueryLog();
      $last_query = end($queries);

      var_dump($last_query['query']);
    }
  }
