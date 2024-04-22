<?php
    // DATABASE CONNECTION
    require_once("database_connection.php");

    // URL VARIABLES
    $tags = htmlspecialchars($_GET["tags"]);
    $story_title = htmlspecialchars($_GET["story_title"]);
    $author = htmlspecialchars($_GET["author"]);
    $min_word_count = htmlspecialchars($_GET["min_word_count"]);
    $max_word_count = htmlspecialchars($_GET["max_word_count"]);

    // Prevent queries where MAX is less than MIN
    if(isset($min_word_count) && !empty($min_word_count) && isset($max_word_count) && !empty($max_word_count) && $max_word_count < $min_word_count)
    {
        // Show error
        echo "<p>Logic error : maximum word count is less than minimum word count.</p>";

        // End script
        exit;
    }

    // Try to search stories
    try
    {
        // Initial dynamic query
        $dynamic_query = "SELECT story_id FROM stories WHERE 1=1 ";

        // If at least 1 tag is given
        if(isset($tags) && !empty($tags))
        {
            // Add a tag criteria to the dynamic query
            $dynamic_query .= "AND tags LIKE '%$tags%' ";
        }

        // If a title is given
        if(isset($story_title) && !empty($story_title))
        {
            // Add a story title criteria to the dynamic query
            $dynamic_query .= "AND story_title LIKE '%$story_title%' ";
        }

        // If an author is given
        if(isset($author) && !empty($author))
        {
            // Add an author criteria to the dynamic query
            $dynamic_query .= "AND author LIKE '%$author%' ";
        }

        // If a minimum word count is given
        if(isset($min_word_count) && !empty($min_word_count))
        {
            // Add a minimum word count criteria to the dynamic query
            $dynamic_query .= "AND word_count >= $min_word_count ";
        }

        // If a maximum word count is given
        if(isset($max_word_count) && !empty($max_word_count))
        {
            // Add a maximum word count criteria to the dynamic query
            $dynamic_query .= "AND word_count <= $max_word_count ";
        }

        // Prepare full query
        $full_query = $db->prepare($dynamic_query);

        // Execution
        $full_query->execute();

        // Store result
        $story_ids = $full_query->fetchAll(PDO::FETCH_ASSOC);

        // For every story ID found
        for($i = 0; $i < count($story_ids); $i++)
        {
            // Transfer it
            echo $story_ids[$i]["story_id"];

            // Add a space to distinguish the different stories
            echo " ";
        }
    }

    // Catch any exception
    catch(Exception $exc)
    {
        // Show error message
        echo "<p>Exception caught during story search : ".$exc->getMessage().".</p>";

        // End script
        exit;
    }
?>