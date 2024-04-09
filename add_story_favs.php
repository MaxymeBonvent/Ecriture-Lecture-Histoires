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

    // If there's a story ID
    else if(isset($story_id) && !empty($story_id))
    {
        // Try to add story to user's favs
        try
        {
            // Begin database modification
            $db->beginTransaction();

            // ---- GET USER'S FAVORTIES STORIES IDS ---- //
            $get_favs = $db->prepare("SELECT favorite_stories_ids FROM users WHERE user_id = :user_id");

            // Binding
            $get_favs->bindValue(":user_id", $user_id);

            // Execution
            $get_favs->execute();

            // Store favs IDs
            $favs = $get_favs->fetchColumn();

            // If URL's Story ID is not in favs string
            if(!str_contains($favs, $story_id))
            {
                // ---- ADD STORY ID TO USER'S FAVORITES ---- //
                // Prepare a query to add story's ID to user's favorites stack
                $add_story_to_favs = $db->prepare("UPDATE users SET favorite_stories_ids = CONCAT(favorite_stories_ids, ' $story_id ') WHERE user_id = :user_id");

                // Binding
                $add_story_to_favs->bindValue(":user_id", $user_id);

                // Execution
                $add_story_to_favs->execute();

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
            echo "<p>Error during additon of story to favorites :".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>