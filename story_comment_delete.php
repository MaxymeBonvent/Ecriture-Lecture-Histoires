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
        // Store URL's story comment ID
        $story_comment_id = htmlspecialchars($_GET["story_comment_id"]);

        // Test
        // echo "<p>Story comment ID :</p>";   
        // var_dump($story_comment_id);
        // exit;

        // If URL's story comment ID exists and is a number
        if(isset($story_comment_id) && !empty($story_comment_id) && is_numeric($story_comment_id))
        {
            // Try to delete the story comment
            try
            {
                // Start database modification
                $db->beginTransaction();

                // ---- DELETE STORY COMMENT ---- //
                // Prepare query
                $delete_story_comment = $db->prepare("DELETE FROM comments WHERE comment_id = :comment_id");

                // Binding
                $delete_story_comment->bindValue(":comment_id", $story_comment_id);

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

        // If URL's story comment ID doesn't exist or isn't a number
        else if(!isset($story_comment_id) || empty($story_comment_id) || !is_numeric($story_comment_id))
        {
            // Show error
            echo "<p>Error : story comment ID doesn't exist or is not a number.</p>";

            // End script
            exit;
        }
    }
?>