<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // ---- COMMENT VARIABLES ---- //
    $comment_text = $_POST["comment_textarea"];
    $chapter_id = htmlspecialchars($_POST["chapter_id"]);
    $date = date("Y-m-d");

    // If there's no Comment Text
    if(!isset($comment_text) || empty($comment_text))
    {
        // Error message
        echo "Error : no comment text.";

        // End script
        exit;
    }

    // If there's no Chapter ID
    if(!isset($chapter_id) || empty($chapter_id))
    {
        // Error message
        echo "Error : no chapter ID.";

        // End script
        exit;
    }

    // If there's a Chapter ID
    else if(isset($chapter_id) && !empty($chapter_id))
    {
        // Try to insert story comment
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- INSERT CHAPTER COMMENT ---- //

            // Prepare a query to insert a chapter comment
            $insert_story_comment = $db->prepare("INSERT INTO comments (user_id, chapter_id, pub_date, comment_text) VALUES (:user_id, :chapter_id, :pub_date, :comment_text)");

            // Binding
            $insert_story_comment->bindValue(":user_id", $user_id);
            $insert_story_comment->bindValue(":chapter_id", $chapter_id);
            $insert_story_comment->bindValue(":pub_date", $date);
            $insert_story_comment->bindValue(":comment_text", $comment_text);

            // Execution
            $insert_story_comment->execute();

            // ---- INCREASE CHAPTER'S COMMENT COUNT ---- //

            // Prepare a query to increase story's comment count
            $increase_chapter_comment_count = $db->prepare("UPDATE chapters SET comment_count = comment_count + 1 WHERE chapter_id = :chapter_id");

            // Binding
            $increase_chapter_comment_count->bindValue(":chapter_id", $chapter_id);

            // Execution
            $increase_chapter_comment_count->execute();

            // ---- REDIRECT USER ---- //

            // Process database modification
            $db->commit();

            // Lead user to chapter comment registration confirmation page    
            header("Location: chapter_comment_confirm.php");
            exit;
        }

        // Catch any problem
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Error message
            echo "<p>Exception caught during chapter comment registration : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>