<?php
   if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
} else {
    $id = $_GET['id'];
}
include ('includes/db_connect.php');
if (!is_numeric($id)){
    header('Location: index.php');
    exit();
}

$sql = "select posted,title,body,category from posts inner join categories on categories.category_id=posts.category_id where post_id='$id'";
$post = $db->query($sql);
if ($post->num_rows != 1){
    header('Location: index.php');
    exit();
}
if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $name = $db->real_escape_string($name);
    $email = $db->real_escape_string($email);
    $comment = $db->real_escape_string($comment);
    $id = $db->real_escape_string($id);
    if ($name && $email && $comment){
       $insert = "insert into comments(post_id,name,email_add,comment) values ('$id','$name','$email','$comment')"; 
       $query = $db->query($insert);
       if ($query){
           echo 'Thank you for posting your views!!';
           $query->close();
       }
       else{
           echo 'Error!!';
       }
    }
    else {
        echo 'Missing Data';    
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <script src="http://code.jquery.com/jquery-1.5.min.js0"></script>
        <style>
            #container{
                margin: auto;
                width: 800px;
                padding: 5px;
            }
            h1{
                font-size: 40px;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <div id="post">
            <?php $row = $post->fetch_object() ;?>
            <article>
                
                <h1><?php echo $row->title; ?></h1>
                <p><?php echo $row->body; ?></p>
                <p><b>Category:</b> <?php echo $row->category; ?></p>
                <p><b>Posted On:</b> <?php echo $row->posted; ?></p>
            </article>
            </div>
            <div id="add-comments">
                <form action="<?php echo $_SERVER['PHP_SELF']."?id=$id" ?>" method="post">
                   <table>
                        <tr>
                            <td><label for="name">Name</label></td>
                            <td><input type="text" name="name"/></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email</label></td>
                            <td><input type="email" name="email"/></td>
                        </tr>
                        <tr>
                            <td><label for="comment">Comment</label></td>
                            <td><textarea name="comment" rows="5" cols="20"></textarea></td>
                        </tr>
                        <br>
                    </table>
                    <input type="submit" name="submit" value="Post"/> 
                </form>
            </div>
            <div id="comments">
                <?php
                   $results=$db->query("select * from comments where post_id='$id' order by post_id desc");
                   while ($rows = $results->fetch_object()):
                ?>
                <div>
                    <h4><?php echo $rows->name; ?></h4>
                    <blockquote><?php echo $rows->comment; ?></blockquote>
                </div>
                <?                endwhile; ?>
            </div>
        </div>
            
    </body>
</html>