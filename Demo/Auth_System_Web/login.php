<?php
    require_once "./AutoLoader.php";
    AutoLoader::LoadClassesFromFolder("../Classes");
    QueryHandler::openConnection(Host , DBName , DBUser  , DBUserPassword);
    AuthForWeb::isUserCookieFound();
    if(AuthForWeb::IsUserLoginBySessionAndQuery()){ SessionManager::RedirectToPath("./index.php");}
  
   
    if($_SERVER["REQUEST_METHOD"] == "GET"){
            $token = DataHandler::CreateCSRFToken(); 
    }else{
        $token_from_input = isset($_POST["CSRF_Token"]) ? $_POST["CSRF_Token"] : "";
        $token_verification_Status = DataHandler::CheckCSRFToken($token_from_input);
        $loginProccesResult = null;
        if(gettype($token_verification_Status) != "string"){$loginProccesResult = AuthForWeb::Login($_POST);}else{SessionManager::SaveKeyInSession("ErrorMesage",$token_verification_Status);}
        if($loginProccesResult != null){ SessionManager::SaveKeyInSession("ErrorMesage" , $loginProccesResult); }
    }

    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>login Page - For Web</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link href="../Css/MessageBox.css" rel="stylesheet">
        </head>
        <body>
            <h1 class="w-75 my-4 text-center  p-3 border rounded-3 mx-auto text-white bg-dark">Login page For Test from Web </h1>

            <div class="container"> 
                <form class="w-75 mx-auto" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
                <input type="hidden" name="CSRF_Token" value="<?php echo SessionManager::FindKeyInSession("CSRF_Token"); ?>">
                    
                    <div class="form-group my-1">
                    <input class="form-control" type="email" name="Email" placeholder="Type your email" aria-label="default input example">
                    </div>
                    
                    <div class="form-group my-1">
                        <input class="form-control"  type="password" name="Password" placeholder="type your password">
                    </div>
 
                    
                    <div class="form-check my-1">
                        <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Remember Me
                        </label>
                    </div>

                    <input class="btn btn-success" type="submit" name="submit" value="Login">
                    <a class="btn btn-primary " href="./register.php">Register</a>    
                </form> 
            </div>

            <?php 
                $ErrorMesage = SessionManager::FindKeyInSession("ErrorMesage"); 
                if($ErrorMesage != null ){
                    $Boxclass = "";
                }else{
                    $Boxclass = "hidden";
                }
                
            ?>

            <div id="MessageBox_parent" class="MessageBox-parent <?php echo $Boxclass;?>" >
                
                <?php   
                    if($ErrorMesage != null){
                        echo '<div class="alert alert-danger" role="alert">' . $ErrorMesage . '</div>';
                        SessionManager::removeKeyFromSession("ErrorMesage");
                    } 
                ?>
                
            </div>
            <script src="../Js/MessageBox.js"></script>
        </body>
    </html>


    <?php
    QueryHandler::closeConnection();  