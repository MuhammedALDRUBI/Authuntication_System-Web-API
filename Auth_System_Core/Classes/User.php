<?php


class User{
    
    private const tableName = "users";
    static private int $Id;
    static private string $Username; //unique value
    static private string $password;
    static private string $Email; //unique value
    static private string $Name;
    static private string $PhoneNumber ; // unique value
    static private int $Permission; // Normal user has 0 value , Admin has differnet value
    static private  $Created_at;


    // important : $userInfo must be associtaive array and ((must be contain all required columns in database's table))
    public static function CreateUser(array $userInfo ){

        try{
            $Sanitizing_Filters_array = array( "Username" => "string" , "Password" => "password", "Email" => "email" , "Name" => "string" , "PhoneNumber" => "string");
            $userInfo =  DataHandler::Sanitize_Data($userInfo , $Sanitizing_Filters_array);
            if(gettype($userInfo) == "string"){throw new Exception($userInfo);}

            $validating_Filters_array = array( "Email" => "email");
            $validatng_result = DataHandler::Validate_Data($userInfo , $validating_Filters_array );
            if(gettype($validatng_result) == "array"){throw new Exception(join("," , $validatng_result));}
            $new_user = QueryHandler::insertIntoableByValues(self::tableName  , $userInfo);
            return $new_user;   
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function getUserInfoById($id){
        $user_info = QueryHandler::getItemAllInfoById(self::tableName , $id);
        return $user_info;
    }

    public static function getUserSomeInfoById($id , $arrayOfColumns){
        $user_info = QueryHandler::getItemSomeInfoById(self::tableName , $arrayOfColumns , $id);
        return $user_info;
    }

    public static function getUserInfoByEmail($Email){
        $statement = "select * from " . self::tableName . " where Email = ?  order by Id DESC limit 1;";
        $user_info = QueryHandler::getItemInfoBySelectStatement($statement , array($Email));
        return $user_info;
    }

    public static function getUserInfoByEmailAndPassword($Email , $password){
        $statement = "select * from " . self::tableName . " where Email = ? and Password = ? order by Id DESC limit 1;";
        $user_info = QueryHandler::getItemInfoBySelectStatement($statement , array($Email , $password));
        return $user_info;
    }

    public static function getUserIdByEmail($Email){
        $statement = "select Id from " . self::tableName . " where Email = ? order by Id DESC limit 1;";
        $userId = QueryHandler::getItemInfoBySelectStatement($statement , array($Email))["Id"];
        return $userId;
    }

    public static function isUserFoundQueryById($id){
        $matched_users = QueryHandler::getItemSomeInfoById(self::tableName , array("count(Id) as count") , $id);
        return $matched_users > 0 ? true : false;
    }

    public static function isUserFoundQueryByEmail($Email){
        $statement = "select count(Id) as count from " . self::tableName . " where Email = ? order by Id DESC limit 1;";
        $matched_users = QueryHandler::getItemInfoBySelectStatement($statement , array($Email))["count"];
        return $matched_users > 0 ? true : false;
    }

    public static function isUserFoundQueryByUsername($Username){
        $statement = "select count(Id) as count from " . self::tableName . " where Username  = ? order by Id DESC limit 1;";
        $matched_users = QueryHandler::getItemInfoBySelectStatement($statement , array($Username))["count"];
        return $matched_users > 0 ? true : false;
    }

    public static function isUserFoundQueryByPhoneNumber($PhoneNumber){
        $statement = "select count(Id) as count from " . self::tableName . " where PhoneNumber  = ? order by Id DESC limit 1;";
        $matched_users = QueryHandler::getItemInfoBySelectStatement($statement , array($PhoneNumber))["count"];
        return $matched_users > 0 ? true : false;
    }

    public static function isUserFoundQueryByEmailPassword($Email , $HashedPassword){
        $statement = "select count(Id) as count from " . self::tableName . " where Email = ? and Password = ? order by Id DESC limit 1;";
        $matched_users = QueryHandler::getItemInfoBySelectStatement($statement , array($Email , $HashedPassword))["count"];
        return $matched_users > 0 ? true : false;

    }

    public static function UpdateUserInfoByEmail($Email , $ColumnsAndNewValuesForUpdatingProccess_array , $ColumnsAndValuesForCondition_array = array() , $operators_array = array("=")){
        if(self::isUserFoundQueryByEmail($Email)){
            $updatingQuery = QueryHandler::updateByColumnsAndValues(self::tableName , $ColumnsAndNewValuesForUpdatingProccess_array , $ColumnsAndValuesForCondition_array , $operators_array);
            return $updatingQuery;
        } 
    }

    
 
} 