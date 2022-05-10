<?php

abstract class Auth{
    
    abstract static public function Login( $userInfoArray);
    abstract static public function IsUserLoggedByQuery($userInfoArray);
    abstract static public function getLoggedUserInfo();
    abstract static public function whatUserPermission(); 
    abstract static public function Register($userInfoArray);


    
    public static function getNewPasswordByEmail($Email){
        if(User::isUserFoundQueryByEmail($Email)){
            $newPassword = uniqid("new_password_");
            $hashed_newPassword = DataHandler::hash_password($newPassword);
            $updatingQuery = QueryHandler::updateByColumnsAndValues("users" , array("Password" => $hashed_newPassword) , array("Email" => $Email));
            if(gettype($updatingQuery) != "string"){ return $newPassword;}
            return $updatingQuery; 
        } 
        return "No Password has been changed ! .... please try again !";
    }

}
