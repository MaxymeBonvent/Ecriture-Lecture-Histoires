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

            // ---- GET USER'S READ LATER STORIES IDS ---- //
            $get_read_later = $db->prepare("SELECT read_later_ids FROM users WHERE user_id = :user_id");

            // Binding
            $get_read_later->bindValue(":user_id", $user_id);

            // Execution
            $get_read_later->execute();

            // Store favs IDs
            $read_later = $get_read_later->fetchColumn();

            // If URL's Story ID is not in read later string
            if(!str_contains($read_later, $story_id))
            {
                // ---- ADD STORY ID TO USER'S READ LATER ---- //
                // Prepare a query to add story's ID to user's favorites stack
                $add_story_to_read_later = $db->prepare("UPDATE users SET read_later_ids = CONCAT(read_later_ids, ' $story_id ') WHERE user_id = :user_id");

                // Binding
                $add_story_to_read_later->bindValue(":user_id", $user_id);

                // Execution
                $add_story_to_read_later->execute();

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
            echo "<p>Error during additon of story to read later :".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>