<?php


class AuthForWeb extends Auth{
 
    static public function Login( $userInfoArray){
        try{
            //sanitizing data before using it
            $Sanitizing_Filters_array = array("Password" => "string", "Email" => "email" );
            $userInfoArray =  DataHandler::Sanitize_Data($userInfoArray , $Sanitizing_Filters_array);

            //validating the data
            $validating_Filters_array = array( "Email" => "email");
            $validatng_result = DataHandler::Validate_Data($userInfoArray , $validating_Filters_array );
            if(gettype($validatng_result) == "array"){throw new Exception(join(" , " , $validatng_result));}

            //using email to get user informations
            $user = User::getUserInfoByEmail($userInfoArray["Email"]);
            if($user == null){ throw new Exception("User is Not found");}
             
            if(!DataHandler::check_hashed_password($user["Password"] , $userInfoArray["Password"])){throw new Exception("User is Not found");}
            
            SessionManager::StartLoginSession(true);
            if(!SessionManager::SaveKeyInSession("user" , $user)){
                throw new Exception("User Cann't login");
            } 
            if(isset($userInfoArray["rememberMe"])){
                self::RememberMe($user);
            }
            SessionManager::RedirectToPath("./index.php");
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    

    static public function isUserCookieFound(){
            $emailFormCookie = SessionManager::FindDataInCookie("UserEmail");
            $passwordFormCookie = SessionManager::FindDataInCookie("UserPassword");
            $user = null;

            if($emailFormCookie != null){
                $user = User::getUserInfoByEmailAndPassword($emailFormCookie , $passwordFormCookie);
            }
            if($user != null){
                SessionManager::StartLoginSession(true);
                if(SessionManager::SaveKeyInSession("user" , $user)){
                    SessionManager::RedirectToPath("./index.php");
                } 
            }
    }

    static public function RememberMe($userInfoArray){
        if(SessionManager::isCookieAvailable()){
            $oneMonthTime = strtotime("+1 Month");
            $addingEmailCookieProcess = SessionManager::setDataInCookieForATime("UserEmail" , $userInfoArray["Email"] , $oneMonthTime );
            $addingPasswordCookieProcess = SessionManager::setDataInCookieForATime("UserPassword" , $userInfoArray["Password"] , $oneMonthTime );
            return $addingEmailCookieProcess && $addingPasswordCookieProcess;
        }
     
    }

    // must be private method but we cann't do it because Abstract Auth class doesn't allowes us to do that (must be public for AuthForApi class)
    static public function IsUserLoggedByQuery($userInfoArray){
        return User::isUserFoundQueryByEmailPassword($userInfoArray["Email"] , $userInfoArray["Password"]);
    }

    static public function IsUserLoginBySession(){
        return SessionManager::FindKeyInSession("user") ;
        
    }
 
    static public function getLoggedUserInfo(){
        return SessionManager::FindKeyInSession("user") ;
    }

    static public function IsUserLoginBySessionAndQuery(){
            $userInfoArray = array();
            $userSessionArray = SessionManager::FindKeyInSession("user") ;
            if($userSessionArray != null){
                $userInfoArray["Email"] = $userSessionArray["Email"];
                $userInfoArray["Password"] = $userSessionArray["Password"];
                return self::IsUserLoggedByQuery($userInfoArray);
            }
            return false;
    }

    static public function whatUserPermission(){
        $userSessionArray = SessionManager::FindKeyInSession("user") ;
        if($userSessionArray != null){
            return $userSessionArray["Permission"];
        }
        return $userSessionArray;
    }

    static public function logout($pathToRedirect = ""){
        $removeDataFromSession        =  SessionManager::removeKeyFromSession("user");
        $removeUserEmailFromCookie    = SessionManager::UnsetDataFromCookie("UserEmail");
        $removeUserPasswordFromCookie = SessionManager::UnsetDataFromCookie("UserPassword"); 
        $DestructionTheSession        =  SessionManager::DestroySession($pathToRedirect);
        if(!$removeDataFromSession || !$DestructionTheSession || !$removeUserEmailFromCookie || !$removeUserPasswordFromCookie){ return false;}
        return true;
    }


    static public function Register($userInfoArray){
        $newUserInserting = User::CreateUser($userInfoArray);
        return $newUserInserting;
    }
 
} 