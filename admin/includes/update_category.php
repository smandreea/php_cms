<form action="" method="post">

    <div class="form-group">
        <label for="update_cat_title">Update Category</label>
        <?php
            if(isset($_GET['update'])) {
                $cat_to_be_updated = $_GET['update'];

                $query = "SELECT * FROM categories WHERE cat_id = '{$cat_to_be_updated}'";
                $category_update_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($category_update_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title']; ?>
                    
                    <input type="text" name="update_cat_title" class="form-control" value="<?php if(isset($cat_title)) {echo $cat_title;}?>">

                <?php }
            }

            if(isset($_POST['update'])) {
                $new_cat_name = $_POST['update_cat_title'];

                $query = "UPDATE categories SET cat_title = '{$new_cat_name}' WHERE cat_id = '{$cat_to_be_updated}'";
                $update_category_name_query = mysqli_query($connection, $query);
            }?>
    </div>
    <div class="form-group">
        <input type="submit" name="update" value="Update category" class="btn btn-primary">
    </div>
</form>