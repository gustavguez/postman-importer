<?php

//Include composer autoload
include './vendor/autoload.php';

use PostmanImporter\Importer;

//Create importer and run
$importer = new Importer(dirname(__FILE__) . '/src/');
$importer->run();