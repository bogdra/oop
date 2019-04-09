<?php

namespace Core;


// Debug mode
define ('DEBUG', false);

// Site title
define ('SITE_TITLE', 'OOP');

// URI
define ('URL_ROOT', '/oop/');

// Source file of the currency
define ('INPUT_SOURCE', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');

// DB credentials
define ('DB_HOST', 'localhost');
define ('DB_USER', 'root');
define ('DB_PASS', 'nuesteasta10');
define ('DB_NAME', 'oop');

// Default Controllers
define ('DEFAULT_CONTROLLER', 'Home');
define ('RESTRICTED_CONTROLLER', 'Restricted');
define ('DEFAULT_ACTION', 'Index');

define ('SUPPORTED_REQUEST_METHODS', ['GET', 'POST', 'PUT', 'DELETE']);

// Routes
define ('ROUTES',
[
    'interfaces/',
    'core/',
    'app/controllers/',
    'app/models/',
    'app/entities/',
    'app/services/',
    'app/exceptions/'
]);
