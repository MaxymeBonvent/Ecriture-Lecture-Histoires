<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // URL VARIABLES
    $chapter_id = htmlspecialchars($_GET["chapter_id"]);
    $user_id = htmlspecialchars($_GET["user_id"]);

    // INCORRECT URL

    // Chapter ID
    if(!isset($chapter_id) || empty($chapter_id))
    {
        // Error message
        echo "Error : no chapter ID.";

        // End script
        exit;
    }

    // User ID
    if(!isset($user_id) || empty($user_id))
    {
        // Error message
        echo "Error : no user ID.";

        // End script
        exit;
    }

    // CORRECT URL
    if(isset($chapter_id) && !empty($chapter_id) && isset($user_id) && !empty($user_id))
    {
        // Try to replace last bookmarked chapter by current chapter
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- REPLACE LAST CHAPTER ID BY CURRENT CHAPTER ID ---- //

            // Prepare a query to replace last bookmarked chapter by current chapter
            $bookmark_chapter = $db->prepare("UPDATE users SET bookmarked_chapter_id = :chapter_id WHERE user_id = :user_id");

            // Binding
            $bookmark_chapter->bindValue(":chapter_id", $chapter_id);
            $bookmark_chapter->bindValue(":user_id", $user_id);

            // Execution
            $bookmark_chapter->execute();
        }

        // Catch any problem
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Output error message
            echo "<p>Exception caught during chapter bookmark : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>