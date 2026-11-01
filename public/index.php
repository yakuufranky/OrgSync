<?php

declare(strict_types=1);

/**
 * OrgSync Front Controller Entry Point
 */

require_once dirname(__DIR__) . '/app/Config/config.php';
require_once dirname(__DIR__) . '/app/Core/Autoloader.php';

use App\Core\Autoloader;
use App\Core\Router;

Autoloader::register();

// Route Definitions
Router::get('/', 'AuthController@showLogin');
Router::get('/login', 'AuthController@showLogin');
Router::post('/login', 'AuthController@login');

Router::get('/register', 'AuthController@showRoleSelect');

Router::get('/register/president', 'AuthController@showRegisterPresident');
Router::post('/register/president', 'AuthController@registerPresident');

Router::get('/register/verify', 'AuthController@showVerifyCode');
Router::post('/verify-code', 'AuthController@verifyCodeApi');

Router::get('/register/officer', 'AuthController@showRegisterOfficer');
Router::post('/register/officer', 'AuthController@registerOfficer');

Router::get('/register/member', 'AuthController@showRegisterMember');
Router::post('/register/member', 'AuthController@registerMember');

Router::get('/register/success', 'AuthController@showSuccess');

Router::get('/dashboard', 'HomeController@index');
Router::get('/logout', 'AuthController@logout');

// Dispatch Request
Router::dispatch();
