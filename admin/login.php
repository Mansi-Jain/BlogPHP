<?php
session_start();
if (isset($_POST['submit'])){
    $user = $_POST['username'];
    $pwrd = $_POST['pwrd'];
    //include database connection
    include('../includes/db_connect.php');
    if(empty($user) || empty($pwrd)){
        echo "Please fill in the details";
    }
    else {
        $user = strip_tags($user);
        $user = $db->real_escape_string($user);
        $pwrd = strip_tags($pwrd);
        $pwrd = $db->real_escape_string($pwrd);
        $pwrd = md5($pwrd);
        $query = "select user_id,username from user where username='$user' and password='$pwrd'";
        $userdetails = $db->query($query);
        if ($userdetails->num_rows===1){
            while ($row = $userdetails->fetch_object()){
                $_SESSION['user_id']=$row->user_id;
            }
            header('Location: index.php');
            exit();
        }
        else {
            echo "Username or Password is incorrect.";
        }
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
            <form method="post" action="login.php">
                <p>
                    <label>Username</label>
                    <input type="text" name="username"/>
                </p>
                <p>
                    <label>Password</label>
                    <input type="password" name="pwrd"/>
                </p>
                <p><input type="submit" name="submit" value="Sign In"/>
                    <a href="signup.php" style="text-align: right;">New User</a>
                </p>
            </form>
            
        </div>
    </body>
</html>