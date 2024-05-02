<?php
    // Database connection variables
    $dsn = "mysql:dbname=storiesdb;host=localhost";
    $user = "root";
    $dsn_pwd = "";

    // ---- DATABASE CONNECTION ----

    // Try database connection
    try
    {
        // Database object
        $db = new PDO($dsn, $user, $dsn_pwd);
    }

    // Catch database connection failure
    catch(Exception $exc)
    {
        // Output an error message
        echo "<p>Exception caught during database connection : ".$exc->getMessage()."</p>";

        // End script
        exit;
    }
?>