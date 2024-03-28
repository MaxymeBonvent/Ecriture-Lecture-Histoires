<?php
    // Start user session
    session_start();

    // If user session is not set
    if(!isset($_SESSION['username'])) 
    {
        // Redirect user to log in form page
        header("Location: log_in_form.php");
    }

    // If user session is set
    else if(isset($_SESSION['username']))
    {
        // ---- DATABASE CONNECTION ----
        require_once("database_connection.php");

        // ---- STORY COUNT ----

        // Try to get story count
        try
        {
            // Prepare a query to get story count
            $story_count_query = $db->prepare("SELECT story_count FROM users WHERE username = :username");

            // Binding
            $story_count_query->bindValue(":username", $_SESSION['username']);
                
            // Execution
            $story_count_query->execute();

            // Get result
            $story_count = $story_count_query->fetch(); // $story_count is an array of two elements

            // Closing
            $story_count_query->closeCursor();

            // ---- REDIRECTIONS ----

            // If user wrote less than 1 story ($story_count is an array of two elements)
            if($story_count[0] < 1)
            {
                // Redirect them to New Story Page
                header("Location: new_story.php");
            }

            // If user wrote at least 1 story
            else if($story_count[0] > 0)
            {
                // Redirect them to Manage User Stories Page
                header("Location: user_stories.php");
            }
        }

        catch(Exception $exc)
        {
            // Output an error message
            echo "<p>Exception caught during story counting  : " . $exc->getMessage() . "</p>";

            // End script
            exit;
        }
    }
?>