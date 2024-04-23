<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // If user is not logged in
    if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
    {
        // Show it
        echo "<p>Error : You're is not logged in.</p>";

        // End script
        exit;
    }

    // If user is logged in
    else if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
    {
        // Story comment ID
        $story_comment_id = $_GET["story_comment_id"];

        // Test
        // echo "<p>Story comment ID :</p>";   
        // var_dump($story_comment_id);
        // exit;

        // Try to delete the story comment
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- DELETE STORY COMMENT ---- //
            // Prepare query
            $delete_story_comment = $db->prepare("DELETE FROM comments WHERE story_id = :story_id");

            // Binding
            $delete_story_comment->bindValue(":story_id", $story_comment_id);

            // Execution    
            $delete_story_comment->execute();

            // Process database modification
            $db->commit();
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Show error
            echo "<p>Exception caught during story comment deletion :".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>