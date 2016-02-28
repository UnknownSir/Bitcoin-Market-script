<?php

// Auto-loading the classes (currently only from application/libs) via Composer's PSR-4 autoloader
// Later it might be useful to use a namespace here, but for now let's keep it as simple as possible
require '../vendor/autoload.php';

// Start our application
new Application();

