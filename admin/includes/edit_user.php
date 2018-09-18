<?php

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $query = "SELECT * FROM users WHERE user_id = '{$user_id}'";

    $user_edit_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($user_edit_query)) {
        $old_username = $row['username'];
        $old_user_password = $row['user_password'];
        $old_user_firstname = $row['user_firstname'];
        $old_user_lastname = $row['user_lastname'];
        $old_user_email = $row['user_email'];
        $old_user_image = $row['user_image'];
        $old_user_role = $row['user_role'];
    }
}
    if(isset($_POST['edit_user'])) {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];

        move_uploaded_file($user_image_temp, "../images/users/$user_image");

        if(empty($user_image)) {
        $query = "SELECT * FROM users WHERE user_id = '{$user_id}' ";

        $select_image_query = mysqli_query($connection, $query);

        confirmQuery($select_image_query);

        while($row = mysqli_fetch_assoc($select_image_query)) {
            $user_image = $row['user_image'];
            }
        }

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "UPDATE users set username = '{$username}', user_password = '{$user_password}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_email = '{$user_email}', user_role = '{$user_role}', user_image = '{$user_image}' WHERE user_id = '{$user_id}'" ;

        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);

        if($update_user_query) {
            echo "<h4>User updated successfully!</h4><a href='users.php'>Go Back</a><br/>";
        }
    }

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-6">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $old_username;?>">
        </div>

        <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" name="user_password" class="form-control" value="<?php echo $old_user_password;?>">
        </div>

        <div class="form-group">
            <label for="user_firstname">Firstname</label>
            <input type="text" name="user_firstname" class="form-control" value="<?php echo $old_user_firstname;?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="user_lastname">Lastname</label>
            <input type="text" name="user_lastname" class="form-control" value="<?php echo $old_user_lastname;?>">
        </div>

        <div class="form-group">
            <label for="user_email">Email</label>
            <input type="email" name="user_email" class="form-control" value="<?php echo $old_user_email;?>">
        </div>

        <div class="form-group">
            <label for="user_role">Role</label>
            <select name="user_role" class="form-control">
                <?php if (empty($old_user_role)) { ?>
                    <option value="admin">admin</option>
                    <option value="subscriber">subscriber</option>
                <?php } else { ?>
                <option value="<?php echo $old_user_role;?>"><?php echo $old_user_role;?></option>
                <?php 
                    if($old_user_role === 'admin') {
                        echo 'subscriber';
                        $new_user_role = 'subscriber';
                    } else if ($old_user_role === 'subscriber') {
                        echo 'admin';
                        $new_user_role = 'admin';
                    } ?>
                <option value="<?php echo $new_user_role;?>"><?php echo $new_user_role;?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
        
    <div class="form-group">
        <label for="user_image">Image</label>
        <img src="../images/users/<?php echo $old_user_image;?>" width = "80"/>
        <br/>
        <input type="file" name="user_image" >
    </div>

    <div class="form-group">
        <input type="submit" name="edit_user" value="Edit User" class="btn btn-primary">
    </div>
</form>