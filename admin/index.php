<?php
session_start();
if (isset($_SESSION['userid'])){
    header('Location: login.php');
    exit();
}
include ('../includes/db_connect.php');
$query_posts = "select * from posts";
$query_comments = "select * from comments";
$posts = $db->query($query_posts);
$comments = $db->query($query_comments); 
if (isset($_POST['submit'])){
    $newCategory = $_POST['newCategory'];
    if (empty($newCategory)){
        echo 'Please add a category!!';
    }
    else {
      $query_insert = "insert into categories(category) values ('$newCategory')";
      $added=$db->query($query_insert);
      if($added){
          echo 'New category added successfully';
      }
      else {
          echo 'error!!!';
      }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <script src="http://code.jquery.com/jquery-1.5.min.js0"></script>
        <style>
            body{
                
            }
            #container{
                padding: 10px;
                width: 800px;
                margin: auto;
                background: white;
            }
            #menu{
                height: 40px;
                line-height: 40px;
            }
            #menu ul{
                margin: 0;
                padding: 0;
            }
            #menu ul li{
                display: inline;
                list-style: none;
                margin-right: 10px;
                font-size: 18px;
            }
            #maincontent{
                clear: both;
                margin-top: 5px;
                font-size: 25px;
            }
            #header{
                height: 80px;
                line-height: 80px;
            }
            #container #header h1{
                font-size: 45px;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <div id="menu">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="new_post.php">Create New Post</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                    <li><a href="../index.php">Blog Home Page</a></li>
                </ul>
            </div>
            <div id="maincontent">
                <table>
                    <tr>
                        <td>Total Blog Posts</td>
                        <td><?php echo $posts->num_rows; ?></td>
                    </tr>
                    <tr>
                        <td>Total Comments</td>
                        <td><?php echo $comments->num_rows; ?></td>
                    </tr>
                </table>
                <div id="categoryForm">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                        <label for="category">Add New Category</label>
                        <input type="text" name="newCategory"/>
                        <input type="submit" name="submit" value="add"/>
                    </form>
                </div>
            </div>
            
        </div>
    </body>
</html>