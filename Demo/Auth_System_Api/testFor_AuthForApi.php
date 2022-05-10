<?php
    require_once "./AutoLoader.php";
    AutoLoader::LoadClassesFromFolder("../Classes");
    QueryHandler::openConnection(Host , DBName , DBUser  , DBUserPassword);
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once "./AutoLoader.php";
        AutoLoader::LoadClassesFromFolder("Classes");
        QueryHandler::openConnection(Host , DBName , DBUser  , DBUserPassword);

        $action = "login";
        if(isset($_GET["action"])){
            $action = $_GET["action"];
        }
        if($action == "login"){ 
            echo AuthForApi::Login($_POST);
        }elseif($action == "register"){ 
            echo AuthForApi::Register($_POST);
        }elseif($action == "IsUserLoggedByQuery"){
            echo AuthForApi::IsUserLoggedByQuery();
        }elseif($action == "getLoggedUserInfo"){
            echo AuthForApi::getLoggedUserInfo();
        }elseif($action == "whatUserPermission"){ 
            echo AuthForApi::whatUserPermission();
        }elseif($action == "getNewPasswordByEmail"){ 
            echo AuthForApi::getNewPasswordByEmail($_POST["Email"]);
        }



        QueryHandler::closeConnection();
    }else{ 
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Home Page - For Web</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        </head>
        <body>

        <div class="container"> 
            <h1 class="text-center my-2">Here you can Test AuthForApi Class <br> <b>Response Will be written In Console</b></h1>
            <form id="registerForm" class="w-75 mx-auto my-3" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
                <h2>Register Form - For Api</h2>    
                <div class="form-group my-1">
                    <input class="form-control"  type="text" name="Name" placeholder="Type your Name">
                </div>

                <div class="form-group my-1">
                    <input class="form-control"  type="text" name="Username" placeholder="Type your Username">
                </div>

                <div class="form-group my-1">
                    <input class="form-control"  type="email" name="Email" placeholder="Type your email">
                </div>

                <div class="form-group my-1">
                    <input class="form-control"  type="password" name="Password" placeholder="type your password">
                </div>
                <div class="form-group my-1">
                    <input class="form-control"  type="text" name="PhoneNumber" placeholder="type your PhoneNumber">
                </div>
                <input class="btn btn-primary" type="submit" name="submit"> 
          </form>
        <hr>

        <form id="LoginForm" class="w-75 mx-auto my-3" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
            <h2>Login Form - For Api</h2>    
            <div class="form-group my-1">
                <input  class="form-control" type="email" name="Email" placeholder="Type your email">
            </div>

            <div class="form-group my-1">
                <input  class="form-control" type="password" name="Password" placeholder="type your password">  
            </div> 
            
            <input  class="btn btn-info" type="submit" name="submit"> 
        </form>

        <hr>

        
        <form id="IsUserLoggedByQuery" class="w-75 mx-auto my-3" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
            <h2>IsUserLoggedByQuery Form - For Api</h2>     
            <div class="form-group my-1">
                <input  class="form-control" type="email" name="Email" placeholder="Type your email That wil be sent by REQUEST's HEADER">
            </div>      
            <div class="form-group my-1">
                <input  class="form-control" type="tpassword" name="Password" placeholder="Type your Hashed Password That wil be sent by REQUEST's HEADER">
                <small>You can get The hashed password after the login Response that you get it</small>
            </div> 
            <input  class="btn btn-success" type="submit" name="submit"> 
        </form>    

        <hr>

        <form id="getLoggedUserInfo" class="w-75 mx-auto my-3" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
            <h2>getLoggedUserInfo Form - For Api</h2>     
            <div class="form-group my-1">
                <input  class="form-control" type="email" name="Email" placeholder="Type your email That wil be sent by REQUEST's HEADER">
            </div>    
            <input  class="btn btn-danger" type="submit" name="submit"> 
        </form>

        <hr>

        <form id="whatUserPermission" class="w-75 mx-auto my-3" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
            <h2>whatUserPermission Form - For Api</h2>     
            <div class="form-group my-1">
                <input  class="form-control" type="email" name="Email" placeholder="Type your email That wil be sent by REQUEST's HEADER">
            </div>    
            <input  class="btn btn-dark" type="submit" name="submit"> 
        </form>
   
        <hr>

        <form id="getNewPasswordByEmail" class="w-75 mx-auto my-3" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
            <h2>getNewPasswordByEmail Form - For Api</h2>
            <p>in this part you will not get a json object .... because you must use this method only to generate a new password and store it in DB <br> then you must send it by Your mail System</p>     
            <div class="form-group my-1">
                <input  class="form-control" type="email" name="Email" placeholder="Type your email That wil be sent by REQUEST's HEADER">
            </div>    
            <input  class="btn btn-secondary" type="submit" name="submit"> 
        </form>
    
        <script>

    
            //this part for Registration Part - start of part
            let registerForm = document.getElementById("registerForm");

            registerForm.onsubmit = function(e){
                e.preventDefault();
                let Rqt = new XMLHttpRequest();
                let data = new FormData(registerForm);

                Rqt.open("POST" , "./testFor_AuthForApi.php?action=register"); 
                Rqt.onreadystatechange = function(){
                    if(Rqt.readyState == 4  && Rqt.status == 200){
                        console.log(Rqt.response);
                    }
                }
                Rqt.send(data);
            } //this part for Registration Part - end of part


            //this part for Login Part - start of part
            let LoginForm = document.getElementById("LoginForm");

            LoginForm.onsubmit = function(e){
                e.preventDefault();
                let Rqt = new XMLHttpRequest();
                let data = new FormData(LoginForm);

                Rqt.open("POST" , "./testFor_AuthForApi.php?action=login"); 
                Rqt.onreadystatechange = function(){
                    if(Rqt.readyState == 4  && Rqt.status == 200){
                        console.log(Rqt.response);
                    }
                }
                Rqt.send(data);
            }//this part for Login Part - end of part
            

            //this part for IsUserLoggedByQueryForm Method Part - start of part
            //here you can can send the info that you get from Login Response To IsUserLoggedByQueryForm Method and receive the response
            let IsUserLoggedByQueryForm = document.getElementById("IsUserLoggedByQuery");

            IsUserLoggedByQueryForm.onsubmit = function(e){
                e.preventDefault();
                let Rqt = new XMLHttpRequest();
                let data = new FormData(IsUserLoggedByQueryForm);
                let emailToSendByHeader = data.get("Email"),
                    passwordToSendByHeader = data.get("Password");
                Rqt.open("POST" , "./testFor_AuthForApi.php?action=IsUserLoggedByQuery"); 
                Rqt.setRequestHeader("USEREMAIL" , emailToSendByHeader);
                Rqt.setRequestHeader("USERPASSWORD" , passwordToSendByHeader);
                Rqt.onreadystatechange = function(){
                    if(Rqt.readyState == 4  && Rqt.status == 200){
                        console.log(Rqt.response);
                    }
                }
                Rqt.send();
            }//this part for IsUserLoggedByQueryForm Method Part - end of part


            //this part for getLoggedUserInfo Method Part - start of part
            //here you can send the email to getLoggedUserInfo method to get all info of user
            let getLoggedUserInfo = document.getElementById("getLoggedUserInfo");

            getLoggedUserInfo.onsubmit = function(e){
                e.preventDefault();
                let Rqt = new XMLHttpRequest();
                let data = new FormData(getLoggedUserInfo);
                let emailToSendByHeader = data.get("Email");
                Rqt.open("POST" , "./testFor_AuthForApi.php?action=getLoggedUserInfo"); 
                Rqt.setRequestHeader("USEREMAIL" , emailToSendByHeader );
                Rqt.onreadystatechange = function(){
                    if(Rqt.readyState == 4  && Rqt.status == 200){
                        console.log(Rqt.response);
                    }
                }
                Rqt.send();
            }//this part for getLoggedUserInfo Method Part - end of part


            //this part for whatUserPermission Method Part - start of part
            //here you can send the email of user to get his permissions (0 or 1)
            let whatUserPermission = document.getElementById("whatUserPermission");

            whatUserPermission.onsubmit = function(e){
                e.preventDefault();
                let Rqt = new XMLHttpRequest();
                let data = new FormData(whatUserPermission);
                let emailToSendByHeader = data.get("Email");
                Rqt.open("POST" , "./testFor_AuthForApi.php?action=whatUserPermission"); 
                Rqt.setRequestHeader("USEREMAIL" , emailToSendByHeader);
                Rqt.onreadystatechange = function(){
                    if(Rqt.readyState == 4  && Rqt.status == 200){
                        console.log(Rqt.response);
                    }
                }
                Rqt.send();
            }//this part for whatUserPermission Method Part - end of part


            //this part for getNewPasswordByEmail Method Part - start of part
            //here you can can generate a new password for email that you send (( Send the new Password By Your mail system to the same email that you write in input))
            let getNewPasswordByEmail = document.getElementById("getNewPasswordByEmail");

            getNewPasswordByEmail.onsubmit = function(e){
                e.preventDefault();
                let Rqt = new XMLHttpRequest();
                let data = new FormData(getNewPasswordByEmail);
                let emailToSendByHeader = data.get("Email");
                Rqt.open("POST" , "./testFor_AuthForApi.php?action=getNewPasswordByEmail"); 
                data.set("Email" , emailToSendByHeader);
                Rqt.onreadystatechange = function(){
                    if(Rqt.readyState == 4  && Rqt.status == 200){
                        console.log(Rqt.response);
                    }
                }
                Rqt.send(data);
            }//this part for getNewPasswordByEmail Method Part - end of part

        </script>
    </body>
    </html>
<?php } ?>
