<?php include "includes/admin_header.php";?>

    <div id="wrapper">

        <?php include "includes/admin_navigation.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the admin area,

                            <?php 
                            echo $_SESSION['username'];

                            ?>
                            <small>Dashboard</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-clipboard fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php 
                                        $query = "SELECT * FROM posts";

                                        $select_posts_query = mysqli_query($connection, $query);
                                        if(!$select_posts_query) {
                                            die("Query error: " . mysqli_error($connection));
                                        }

                                        $post_count = mysqli_num_rows($select_posts_query);
                                        ?>
                                        <div class="huge"><?php echo $post_count;?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                            $query = "SELECT * FROM comments";
                                            $select_comments_query = mysqli_query($connection, $query);

                                            if(!$select_comments_query) {
                                                die("Query error: " . mysqli_error($connection));
                                            }

                                            $comments_count = mysqli_num_rows($select_comments_query);
                                        ?>
                                        <div class="huge"><?php echo $comments_count;?></div>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                            $sql = "SELECT * FROM users";
                                            $select_users_query = $connection->query($sql);

                                            if(!$select_users_query) {
                                                die("Query error: " . mysqli_error($connection));
                                            }

                                            $users_count = $select_users_query->num_rows;
                                        ?>
                                        <div class="huge"><?php echo $users_count;?></div>
                                        <div>Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php

                                        $sql = "SELECT * from categories";
                                        $select_categories_query = $connection->query($sql);

                                        if(!$select_categories_query) {
                                            die("Query error: " . mysqli_error($connection));
                                        }

                                        $categories_count = $select_categories_query->num_rows;
                                        ?>
                                        <div class="huge"><?php echo $categories_count;?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">

                <?php
                // Draft posts
                $sql = "SELECT * FROM posts WHERE post_status = 'draft'";
                $select_draft_posts_query = $connection->query($sql);
                $draft_posts_count = $select_draft_posts_query->num_rows;

                // Published posts
                $sql = "SELECT * FROM posts WHERE post_status = 'published'";
                $select_published_posts_query = $connection->query($sql);
                $published_posts_count = $select_published_posts_query->num_rows;

                // Unapproved comments
                $sql = "SELECT * FROM comments WHERE comment_status = 'Unapproved'";
                $select_unapproved_comments_query = $connection->query($sql);
                $unapproved_comments_count = $select_unapproved_comments_query->num_rows;

                // Admin users
                $sql = "SELECT * FROM users WHERE user_role = 'admin'";
                $select_admin_users_query = $connection->query($sql);
                $admin_users_count = $select_admin_users_query->num_rows;

                // Subscribers
                $sql = "SELECT * FROM users WHERE user_role='subscriber'";
                $select_subscribers_query = $connection->query($sql);
                $subscribers_count = $select_subscribers_query->num_rows;
                ?>
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                                <?php
                                    $elements_array = array(
                                        "Posts" => $post_count,
                                        "Draft posts" => $draft_posts_count,
                                        "Published posts" => $published_posts_count,
                                        "Comments" => $comments_count,
                                        "Unapproved comments" => $unapproved_comments_count,
                                        "Admins" => $admin_users_count,
                                        "Subscribers" => $subscribers_count,
                                        "Categories" => $categories_count
                                    );

                                    foreach($elements_array as $element_key => $element_value) {
                                        echo "['$element_key', $element_value],";
                                    }
                                ?>
                            ]);

                            var options = {
                            chart: {
                                title: 'CMS Content Status'
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include "includes/admin_footer.php";?>