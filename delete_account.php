<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // User ID
    $user_id = htmlspecialchars($_GET["user_id"]);

    // If user ID does not exists
    if(!isset($user_id) || empty($user_id))
    {
        // Error message
        echo "<p>Error : no user ID.</p>";

        // End script
        exit;
    }

    // If user ID exists
    else if(isset($user_id) && !empty($user_id))
    {
        /*
            Try to delete user's : 

            1) comments,         
            2) chapters,
            3) stories,

            Try to remove user's ID from :

            4) chapter comments like IDs,  
            5) chapter comments dislike IDs,  

            6) chapter like IDs, 
            7) chapter dislike IDs,

            8) chapter bookmark IDs,

            9) story comments like IDs,
            10) story comments dislike IDs,

            11) story like IDs.
            12) story dislike IDs.
        */
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- 1) DELETE USER'S COMMENTS ---- //

            // Prepare query
            $delete_comments = $db->prepare("DELETE FROM comments WHERE user_id = :user_id");

            // Binding
            $delete_comments->bindValue(":user_id", $user_id);

            // Execute
            $delete_comments->execute();

            // ---- 2) DELETE USER'S  CHAPTERS ---- //

            // Get every story
            $get_stories = $db->prepare("");
            

            // Process database modification
            $db->commit();

            // ---- REDIRECTION ---- //

            // Redirect user to account deletion confirmation page
            header("Location: user_delete_confirm.php");

            // End script
            exit();
        }

        // Catch any exception
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Log and Output error message
            error_log("Exception caught during account deletion : ".$exc->getMessage());
            echo "<p>Exception caught during account deletion : ".$exc->getMessage()."</p>";
        }
    }
?>