<?php

require_once "./AutoLoader.php";
AutoLoader::LoadClassesFromFolder("../Classes");
QueryHandler::openConnection(Host , DBName , DBUser  , DBUserPassword);
SessionManager::StartLoginSession(true);

if(AuthForWeb::IsUserLoginBySessionAndQuery()){ 
?>


<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Home Page - For Web</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        </head>
        <body>
            <h1 class="w-75 my-4 text-center  p-3 border rounded-3 mx-auto text-white bg-dark">Home Page After Login - For Test from Web   - <a class="btn btn-info " href="./logout.php">Logout</a></h1>
            <h2 class="w-75 mx-auto my-4 text-center">Hello <?php echo SessionManager::FindKeyInSession("user")["Name"];  ?> , This is Your Home page</h2>
            <h3 class="w-75 mx-auto my-4 text-center">You are logged by Email : <?php echo SessionManager::FindKeyInSession("user")["Email"];  ?></h3>
            <h4 class="w-75 mx-auto my-4 text-center">Your Role is : <?php echo AuthForWeb::whatUserPermission() == 0 ? "Normal User" : "Admin";  ?></h4>
            <div class="w-75 mx-auto">
            
            </div>
     
    </body>
    </html>
<?php
QueryHandler::closeConnection();
}else{
    SessionManager::RedirectToPath("./logout.php");
}


?>
 
