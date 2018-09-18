<?php include "includes/header.php";?>

<?php include "includes/navigation.php";?>

<?php

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    if(!empty($username) && !empty($user_email) && !empty($user_password)) {

        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        // $sql = "SELECT randSalt FROM users";
        // $select_randSalt_query = $connection->query($sql);

        // if($select_randSalt_query === FALSE) {
        //     echo "Error: " . $sql . "<br>" . $connection->error;
        //     die();
        // }

        // $row = mysqli_fetch_array($select_randSalt_query);
        // $salt = $row['randSalt'];

        // $hashed_password = crypt($user_password, $salt);

        $sql = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$user_email}', '{$user_password}', 'subscriber')";

        if($connection->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $connection->error;
            die();
        }
        $message = "Your registration has been submitted!";
    } else {
        $message = "Fields cannot be empty";
    }
} else {
    $message ="";
}

?>
<div class="container">
    <section id = "login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <h6 class="text-center"><?php echo $message;?></h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required="true">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Desired email" required="true">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Desired password" required="true">
                            </div>
                            <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "includes/footer.php";?>