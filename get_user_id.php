<?php
    // ---- DATABASE CONNECTION ---- //
    require_once("database_connection.php");

    // --- GET USER ID --- //

    // Prepare query to get logged in user's ID
    $get_user_id = $db->prepare("SELECT user_id FROM users WHERE username = :username");

    // If user is not logged in
    if(!isset($_SESSION['username']) || empty($_SESSION['username']))
    {
        // Output an error message
        echo "<p>Error : you are not logged in.</p>";

        // End script
        exit;
    }

    // If user is logged in
    else if(isset($_SESSION['username']) && !empty($_SESSION['username']))
    {
        // Bind their name to the prepared username variable
        $get_user_id->bindValue(":username", $_SESSION['username']);

        // Execution
        $get_user_id->execute();

        // Fetch result
        $user_id = $get_user_id->fetchColumn();

        // Closing
        $get_user_id->closeCursor();
    }
?>