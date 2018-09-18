<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_all_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
?>
        <tr>
            <td><?php echo $user_id;?></td>
            <td><?php echo $username;?></td>
            <td><?php echo $user_firstname;?></td>
            <td><?php echo $user_lastname;?></td> 
            <td><?php echo $user_email;?></td>
            <td class="image_column"><div style="background: url(../images/users/<?php echo $user_image;?>) 50% 50% no-repeat; background-size: cover;" class="user_image"></div></td>
            <td><?php echo $user_role;?></td>
            <td><a onClick = "javascript: return confirm('Are you sure that you want to delete this user?'); " href="?delete_user=<?php echo $user_id;?>">Delete</a></td>
            <td><a href="?source=edit_user&user_id=<?php echo $user_id;?>">Edit</a></td>
            <?php
    }?>
        </tr>
    <?php 
    
    if(isset($_GET['delete_user'])) {
        if(isset($_SESSION['user_role'])) {
            if($_SESSION['user_role'] == "admin") {
                $user_id = mysqli_real_escape_string($connection, $_GET['delete_user']);
            
                $query = "DELETE FROM users WHERE user_id='{$user_id}'";
                $delete_user_query = mysqli_query($connection, $query);

                confirmQuery($delete_user_query);
                header('Location: users.php');
            }
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
    
    ?>
    </tbody>
</table>