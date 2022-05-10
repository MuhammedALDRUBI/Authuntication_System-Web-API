<?php


class AuthForApi extends Auth{
 
    static public function Login($userInfoArray ,  $pathToRedirect = ""){
         
            //sanitizing data before using it
            $Sanitizing_Filters_array = array("Password" => "string", "Email" => "email" );
            $userInfoArray =  DataHandler::Sanitize_Data($userInfoArray , $Sanitizing_Filters_array);
            if(gettype($userInfoArray) == "string"){
                $apiResult = DataHandler::returnAsJSON(false , array($userInfoArray));
                throw new Exception($apiResult);
            }
            //validating the data
            $validating_Filters_array = array( "Email" => "email");
            $validatng_result = DataHandler::Validate_Data($userInfoArray , $validating_Filters_array );
            if(gettype($validatng_result) == "array"){
                $apiResult = DataHandler::returnAsJSON(false , $validatng_result);
                throw new Exception($apiResult);
            }

            //using email to get user informations
            $user = User::getUserInfoByEmail($userInfoArray["Email"]);
            if(gettype($user) == "string"){ 
                $apiResult = DataHandler::returnAsJSON(false , array($user));
                throw new Exception($apiResult);
            }
            if($user == null){ 
                $apiResult = DataHandler::returnAsJSON(false , array("User is Not found"));
                throw new Exception($apiResult);
            }
             
            if(!DataHandler::check_hashed_password($user["Password"] , $userInfoArray["Password"])){
                $apiResult = DataHandler::returnAsJSON(false , array("User is Not found"));
                throw new Exception($apiResult);
            }
            
            $apiResult = DataHandler::returnAsJSON(true , array("User is Login Now") , $user);
            return $apiResult;
 
    }
    
 
 
    
    static public function IsUserLoggedByQuery($userInfoArray = array()){
        $userInfoArray = array("Email" => $_SERVER["HTTP_USEREMAIL"] , "Password" => $_SERVER["HTTP_USERPASSWORD"]);
        $Sanitizing_Filters_array = array( "Password" => "string", "Email" => "email" );
        $userInfoArray =  DataHandler::Sanitize_Data($userInfoArray , $Sanitizing_Filters_array);

        if(gettype($userInfoArray) == "string"){
            $apiResult = DataHandler::returnAsJSON(false , array($userInfoArray));
            return $apiResult;
        }

        $validating_Filters_array = array( "Email" => "email");
        $validatng_result = DataHandler::Validate_Data($userInfoArray , $validating_Filters_array );
        
        if(gettype($validatng_result) == "array"){
            $apiResult = DataHandler::returnAsJSON(false , $validatng_result);
            return $apiResult;
        }

        $IsUserFound = User::isUserFoundQueryByEmailPassword($userInfoArray["Email"] , $userInfoArray["Password"]);
        $MessageArray = array();
        $MessageArray[] = $IsUserFound == true ? "User Is Found !" : "User Not Found !";
        $apiResult = DataHandler::returnAsJSON($IsUserFound , $MessageArray);
        return $apiResult;

        
    }

    
    static public function getLoggedUserInfo(){
        $userInfoArray = array("Email" => $_SERVER["HTTP_USEREMAIL"]);
        $Sanitizing_Filters_array = array(  "Email" => "email" );
        $userInfoArray =  DataHandler::Sanitize_Data($userInfoArray , $Sanitizing_Filters_array);

        if(gettype($userInfoArray) == "string"){
            $apiResult = DataHandler::returnAsJSON(false , array($userInfoArray));
            return $apiResult;
        }

        $validating_Filters_array = array( "Email" => "email");
        $validatng_result = DataHandler::Validate_Data($userInfoArray , $validating_Filters_array );
        
        if(gettype($validatng_result) == "array"){
            $apiResult = DataHandler::returnAsJSON(false , $validatng_result);
            return $apiResult;
        }

        $userInfoQuery = User::getUserInfoByEmail($userInfoArray["Email"]);
        if(gettype($userInfoQuery) == "string"){
            $apiResult = DataHandler::returnAsJSON(false , array($userInfoQuery) );
            return $apiResult;
        }

        if($userInfoQuery == null){
            $apiResult = DataHandler::returnAsJSON(false , array("User Is not Found !"));
            return $apiResult;
        }

        $apiResult = DataHandler::returnAsJSON(true , array() , $userInfoQuery);
        return $apiResult;
    }

  
    static public function whatUserPermission(){

        $userEmail = $_SERVER["HTTP_USEREMAIL"];
        $userPermission = User::getUserInfoByEmail($userEmail);

        if(gettype($userPermission) == "string"){
            $apiResult = DataHandler::returnAsJSON(false , array($userPermission));
            return $apiResult;
        }
        if($userPermission == null){
            $apiResult = DataHandler::returnAsJSON(false , array("User Is not Found !"));
            return $apiResult;
        }
        $Permission = intval($userPermission["Permission"]);
        $MessageArray = array();
        $MessageArray[] = $Permission == 0 ? "User is Normal user" : "User is Admin";
        $apiResult = DataHandler::returnAsJSON(true , $MessageArray , array("Permission" => $Permission ));
        return $apiResult;
    }
  
    static public function Register($userInfoArray){
        $newUserInserting = User::CreateUser($userInfoArray);
        if(gettype($newUserInserting) == "string"){
            $apiResult = DataHandler::returnAsJSON(false , array($newUserInserting) );
            return $apiResult;
        }
        $apiResult = DataHandler::returnAsJSON(true);
        return $apiResult;
    }
} 
