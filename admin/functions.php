<?php

function confirmQuery($result) {
    global $connection;
    
    if(!$result) {
        die("Query error: " . mysqli_error($connection));
    }
}

function insert_category() {
    global $connection;

    if(isset($_POST['submit'])) {

        if(!empty($_POST['cat_title'])) {

            $add_category = $_POST['cat_title'];
            $query = "INSERT INTO categories (cat_title) VALUES ('{$add_category}')";
            $create_category_query = mysqli_query($connection, $query);

            if(!$create_category_query) {
                die("Query failed: " . mysqli_error($connection));
            }
            
        } else {
            echo "<h3>Please insert a category</h2>";
        }
    }
}

function find_all_categories() {
    global $connection;

    $query = "SELECT * FROM categories";

    $get_all_categories_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($get_all_categories_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title']; ?>
        <tr>
            <td><?php echo $cat_id;?></td>
            <td><?php echo $cat_title;?></td>
            <td><a href="categories.php?delete=<?php echo $cat_id;?>">Delete</a></td>
            <td><a href="categories.php?update=<?php echo $cat_id;?>">Update</a></td>
        </tr>
        <?php
    }
}

function delete_category() {
    global $connection;
    
    if(isset($_GET['delete'])) {
        $cat_to_be_deleted = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id = '{$cat_to_be_deleted}'";
        $delete_category_query = mysqli_query($connection, $query);

        header("Location: categories.php");
    }
}
    
function users_online() {
    global $connection;

    $session = session_id();
    $time = time();
    $time_out_in_seconds = 10;

    $time_out = $time - $time_out_in_seconds;

    $sql = "SELECT * FROM users_online WHERE session = '{$session}'";
    $users_online = $connection->query($sql);

    confirmQuery($users_online);

    $count = $users_online->num_rows;

    if($count == NULL){
    $connection->query("INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
    $connection->query("UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $sql = "SELECT * FROM users_online WHERE time > '{$time_out}'";
    $users_online_query = $connection->query($sql);

    confirmQuery($users_online_query);

    return $count_online_users = $users_online_query->num_rows;
}