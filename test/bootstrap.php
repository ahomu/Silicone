<?php

echo "Bootstrapping...........................\n";

define('TEST_RUNNER', true);
define('DIR_TEST', dirname(__FILE__).'/');
define('DIR_FIXTURES', DIR_TEST.'fixtures/');

require DIR_TEST . '../src/app.sample.php';
