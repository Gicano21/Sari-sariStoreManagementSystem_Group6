<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/login', 'StoreOwnerController::login', ['as' => 'login']);
$routes->get('/register', 'StoreOwnerController::registerView', ['as' => 'register']);
$routes->post('/storeOwner/login', 'StoreOwnerController::authenticate');
$routes->post('/storeOwner/register', 'StoreOwnerController::register');
$routes->post('/logout', 'StoreOwnerController::logout');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'session']);
$routes->post('/products', 'ProductController::create', ['filter' => 'session']);
$routes->post('/products/(:num)/update', 'ProductController::update/$1', ['filter' => 'session']);
$routes->post('/products/(:num)/delete', 'ProductController::delete/$1', ['filter' => 'session']);