<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // Username
    $username = htmlspecialchars($_GET["username"]);

    // ---- INCORRECT FORM ----

    // If username field is empty
    if(empty($username))
    {
        // Show an error message
        echo "<p>Error : no username.</p>";

        // End this script
        exit;
    }

    // ---- CORRECT FORM ----

    // If there is a username
    else if(!empty($username))
    {
        // Try to count identical usernames
        try
        {
            // Query to count number of identical usernames
            $count_identical_usernames = $db->prepare("SELECT COUNT(*) as count FROM users WHERE username = :username");

            // Binding
            $count_identical_usernames->bindValue(":username", $username);

            // Execution
            $count_identical_usernames->execute();

            // Fetch result
            $result = $count_identical_usernames->fetch(PDO::FETCH_ASSOC);
            $count = $result["count"];

            // Closing
            $count_identical_usernames->closeCursor();

            // Response
            echo $count;
        }

        // Catch any error
        catch(Exeption $exc)
        {
            // Output an error message
            echo "<p>Exception caught during count of identical usernames  : " . $exc->getMessage() . "</p>";

            // End script
            exit;
        }
    }
?>