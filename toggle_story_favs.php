<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL'S STORY ID
    $url_story_id = htmlspecialchars($_GET["story_id"]);

    // Test
    // echo "<p>URL Story ID :</p>";
    // var_dump($url_story_id);
    // exit;

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
        // Try to toggle story to/from user's favs stack
        try
        {
            // Begin database modification
            $db->beginTransaction();

            // ---- GET USER'S FAVORITES STORIES IDS ---- //
            // Prepare query
            $get_favs = $db->prepare("SELECT favorite_stories_ids FROM users WHERE user_id = :user_id");

            // Binding
            $get_favs->bindValue(":user_id", $user_id);

            // Execution
            $get_favs->execute();

            // Store favs IDs
            $user_favs = $get_favs->fetchColumn();

            // Test
            // echo "<p>User's favorite stories IDs :</p>";
            // var_dump($favs);
            // exit;

            // If URL's Story ID is not in user's favs string
            if(!str_contains($user_favs, $url_story_id))
            {
                // Confirm test
                // echo "<p>URL Story ID is not in user's favorite stories.</p>";
                // exit;

                // ---- ADD STORY ID TO USER'S FAVORITES ---- //
                // Prepare query
                $add_story_to_favs = $db->prepare("UPDATE users SET favorite_stories_ids = CONCAT(favorite_stories_ids, ' $url_story_id ') WHERE user_id = :user_id");

                // Binding
                $add_story_to_favs->bindValue(":user_id", $user_id);

                // Execution
                $add_story_to_favs->execute();

                // ---- ADD USER'S ID TO STORY'S USER FAV IDS ---- //
                // Prepare query
                $add_user_id_to_story_user_fav_ids = $db->prepare("UPDATE stories SET user_fav_ids := ' $user_id '");

                // Execution
                $add_user_id_to_story_user_fav_ids->execute();

                // Process database modification
                $db->commit();
            }

            // If URL's Story ID is already in user's favs string
            else if(str_contains($user_favs, $url_story_id))
            {
                // Confirm test
                // echo "<p>URL Story ID is in user's favorite stories.</p>";
                // exit;

                // ---- REMOVE STORY ID FROM USER'S FAVORITES ---- //
                // Prepare query
                $remove_story_from_favs = $db->prepare("UPDATE users SET favorite_stories_ids = REPLACE(favorite_stories_ids, ' $url_story_id ', '') WHERE user_id = :user_id");

                // Binding
                $remove_story_from_favs->bindValue(":user_id", $user_id);

                // Execution
                $remove_story_from_favs->execute();

                // ---- REMOVE USER'S ID FROM STORY'S USER FAV IDS ---- //
                // Prepare query
                $remove_user_id_from_story_user_fav_ids = $db->prepare("UPDATE stories SET user_fav_ids = REPLACE(user_fav_ids, ' $user_id ', '') WHERE story_id = :story_id");

                // Binding
                $remove_user_id_from_story_user_fav_ids->bindValue(":story_id", $url_story_id);

                // Execution
                $remove_user_id_from_story_user_fav_ids->execute();

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
            echo "<p>Error caught during addition/removal of story to/from user's favorites : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>