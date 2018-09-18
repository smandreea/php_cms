<?php include "includes/header.php";?>
<?php include "includes/navigation.php";?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Web technologies
                <small>See what's new!</small>
            </h1>

            <?php

            if(isset($_POST['submit'])) {
                $search = $_POST['search'];

                $query = "SELECT * FROM posts WHERE (post_tags LIKE '%$search%' OR post_title LIKE '%$search%') AND post_status = 'published'";

                $search_query = mysqli_query($connection, $query);
            
                if(!$search_query) {
                    die("Query failed " . mysqli_error($connection));
                }
            
                $count = mysqli_num_rows($search_query);
                if($count == 0) {
                    echo "<h2>No result</h2>";
                } else {
                    while($row = mysqli_fetch_assoc($search_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0, 200);;
                        ?>

                        <!-- First Blog Post -->
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
                }
            
            }?>
        </div>
        <!-- Blog sidebar widgets column -->
        <?php include "includes/sidebar.php"; ?>
    </div>
</div>
<!-- /.row -->
<?php include "includes/footer.php"; ?>