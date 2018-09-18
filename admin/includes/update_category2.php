<form action="" method="post">

<div class="form-group">
        <label for="update_cat_title">Update Category 2</label>
        <?php
            if(isset($_GET['update'])) {
                $cat_to_be_modified = $_GET['update'];

                $query = "SELECT * FROM categories WHERE cat_id='{$cat_to_be_modified}'";
                $catch_category_details_query = mysqli_query($connection, $query);

                if(!isset($catch_category_details_query)) {
                    die("Query error: " . mysqli_error($connection));
                }

                while($row = mysqli_fetch_assoc($catch_category_details_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title']; ?>

                    <input type="text" class="form-control" name="new_category_name" value="<?php if(isset($cat_title)) { echo $cat_title; }?>">
                <?php    
                }
            }

            if(isset($_POST['update'])) {
                $new_category_name = $_POST['new_category_name'];

                $query = "UPDATE categories SET cat_title = '{$new_category_name}' WHERE cat_id = '{$cat_to_be_modified}'";

                $change_category_name_query = mysqli_query($connection, $query);
            }
?>
</div>
<div class="form-group">
    <input type="submit" name="update" value="Update category2" class="btn btn-primary">
</div>
</form>