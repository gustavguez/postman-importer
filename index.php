<?php

//Include composer autoload
include './vendor/autoload.php';

use PostmanImporter\Importer;

//Create importer and run
$importer = new Importer(__DIR__);
$result = $importer->run();

//Print result
printf('POSTMAN IMPORTER RESULTS%s', PHP_EOL);
printf('--------------------------------%s', PHP_EOL);
foreach ($result as $file => $result) {
    printf('- SOURCE FILE: %s, STATUS: %s %s', $file, $result ? 'OK' : 'FAIL', PHP_EOL);
}