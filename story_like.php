<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL'S STORY ID
    $story_id = htmlspecialchars($_GET["story_id"]);
    var_dump($story_id);

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

            // ---- GET IDS OF USERS WHO ALREADY LIKED THIS STORY ---- //
            // Prepare a query to get IDs of user who already liked this story
            $get_user_like_ids = $db->prepare("SELECT user_like_ids FROM stories WHERE story_id = :story_id");

            // Binding  
            $get_user_like_ids->bindValue(":story_id", $story_id);

            // Execute
            $get_user_like_ids->execute();

            // Store IDs
            $user_like_ids = $get_user_like_ids->fetchColumn();

            // Test
            // var_dump($user_like_ids);
            // exit;

            // If user ID is not part of Story's user like IDs
            if(!str_contains($user_like_ids, $user_id))
            {
                // ---- ADD USER'S ID TO STORY'S LIST OF USERS WHO LIKED ---- //
                // Prepare query
                $add_user_id = $db->prepare("UPDATE stories SET user_like_ids = CONCAT(user_like_ids, ' $user_id ') WHERE story_id = :story_id");

                // Binding
                $add_user_id->bindValue(":story_id", $story_id);

                // Execution
                $add_user_id->execute();

                // ---- INCREASE STORY'S LIKE COUNT ---- //
                // Prepare query
                $increase_story_like_count = $db->prepare("UPDATE stories SET likes = likes + 1 WHERE story_id = :story_id");

                // Binding
                $increase_story_like_count->bindValue(":story_id", $story_id);

                // Execution
                $increase_story_like_count->execute();

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
            echo "<p>Exception caught during story like addition :".$exc->getMessage().".</p>";

            // End script
            exit;
        }
    }
?>