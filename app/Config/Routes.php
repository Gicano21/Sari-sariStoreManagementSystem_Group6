<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->post('/storeOwner/login', 'Home::AuthenticateStoreOwner');
$routes->post('/storeOwner/register', 'Home::registerStoreOwner');
$routes->get('/dashboard', 'Home::dashboard');
$routes->post('/products', 'Home::createProduct');
$routes->post('/products/(:num)/update', 'Home::updateProduct/$1');
$routes->post('/products/(:num)/delete', 'Home::deleteProduct/$1');
$routes->post('/logout', 'Home::logout');