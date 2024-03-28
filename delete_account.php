<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // User ID
    $user_id = $_GET["user_id"];

    // Try to delete user's chapters, stories, and account
    try
    {
        // ---- 1. GET EVERY STORY WITH USER'S ID ----

        // Prepare a query to get every story written by user
        $get_stories = $db->prepare("SELECT story_title, chapter_ids FROM stories WHERE user_id = :user_id");

        // Binding
        $get_stories->bindValue(":user_id", $user_id);

        // Execution
        $get_stories->execute();

        // Store result
        $story_titles_and_chapter_ids = $get_stories->fetchAll(PDO::FETCH_ASSOC);

        // Test
        var_dump($story_titles_and_chapter_ids[0]["chapter_ids"]);
        exit;

        // Explode chapter_ids in an array
        // $chapter_ids = explode(",", $story_titles_and_chapter_ids["chapter_ids"]);

        // Test
        // var_dump($chapter_ids);

        // Closing
        // $get_stories->closeCursor();

        // // ---- 2. FOR EVERY STORY, GET ALL THEIR CHAPTERS ----

        // // For each story
        // foreach($story_titles_and_chapter_ids as $single_story_title_and_chapter_ids)
        // {
        //     // ---- 3. DELETE ALL CHAPTERS ----

        //     // Prepare a query to delete every chapter of a given story
        //     $delete_chapters = $db->prepare("DELETE * FROM chapters WHERE chapter_id = :chapter_id");

        //     // Binding
        //     $delete_chapters->bindValue(":chapter_id", $single_story_title_and_chapter_ids["chapter_ids"]);
        // }

        // ---- 4. DELETE ALL STORIES ----

        // ---- 5. DELETE ACCOUNT ----

        // ---- 6. REDIRECTION ----
    }

    // Catch any exception
    catch(Exception $exc)
    {
        echo "<p>Exception caught during account deletion : ".$exc->getMessage()."</p>";
    }
?>