<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // ---- USER VARIABLES ----

    // New user form variables
    $mail = $_GET["mail"];

    // ---- INCORRECT FORM ----

    // If mail field is empty
    if(empty($mail))
    {
        // Show an error message
        echo "<p>Error : mail field is empty.</p>";

        // End this script
        exit;
    }

    // ---- CORRECT FORM ----

    // If mail field is set and filled
    else if(isset($mail) && !empty($mail))
    {
        // Try to count identical mails
        try
        {
            // Query to count number of identical mails
            $count_identical_mails = $db->prepare("SELECT COUNT(*) as count FROM users WHERE mail = :mail");

            // Binding
            $count_identical_mails->bindValue(":mail", $mail);

            // Execution
            $count_identical_mails->execute();

            // Fetch result
            $result = $count_identical_mails->fetch(PDO::FETCH_ASSOC);
            $count = $result["count"];

            // Closing
            $count_identical_mails->closeCursor();

            // Response
            echo $count;
        }

        // Catch any error
        catch(Exeption $exc)
        {
            // Output an error message
            echo "<p>Exception caught during count of identical mails : " . $exc->getMessage() . "</p>";

            // End script
            exit;
        } 
    }
?>