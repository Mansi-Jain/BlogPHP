<?php
if (isset($_POST['submit'])){
    $user = $_POST['username'];
    $pwrd = $_POST['pwrd'];
    $cpwrd = $_POST['cpwrd'];
    //include database connection
    include('../includes/db_connect.php');
    
    if($user && $pwrd && $cpwrd) {
        $user = strip_tags($user);
        $user = $db->real_escape_string($user);
        $pwrd = strip_tags($pwrd);
        $pwrd = $db->real_escape_string($pwrd);
        $pwrd = md5($pwrd);
        $cpwrd = strip_tags($cpwrd);
        $cpwrd = $db->real_escape_string($cpwrd);
        $cpwrd = md5($cpwrd);
        if (strcmp($pwrd, $cpwrd)== 0){
            $insert = "insert into user(username,password) values ('$user','$pwrd')";
            if($db->query($insert)){
                header('Location: login.php');
                exit();
            }
            else{
                echo 'Error while registering new user!!';
            }
        }
        else {
            echo 'Both the passwords must be same';
        }
    }
    else {
       echo "Please fill in the details";    
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <script src="http://code.jquery.com/jquery-1.5.min.js0"></script>
    </head>
    <body>
        <div id="container">
            <form method="post" action="signup.php">
                <p>
                    <label>Username</label>
                    <input type="text" name="username"/>
                </p>
                <p>
                    <label>Password</label>
                    <input type="password" name="pwrd"/>
                </p>
                <p>
                    <label>Confirm Password</label>
                    <input type="password" name="cpwrd"/>
                </p>
                <input type="submit" name="submit" value="Sign Up"/>
            </form>
            
        </div>
    </body>
</html>