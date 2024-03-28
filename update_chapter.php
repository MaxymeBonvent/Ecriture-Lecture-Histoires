<?php
    // ---- SESSION ----
    session_start();

    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // ---- FORM ANALYSIS ----

    // Try to get form info and update chapter
    try
    {
        // ID variables
        $story_id = htmlspecialchars($_POST["story_id"]);
        $chapter_id = htmlspecialchars($_POST["chapter_id"]);

        // Chapter Title and Chapter Text variables
        $edited_chapter_title = htmlspecialchars($_POST["chapter_title"]);
        $edited_chapter_text = htmlspecialchars($_POST["chapter_text"]);

        // ---- INCORRECT FORM ----

        // Story ID
        if(!isset($story_id) || empty($story_id))
        {
            // Error message
            echo "<p>Error : no story ID.</p>";

            // End script
            exit;
        }

        // Chapter ID
        if(!isset($chapter_id) || empty($chapter_id))
        {
            // Error message
            echo "<p>Error : no chapter ID.</p>";

            // End script
            exit;
        }

        // Edited Chapter Title
        if(!isset($edited_chapter_title) || empty($edited_chapter_title))
        {
            // Error message
            echo "<p>Error : no chapter title.</p>";

            // End script
            exit;
        }

        // Edited Chapter Text
        if(!isset($edited_chapter_text) || empty($edited_chapter_text))
        {
            // Error message
            echo "<p>Error : no chapter title.</p>";

            // End script
            exit;
        }

        // ---- CORRECT FORM ----

        if  (   isset($story_id) && !empty($story_id) &&
                isset($chapter_id) && !empty($chapter_id) &&
                isset($edited_chapter_title) && !empty($edited_chapter_title) &&
                isset($edited_chapter_text) && !empty($edited_chapter_text)
            )
        {
            // Prepare a query to assign the edited chapter title and text to the chapter of given story ID and chapter ID
            $edit_chapter = $db->prepare("UPDATE chapters SET chapter_title = :chapter_title, chapter_text = :chapter_text WHERE story_id = :story_id AND chapter_id = :chapter_id");

            // Binding
            $edit_chapter->bindValue(":story_id", $story_id);
            $edit_chapter->bindValue(":chapter_id", $chapter_id);
            $edit_chapter->bindValue(":chapter_title", $edited_chapter_title);
            $edit_chapter->bindValue(":chapter_text", $edited_chapter_text);

            // Execution
            $edit_chapter->execute();

            // Redirect user
            header("Location: chapter_edit_confirm.php");
        }
    }

    // Catch any exception
    catch(Exception $exc)
    {
        // Output error message
        echo "<p>Exception caught during chapter updating  : " . $exc->getMessage() . "</p>";

        // End script
        exit;
    }
?>