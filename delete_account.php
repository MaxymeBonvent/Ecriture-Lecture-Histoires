<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // User ID
    $user_id = htmlspecialchars($_GET["user_id"]);

    // Try to delete user's comments chapters, stories, and account
    try
    {
        // BEGIN TRANSACTION
        $db->beginTransaction();

        // ---- 0. DELETE EVERY COMMENT FROM USER ---- //
        // Prepare query
        $delete_comments = $db->prepare("DELETE FROM comments WHERE user_id = :user_id");

        // Binding
        $delete_comments->bindValue(":user_id", $user_id);

        // Execution
        $delete_comments->execute();

        // ---- 1. GET EVERY STORY AND CHAPTER IDS WRITTEN BY USER ---- //

        // Prepare a query to get every story written by user
        $get_stories = $db->prepare("SELECT story_title, chapter_ids FROM stories WHERE user_id = :user_id");

        // Binding
        $get_stories->bindValue(":user_id", $user_id);

        // Execution
        $get_stories->execute();

        // Store result
        $story_titles_and_chapter_ids = $get_stories->fetchAll(PDO::FETCH_ASSOC);

        // Closing
        $get_stories->closeCursor();

        // ---- 2. FOR EVERY STORY, PUT ITS CHAPTERS IDS IN AN ARRAY ---- //

        // For every story
        for($i = 0; $i < count($story_titles_and_chapter_ids); $i++)
        {
            // Put each chapter ID of the current story in an array
            $current_story_chapter_ids = explode("  ", $story_titles_and_chapter_ids[$i]["chapter_ids"]);

            // Test
            var_dump($current_story_chapter_ids);

            // For each chapter ID of the current story
            for($j = 0; $j < count($current_story_chapter_ids); $j++)
            {
                // ---- 3. FOR EVERY CHAPTER ID, DELETE ITS CHAPTER ROW ---- //

                // Prepare a query to delete chapters of given IDs
                $delete_chapter = $db->prepare("DELETE FROM chapters WHERE chapter_id = :chapter_id");

                // Binding
                $delete_chapter->bindValue(":chapter_id", $current_story_chapter_ids[$j]);

                // Execution
                $delete_chapter->execute();
            }
        }  

        // ---- 4. DELETE ALL STORIES ---- //

        // Prepare a query to delete all stories of the user
        $delete_stories = $db->prepare("DELETE FROM stories WHERE user_id = :user_id");

        // Binding
        $delete_stories->bindValue(":user_id", $user_id);

        // Execution
        $delete_stories->execute();

        // ---- 5. DELETE ACCOUNT ---- //

        // Prepare a query to delete user's account
        $delete_user = $db->prepare("DELETE FROM users WHERE user_id = :user_id");

        // Binding
        $delete_user->bindValue(":user_id", $user_id);

        // Execution
        $delete_user->execute();

        // COMMIT TRANSACTION
        $db->commit();

        // ---- 6. REDIRECTION ---- //

        // Redirect user to account deletion confirmation page
        header("Location: user_delete_confirm.php");

        // End script
        exit();
    }

    // Catch any exception
    catch(Exception $exc)
    {
        // CANCEL TRANSACTION
        $db->rollBack();

        // Log and Output error message
        error_log("Exception caught during account deletion : ".$exc->getMessage());
        echo "<p>Exception caught during account deletion : ".$exc->getMessage()."</p>";
    }
?>