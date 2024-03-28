<?php
    // ---- DATABASE CONNECTION ----
    require_once("database_connection.php");

    // ---- CHAPTER INFO OBTENTION ----

    // Try to obtain chapter info
    try
    {
        // Chapter ID
        $chapter_id = $_POST["chapter_id"];

        // Query to obtain chapter info of the clicked chapter
        $get_chapter_info = $db->prepare("SELECT story_id, chapter_title, chapter_text, likes, dislikes FROM chapters WHERE chapter_id = :chapter_id");

        // Binding
        $get_chapter_info->bindValue(":chapter_id", $chapter_id);
        
        // Execution
        $get_chapter_info->execute();

        // Store all info in an associative array
        $chapter_infos = $get_chapter_info->fetchAll(PDO::FETCH_ASSOC);

        // Encode array as JSON
        $json = json_encode($chapter_infos);
        echo $json;
    }

    // Catch any problem
    catch(Exception $exc)
    {
        // Output error message
        echo "<p>Exception caught during chapter info retrieval : ". $exc->getMessage() ."</p>";

        // End script
        exit;
    }
?>