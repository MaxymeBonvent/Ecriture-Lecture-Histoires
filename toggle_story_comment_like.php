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
        // Try to like comment
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- GET IDS OF EVERYONE WHO LIKED THIS COMMENT ---- //
            // Prepare query
            $get_user_like_ids = $db->prepare("SELECT user_like_ids FROM comments WHERE comment_id = :comment_id AND user_id = :user_id");

            // Binding
            $get_user_like_ids->bindValue(":comment_id", $story_comment_id);
            $get_user_like_ids->bindValue(":user_id", $user_id);

            // Execution
            $get_user_like_ids->execute();

            // Store results
            $user_like_ids = $get_user_like_ids->fetchColumn();

            // Test
            // echo "<p>IDs of users who already liked this story comment :</p>";
            // var_dump($user_like_ids);
            // exit;

            // ---- AT LEAST ONE USER LIKED THE COMMENT ---- //
            if($user_like_ids != null && $user_like_ids != "")
            {
                // ---- USER ALREADY LIKED THIS COMMENT ---- //
                if(str_contains($user_like_ids, $user_id))
                {
                    // REMOVE USER ID FROM COLUMN
                    // Prepare query
                    $remove_user_id = $db->prepare("UPDATE comments SET user_like_ids = REPLACE(user_like_ids, ' $user_id ', '') WHERE comment_id = :comment_id");

                    // Binding
                    $remove_user_id->bindValue(":comment_id", $story_comment_id);

                    // Execution
                    $remove_user_id->execute();

                    // Process database modification
                    $db->commit();
                }

                // ---- USER DID NOT LIKE THIS COMMENT YET ---- // 
                else if(!str_contains($user_like_ids, $user_id))
                {
                    // ADD USER ID TO COLUMN
                    // Prepare query
                    $add_user_id = $db->prepare("UPDATE comments SET user_like_ids = CONCAT(user_like_ids, ' $user_id ') WHERE comment_id = :comment_id");

                    // Binding
                    $add_user_id->bindValue(":comment_id", $story_comment_id);

                    // Execution
                    $add_user_id->execute();

                    // Process database modification
                    $db->commit();
                }                
            }

            // ---- NO ONE LIKED THE COMMENT YET ---- //
            else if($user_like_ids == null || $user_like_ids == "")
            {
                // ADD USER ID TO COLUMN
                // Prepare query
                $add_user_id = $db->prepare("UPDATE comments SET user_like_ids = CONCAT(user_like_ids, ' $user_id ') WHERE comment_id = :comment_id");

                // Binding
                $add_user_id->bindValue(":comment_id", $story_comment_id);

                // Execution
                $add_user_id->execute();

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
            echo "<p>Exception caught during story comment like toggling : ".$exc->getMessage().".</p>";

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