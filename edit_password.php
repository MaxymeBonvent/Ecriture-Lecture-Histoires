<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL VARIABLES
    $old_pwd = htmlspecialchars($_GET["old_password"]);
    $new_pwd = htmlspecialchars($_GET["new_password"]);
    $repeat_new_pwd = htmlspecialchars($_GET["repeat_new_password"]);

    // If old password does not exist
    if(!isset($old_pwd) || empty($old_pwd))
    {
        // Show error message
        echo "<p>Error : old password not received.</p>";

        // End script
        exit;
    }

    // If new password does not exist
    else if(!isset($new_pwd) || empty($new_pwd))
    {
        // Show error message
        echo "<p>Error : new password not received.</p>";

        // End script
        exit;
    }

    // If repeated new password does not exist
    else if(!isset($repeat_new_pwd) || empty($repeat_new_pwd))
    {
        // Show error message
        echo "<p>Error : repeated new password not received.</p>";

        // End script
        exit;
    }

    // If new passwords are not identical
    else if($new_pwd != $repeat_new_pwd)
    {
        // Show error message
        echo "<p>Error : new passwords are not identical.</p>";

        // End script
        exit;
    }

    // If every variable exist and new passwords are identical
    else if(isset($old_pwd) && !empty($old_pwd) && isset($new_pwd) && !empty($new_pwd) && isset($repeat_new_pwd) && !empty($repeat_new_pwd) && $new_pwd == $repeat_new_pwd)
    {
        // Try to change user's password
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- HASH NEW PASSWORD ---- //
            $hashed_new_pwd = password_hash($repeat_new_pwd, PASSWORD_DEFAULT);

            // ---- CHANGE USER'S PASSWORD ---- //
            // Prepare query
            $edit_password = $db->prepare("UPDATE users SET hashed_password = :hashed_password WHERE user_id = :user_id");

            // Binding
            $edit_password->bindValue(":user_id", $user_id);
            $edit_password->bindValue(":hashed_password", $hashed_new_pwd);

            // Execution
            $edit_password->execute();

            // Process database modification
            $db->commit();

            // ---- REDIRECTION ---- //
            // Redirect user to confirmation page
            header("Location: password_edit_confirm.php");
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Show error message
            echo "<p>Exception caught during password edition : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>