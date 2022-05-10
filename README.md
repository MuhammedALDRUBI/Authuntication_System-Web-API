# Authuntication_System-Web-API-

## To use this system yo have many options : 
- You can integrate the Demo into your system (Don't forget to redesign pages as you like).
- You can use System Core that is in "Auth_System_Core" folder and use classes as you need .

### Don't forget to import sql file to your database and specify its name in config.php file .
### Dont't forget to use Demo by its files structure (if you change the file's structure you must load each file that require for system to work) .
### if you decide to use Autuntication system core you wil be able to use many methodes that never used in Demo (as you need).
### System core use all classes that are in Classes Folder (To require all it use AutoLoader from this link https://github.com/MuhammedALDRUBI/AutoLoader).
### Authuntication System is mdae for web and mobile (API) ... Enjoy.

<hr>



##usable Methodes in AuthForWeb Class (For authuntication in web side) :

### Login( $userInfoArray , $pathToRedirect = "")  : is used to login and save userinfo in session where :
    - $userInfoArray is an associative array that contains Email and password of the user (that comes from user).
    - $pathToRedirect is used to redirect user to an other page if login operation is done (default value is index.php page path).
    - Note : All data validation and filtering are executed automatically (By DataHandler class). 
  <hr>
  
### isUserCookieFound($pathToRedirect = "./index.php") : is used to redirect user to home page if he has selected to save his info in cookies (after he clicked on remember me button and after a new visiting to website).
       - $pathToRedirect is used to redirect user to an other page if his info is found in session <b>And it is correct </b> (default value is index.php page path).
       - All values are matched in database ... if it is wrong nothing will be happen;
       
 <hr>
     
### IsUserLoggedByQuery($userInfoArray) : is used to do a login operation without any redirection and <b>By array that contains Email And hashed password</b> , returns     true or false;
  <hr>
  
### IsUserLoginBySession() : is used to check if user's info is saved in session or not , it use SessionManager Class (FindKeyInSession method with "user" key).
    returns user info if it is found in session , else it returns false;
  <hr>
    
### getLoggedUserInfo() : is alias to IsUserLoginBySession() method (do the same operations).
  <hr>

### IsUserLoginBySessionAndQuery() : is used to match the user info that saved in session in database (using IsUserLoggedByQuery() method that is in the same class) ... returns true or false;

  <hr>
  
### whatUserPermission() : is used to get user permissions that is a column in database (its value is important for user's previliges).
   <hr>
    
### logout($pathToRedirect = "") : is used to loggout and destroy all session's info (using SessionManager Class) , $pathToRedirect is used to specify a path for  redirectiong after logout operation is done.
  <hr>
  
### Register($userInfoArray) : is used to save a new user in database (using an associative aaray that contains columns these are in users table).

<hr>

### getNewPasswordByEmail($Email) : is used to change password of user and get a new password (returns a string value).

<hr>

##usable Methodes in AuthForApi Class (For authuntication in Mobile and external side) :

### Login($userInfoArray ,  $pathToRedirect = "") : is used to login by an associative array that contains Email , password or user , it returns a JSON object that contains user info (that comes from DB to use it in all authuntication operations ) , if user is not found it will be returns a JSON oject that contains error messages.
    Note : All data validation and filtering are executed automatically (By DataHandler class). 

<hr>

### IsUserLoggedByQuery($userInfoArray = array()) : is used to matching the Email and hashed password (these comes with Headers from frontend side) in database , and return JSON object contains the result (with messages).

<hr>

###  getLoggedUserInfo() :  is used to get user info from DB by user's email that will be sent with headers from frontend side , and return JSON object contains the result (data with messages).

<hr>

### whatUserPermission()  is used to get user permissions from DB by user's email that will be sent with headers from frontend side , and return JSON object contains the result (data with messages).

<hr>

### Register($userInfoArray) :  is used to insert (save) a new user into DB by user info array that will be sent with form (post request) from frontend side , and return JSON object contains the result (status & messages).

<hr>


Don't Forget to support me on :
<p dir="rtl" >لا تنسى دعمي على </p>
<p>Facebook : https://www.facebook.com/MDRDevelopment/</p>
<p>Instagram : https://www.instagram.com/mdr_development_tr/</p>
