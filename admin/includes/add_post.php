<?php
    if(isset($_POST['create_post'])) {
        $post_title = $_POST['post_title'];
        $post_category = $_POST['post_category'];
        $post_author = $_POST['post_author'];
        $post_user = $_POST['post_user'];
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_content = mysqli_real_escape_string($connection, $post_content);
        $post_date = date('d-m-Y');
        // $post_comment_count = 4;

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts (post_title, post_category_id, post_author, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES ('{$post_title}', '{$post_category}', '{$post_author}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";

        $create_post_query = mysqli_query($connection, $query);
        confirmQuery($create_post_query);

        $query2 = "SELECT @the_post_id := MAX(post_id) FROM posts";
        $get_the_id_query2 = mysqli_query($connection, $query2);

        $query3 = "SELECT * FROM posts WHERE post_id = @the_post_id";

        $get_the_id_query3 = mysqli_query($connection, $query3);

        confirmQuery($get_the_id_query3);

        while($row = mysqli_fetch_assoc($get_the_id_query3)){
            $the_new_post_id = $row['post_id'];
        }
        // sau mai simplu
        // $the_new_post_id = mysqli_insert_id($connection);

        if($create_post_query) {
            echo "<h4>Post created successfully!</h4><a href='posts.php'>Go Back</a> or <a href='../post.php?p_id={$the_new_post_id}'>View post</a><br/><br/>";
        }
    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Title</label>
        <input type="text" name="post_title" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_category">Category</label>
        <select name="post_category" class="form-control">
            <?php

                $query = "SELECT * FROM categories";
                $select_categories_query = mysqli_query($connection, $query);

                confirmQuery($select_categories_query);

                while($row = mysqli_fetch_assoc($select_categories_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title']; ?>

                    <option value="<?php echo $cat_id;?>" ><?php echo $cat_title;?></option>
                <?php
                }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Author</label>
        <input type="text" name="post_author" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_user">User</label>
        <select name="post_user" class="form-control">
            <?php

                $query = "SELECT * FROM users";
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
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Image</label>
        <input type="file" name="post_image" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_tags">Tags</label>
        <input type="text" name="post_tags" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_content">Content</label>
        <p>
        <textarea name="post_content" class="form-control" cols="20" rows="10"></textarea>
        </p>
    </div>

    <div class="form-group">
        <input type="submit" name="create_post" value="Publish Post" class="btn btn-primary">
    </div>
</form>