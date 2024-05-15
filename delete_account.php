<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // User ID
    $user_id = htmlspecialchars($_GET["user_id"]);

    // If user ID does not exists
    if(!isset($user_id) || empty($user_id))
    {
        // Error message
        echo "<p>Error : no user ID.</p>";

        // End script
        exit;
    }

    // If user ID exists
    else if(isset($user_id) && !empty($user_id))
    {
        /*
            Try to delete user's : 

            1) comments,         
            2) chapters,
            3) stories,

            Try to remove user's ID from :

            4) chapter comments like IDs,  
            5) chapter comments dislike IDs,  

            6) chapter like IDs, 
            7) chapter dislike IDs,

            8) chapter bookmark IDs,

            9) story comments like IDs,
            10) story comments dislike IDs,

            11) story like IDs.
            12) story dislike IDs.
        */
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- 1) DELETE USER'S COMMENTS ---- //

            // Prepare query
            $delete_comments = $db->prepare("DELETE FROM comments WHERE user_id = :user_id");

            // Binding
            $delete_comments->bindValue(":user_id", $user_id);

            // Execute
            $delete_comments->execute();

            // ---- 2) DELETE USER'S CHAPTERS ---- //

            // GET EVERY STORY

            // Prepare query
            $get_story_ids = $db->prepare("SELECT story_id FROM stories WHERE user_id = :user_id");

            // Binding
            $get_story_ids->bindValue(":user_id", $user_id);

            // Execution
            $get_story_ids->execute();

            // Store story IDs
            $story_ids = $get_story_ids->fetchAll(PDO::FETCH_ASSOC);

            // Test
            // echo "<p>Story IDs of user $user_id :</p>";
            // var_dump($story_ids);
            // var_dump(count($story_ids));
            // exit;

            // For every story
            for($i = 0; $i < count($story_ids); $i++)
            {
                // ---- GET ITS CHAPTERS ---- //

                // Prepare query
                $get_chapter_ids = $db->prepare("SELECT chapter_ids FROM stories WHERE story_id = :story_id");

                // Binding
                $get_chapter_ids->bindValue(":story_id", $story_ids[$i]["story_id"]);

                // Execution
                $get_chapter_ids->execute();

                // Store result
                $chapter_ids = $get_chapter_ids->fetchAll(PDO::FETCH_ASSOC);

                // Test
                // echo "<p>Chapter IDs of story".$story_ids[$i]["story_id"]." :</p>";
                // var_dump($chapter_ids);
                // exit;

                // ---- DELETE ITS CHAPTERS ---- //

                // For every chapter
                for($i = 0; $i < count($chapter_ids); $i++)
                {
                    // DELETE IT

                    // Prepare query
                    $delete_chapter = $db->prepare("DELETE FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $delete_chapter->bindValue(":chapter_id", $chapter_ids[$i]["chapter_id"]);

                    // Execution
                    $delete_chapter->execute();
                }

                // ---- 3) DELETE USER'S STORIES  ---- //

                // Prepare query
                $delete_story = $db->prepare("DELETE FROM stories WHERE story_id = :story_id");

                // Binding
                $delete_story->bindValue(":story_id", $story_ids[$i]["story_id"]);

                // Execute
                $delete_story->execute();
            }

            // --- DELETE ACCOUNT ---- //
            // Prepare query
            $delete_user = $db->prepare("DELETE FROM users WHERE user_id = :user_id");

            // Binding
            $delete_user->bindValue(":user_id", $user_id);

            // Execution
            $delete_user->execute();
            
            // Process database modification
            $db->commit();
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Log and Output error message
            error_log("Exception caught during account deletion : ".$exc->getMessage());
            echo "<p>Exception caught during account deletion : ".$exc->getMessage()."</p>";

            // End script
            exit();
        }
    }
?>