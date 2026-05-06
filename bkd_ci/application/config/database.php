<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;


// server api 106
$db['default']['hostname'] = '103.182.48.106';
$db['default']['username'] = 'admindb';
$db['default']['password'] = 'admin_db123@123';
$db['default']['port'] = 33036;

$db['default']['database'] = 'siap_bkd_live4';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
// $db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'latin1';
$db['default']['dbcollat'] = 'latin1_swedish_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['default']['options'] = array(
	MYSQLI_OPT_SSL_VERIFY_SERVER_CERT => false,
	MYSQLI_CLIENT_SSL => false,
);

// TAMBAHKAN INI:
$db['default']['ssl_verify'] = FALSE;
$db['default']['connect_timeout'] = 30;
$db['default']['stricton'] = FALSE;

$db['oracle']['hostname'] = '103.182.48.109/ORCL'; // IP dan SID/Service Name database Oracle
$db['oracle']['username'] = 'SIMPEG_PROB_KAB';
$db['oracle']['password'] = 'simpegdata';
$db['oracle']['database'] = '';
$db['oracle']['dbdriver'] = 'oci8';
$db['oracle']['dbprefix'] = '';
$db['oracle']['pconnect'] = FALSE;
$db['oracle']['db_debug'] = TRUE;
$db['oracle']['cache_on'] = FALSE;
$db['oracle']['cachedir'] = '';
$db['oracle']['char_set'] = 'utf8';
$db['oracle']['dbcollat'] = 'utf8_general_ci';
$db['oracle']['swap_pre'] = '';
$db['oracle']['autoinit'] = TRUE;
$db['oracle']['stricton'] = FALSE;


$db['postgre']['hostname'] = '103.182.48.109'; // Ganti dengan hostname PostgreSQL Anda
$db['postgre']['username'] = 'postgres';
$db['postgre']['password'] = 'r00t';
$db['postgre']['database'] = 'redok_probolinggo';
$db['postgre']['dbdriver'] = 'postgre';
$db['postgre']['dbprefix'] = '';
$db['postgre']['pconnect'] = FALSE;
$db['postgre']['db_debug'] = TRUE;
$db['postgre']['cache_on'] = FALSE;
$db['postgre']['cachedir'] = '';
$db['postgre']['char_set'] = 'utf8';
$db['postgre']['dbcollat'] = 'utf8_general_ci';
$db['postgre']['swap_pre'] = '';
$db['postgre']['autoinit'] = TRUE;
$db['postgre']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */