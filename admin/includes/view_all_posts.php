<?php 

if(isset($_POST['checkBoxesArray'])) {
    foreach($_POST['checkBoxesArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options) {
            case "published": 
            $update_status = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkBoxValue}'";
            $connection->query($update_status);
            break;

            case "draft":
            $update_status = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkBoxValue}'";
            $connection->query($update_status);
            break;

            case "delete":
            $delete_posts = "DELETE FROM posts WHERE post_id = '{$checkBoxValue}'";
            $connection->query($delete_posts);
            break;

            case "clone":
            $post_user = $_SESSION['user_id'];
            $sql = "SELECT * FROM posts WHERE post_id = '{$checkBoxValue}'";
            $select_post_to_be_cloned_query = $connection->query($sql);
            confirmQuery($select_post_to_be_cloned_query);

            while($row = mysqli_fetch_assoc($select_post_to_be_cloned_query)) {
                $post_title = $row['post_title'];
                $post_category = $row['post_category_id'];
                $post_author = $row['post_author'];
                
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_content = $row['post_content'];
                $post_date = $row['post_date'];
                $post_comment_count = $row['post_comment_count'];
            }
            
            $sql = "INSERT INTO posts (post_title, post_category_id, post_author, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES ('{$post_title}', '{$post_category}', '{$post_author}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";

            $insert_cloned_post_query = $connection->query($sql);
            confirmQuery($insert_cloned_post_query);
            break;
        }
    }
}
?>

<form action="" method="post"> 
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4 form-group">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply" onClick = "javascript: return confirm('Please confirm the selected action'); ">
            <a href="?source=add_post" class="btn btn-primary">Add post</a>
        </div>
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes"></th>
                <th>ID</th>
                <th>Author</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $select_all_posts_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_user = $row['post_user'];
            $post_title = $row['post_title'];
            $post_category = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_date = $row['post_date'];
            $post_views = $row['post_views'];?>
    
            <tr>
                <td><input type="checkbox" class="checkBoxes" name="checkBoxesArray[]" value="<?php echo $post_id;?>"></td>
                <td><?php echo $post_id;?></td>
                <td><?php echo $post_author;?></td>
                <?php

                $query = "SELECT * FROM users WHERE user_id = '{$post_user}'";
                $show_user = mysqli_query($connection, $query);

                confirmQuery($show_user);

                while($row = mysqli_fetch_assoc($show_user)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                ?>
                <td><?php echo $username;?></td>  <?php } ?>
                <td><a href="../post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title;?></a></td>

                <?php

                $query = "SELECT * FROM categories WHERE cat_id = '{$post_category}'";
                $show_category_query = mysqli_query($connection, $query);

                confirmQuery($show_category_query);

                while($row = mysqli_fetch_assoc($show_category_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                
                ?>
                <td><?php echo $cat_title;?></td> <?php } ?>
                <td><?php echo $post_status;?></td>
                <td><?php echo "<img src='../images/".$post_image.".' width='90px'";?></td>
                <td><?php echo $post_tags;?></td>
                <?php
                $sql = "SELECT * FROM comments WHERE comment_post_id = '$post_id'";
                $comments_no_query = $connection->query($sql);

                $comments_no = $comments_no_query->num_rows;
                ?>

                <td><a href="post_comments.php?id=<?php echo $post_id?>"><?php echo $comments_no;?></a></td>
                <td><?php echo $post_views;?></td>
                <td><?php echo $post_date;?></td>
                <td><a href="?source=edit_post&p_id=<?php echo $post_id;?>">Edit</a></td>
                <td><a onClick = "javascript: return confirm('Are you sure that you want to delete this post?'); " href="?delete=<?php echo $post_id;?>">Delete</a></td>
            </tr>
        <?php }
        
        
        if(isset($_GET['delete'])) {
            $post_id = $_GET['delete'];
        
        $query = "DELETE FROM posts WHERE post_id='{$post_id}'";
        $delete_post_query = mysqli_query($connection, $query);

        confirmQuery($delete_post_query);
        header('Location: posts.php');
        
        $query = "DELETE FROM comments WHERE comment_post_id='{$post_id}'";
        $result = $connection->query($query);
        confirmQuery($result);
        }
        // if(isset($_GET['edit_post'])) {
        //     $edit_post_id = $_GET['p_id'];
        // }
        
        ?>
        </tbody>
    </table>
</form>