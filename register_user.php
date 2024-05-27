<?php
    // ---- DATABASE CONNECTION ---- //
    require_once("database_connection.php");

    // User variables
    $username = htmlspecialchars($_POST['username']);
    $mail = htmlspecialchars($_POST['mail']);
    $user_pwd = htmlspecialchars($_POST['password']);
    $user_pwd_check = htmlspecialchars($_POST['password_check']);

    // ---- INCORRECT FORM ---- //

    // If username field is empty
    if(empty($username))
    {
        // Show an error message
        echo "<p>Error : no username.</p>";

        // End script
        exit;
    }

    // If mail field is empty
    if(empty($mail))
    {
        // Show an error message
        echo "<p>Error : no mail.</p>";

        // End script
        exit;
    }

    // If password is empty
    if(empty($user_pwd))
    {
        // Show an error message
        echo "<p>Error : no password.</p>";

        // End script
        exit;
    }

    // If password check is empty
    if(empty($user_pwd_check))
    {
        // Show an error message
        echo "<p>Error : no second password.</p>";

        // End script
        exit;
    }

    // If passwords are different
    if($user_pwd != $user_pwd_check)
    {
        // Show an error message
        echo "<p>Error : passwords are different.</p>";

        // End script
        exit;
    }

    // ---- CORRECT FORM ---- //

    // If every field is set and filled and passwords are identical
    if  (   isset($username) && !empty($username) && 
            isset($mail) && !empty($mail) &&  
            isset($user_pwd) && !empty($user_pwd) && 
            isset($user_pwd_check) && !empty($user_pwd_check) && 
            $user_pwd === $user_pwd_check
        )
    {
        // Try to register new user
        try
        {
            // Assign hashed password to a variable
            $hashed_user_pwd = password_hash($user_pwd_check, PASSWORD_DEFAULT); // password_hash expects 2 arguments

            // ---- RERGISTER USER ----//

            // Begin database modification
            $db->beginTransaction();

            // Prepare query
            $register_user = $db->prepare("INSERT INTO users (username, mail, hashed_password) VALUES (:username, :mail, :hashed_password)");

            // Binding
            $register_user->bindValue(":username", $username);
            $register_user->bindValue(":mail", $mail);
            $register_user->bindValue(":hashed_password", $hashed_user_pwd);

            // Execution
            $register_user->execute();

            // ---- RESET USER ID COLUMN ---- //

            // Prepare query
            $reset_user_id = $db->prepare("ALTER TABLE users AUTO_INCREMENT = 1");

            // Execution
            $reset_user_id->execute();

            // Closing
            $register_user->closeCursor();

            // Process database modification
            $db->commit();

            // ---- USER SESSION  ---- //

            // Start session
            session_start();

            // Store session name and mail in superglobals
            $_SESSION['username'] = $username;
            $_SESSION['mail'] = $mail;

            // ---- REDIRECTION ---- //
            header("Location: user_page.php");
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Output an error message
            echo "<p>Exception caught during user registration  : " . $exc->getMessage() . "</p>";

            // End script
            exit;
        } 
    }
?>