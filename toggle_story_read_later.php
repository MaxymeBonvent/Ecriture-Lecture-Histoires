<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL'S STORY ID
    $url_story_id = htmlspecialchars($_GET["story_id"]);
    // var_dump($url_story_id);

    // If there's no story ID
    if(!isset($url_story_id) || empty($url_story_id))
    {
        // Show error message
        echo "<p>Error : no story ID.</p>";

        // End script
        exit;
    }

    // If there's a story ID
    else if(isset($url_story_id) && !empty($url_story_id))
    {
        // Try to toggle story to/from user's read later stack
        try
        {
            // Begin database modification
            $db->beginTransaction();

            // ---- GET USER'S READ LATER STORIES IDS ---- //
            // Prepare query
            $get_read_later = $db->prepare("SELECT read_later_ids FROM users WHERE user_id = :user_id");

            // Binding
            $get_read_later->bindValue(":user_id", $user_id);

            // Execution
            $get_read_later->execute();

            // Store read later IDs
            $user_read_later = $get_read_later->fetchColumn();

            // If URL's Story ID is not in user's read later string
            if(!str_contains($user_read_later, $url_story_id))
            {
                // ---- ADD STORY ID TO USER'S READ LATER ---- //
                // Prepare query
                $add_story_to_read_later = $db->prepare("UPDATE users SET read_later_ids = CONCAT(read_later_ids, ' $url_story_id ') WHERE user_id = :user_id");

                // Binding
                $add_story_to_read_later->bindValue(":user_id", $user_id);

                // Execution
                $add_story_to_read_later->execute();

                // ---- ADD USER'S ID TO STORY'S USER LATER IDS ---- //
                // Prepare query
                $add_user_id_to_story_user_later_ids = $db->prepare("UPDATE stories SET user_later_ids := ' $user_id '");

                // Execution
                $add_user_id_to_story_user_later_ids->execute();

                // Process database modification
                $db->commit();
            }

            // If URL's Story ID is already in user's read later string
            else if(str_contains($user_read_later, $url_story_id))
            {
                // ---- REMOVE STORY ID FROM USER'S READ LATER ---- //
                // Prepare query
                $remove_story_from_read_later = $db->prepare("UPDATE users SET read_later_ids = REPLACE(read_later_ids, ' $url_story_id ', '') WHERE user_id = :user_id");

                // Binding
                $remove_story_from_read_later->bindValue(":user_id", $user_id);

                // Execution
                $remove_story_from_read_later->execute();

                // ---- REMOVE USER'S ID FROM STORY'S USER LATER IDS ---- //
                // Prepare query
                $remove_user_id_from_story_user_later_ids = $db->prepare("UPDATE stories SET user_later_ids = REPLACE(user_later_ids, ' $user_id ', '') WHERE story_id = :story_id");

                // Binding
                $remove_user_id_from_story_user_later_ids->bindValue(":story_id", $url_story_id);

                // Execution
                $remove_user_id_from_story_user_later_ids->execute();

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
            echo "<p>Error during additon/removal of story to/from read later :".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>