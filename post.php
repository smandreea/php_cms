<?php include "includes/header.php";?>
<?php include "includes/navigation.php";?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if(isset($_GET['p_id'])) {
                $p_id = $_GET['p_id'];

                $query = "SELECT * FROM posts WHERE post_id = '{$p_id}'";
                $select_all_posts_query = mysqli_query($connection, $query);

                $views_count = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = '{$p_id}'";
                $connection->query($views_count);

            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                ?>

                <!-- First Blog Post -->
                <h1>
                    <?php echo $post_title;?>
                </h1>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author;?>"><?php echo $post_author;?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                <p><?php echo $post_content;?></p>
            <?php
            } } else {
                header("Location: index.php");
            }
            ?>
            
    <!-- Comments Form -->
<?php

if(isset($_POST['submit_comment'])) {
    $comment_author = $_POST['comment_author'];
    $comment_email = $_POST['comment_email'];
    $comment_content = $_POST['comment_content'];
    $comment_post_id = $_GET['p_id'];
    $comment_date = date("d-m-Y");
    $default_comment_status = 'Unapproved';

    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
    
        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_date, comment_status) VALUES ('{$comment_post_id}', '{$comment_author}', '{$comment_email}', '{$comment_content}', now(), '{$default_comment_status}') ";

        $insert_comment_query = mysqli_query($connection, $query);

        if(!$insert_comment_query) {
            die ("Query error: " . mysqli_error($connection));
        }

        $update_comment_count = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = '{$comment_post_id}' ";

        $update_comment_count_query = mysqli_query($connection, $update_comment_count);

        if(!$update_comment_count_query) {
            die ("Query error: " . mysqli_error($connection));
        }
    } else {
        echo "<script>
           alert('Fields cannot be empty.');</script>";
    }
}


?>

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="comment_author">Author name</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Author email</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
<?php 

$query = "SELECT * FROM comments WHERE comment_post_id = '{$p_id}' AND comment_status = 'Approved' ORDER BY comment_id DESC";
$post_comments_query = mysqli_query($connection, $query);

if(!$post_comments_query) {
    die("Query error: " . mysqli_error($connection));
}

while($row = mysqli_fetch_assoc($post_comments_query)) {
    $comment_author = $row['comment_author'];
    $comment_date = $row['comment_date'];
    $comment_content = $row['comment_content'];
?>
 
                <div class="media">
                    <a class="pull-left" href="">
                        <img class="media-object" src="images/users/comment_user.png" alt="" width="50">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author;?>
                            <small><?php echo $comment_date;?></small>
                        </h4>
                        <?php echo $comment_content;?>
                    </div>
                    <!-- <button class="btn btn-sm btn-default pull-right reply-comment">Reply</button>
                        <form role="form" action="" method="post" class="col-md-8 pull-right reply-form">
                            <div class="form-group">
                                <input type="text" class="form-control" name="comment_author" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="comment_email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="comment_content" placeholder="Comment"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit_reply">Submit</button>
                        </form> -->
                </div>
<?php } ?>
 
        </div>
        <?php include "includes/sidebar.php"; ?>
    </div>
</div>
<!-- /.row -->
<?php include "includes/footer.php"; ?>