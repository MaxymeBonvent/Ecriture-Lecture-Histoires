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
        // Store URL's chapter comment ID
        $chapter_comment_id = htmlspecialchars($_GET["chapter_comment_id"]);

        // Test
        // echo "<p>Chapter comment ID :</p>";   
        // var_dump($chapter_comment_id);
        // exit;

        // If URL's chapter comment ID exists and is a number
        if(isset($chapter_comment_id) && !empty($chapter_comment_id) && is_numeric($chapter_comment_id))
        {
            // Try to delete the chapter comment
            try
            {
                // Start database modification
                $db->beginTransaction();

                // ---- DELETE CHAPTER COMMENT ---- //
                // Prepare query
                $delete_chapter_comment = $db->prepare("DELETE FROM comments WHERE comment_id = :comment_id");

                // Binding
                $delete_chapter_comment->bindValue(":comment_id", $chapter_comment_id);

                // Execution    
                $delete_chapter_comment->execute();

                // Process database modification
                $db->commit();
            }

            // Catch any exception
            catch(Exception $exc)
            {
                // Cancel database modification
                $db->rollBack();

                // Show error
                echo "<p>Exception caught during chapter comment deletion :".$exc->getMessage()."</p>";

                // End script
                exit;
            }
        }

        // If URL's chapter comment ID doesn't exist or isn't a number
        else if(!isset($chapter_comment_id) || empty($chapter_comment_id) || !is_numeric($chapter_comment_id))
        {
            // Show error
            echo "<p>Error : chapter comment ID doesn't exist or is not a number.</p>";

            // End script
            exit;
        }
    }
?>