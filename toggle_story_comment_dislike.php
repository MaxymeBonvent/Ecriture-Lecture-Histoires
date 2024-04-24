<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL story comment ID
    $story_comment_id = htmlspecialchars($_GET["story_comment_id"]);

    // URL user  ID
    $user_id = htmlspecialchars($_GET["user_id"]);

    // Test
    // echo "<p>Story comment ID :</p>";
    // var_dump($story_comment_id);

    // echo "<p>User  ID :</p>";
    // var_dump($user_id);

    // exit;

    // If both IDs exists and are numbers
    if(isset($story_comment_id) && !empty($story_comment_id) && is_numeric($story_comment_id) && isset($user_id) && !empty($user_id) && is_numeric($user_id))
    {
        // Try to dislike/undislike comment
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- GET IDS OF EVERYONE WHO DISLIKED THIS COMMENT ---- //
            // Prepare query
            $get_user_dislike_ids = $db->prepare("SELECT user_dislike_ids FROM comments WHERE comment_id = :comment_id");

            // Binding
            $get_user_dislike_ids->bindValue(":comment_id", $story_comment_id);

            // Execution
            $get_user_dislike_ids->execute();

            // Store results
            $user_dislike_ids = $get_user_dislike_ids->fetchColumn();

            // Test
            // echo "<p>IDs of users who already disliked this story comment :</p>";
            // var_dump($user_dislike_ids);
            // exit;

            // ---- AT LEAST ONE USER DISLIKED THE COMMENT ---- //
            if($user_dislike_ids != null && $user_dislike_ids != "")
            {
                // ---- USER ALREADY DISLIKED THIS COMMENT ---- //
                if(str_contains($user_dislike_ids, $user_id))
                {
                    // REMOVE USER ID FROM COLUMN
                    // Prepare query
                    $remove_user_id = $db->prepare("UPDATE comments SET user_dislike_ids = REPLACE(user_dislike_ids, ' $user_id ', '') WHERE comment_id = :comment_id");

                    // Binding
                    $remove_user_id->bindValue(":comment_id", $story_comment_id);

                    // Execution
                    $remove_user_id->execute();

                    // DECREASE DISLIKES NUMBER
                    // Prepare query
                    $decrease_dislikes_number = $db->prepare("UPDATE comments SET dislikes = dislikes - 1 WHERE comment_id = :comment_id");

                    // Binding
                    $decrease_dislikes_number->bindValue(":comment_id", $story_comment_id);

                    // Execution
                    $decrease_dislikes_number->execute();

                    // Process database modification
                    $db->commit();
                }

                // ---- USER DID NOT DISLIKE THIS COMMENT YET ---- // 
                else if(!str_contains($user_dislike_ids, $user_id))
                {
                    // ADD USER ID TO COLUMN
                    // Prepare query
                    $add_user_id = $db->prepare("UPDATE comments SET user_dislike_ids = CONCAT(user_dislike_ids, ' $user_id ') WHERE comment_id = :comment_id");

                    // Binding
                    $add_user_id->bindValue(":comment_id", $story_comment_id);

                    // Execution
                    $add_user_id->execute();

                    // INCREASE DISLIKES NUMBER
                    // Prepare query
                    $increase_dislikes_number = $db->prepare("UPDATE comments SET dislikes = dislikes + 1 WHERE comment_id = :comment_id");

                    // Binding
                    $increase_dislikes_number->bindValue(":comment_id", $story_comment_id);

                    // Execution
                    $increase_dislikes_number->execute();

                    // Process database modification
                    $db->commit();
                }                
            }

            // ---- NO ONE DISLIKED THE COMMENT YET ---- //
            else if($user_dislike_ids == null || $user_dislike_ids == "")
            {
                // ADD USER ID TO COLUMN
                // Prepare query
                $add_user_id = $db->prepare("UPDATE comments SET user_dislike_ids = ' $user_id ' WHERE comment_id = :comment_id");

                // Binding
                $add_user_id->bindValue(":comment_id", $story_comment_id);

                // Execution
                $add_user_id->execute();

                // INCREASE DISLIKES NUMBER
                // Prepare query
                $increase_dislikes_number = $db->prepare("UPDATE comments SET dislikes = dislikes + 1 WHERE comment_id = :comment_id");

                // Binding
                $increase_dislikes_number->bindValue(":comment_id", $story_comment_id);

                // Execution
                $increase_dislikes_number->execute();

                // Process database modification
                $db->commit();
            }
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Show error
            echo "<p>Exception caught during story comment dislike toggling : ".$exc->getMessage().".</p>";

            // End script
            exit;
        }
    }

    // If at least one ID does not exist and/or is not a number
    else if(!isset($story_comment_id) || empty($story_comment_id) || !is_numeric($story_comment_id) || !isset($user_id) || empty($user_id) || !is_numeric($user_id))
    {
        // Show error
        echo "<p>Error : at least one ID doesn't exist or is not a number.</p>";

        // End script
        exit;
    }
?>