<?php
    // ---- SESSION ----
    session_start();

    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // ---- URL ANALYSIS ----

    // Try to get URL info from clicked chapter
    try
    {
        // ---- GET USER ID ----
        require_once("get_user_id.php");

        // ---- STORY AND CHAPTER VARIABLES ----
        // Story variable
        $story_id = htmlspecialchars($_GET["story_id"]);

        // Chapter variable
        $chapter_title = htmlspecialchars($_GET["chapter_title"]);

        // ---- DECREASE CHAPTER COUNT ----

        // Prepare a query to decrease by 1 user's chapter count
        $decrease_chapter_count = $db->prepare("UPDATE users SET chapter_count = chapter_count - 1 WHERE username = :username");

        // Binding
        $decrease_chapter_count->bindValue(":username", $_SESSION["username"]);

        // Execution
        $decrease_chapter_count->execute();

        // Closing
        $decrease_chapter_count->closeCursor();

        // ---- GET CHAPTER ID ----

        // Prepare query to get chapter ID
        $get_chapter_id = $db->prepare("SELECT chapter_id FROM chapters WHERE story_id = :story_id AND chapter_title = :chapter_title");

        // Binding  
        $get_chapter_id->bindValue(":story_id", $story_id);
        $get_chapter_id->bindValue(":chapter_title", $chapter_title);

        // Execution
        $get_chapter_id->execute();

        // Store result
        $chapter_id = $get_chapter_id->fetchColumn();

        // Close
        $get_chapter_id->closeCursor();

        // ---- REMOVE CHAPTER ID FROM ITS STORY ----

        // Prepare query to remove the chapter's ID from its story's chapter IDs column
        $remove_chapter_id = $db->prepare("UPDATE stories SET chapter_ids = REPLACE(chapter_ids, ' $chapter_id ', '') WHERE story_id = :story_id");

        // Binding
        $remove_chapter_id->bindValue(":story_id", $story_id);

        // Execution
        $remove_chapter_id->execute();

        // Close
        $remove_chapter_id->closeCursor();

        // ---- DELETE CHAPTER ----

        // Prepare query to delete chapter with given story ID, chapter ID and title
        $delete_chapter = $db->prepare("DELETE FROM chapters WHERE story_id = :story_id AND chapter_id = :chapter_id AND chapter_title = :chapter_title");

        // Binding
        $delete_chapter->bindValue(":story_id", $story_id);
        $delete_chapter->bindValue(":chapter_id", $chapter_id);
        $delete_chapter->bindValue(":chapter_title", $chapter_title);

        // Execution
        $delete_chapter->execute();

        // Close
        $delete_chapter->closeCursor();

        // ---- GET STORY'S CHAPTER IDS ----

        // Prepare a query to get the deleted chapter's story's chapter IDs
        $get_chapter_ids = $db->prepare("SELECT chapter_ids FROM stories WHERE story_id = :story_id");

        // Binding
        $get_chapter_ids->bindValue(":story_id", $story_id);

        // Execute
        $get_chapter_ids->execute();

        // Store result
        $chapter_ids = $get_chapter_ids->fetchColumn();

        // Close
        $get_chapter_ids->closeCursor();

        // ---- DELETE STORY IF CHAPTER IDS IS EMPTY ----

        // If there nothing in the chapter IDs column
        if(empty($chapter_ids))
        {
            // ---- DELETE STORY ----
            // Prepare a query to delete story
            $delete_story = $db->prepare("DELETE FROM stories WHERE story_id = :story_id");

            // Binding
            $delete_story->bindValue(":story_id", $story_id);

            // Execute
            $delete_story->execute();

            // Close
            $delete_story->closeCursor();

            // ---- DECREASE STORY COUNT ----

            // Prepare a query to decrease by 1 user's story count
            $decrease_story_count = $db->prepare("UPDATE users SET story_count = story_count - 1 WHERE username = :username");

            // Binding
            $decrease_story_count->bindValue(":username", $_SESSION["username"]);

            // Execution
            $decrease_story_count->execute();

            // Closing
            $decrease_story_count->closeCursor();
        }

        // ---- REDIRECTION ----

        // Redirect user to chapter deletion confirmation page
        header("Location: chapter_delete_confirm.php");
    }

    // Catch any exception
    catch(Exception $exc)
    {
        // Output error message
        echo "<p>Exception caught during chapter deletion  : " . $exc->getMessage() . "</p>";

        // End script
        exit;
    }
?>