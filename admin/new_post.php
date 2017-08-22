<?php
  session_start();
  include('../includes/db_connect.php');
  if (!isset($_SESSION['user_id'])){
      header('Location: login.php');
      exit();
  }
  if (isset($_POST['submit'])){
      $title = $_POST['title'];
      $body = $_POST['body'];
      $category_id = $_POST['category'];
      $title = $db->real_escape_string($title);
      $body = $db->real_escape_string($body);
      $user_id = $_SESSION['user_id'];
      $date = date('Y-m-d G:i:s');
      $body = htmlentities($body);
      if ($title && $body && $category_id){
          $query = "insert into posts (user_id,title,body,category_id,posted) values ('$user_id','$title','$body','$category_id','$date')";
          $addPost = $db->query($query);
          if ($addPost){
              echo 'Post Added Successfully';
          }
          else{
              echo 'Error!!';
          }
      }
      else {
          echo 'Missing data';  
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <script src="http://code.jquery.com/jquery-1.5.min.js0"></script>
        <style>
            #wrapper{
                margin: auto;
                width: 800px;
            }
            label{
                display: inline;
            }
        </style>
    </head>
    <body>
        <h1 style="text-align:center;">New Post</h1>
        <div id="wrapper">
            <div id="content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <table>
                        <tr>
                            <td><label for="title">Title</label></td>
                            <td><input type="text" name="title"/></td>
                        </tr>
                        <tr>
                            <td><label for="body">Body</label></td>
                            <td><textarea name="body" cols="60" rows="30"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="category">Category</label></td>
                            <td><select name="category">
                                    <?php 
                                       $query = $db->query("select * from categories");
                                       while ($row = $query->fetch_object()){
                                           echo "<option value='".$row->category_id."'>".$row->category."</option>";
                                       }
                                    ?>
                                </select></td>
                        </tr>
                        <br>
                    </table>
                    <input type="submit" name="submit" value="Post"/>
                </form>
            </div>
        </div>
    </body>
</html>