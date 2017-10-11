<?php

//Include composer autoload
include './vendor/autoload.php';

use PostmanImporter\Importer;

//Create importer and run
$importer = new Importer(dirname(__FILE__));
$result = $importer->run();

//Print result
var_dump($result);