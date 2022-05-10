<?php
 require_once "./AutoLoader.php";
 AutoLoader::LoadClassesFromFolder("../Classes");

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $token = DataHandler::CreateCSRFToken(); 
}else{    
    QueryHandler::openConnection(Host , DBName , DBUser  , DBUserPassword);

    
    $token_from_input = isset($_POST["CSRF_Token"]) ? $_POST["CSRF_Token"] : "";
    $token_verification_Status = DataHandler::CheckCSRFToken($token_from_input);
    $registerationResult = null;
    if(gettype($token_verification_Status) != "string"){$registerationResult =  AuthForWeb::Register($_POST);}else{SessionManager::SaveKeyInSession("ErrorMesage" , $token_verification_Status);}
    if($registerationResult != null){
        if($registerationResult == 1){
            SessionManager::SaveKeyInSession("SuccessMesage" , "Registration Procces Completed !");
        }else{
            SessionManager::SaveKeyInSession("ErrorMesage" , $registerationResult);
        }
    }
    
     QueryHandler::closeConnection();
}

 
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Register Page - For Web</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link href="../Css/MessageBox.css" rel="stylesheet">
        </head>
        <body>
            <h1 class="w-75 my-4 text-center  p-3 border rounded-3 mx-auto text-white bg-dark">Register page For Test from Web </h1>

            <div class="container"> 
                <form class="w-75 mx-auto" action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
                    <input type="hidden" name="CSRF_Token" value="<?php echo SessionManager::FindKeyInSession("CSRF_Token"); ?>">
 
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

                    <input class="btn btn-success" value="Register" type="submit" name="submit">

                    <a class="btn btn-primary" href="./login.php">Login</a>
                </form> 
            </div>
            <?php 
                $ErrorMesage = SessionManager::FindKeyInSession("ErrorMesage");
                $SuccessMesage = SessionManager::FindKeyInSession("SuccessMesage");
                if($ErrorMesage != null || $SuccessMesage != null){
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
                    if($SuccessMesage != null){
                        echo '<div class="alert alert-danger" role="alert">' .  $SuccessMesage . '</div>';
                        SessionManager::removeKeyFromSession("SuccessMesage");
                    }
                ?>
                
            </div>

            <script src="../Js/MessageBox.js"></script>
        </body>
    </html>