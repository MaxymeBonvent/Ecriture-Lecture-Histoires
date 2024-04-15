<?php
    // SESSION
    session_start();

    // DATABASE CONNECTION
    require_once("database_connection.php");

    // USER ID
    require_once("get_user_id.php");

    // URL VARIABLES
    $url_chapter_id = htmlspecialchars($_GET["chapter_id"]);

    // Test
    // echo "<p>URL chapter ID :</p>";
    // var_dump($url_chapter_id);
    // exit;

    // ---- INCORRECT URL ---- //

    // Chapter ID
    if(!isset($url_chapter_id) || empty($url_chapter_id))
    {
        // Error message
        echo "Error : no chapter ID.";

        // End script
        exit;
    }

    // User ID
    if(!isset($user_id) || empty($user_id))
    {
        // Error message
        echo "Error : no user ID.";

        // End script
        exit;
    }

    // ---- CORRECT URL ---- //
    // If there's a valid chapter ID and a valid user ID
    if(isset($url_chapter_id) && !empty($url_chapter_id) && isset($user_id) && !empty($user_id))
    {
        // Try to toggle the bookmarking of a chapter
        try
        {
            // Start database modification
            $db->beginTransaction();

            // ---- GET USER'S BOOKMARKED CHAPTER ID ---- //
            // Prepare query
            $get_marked_id = $db->prepare("SELECT bookmarked_chapter_id FROM users WHERE user_id = :user_id");

            // Binding
            $get_marked_id->bindValue(":user_id", $user_id);

            // Execution
            $get_marked_id->execute();

            // Store marked ID
            $marked_id = $get_marked_id->fetchColumn();

            // Test
            // echo "<p>Bookmarked chapter ID :</p>";
            // var_dump($marked_id);
            // exit;

            // ---- TOGGLE ADDITION OR REMOVAL OF URL CHAPTER ID ---- //
            // If there is a bookmarked chapter
            if($marked_id != "")
            {
                // If the stored chapter ID is different from URL's chapter ID
                if($marked_id != $url_chapter_id)
                {
                    // ---- REMOVE USER'S ID FROM PREVIOUSLY STORED CHAPTER'S USER_BOOKMARK_IDS COLUMN ---- //
                    // Prepare query
                    $remove_user_id_from_previous_chap = $db->prepare("UPDATE chapters SET user_bookmark_ids = REPLACE(user_bookmark_ids, ' $user_id ', '')");

                    // Execution
                    $remove_user_id_from_previous_chap->execute();

                    // ---- ADD USER'S ID TO URL CHAPTER'S USER_BOOKMARK_IDS COLUMN ---- //
                    // Prepare query
                    $add_user_id_to_url_chap = $db->prepare("UPDATE chapters SET user_bookmark_ids = user_bookmark_ids + ' $user_id '  WHERE chapter_id = :previous_chapter_id");

                    // Binding
                    $add_user_id_to_url_chap->bindValue(":previous_chapter_id", $marked_id);

                    // Execution
                    $add_user_id_to_url_chap->execute();

                    // ---- REPLACE STORED CHAPTER ID WITH URL CHAPTER ID ---- //
                    // Prepare query
                    $replace_marked_with_url = $db->prepare("UPDATE users SET bookmarked_chapter_id = REPLACE(bookmarked_chapter_id, :marked_id, :url_chapter_id) WHERE user_id = :user_id");

                    // Binding
                    $replace_marked_with_url->bindValue(":marked_id", $marked_id);
                    $replace_marked_with_url->bindValue(":url_chapter_id", $url_chapter_id);
                    $replace_marked_with_url->bindValue(":user_id", $user_id);

                    // Execution
                    $replace_marked_with_url->execute();

                    // Process database modification
                    $db->commit();
                }

                // If the stored chapter ID is the same as URL's chapter ID
                else if($marked_id == $url_chapter_id)
                {
                    // ---- EMPTY USER'S BOOKMARKED CHAPTER ID COLUMN ---- //
                    // Prepare query
                    $empty_marked_column = $db->prepare("UPDATE users SET bookmarked_chapter_id = REPLACE(bookmarked_chapter_id, :marked_id, '') WHERE user_id = :user_id");

                    // Binding
                    $empty_marked_column->bindValue(":marked_id", $marked_id);
                    $empty_marked_column->bindValue(":user_id", $user_id);

                    // Execution
                    $empty_marked_column->execute(); 

                    // ---- REMOVE USER'S ID FROM STORED CHAPTER'S USER_BOOKMARK_IDS COLUMN ---- //
                    // Prepare query
                    $remove_user_id_from_url_chap = $db->prepare("UPDATE chapters SET user_bookmark_ids = REPLACE(user_bookmark_ids, ' $user_id ', '') WHERE chapter_id = :previous_chapter_id");

                    // Binding
                    $remove_user_id_from_url_chap->bindValue(":previous_chapter_id", $url_chapter_id);

                    // Execution
                    $remove_user_id_from_url_chap->execute();

                    // Process database modification
                    $db->commit();
                }
            }

            // If there is no bookmarked chapter
            else if($marked_id  == "")
            {
                // ---- ADD URL CHAPTER ID TO USER'S BOOKMARKED CHAPTER ID COLUMN ---- //
                // Prepare query
                $add_url_id = $db->prepare("UPDATE users SET bookmarked_chapter_id = :url_chapter_id WHERE user_id = :user_id");

                // Binding
                $add_url_id->bindValue(":url_chapter_id", $url_chapter_id);
                $add_url_id->bindValue(":user_id", $user_id);

                // Execution
                $add_url_id->execute(); 

                // ---- ADD USER'S ID TO URL CHAPTER'S USER_BOOKMARK_IDS COLUMN ---- //
                // Prepare query
                $add_user_id_to_url_chap = $db->prepare("UPDATE chapters SET user_bookmark_ids = user_bookmark_ids + ' $user_id '  WHERE chapter_id = :previous_chapter_id");

                // Binding
                $add_user_id_to_url_chap->bindValue(":previous_chapter_id", $url_chapter_id);

                // Execution
                $add_user_id_to_url_chap->execute();

                // Process database modification
                $db->commit();
            }
        }

        // Catch any problem
        catch(Exception $exc)
        {
            // Cancel database modification
            $db->rollBack();

            // Output error message
            echo "<p>Exception caught during chapter bookmark toggle : ".$exc->getMessage()."</p>";

            // End script
            exit;
        }
    }
?>