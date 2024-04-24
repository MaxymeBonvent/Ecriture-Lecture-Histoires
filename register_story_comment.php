<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // ---- COMMENT VARIABLES ---- //
    $comment_text = $_POST["comment_textarea"];
    $story_id = htmlspecialchars($_POST["story_id"]);
    $date = date("Y-m-d");

    // If there's no Comment Text
    if(!isset($comment_text) || empty($comment_text))
    {
        // Error message
        echo "<p>Error : no comment text.</p>";

        // End script
        exit;
    }

    // If there's no Story ID
    if(!isset($story_id) || empty($story_id))
    {
        // Error message
        echo "<p>Error : no story ID.</p>";

        // End script
        exit;
    }

    // If there's a Story ID
    else if(isset($story_id) && !empty($story_id))
    {
        // Try to insert story comment
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- INSERT STORY COMMENT ---- //

            // Prepare a query to insert a story comment
            $insert_story_comment = $db->prepare("INSERT INTO comments (user_id, story_id, pub_date, comment_text) VALUES (:user_id, :story_id, :pub_date, :comment_text)");

            // Binding
            $insert_story_comment->bindValue(":user_id", $user_id);
            $insert_story_comment->bindValue(":story_id", $story_id);
            $insert_story_comment->bindValue(":pub_date", $date);
            $insert_story_comment->bindValue(":comment_text", $comment_text);

            // Execution
            $insert_story_comment->execute();

            // ---- INCREASE STORY'S COMMENT COUNT ---- //

            // Prepare a query to increase story's comment count
            $increase_story_comment_count = $db->prepare("UPDATE stories SET comment_count = comment_count + 1 WHERE story_id = :story_id");

            // Binding
            $increase_story_comment_count->bindValue(":story_id", $story_id);

            // Execution
            $increase_story_comment_count->execute();

            // ---- REDIRECT USER ---- //

            // Process database modification
            $db->commit();

            // Lead user to story comment registration confirmation page    
            header("Location: story_comment_confirm.php");
            exit;
        }

        // Catch any problem
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Error message
            echo "<p>Exception caught during story comment registration : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>