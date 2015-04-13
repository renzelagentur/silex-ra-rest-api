Installation:

1. Install using composer
2. Create a .php file that is reachable via HTTP
3. Add the following in it

define('CONNECTED_APP', 'Oxid');
define('CONNECTED_APP_ROOT', __DIR__ . '/../');

include 'vendor/autoload.php';

CONNECTED_APP_ROOT is the relative path to the connected app
The autloader of composer must be inlcuded

Also make sure, to include app.php from this package like:

include 'vendor/ra/rest/app.php'