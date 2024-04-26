<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL's old password
    $url_old_password = htmlspecialchars($_GET["old_password"]);

    // If old password exists
    if(isset($url_old_password) && !empty($url_old_password))
    {
        // Test
        // echo "<p>Old password : </p>";
        // var_dump($url_old_password);
        // exit;

        // Prepare query to get user's hashed password
        $get_user_hashed_password = $db->prepare("SELECT hashed_password FROM users WHERE user_id = :user_id");

        // Binding
        $get_user_hashed_password->bindValue(":user_id", $user_id);

        // Execution
        $get_user_hashed_password->execute();

        // Store result
        $user_hashed_password = $get_user_hashed_password->fetchColumn();

        // Test
        // echo "<p>User's hashed password :</p>";
        // var_dump($user_hashed_password);
        // exit;

        // If passwords are identical
        if(password_verify($url_old_password, $user_hashed_password))
        {
            echo "<p style='color: rgb(0, 120, 0);'>Password is yours.</p>";
        }

        // If passwords are not identical
        else if(!password_verify($url_old_password, $user_hashed_password))
        {
            echo "<p style='color: rgb(120, 0, 0);'>Password is not yours.</p>";
        }
    }

    // If old password does not exist
    else if(!isset($url_old_password) || empty($url_old_password))
    {
        // Show error
        echo "<p>Error : old password does not exist.</p>";

        // End script
        exit;
    }
?>