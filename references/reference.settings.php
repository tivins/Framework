<?php
/**
 * This is an example of what kind of code to put in the settings.
 *
 * At this time of execution of the process, the Session and the Request
 * in the App are ready to be used.
 */

use Tivins\Framework\App;
use Tivins\Database\Connectors\MySQLConnector;

/**
 * Define the global informations.
 * This could be done in common.settings.php, and overriden in a specific
 * host settings.
 */
/*
App::setSiteTitle('My Application');
App::setAcceptedLanguages('en', 'fr', 'ja');
*/

/**
 * This override the default messenger for a compatible to CSS Boostrap.
 */
/*
App::setMessenger(new MsgBoostrap);
*/

/**
 * If you're using a database, you need to call `App::initDB()`, and provide
 * a Connector.
 */
/*
App::initDB(new MySQLConnector(
    dbname:   "my_database",
    user:     "db_user",
    password: "password",
));
*/

/**
 * You can define, per-host, the production mode of the application.
 * This allows to process to different actions such as displaying debug
 * informations or not. See App::getProductionMode().
 */
/*
App::setDevMode();
*/