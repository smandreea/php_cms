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
    $query = "SELECT * FROM comments";
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

            <?php

            // $query = "SELECT * FROM categories WHERE cat_id = '{$post_category}'";
            // $show_category_query = mysqli_query($connection, $query);

            // confirmQuery($show_category_query);

            // while($row = mysqli_fetch_assoc($show_category_query)) {
            //     $cat_id = $row['cat_id'];
            //     $cat_title = $row['cat_title'];
            

            ?>
            <td><?php echo $comment_email;?></td> 
            <td><?php echo $comment_status;?></td>
            <?php

            $post_title_query = "SELECT * from posts WHERE post_id = '{$comment_post_id}'";
            $post_title_query_result = mysqli_query($connection, $post_title_query);

            while($row = mysqli_fetch_assoc($post_title_query_result)) {
                $post_title = $row['post_title'];?>
            <td><a href="../post.php?p_id=<?php echo $comment_post_id;?>"><?php echo $post_title;?></a></td><?php } ?>
            <td><?php echo $comment_date;?></td>
            
            <td><a href="?approve=<?php echo $comment_id;?>">Approve</a></td>
            <td><a href="?unapprove=<?php echo $comment_id;?>">Unapprove</a></td>
            <td><a href="?delete_comment=<?php echo $comment_id;?>">Delete</a></td><?php } ?>

            <!-- daca get[status] = approved -> db cu approved si apare -->
        </tr>
    <?php 
      
    
    if(isset($_GET['delete_comment'])) {
        $comment_id = $_GET['delete_comment'];
    
        $query = "DELETE FROM comments WHERE comment_id='{$comment_id}'";
        $delete_comment_query = mysqli_query($connection, $query);

        confirmQuery($delete_comment_query);
        header('Location: comments.php');

        $update_comment_count = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = '{$comment_post_id}' ";

        $update_comment_count_query = mysqli_query($connection, $update_comment_count);

        if(!$update_comment_count_query) {
            die ("Query error: " . mysqli_error($connection));
        }
    }

    if(isset($_GET['unapprove'])) {
        $comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = '{$comment_id}'";
        $unapprove_comment_query = mysqli_query($connection, $query);

        confirmQuery($unapprove_comment_query);
        header('Location: comments.php');
    }

    if(isset($_GET['approve'])) {
        $comment_id = $_GET['approve'];

        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = '{$comment_id}'";
        $approve_comment_query = mysqli_query($connection, $query);

        confirmQuery($approve_comment_query);
        header('Location: comments.php');
    }

    // if(isset($_GET['edit_post'])) {
    //     $edit_post_id = $_GET['p_id'];
    // }
    
    ?>
    </tbody>
</table>