
<?php

include __DIR__ . "/../config/app.php";


use Ufe\Router;


$router = new Router();

//Pages Pagina Principal

include __DIR__ . "/../routes/LoginRoutes.php";
include __DIR__ . "/../routes/DashRoutes.php";


$router->listen(NOTFOUND);
