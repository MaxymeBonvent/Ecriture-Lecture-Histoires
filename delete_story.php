<?php
    // ---- SESSION ---- //
    session_start();

    // ---- DATABASE CONNECTION ---- //
    require_once("database_connection.php");

    // ---- GET USER ID ---- //
    require_once("get_user_id.php");

    // STORY ID
    $story_id = htmlspecialchars($_GET['story_id']);

    // ---- URL CHECK ---- //

    // If there's no story ID
    if(!isset($story_id) || empty($story_id))
    {
        // Output an error message
        echo "<p>Error : no story ID.</p>";

        // End script
        exit;
    }

    // If there's a story ID
    else if(isset($story_id) && !empty($story_id))
    {
        // Try to delete the story and its chapters
        try
        {
            // Begin database modification
            $db->beginTransaction();

            // ---- GET EVERY CHAPTER ID OF SELECTED STORY ---- //

            // Prepare a query to get the chapter IDs of the story
            $get_chapter_ids = $db->prepare("SELECT chapter_ids FROM stories WHERE story_id = :story_id");

            // Binding
            $get_chapter_ids->bindValue(":story_id", $story_id);

            // Execution
            $get_chapter_ids->execute();

            // Store result
            $chapter_ids = $get_chapter_ids->fetchColumn();

            // Closing
            $get_chapter_ids->closeCursor();

            // Separate each chapter ID in an array
            $chapter_ids_array = explode("  ", $chapter_ids);

            // ---- DELETE STORY'S CHAPTERS ---- //

            // For every chapter ID
            for($i = 0; $i < count($chapter_ids_array); $i++)
            {
                // DELETE CHAPTER

                // Prepare a query to delete the chapter with a given ID
                $delete_chapter = $db->prepare("DELETE FROM chapters WHERE chapter_id = :chapter_id");

                // Binding
                $delete_chapter->bindValue(":chapter_id", $chapter_ids_array[$i]);

                // Execution
                $delete_chapter->execute();

                // DECREASE USER'S CHAPTER COUNT

                // Prepare a query to decrease by 1 user's chapter count
                $decrease_chapter_count = $db->prepare("UPDATE users SET chapter_count = chapter_count - 1 WHERE user_id = :user_id");

                // Binding
                $decrease_chapter_count->bindValue(":user_id", $user_id);

                // Execution
                $decrease_chapter_count->execute();
            }

            // ---- GET USER IDS ---- //
            // Prepare query
            $get_user_ids = $db->prepare("SELECT user_id FROM users");

            // Execute
            $get_user_ids->execute();

            // Store result
            $user_ids = $get_user_ids->fetchAll(PDO::FETCH_ASSOC);

            // Test
            // echo "<p>User IDs :</p>";
            // var_dump($user_ids);
            // exit;

            // For every user
            for($i = 0; $i < count($user_ids); $i++)
            {
                // ---- GET USER'S FAVORITE STORIES ---- //

                // Prepare query
                $get_favs = $db->prepare("SELECT favorite_stories_ids FROM users WHERE user_id = :user_id");

                // Binding
                $get_favs->bindValue(":user_id", $user_ids[$i]["user_id"]);

                // Execution
                $get_favs->execute();

                // Store result
                $favs = $get_favs->fetchColumn();

                // Test
                // echo "<p>Favorite stories of user n°$i :</p>";
                // var_dump($favs);
                // exit;

                // If story to delete is in user's favs
                if(str_contains($favs, $story_id))
                {
                    // ---- REMOVE STORY ID FROM USER'S FAVS ---- //

                    // Prepare query
                    $remove_story_from_favs = $db->prepare("UPDATE users SET favorite_stories_ids = REPLACE(favorite_stories_ids, ' $story_id ', '') WHERE user_id = :user_id");

                    // Binding
                    $remove_story_from_favs->bindValue(":user_id", $user_ids[$i]["user_id"]);

                    // Execution
                    $remove_story_from_favs->execute();
                }

                // ---- GET USER'S READ LATER STORIES ---- //

                // Prepare query
                $get_later = $db->prepare("SELECT read_later_ids FROM users WHERE user_id = :user_id");

                // Binding
                $get_later->bindValue(":user_id", $user_ids[$i]["user_id"]);

                // Execution
                $get_later->execute();

                // Store result
                $later = $get_later->fetchColumn();

                // Test
                // echo "<p>Read later stories of user n°$i :</p>";
                // var_dump($later);
                // exit;

                // If story to delete is in user's read later
                if(str_contains($later, $story_id))
                {
                    // ---- REMOVE STORY ID FROM USER'S READ LATER ---- //

                    // Prepare query
                    $remove_story_from_later = $db->prepare("UPDATE users SET read_later_ids = REPLACE(read_later_ids, ' $story_id ', '') WHERE user_id = :user_id");

                    // Binding
                    $remove_story_from_later->bindValue(":user_id", $user_ids[$i]["user_id"]);

                    // Execution
                    $remove_story_from_later->execute();
                }
            }

            // ---- DELETE THE STORY ---- //

            // Prepare a query to delete the clicked story
            $delete_story = $db->prepare("DELETE FROM stories WHERE story_id = :story_id");

            // Binding
            $delete_story->bindValue(":story_id", $story_id);

            // Execution
            $delete_story->execute();

            // Process database modification
            $db->commit();

            // ---- DECREASE USER'S STORY COUNT ---- //

            // Prepare a query to decrease by 1 user's story count
            $decrease_story_count = $db->prepare("UPDATE users SET story_count = story_count - 1 WHERE user_id = :user_id");

            // Binding
            $decrease_story_count->bindValue(":user_id", $user_id);

            // Execution
            $decrease_story_count->execute();

            // ---- REDIRECTION ---- //

            // Redirect user to a page that tells them the story is gone
            header("Location: story_delete_confirm.php");
        }

        // Catch any problem
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Error message
            echo "<p>Exception caught during story deletion : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }  
    }
?>