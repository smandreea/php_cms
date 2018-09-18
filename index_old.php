<?php include "includes/header.php";?>
<?php include "includes/navigation.php";?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Titlu suprem
                <small>Secondary Text</small>
            </h1>

            <?php
            if(isset($_GET['p_id'])) {
                $p_id = $_GET['p_id'];
            }

            $query = "SELECT * FROM posts WHERE post_status = 'Published'";
            $select_all_posts_query = mysqli_query($connection, $query);

            if($select_all_posts_query->num_rows === 0) {
                echo "<h2>Nothing to show, sorry!</h2>";
            }

            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 100);
                $post_status = $row['post_status'];
                

                $sql = "SELECT * FROM posts WHERE post_author = '{$post_author}'";
                $select_author_query = $connection->query($sql);

                if($select_author_query === FALSE) {
                    echo "Error: " . $sql . "<br>" . $connection->error;
                    die();
                }



                ?>
                <!-- Blog Posts -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title;?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author;?>"><?php echo $post_author;?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id;?>"><img class="img-responsive" src="images/<?php echo $post_image;?>" alt=""></a>
                <hr>
                <p><?php echo $post_content;?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
            <?php 
            }
            ?>
        </div>
        <?php include "includes/sidebar.php"; ?>
    </div>
</div>
<!-- /.row -->
<?php include "includes/footer.php"; ?>