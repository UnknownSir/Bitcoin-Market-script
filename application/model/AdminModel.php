<?php


class AdminModel {


    public static function tracking() {
        $database = DatabaseFactory::getFactory()->getConnection();
        $messages = $database->prepare("SELECT * FROM action_tracking"); 
        $messages->execute();
        return $messages->fetchAll();
    }

    
}
