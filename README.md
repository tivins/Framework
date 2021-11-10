# Framework
PHP framework for web applications

Requirements:

* PHP8.0+

Dependencies:

* [tivins/database](https://github.com/tivins/database) (facultative. Only if a database is used for the project)
* [erusev/parsedown](https://github.com/erusev/parsedown)

## Usage

1. Install
   ```shell
   # echo "{}" > composer.json # for a new empty projet
   composer require tivins/framework
   ```

2. Prepare folders
   ```shell
   mkdir settings # create folder for settings files
   cp vendor/tivins/framework/references/reference.settings.php settings/my-app.test.settings.php # See settings
   mkdir -p htdocs/cache # public data and its cache dir
   mkdir -p pdata/cache # private data and its cache dir
   touch boot.php # see Boot
   touch htdocs/index.php # see Index
   ```

2. Init settings
   ```shell
   mkdir settings # create folder for settings files
   touch settings/my-app.test.settings.php
   ```
   Nota: Colons `:` are replaced by hyphens `-` in the host name (eg: if the hostname is `my-app.test:8080`, the settings filename should be `my-app.test-8080.settings.php`.

   Here is an example of the setting file:
   ```php
   <?php
   
   use Tivins\Framework\App;
   use Tivins\Database\Connectors\MySQLConnector;
   
   App::initDB(new MySQLConnector(
       dbname:   "my_database",
       user:     "db_user",
       password: "password",
   ));
   ```

   Nota: you can add a `common.settings.php` for shared rules (called first).

3. Boot
   ```php
   <?php
   use Tivins\Framework\App;
   require __dir__ . '/vendor/autoload.php';
   define('FRAMEWORK_ROOT_PATH', __dir__);
   App::init();
   ```

4. Index
   ```php
   <?php
   use Tivins\Framework\App;
   require __dir__ . '/../boot.php';
   App::doc()->deliver();
   ```
