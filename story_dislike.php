<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL'S STORY ID
    $story_id = htmlspecialchars($_GET["story_id"]);
    // var_dump($story_id);

    // If there's no story ID
    if(!isset($story_id) || empty($story_id))
    {
        // Show error message
        echo "<p>Error : no story ID.</p>";

        // End script
        exit;
    }

    // If there's a story ID and a user ID
    else if(isset($story_id) && !empty($story_id) && isset($user_id) && !empty($user_id))
    {
        // Try to add a like to the story
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- GET IDS OF USERS WHO ALREADY DISLIKED THIS STORY ---- //
            // Prepare a query to get IDs of user who already liked this story
            $get_user_dislike_ids = $db->prepare("SELECT user_dislike_ids FROM stories WHERE story_id = :story_id");

            // Binding  
            $get_user_dislike_ids->bindValue(":story_id", $story_id);

            // Execute
            $get_user_dislike_ids->execute();

            // Store IDs
            $user_dislike_ids = $get_user_dislike_ids->fetchColumn();

            // Test
            // var_dump($user_like_ids);
            // var_dump(gettype($user_like_ids));
            // exit;

            // If user ID is not part of Story's user dislike IDs
            if(!str_contains($user_dislike_ids, $user_id))
            {
                // ---- ADD USER'S ID TO STORY'S LIST OF USERS WHO DISLIKED ---- //
                // Prepare query
                $add_user_id = $db->prepare("UPDATE stories SET user_dislike_ids := ' $user_id ' WHERE story_id = :story_id");

                // Binding
                $add_user_id->bindValue(":story_id", $story_id);

                // Execution
                $add_user_id->execute();

                // ---- INCREASE STORY'S DISLIKE COUNT ---- //
                // Prepare query
                $increase_story_dislike_count = $db->prepare("UPDATE stories SET dislikes = dislikes + 1 WHERE story_id = :story_id");

                // Binding
                $increase_story_dislike_count->bindValue(":story_id", $story_id);

                // Execution
                $increase_story_dislike_count->execute();

                // Process database modification
                $db->commit();
            }

            // If user ID is part of Story's user like IDs
            else if(str_contains($user_dislike_ids, $user_id))
            {
                // ---- REMOVE USER'S ID FROM STORY'S LIST OF USERS WHO DISLIKED ---- //
                // Prepare query
                $remove_user_id = $db->prepare("UPDATE stories SET user_dislike_ids = REPLACE(user_dislike_ids, ' $user_id ', '') WHERE story_id = :story_id");

                // Binding
                $remove_user_id->bindValue(":story_id", $story_id);

                // Execution
                $remove_user_id->execute();

                // ---- DECREASE STORY'S DISLIKE COUNT ---- //
                // Prepare query
                $decrease_story_dislike_count = $db->prepare("UPDATE stories SET dislikes = dislikes - 1 WHERE story_id = :story_id");

                // Binding
                $decrease_story_dislike_count->bindValue(":story_id", $story_id);

                // Execution
                $decrease_story_dislike_count->execute();

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
            echo "<p>Exception caught during story dislike addition :".$exc->getMessage().".</p>";

            // End script
            exit;
        }
    }
?>