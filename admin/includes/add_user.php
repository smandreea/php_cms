<?php
    if(isset($_POST['create_user'])) {
        $username = $_POST['username'];

        $user_password = $_POST['user_password'];
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        
        $user_role = $_POST['user_role'];

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];

        move_uploaded_file($user_image_temp, "../images/users/$user_image");

        $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_role, user_image) VALUES ('{$username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_role}', '{$user_image}') ";

        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);

        if($create_user_query) {
            echo "<h4>User created successfully!</h4>";
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-6">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" name="user_password" class="form-control">
        </div>

        <div class="form-group">
            <label for="user_firstname">Firstname</label>
            <input type="text" name="user_firstname" class="form-control">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="user_lastname">Lastname</label>
            <input type="text" name="user_lastname" class="form-control">
        </div>

        <div class="form-group">
            <label for="user_email">Email</label>
            <input type="email" name="user_email" class="form-control">
        </div>

        <div class="form-group">
            <label for="user_role">Role</label>
            <select name="user_role" class="form-control">
                <option value="admin">Admin</option>
                <option value="subscriber">Subscriber</option>
            </select>
        </div>
    </div>
        
    <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="user_image" >
    </div>

    <div class="form-group">
        <input type="submit" name="create_user" value="Create User" class="btn btn-primary">
    </div>
</form>