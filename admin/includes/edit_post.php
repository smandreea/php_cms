<?php

if(isset($_GET['p_id'])) {
    $post_edited_id = $_GET['p_id'];

    $query = "SELECT * FROM posts WHERE post_id = '{$post_edited_id}'";

    $post_edit_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($post_edit_query)) {
        $old_post_views = $row['post_views'];
        $old_post_title = $row['post_title'];
        $old_post_category = $row['post_category_id'];
        $old_post_author = $row['post_author'];
        $old_post_user = $row['post_user'];
        $old_post_status = $row['post_status'];
        $old_post_image = $row['post_image'];
        $old_post_tags = $row['post_tags'];
        $old_post_content = $row['post_content'];
        $old_post_date = date('d-m-Y');
        $old_post_comment_count = 4;
    }
}
    if(isset($_POST['edit_post'])) {
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category'];
        $post_author = $_POST['post_author'];
        $post_user = $_POST['post_user'];
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_content = mysqli_real_escape_string($connection, $post_content);
        $post_date = date('d-m-Y');
        $post_comment_count = 4;

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if(empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = '{$post_edited_id}' ";

        $select_image_query = mysqli_query($connection, $query);

        confirmQuery($select_image_query);

        while($row = mysqli_fetch_assoc($select_image_query)) {
            $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts set post_title = '{$post_title}', post_category_id = '{$post_category_id}', post_author = '{$post_author}', post_user = '{$post_user}', post_date = now(), post_image = '{$post_image}', post_content = '{$post_content}', post_tags = '{$post_tags}', post_status = '{$post_status}' WHERE post_id = '{$post_edited_id}'" ;

        $update_post_query = mysqli_query($connection, $query);
        confirmQuery($update_post_query);
        // header("Refresh:0");
        
        if($update_post_query) {
            echo "<h4 class='bg-success'>Post updated successfully!</h4><a href='posts.php'>Go Back</a> or <a href='../post.php?p_id={$post_edited_id}'>View post</a><br/><br/>";
        }
    }

    if(isset($_POST['reset_views'])) {
        $sql = "UPDATE posts SET post_views = 0 WHERE post_id = '{$post_edited_id}'";
        $reset_views_query = $connection->query($sql);
        confirmQuery($reset_views_query);

        echo "<h4 class='bg-success'>Views updated!</h4><a href='posts.php'>Go Back</a>";
    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_views">Post Views &nbsp; </label><span class="badge"><?php echo $old_post_views;?></span>
    </div>

    <div class="form-group">
        <label for="post_title">Title</label>
        <input type="text" name="post_title" class="form-control" value="<?php echo $old_post_title;?>">
    </div>

    <div class="form-group">
        <label for="post_category">Category</label>
        <select class="form-control" name="post_category" id="">
            <?php 
                $query = "SELECT * FROM categories WHERE cat_id = '{$old_post_category}'";
                $result = $connection->query($query);

                confirmQuery($result);

                while($row = $result->fetch_assoc()) {
                    $old_post_category_title = $row['cat_title'];
                }
            ?>

            <option value="<?php echo $old_post_category;?>"><?php echo $old_post_category_title;?></option>
            <?php
                $query = "SELECT * FROM categories WHERE cat_id != '{$old_post_category}'";
                $categories_query = mysqli_query($connection, $query);

                confirmQuery($categories_query);

                while($row = mysqli_fetch_assoc($categories_query)) {
                    
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                    
                    ?>

                    <option value="<?php echo $cat_id;?>"><?php echo $cat_title;?></option>

                <?php }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Author</label>
        <input type="text" name="post_author" class="form-control" value="<?php echo $old_post_author;?>">
    </div>

    <div class="form-group">
        <label for="post_user">User</label>
        <select name="post_user" class="form-control">
            <?php
                $query = "SELECT * FROM users WHERE user_id = '{$old_post_user}'";
                $result = $connection->query($query);

                confirmQuery($result);

                while($row = $result->fetch_assoc()) {
                    $old_post_user_name = $row['username'];
                }
            ?>

            <option value="<?php echo $old_post_user;?>" ><?php echo $old_post_user_name;?></option>
            <?php

                $query = "SELECT * FROM users WHERE user_id != '{$old_post_user}'";
                $select_users_query = mysqli_query($connection, $query);

                confirmQuery($select_users_query);

                while($row = mysqli_fetch_assoc($select_users_query)) {
                    $user_id = $row['user_id'];
                    $username = $row['username']; ?>

                    <option value="<?php echo $user_id;?>" ><?php echo $username;?></option>
                <?php
                }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Status</label>

            <select name="post_status" class="form-control">
                <option value="<?php echo $old_post_status;?>"><?php echo ucfirst($old_post_status);?></option>
                <?php
                if($old_post_status == 'draft') { 
                    echo "<option value='published'>Published</option>";
                } else if($old_post_status == 'published') {
                    echo "<option value='draft'>Draft</option>";
                }
                ?>
            </select>
    </div>

    <div class="form-group">
        <img width="100" src="../images/<?php echo $old_post_image;?>"><br><br>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Tags</label>
        <input type="text" name="post_tags" class="form-control" value="<?php echo $old_post_tags;?>">
    </div>

    <div class="form-group">
        <label for="post_content">Content</label>
        <p>
        <textarea name="post_content" class="form-control" cols="20" rows="10"><?php echo $old_post_content;?></textarea>
        </p>
    </div>

    <div class="form-group">
        <input type="submit" name="edit_post" value="Update Post" class="btn btn-primary">
        <input type="submit" name="reset_views" value="Reset Number of Views" class="btn btn-success">
    </div>
</form>