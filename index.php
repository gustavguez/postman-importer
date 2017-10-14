<?php

//Include composer autoload
include './vendor/autoload.php';

use PostmanImporter\Importer;

//Create importer and run
$importer = new Importer(__DIR__ . '/src/');
$result = $importer->run();

//Print result
var_dump($result);