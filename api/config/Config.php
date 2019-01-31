<?php

namespace Api\Config;

define('_DB_SERVER_', 'localhost');
define('_DB_DRIVER_', 'mysql');
define('_DB_PORT_', 3306);
define('_DB_NAME_', 'posts_api');
define('_DB_USER_', 'root');
define('_DB_PASSWD_', 'root');

#JWT configuratiion
define('_KEY_', "example_key");
define('_ISS_', "http://example.org");
define('_AUD_', "http://example.com");
define('_IAT_', 1356999524);	
define('_NBF_', 1357000000);	

?>