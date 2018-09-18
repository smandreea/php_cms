<?php include "includes/admin_header.php";?>
    <div id="wrapper">
        <?php include "includes/admin_navigation.php";?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comments
                            <small>View/approve/unapprove/delete</small>
                        </h1>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($_GET['id'])) {
                                $post_comments_id = $_GET['id'];
                            }
                            $query = "SELECT * FROM comments WHERE comment_post_id = '{$post_comments_id}'";
                            $select_all_comments_query = mysqli_query($connection, $query);

                            while($row = mysqli_fetch_assoc($select_all_comments_query)) {
                                $comment_id = $row['comment_id'];
                                $comment_author = $row['comment_author'];
                                $comment_email = $row['comment_email'];
                                $comment_content = $row['comment_content'];
                                $comment_status = $row['comment_status'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_date = $row['comment_date'];
                            ?>
                            
                                <tr>
                                    <td><?php echo $comment_id;?></td>
                                    <td><?php echo $comment_author;?></td>
                                    <td><?php echo $comment_content;?></td>
                                    <td><?php echo $comment_email;?></td> 
                                    <td><?php echo $comment_status;?></td>
                                    <?php

                                    $post_title_query = "SELECT * from posts WHERE post_id = '{$comment_post_id}'";
                                    $post_title_query_result = mysqli_query($connection, $post_title_query);

                                    while($row = mysqli_fetch_assoc($post_title_query_result)) {
                                        $post_title = $row['post_title'];?>
                                    <td><a href="../post.php?p_id=<?php echo $comment_post_id;?>"><?php echo $post_title;?></a></td><?php } ?>
                                    <td><?php echo $comment_date;?></td>
                                    
                                    <td><a href="post_comments.php?id=<?php echo $_GET['id'];?>&approve_comment=<?php echo $comment_id;?>">Approve</a></td>
                                    <td><a href="post_comments.php?id=<?php echo $_GET['id'];?>&unapprove_comment=<?php echo $comment_id;?>">Unapprove</a></td>
                                    <td><a href="post_comments.php?id=<?php echo $_GET['id'];?>&delete_comment=<?php echo $comment_id;?>">Delete</a></td><?php } ?>
                                </tr>
                                <?php 
                                
                                if(isset($_GET['delete_comment'])) {
                                    $comment_id = $_GET['delete_comment'];
                                
                                    $query = "DELETE FROM comments WHERE comment_id='{$comment_id}'";
                                    $delete_comment_query = mysqli_query($connection, $query);

                                    confirmQuery($delete_comment_query);
                                    header("Location: post_comments.php?id=" . $post_comments_id . "");

                                    $update_comment_count = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = '{$comment_post_id}' ";

                                    $update_comment_count_query = mysqli_query($connection, $update_comment_count);

                                    if(!$update_comment_count_query) {
                                        die ("Query error: " . mysqli_error($connection));
                                    }
                                }

                                if(isset($_GET['unapprove_comment'])) {
                                    $comment_id = $_GET['unapprove_comment'];
                                    $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = '{$comment_id}'";
                                    $unapprove_comment_query = mysqli_query($connection, $query);

                                    confirmQuery($unapprove_comment_query);
                                    header("Location: post_comments.php?id=" . $post_comments_id . "");
                                }

                                if(isset($_GET['approve_comment'])) {
                                    $comment_id = $_GET['approve_comment'];

                                    $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = '{$comment_id}'";
                                    $approve_comment_query = mysqli_query($connection, $query);

                                    confirmQuery($approve_comment_query);
                                    header("Location: post_comments.php?id=" . $post_comments_id . "");
                                }
                                ?>
                                </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
<?php include "includes/admin_footer.php";?>