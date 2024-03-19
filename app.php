<?php

require __DIR__ . '/vendor/autoload.php';

use App\Application;
use App\Factory;

$application = new Application(new Factory());
try {
    $application->run($argv[1] ?? null);
} catch (\Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
    exit(1);
}
