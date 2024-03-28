<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // ---- USER VARIABLES ----

    // User variables
    $username = htmlspecialchars($_POST['username']);
    $user_pwd = htmlspecialchars($_POST['password']);

    // ---- INCORRECT FORM ----

    // If username field is empty
    if(empty($username))
    {
        // Show an error message
        echo "<p>Error : no username.</p>";

        // End script
        die();
    }

    // If password is empty
    if(empty($user_pwd))
    {
        // Show an error message
        echo "<p>Error : no password.</p>";

        // End script
        die();
    }

    // ---- CORRECT FORM ----

    // If both fields are set and filled
    if(isset($username) && !empty($username) && isset($user_pwd) && !empty($user_pwd))
    {
        // Try to find the account
        try
        {
            // Preparation of a query to check if username and password both exist and belong to the same account
            $account_existence_check = $db->prepare("SELECT username, hashed_password FROM users WHERE username = :username");

            // Binding
            $account_existence_check->bindValue(":username", $username);

            // Execution
            $account_existence_check->execute();

            // Fetch result row
            $result = $account_existence_check->fetch(PDO::FETCH_ASSOC);

            // ---- CHECKS ----
            // If username does not exist
            if(!$result)
            {
                // Say it
                echo "<p>Error : username does not exist in the database.</p>";
            }

            // If username exists but the table's hashed password is different from the form's password
            if($result && !password_verify($user_pwd, $result['hashed_password']))
            {
                // Confirm that the password does not exist in the database
                echo "<p>Error : password does not exist in the database.</p>";
            }

            // If username exists table's username is set and table's username equals form's username
            if ($result && isset($result["username"]) && $result["username"] === $username)
            {
                // Confirm that the username exists in the database
                echo "<p>Username exists in the database.</p>";
            }

            // If username exists and the table's hashed password equals the form's password
            if($result && password_verify($user_pwd, $result['hashed_password']))
            {
                // Confirm that the password does exist in the database
                echo "<p>Password exists in the database.</p>";
            }

            // ---- CORRECT CASE ----
            // If both username and password exist and are set
            if($result && isset($result["username"]) && isset($result["hashed_password"]) && password_verify($user_pwd, $result['hashed_password']))
            {

                // Confirm that the account exists
                echo "<p>An account with both this username and this password does exist in the database.</p>";

                // SESSION START
                session_start();

                // Store session in the superglobal
                $_SESSION['username'] = $username;

                // Lead user to their page
                header("Location: user_page.php");
            }

            // Closing
            $account_existence_check->closeCursor();
        }

        // Catch any error
        catch(Exception $exc)
        {
            // Output an error message
            echo "<p>Exception catched during account existence check  : " . $exc->getMessage() . "</p>";

            // End script
            exit;
        }
    }
?>