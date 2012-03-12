Silicone
=============================

Silicone is a framework wrapped around a thin layer of Silex.

###app.php

    <?php
    require dirname(__FILE__).'/bootstrap.php';
    require dirname(__FILE__).'/config.php';

    use Silicone\Application;

    $app = new Application($config);
    $app->domain->import('Sample');

    /*
    * Write here your presentation logic for web request.
    * You can include other php file which wrote any logic.
    */
    $app->get('/', function (Application $app) {

        return 'hogehoge fugafuga.';
    });

###public/index.php

    <?php

    /**
     * Front presentation for request from http.
     */
    require dirname(__FILE__).'/../app.php';
    $app->run(); // send http response.

The 'run' methods return response with http. This is simple approach develop of WebApps.

###call other php

    <?php

    /**
     * some process include and execute.
     */
    require dirname(__FILE__).'/../app.php';
    $response = $app->lan(); // return Symfoby http response object.

    $Acme->someMethod($response);

The 'lan' methods return response without sending http. Can be executing from locally and CLIs processes.

## Feature

+  Added import of functional domain unit.
+  Added some ServiceProvider. ( FileReader, Simple PDO Wrapper...and more )
+  Override Pimple's implements. Because I want to access the property as well ServiceProvider.

## Requirement

Silicone works with PHP 5.3.2 or later.

## License

Silicone is licensed under the MIT license.
