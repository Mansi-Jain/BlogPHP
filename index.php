<?php 
 include 'includes/db_connect.php';
 $record_count = $db->query("select * from posts");
 
 $per_page=3;
 $pages = ceil($record_count->num_rows/$per_page);
 if (isset($_GET['p']) && is_numeric($_GET['p'])){
     $page=$_GET['p'];
 }
 else {
     $page=1;     
}
if ($page<=0){
    $start=0;
}
 else {
    $start=$page*$per_page-$per_page;
}
$next=$page+1;
$prev=$page-1;
 $query = $db->prepare("select post_id,posted,title,body,category from posts inner join categories on categories.category_id=posts.category_id order by post_id desc limit $start,$per_page");
 $query->execute();
 $query->bind_result($post_id,$posted,$title,$body,$category);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <script src="http://code.jquery.com/jquery-1.5.min.js0"></script>
        <style>
            .blog-masthead {
                margin-bottom: 3rem;
            }
            
            .container {
                max-width: 60rem;
            }

            /* Nav links */
            .nav-link {
                position: relative;
                padding: 1rem;
                font-weight: 500;
                font-size: 25px;
                text-align: right;
            }
            #container_main{
                margin: auto;
                width: 800px;
            }
            h1{
                font-size: 40px;
            }
        </style>
    </head>
    <body>
      <div class="blog-masthead">
      <div class="container">
        <nav class="nav">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="admin/signup.php">Sign In</a>
            <a class="nav-link" href="admin/signup.php">Sign Up</a>
        </nav>
      </div>
    </div>
        <div id="container_main">
            <?php
            while ($query->fetch()):
            ?>
            <article>
                <h1><?php echo $title; ?></h1>
                <p><?php echo substr($body, 0, 400)."..."?></p>
                <p><b>Category:</b> <?php echo $category; ?></p>
                <p><b>Posted On:</b> <?php echo $posted; ?></p>
                <p><b><a href="post.php?id=<?php echo $post_id; ?>">Read More</a></b></p>
            </article>
            <?            endwhile; ?>
            <?php
                 if ($prev>0){
                     echo '<b><a style="text-align: left;" href="index.php?p=$prev">Prev</a></b>';
                 }
                 if ($page < $pages){
                     echo '<b><a style="text-align: right;" href="index.php?p=$next">Next</a></b>';
                 }
            ?>
            
        </div>
    </body>
</html>
            