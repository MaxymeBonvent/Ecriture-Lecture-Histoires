<?php
    // ---- SESSION ----
    session_start();

    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // ---- FORM ANALYSIS ----

    // Try to get form info and store new story
    try
    {
        // ---- CHAPTER VARIABLES ----
        $chapter_title = htmlspecialchars($_POST["chapter_title"]);
        $chapter_text = $_POST["chapter_text"];

        // ---- STORY VARIABLES ----
        $story_title = htmlspecialchars($_POST["story_title"]);
        $synopsis = htmlspecialchars($_POST["synopsis"]);
        $tags = htmlspecialchars($_POST["tags"]);

        // ---- VARIABLES COMMON TO BOTH CHAPTER AND STORY ----
        $chapter_word_count = str_word_count($chapter_text);
        $date = date("Y/m/d");

        // --- INCORRECT FORM ----

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

        // Story Title
        if(!isset($story_title) || empty($story_title))
        {
            // Output error message
            echo "<p>Error : no story title.</p>";

            // End script
            exit;
        }

        // Synopsis
        if(!isset($synopsis) || empty($synopsis))
        {
            // Output error message
            echo "<p>Error : no synopsis.</p>";

            // End script
            exit;
        }

        // Tags
        if(!isset($tags) || empty($tags))
        {
            // Output error message
            echo "<p>Error : no tags.</p>";

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

        // --- CORRECT FORM ----

        // If every field is set and filled and there's at least 1 word
        if  (   isset($chapter_title) && !empty($chapter_title) &&
                isset($chapter_text) && !empty($chapter_text) &&
                isset($story_title) && !empty($story_title) &&
                isset($synopsis) && !empty($synopsis) &&
                isset($tags) && !empty($tags) && 
                $chapter_word_count > 0
            ) 

            {
                // ---- GET USER ID ----
                require_once("get_user_id.php");

                // --- INSERT CHAPTER ---

                // Prepare query to insert chapter
                $insert_chapter = $db->prepare("INSERT INTO chapters (chapter_title, chapter_text, word_count, pub_date) VALUES (:chapter_title, :chapter_text, :word_count, :pub_date)");

                // Binding
                $insert_chapter->bindValue(":chapter_title", $chapter_title);
                $insert_chapter->bindValue(":chapter_text", $chapter_text);
                $insert_chapter->bindValue(":word_count", $chapter_word_count);
                $insert_chapter->bindValue(":pub_date", $date);

                // Execution
                $insert_chapter->execute();
                
                // Closing
                $insert_chapter->closeCursor();

                // ---- INCREASE CHAPTER COUNT ----

                // Prepare a query to increase by 1 user's chapter count
                $increase_chapter_count = $db->prepare("UPDATE users SET chapter_count = chapter_count + 1 WHERE username = :username");

                // Binding
                $increase_chapter_count->bindValue(":username", $_SESSION["username"]);

                // Execution
                $increase_chapter_count->execute();

                // Closing
                $increase_chapter_count->closeCursor();

                // --- GET CHAPTER ID ---

                // Newest chapter ID Query
                $newest_chapter_id_query = $db->query("SELECT MAX(chapter_id) FROM chapters");

                // Execution
                $newest_chapter_id_query->execute();

                // Get array result
                $newest_chapter_id = $newest_chapter_id_query->fetchColumn();

                // Closing
                $newest_chapter_id_query->closeCursor();

                // ---- INSERT STORY ----

                // Prepare query to insert story
                $insert_story = $db->prepare("INSERT INTO stories (user_id, story_title, synopsis, pub_date, tags, word_count) VALUES (:user_id, :story_title, :synopsis, :pub_date, :tags, :word_count)");

                // Binding  
                $insert_story->bindValue(":user_id", $user_id[0]);
                $insert_story->bindValue(":story_title", $story_title);
                $insert_story->bindValue(":synopsis", $synopsis);
                $insert_story->bindValue(":pub_date", $date);
                $insert_story->bindValue(":tags", $tags);
                $insert_story->bindValue(":word_count", $chapter_word_count);

                // Execution
                $insert_story->execute();

                // Closing
                $insert_story->closeCursor();

                // ---- INCREASE STORY COUNT ----

                // Prepare a query to increase by 1 user's story count
                $increase_story_count = $db->prepare("UPDATE users SET story_count = story_count + 1 WHERE username = :username");

                // Binding
                $increase_story_count->bindValue(":username", $_SESSION["username"]);

                // Execution
                $increase_story_count->execute();

                // Closing
                $increase_story_count->closeCursor();

                // ---- GET STORY ID ----

                // Query to obtain the last story ID
                $newest_story_id_query = $db->query("SELECT MAX(story_id) FROM stories");

                // Execution
                $newest_story_id_query->execute();

                // Store array result
                $newest_story_id = $newest_story_id_query->fetchColumn();

                // Closing
                $newest_story_id_query->closeCursor();

                // ---- GIVE CHAPTER ID TO STORY ----

                // Query to give chapter ID to latest story
                $give_chapter_id_to_story = $db->query("UPDATE stories SET chapter_ids = ' $newest_chapter_id ' WHERE story_id = $newest_story_id");

                // Execution
                $give_chapter_id_to_story->execute();

                // Closing
                $give_chapter_id_to_story->closeCursor();

                // ---- GIVE STORY ID TO CHAPTER ----

                // Prepare query to assign last story ID to last chapter
                $give_last_story_id_to_last_chapter = $db->query("UPDATE chapters SET story_id = $newest_story_id WHERE chapter_id = $newest_chapter_id");

                // Execution
                $give_last_story_id_to_last_chapter->execute();

                // Closing
                $give_last_story_id_to_last_chapter->closeCursor();

                // ---- REDIRECTION ----

                // Redirect user to Story Storage Confirmation Page
                header("Location: story_registration_confirm.php");
            }
    }

    // Catch any exception
    catch(Exception $exc)
    {
        // Output error message
        echo "<p>Exception caught during story registration  : " . $exc->getMessage() . "</p>";

        // End script
        exit;
    }
?>