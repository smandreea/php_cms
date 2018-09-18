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
            if(isset($_GET['p_id'])) {
                $p_id = $_GET['p_id'];
            }

            $sql = "SELECT * FROM posts WHERE post_status = 'Published'";
            $count_posts_query = $connection->query($sql);

            $no_of_rows = $count_posts_query->num_rows;

            $posts_per_page = 4;

            $no_of_rows = $no_of_rows / $posts_per_page;
            $no_of_rows = ceil($no_of_rows);

            

            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                // trebuie -$posts_per_page pentru ca pe prima pagina vor aparea primele $posts_per_page care trebuie scazute ulterior
                $page_1 = ($page * $posts_per_page) - $posts_per_page;
            }

            $query = "SELECT * FROM posts WHERE post_status = 'Published' LIMIT $page_1, $posts_per_page";
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
                $post_content = substr($row['post_content'], 0, 200);
                $post_status = $row['post_status'];
                
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
                <p class="not-formatted"><?php echo $post_content;?></p>
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
<ul class="pager">
    <?php
    for($i = 1; $i <= $no_of_rows; $i++) { 

    if($i == $page) { ?>
        <li><a href="?page=<?php echo $i;?>" class="active_page"><?php echo $i;?></a></li>
        <?php
    } else { ?>
        <li><a href="?page=<?php echo $i;?>"><?php echo $i;?></a></li>
        <?php
    }
    }
    ?>
</ul>
<?php include "includes/footer.php"; ?>