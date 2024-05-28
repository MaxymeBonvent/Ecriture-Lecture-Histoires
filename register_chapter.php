<?php
    // ---- SESSION ---- //
    session_start();

    // ---- DATABASE CONNECTION ---- //
    require_once("database_connection.php");

    // ---- FORM ANALYSIS ---- //

    // Try to get form info and store new chapter
    try
    {
        // ---- STORY VARIABLES ---- //
        $story_id = htmlspecialchars($_POST["story_id"]);

        // ---- CHAPTER VARIABLES ---- //
        $chapter_title = htmlspecialchars($_POST["chapter_title"]);
        $chapter_text = $_POST["chapter_text"];
        $chapter_word_count = str_word_count($chapter_text);

        // ---- VARIABLES COMMON TO BOTH CHAPTER AND STORY ---- //
        $date = date("Y/m/d");

        // --- INCORRECT FORM ---- //

        // Chapter Title
        if(!isset($chapter_title) || empty($chapter_title))
        {
            // Output error message
            echo "<p>Error : no chapter title.</p>";

            // End script
            exit;
        }

        // Chapter Text
        if(!isset($chapter_text) || empty($chapter_text))
        {
            // Output error message
            echo "<p>Error : no chapter text.</p>";

            // End script
            exit;
        }

        // Story ID
        if(!isset($story_id) || empty($story_id))
        {
            // Output error message
            echo "<p>Error : no story ID.</p>";

            // End script
            exit;
        }

        // Word count
        if($chapter_word_count < 1)
        {
            // Output error message
            echo "<p>Error : no words.</p>";

            // End script
            exit;
        }

        // --- CORRECT FORM ---- //

        // If every field is set and filled and there's at least 1 word
        if  (   isset($story_id) && !empty($story_id) &&
                isset($chapter_title) && !empty($chapter_title) &&
                isset($chapter_text) && !empty($chapter_text) &&
                $chapter_word_count > 0
            )

            {
                // Start database modification
                $db->beginTransaction();

                // ---- INSERT NEW CHAPTER ---- //

                // Prepare a query to insert a chapter with its story ID, title, text, word count and date
                $insert_chapter = $db->prepare("INSERT INTO chapters (story_id, chapter_title, chapter_text, word_count, pub_date) VALUES (:story_id, :chapter_title, :chapter_text, :word_count, :pub_date)");

                // Binding
                $insert_chapter->bindValue(":story_id", $story_id);
                $insert_chapter->bindValue(":chapter_title", $chapter_title);
                $insert_chapter->bindValue(":chapter_text", $chapter_text);
                $insert_chapter->bindValue(":word_count", $chapter_word_count);
                $insert_chapter->bindValue(":pub_date", $date);

                // Execution
                $insert_chapter->execute();

                // Closing
                $insert_chapter->closeCursor();

                // ---- INCREASE CHAPTER COUNT ---- //

                // Prepare a query to increase by 1 user's chapter count
                $increase_chapter_count = $db->prepare("UPDATE users SET chapter_count = chapter_count + 1 WHERE username = :username");

                // Binding
                $increase_chapter_count->bindValue(":username", $_SESSION["username"]);

                // Execution
                $increase_chapter_count->execute();

                // Closing
                $increase_chapter_count->closeCursor();

                // ---- GET NEW CHAPTER'S ID ---- //

                // Query to get new chapter's ID
                $get_new_chapter_id = $db->query("SELECT MAX(chapter_id) FROM chapters");

                // Execution
                $get_new_chapter_id->execute();

                // Store new chapter's ID
                $new_chapter_id = $get_new_chapter_id->fetchColumn();

                // Closing
                $get_new_chapter_id->closeCursor();

                // ---- GIVE CHAPTER'S ID TO ITS STORY ---- //

                // Prepare a query to insert new chapter's ID to its story's chapter IDs
                $give_chapter_id_to_story = $db->prepare("UPDATE stories SET chapter_ids = CONCAT(chapter_ids, ' $new_chapter_id ')  WHERE story_id = :story_id");

                // Binding
                $give_chapter_id_to_story->bindValue(":story_id", $story_id);

                // Execute
                $give_chapter_id_to_story->execute();

                // Closing
                $give_chapter_id_to_story->closeCursor();  

                // ---- INCREASE STORY'S WORD COUNT BY CHAPTER'S WORD COUNT ---- //

                // Prepare a query to increase story's word count by chapter's word count
                $increase_story_word_count = $db->prepare("UPDATE stories SET word_count = word_count + :chapter_word_count WHERE story_id = :story_id");

                // Binding
                $increase_story_word_count->bindValue(":chapter_word_count", $chapter_word_count);
                $increase_story_word_count->bindValue(":story_id", $story_id);

                // Execution
                $increase_story_word_count->execute();

                // Closing
                $increase_story_word_count->closeCursor();

                // ---- REDIRECTION ---- //

                // Process database modification
                $db->commit();

                // Redirect user to chapter storage confirmation page
                header("Location: chapter_registration_confirm.php");
            }
    }

    // Catch any exception
    catch(Exception $exc)
    {
        // Cancel database modification
        $db->rollBack();

        // Output error message
        echo "<p>Exception caught during chapter registration  : " . $exc->getMessage() . "</p>";

        // End script
        exit;
    }
?>