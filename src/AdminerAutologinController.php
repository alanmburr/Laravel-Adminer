<?php

namespace AlanMBurr\LaravelAdminer;

/**
 * Autologin with current Laravel database credentials
 */
class AdminerAutologinController extends AdminerController
{

    public function index()
    {
        if (! isset($_GET['db'])) {
            
            $database_config = config('database.default');
        
            $database_driver = config("database.connections.$database_config.driver");
            if ($database_driver === "mysql") {$database_driver = "server";}
            
            $_POST['auth']['driver'] = $database_driver;
            $_POST['auth']['server'] = config("database.connections.$database_config.host");
            $_POST['auth']['db'] = config("database.connections.$database_config.database");
            $_POST['auth']['username'] = config("database.connections.$database_config.username");
            $_POST['auth']['password'] = config("database.connections.$database_config.password");
        }
        
        parent::index();
    }

}
