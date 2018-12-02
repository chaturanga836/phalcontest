<?php

$router = $di->getRouter();

// Define your routes here

$router->addGet('/',['controller'=>'Auth','action'=>'index']);

$router->addPost('/login',['controller'=>'Auth','action'=>'signIn']);

$router->addGet('/register',['controller'=>'Auth','action'=>'getRegister']);

$router->addGet('/sign-out',['controller'=>'Auth','action'=>'signOut']);

$router->addPost('/register',['controller'=>'Auth','action'=>'signUp']);

$router->addGet('/favorites',['controller'=>'Favorites','action'=>'index']);

$router->addGet('/favorites-get/{page}',['controller'=>'Favorites','action'=>'getList']);

$router->addPost('/favorites-manage',['controller'=>'Favorites','action'=>'handleFavorit']);

$router->handle();
