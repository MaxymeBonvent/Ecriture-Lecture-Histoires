<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL'S CHAPTER ID
    $chapter_id = htmlspecialchars($_GET["chapter_id"]);
    // var_dump($story_id);

    // If there's no chapter ID
    if(!isset($chapter_id) || empty($chapter_id))
    {
        // Show error message
        echo "<p>Error : no chapter ID.</p>";

        // End script
        exit;
    }

    // If there's a chapter ID and a user ID
    else if(isset($chapter_id) && !empty($chapter_id) && isset($user_id) && !empty($user_id))
    {
        // Try to add a dislike to the chapter
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- GET IDS OF USERS WHO ALREADY DISLIKED THIS CHAPTER ---- //
            // Prepare a query to get IDs of user who already disliked this chapter
            $get_user_dislike_ids = $db->prepare("SELECT user_dislike_ids FROM chapters WHERE chapter_id = :chapter_id");

            // Binding  
            $get_user_dislike_ids->bindValue(":chapter_id", $chapter_id);

            // Execute
            $get_user_dislike_ids->execute();

            // Store IDs
            $user_dislike_ids = $get_user_dislike_ids->fetchColumn();

            // Test
            // var_dump($user_like_ids);
            // var_dump(gettype($user_like_ids));
            // exit;

            // If user ID is not part of chapter's user dislike IDs
            if(!str_contains($user_dislike_ids, $user_id))
            {
                // ---- ADD USER'S ID TO CHAPTER'S LIST OF USERS WHO LIKED ---- //
                // Prepare query
                $add_user_id = $db->prepare("UPDATE chapters SET user_dislike_ids := ' $user_id ' WHERE chapter_id = :chapter_id");

                // Binding
                $add_user_id->bindValue(":chapter_id", $chapter_id);

                // Execution
                $add_user_id->execute();

                // ---- INCREASE CHAPTER'S DISLIKE COUNT ---- //
                // Prepare query
                $increase_chapter_dislike_count = $db->prepare("UPDATE chapters SET dislikes = dislikes + 1 WHERE chapter_id = :chapter_id");

                // Binding
                $increase_chapter_dislike_count->bindValue(":chapter_id", $chapter_id);

                // Execution
                $increase_chapter_dislike_count->execute();

                // Process database modification
                $db->commit();
            }

            // If user ID is part of chapter's user dislike IDs
            else if(str_contains($user_dislike_ids, $user_id))
            {
                // ---- REMOVE USER'S ID FROM CHAPTER'S LIST OF USERS WHO DISLIKED ---- //
                // Prepare query
                $remove_user_id = $db->prepare("UPDATE chapters SET user_dislike_ids = REPLACE(user_dislike_ids, ' $user_id ', '') WHERE chapter_id = :chapter_id");

                // Binding
                $remove_user_id->bindValue(":chapter_id", $chapter_id);

                // Execution
                $remove_user_id->execute();

                // ---- DECREASE CHAPTER'S DISLIKE COUNT ---- //
                // Prepare query
                $decrease_chapter_dislike_count = $db->prepare("UPDATE chapters SET dislikes = dislikes - 1 WHERE chapter_id = :chapter_id");

                // Binding
                $decrease_chapter_dislike_count->bindValue(":chapter_id", $chapter_id);

                // Execution
                $decrease_chapter_dislike_count->execute();

                // Process database modification
                $db->commit();
            }
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Show error message
            echo "<p>Exception caught during chapter dislike addition :".$exc->getMessage().".</p>";

            // End script
            exit;
        }
    }
?>