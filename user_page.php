<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User page</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>User page</h2>

        <!-- NAVIGATION -->
        <nav>

            <!-- HOME -->
            <a href="homepage.php">
                <img src="img/home.png" alt="Home" title="Go to homepage">
            </a>

            <!-- DAY/NIGHT -->
            <img src="img/sun.png" alt="Day Symbol" title="Day Theme On">

            <!-- MAGNIFYING GLASS -->
            <a href="story_search_page.php">
                <img src="img/magnifying_glass.png" alt="Magnifying glass" title="Search stories">
            </a>

            <!-- QUILL -->
            <a href="new_story.php">
                <img src="img/quill.png" alt="Quill" title="Write a new story">
            </a>

            <!-- USER -->
            <a href="user_page.php">
                <img src="img/user.png" alt="User" title="Your page">
            </a>

        </nav>

    </header>

    <!-- MAIN -->
    <main>

        <!-- OUTLINE OF BACK TO TOP DIV -->
        <a id="back_to_top_outline" href="#_header">

            <!-- BACK TO TOP LINK  -->
            <div id="back_to_top"></div>

        </a>

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
            else if (isset($_SESSION['username'])) 
            {
                // ---- DATABASE CONNECTION ----
                require_once("database_connection.php");

                // ---- GET USER ID ----
                require_once("get_user_id.php");

                // ---- GET BOOKMARKED CHAPTER ID ---- //
                // Prepare query
                $get_marked_chapter_id = $db->prepare("SELECT bookmarked_chapter_id FROM users WHERE user_id = :user_id");

                // Binding
                $get_marked_chapter_id->bindValue(":user_id", $user_id);

                // Execution
                $get_marked_chapter_id->execute();

                // Store bookmarked chapter ID
                $marked_chapter_id = $get_marked_chapter_id->fetchColumn();

                // Test
                // echo "<p>Bookmarked chapter ID :</p>";
                // var_dump($marked_chapter_id);

                // If user did bookmark a chapter
                if($marked_chapter_id != null && $marked_chapter_id != "")
                {
                    // --- GET BOOKMARKED CHAPTER'S TITLE AND STORY ID ---- //
                    // Prepare query
                    $get_story_id_chapter_title = $db->prepare("SELECT story_id, chapter_title FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_story_id_chapter_title->bindValue(":chapter_id", $marked_chapter_id);

                    // Execution    
                    $get_story_id_chapter_title->execute();

                    // Store story ID and chapter title
                    $story_id_chapter_title = $get_story_id_chapter_title->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // echo "<p>Story ID and chapter title:</p>";
                    // var_dump($story_id_chapter_title);

                    // ---- GET BOOKMARKED CHAPTER'S STORY INFO ---- //
                    // Prepare query
                    $get_story_info = $db->prepare("SELECT story_title, author, pub_date, tags, likes, dislikes FROM stories WHERE story_id = :story_id");

                    // Binding
                    $get_story_info->bindValue(":story_id", $story_id_chapter_title[0]["story_id"]);

                    // Execution
                    $get_story_info->execute();

                    // Store story info
                    $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // echo "<p>Story info :</p>";
                    // var_dump($story_info);

                    // ---- CREATE TAGS ARRAY ---- //
                    // Separate each tag
                    $tags = explode(" ", $story_info[0]["tags"]);

                    // Test
                    // echo "<p>Tags :</p>";
                    // var_dump($tags);
                }

                // ---- GET USER'S FAVORITE STORIES IDS ---- //
                // Prepare query
                $get_favs_ids = $db->prepare("SELECT favorite_stories_ids FROM users WHERE user_id = :user_id");

                // Binding
                $get_favs_ids->bindValue(":user_id", $user_id);

                // Execution
                $get_favs_ids->execute();

                // Store Favorite Stories IDs
                $favs_ids = $get_favs_ids->fetchColumn();

                // Test
                // echo "<p>Favorite Stories IDs :</p>";
                // var_dump($favs_ids);

                // ---- CREATE USER'S FAVORITE STORIES IDS ARRAY ---- //
                $favs_ids_array = explode("  ", $favs_ids);

                // Test
                // echo "<p>Array of Favorite Stories IDs :</p>";
                // var_dump($favs_ids_array);


                // ---- GET USER'S READ LATER STORIES IDS ---- //
                // Prepare query
                $get_later_ids = $db->prepare("SELECT read_later_ids FROM users WHERE user_id = :user_id");

                // Binding
                $get_later_ids->bindValue(":user_id", $user_id);

                // Execution
                $get_later_ids->execute();

                // Store Read Later IDs
                $later_ids = $get_later_ids->fetchColumn();

                // Test
                // echo "<p>Read Later Stories IDs :</p>";
                // var_dump($later_ids);

                // ---- CREATE USER'S READ LATER STORIES IDS ARRAY ---- //
                $later_ids_array = explode("  ", $later_ids);

                // Test
                // echo "<p>Array of Read Later Stories IDs :</p>";
                // var_dump($later_ids_array);

                // ---- PAGE LAYOUT ---- //
                
                // START of top half section
                echo "<section class='user_page_half_section'>";

                    // START of user info section
                    echo "<section class='user_page_inner_section'>";

                        // Username
                        echo "<h2>".$_SESSION['username']."</h2>";

                        // START of account options div
                        echo "<div class='section_div'>";

                            // User's stories page
                            echo "<a href='story_count_check.php'>Your stories</a>";

                            // Log out
                            echo "<a href='log_out.php'>Log out</a>";

                            // Account delete
                            echo "<p onclick='DeleteAccount($user_id)' class='delete_txt'>Delete account</p>";

                            // END of account options div
                            echo "</div>";

                            // START of notifications div
                            echo "<div class='section_div'>";

                                echo "<p>You have 000 notifications.</p>";

                            // END of notifications div
                            echo "</div>";

                    // END of user info section
                    echo "</section>";

                    // If user bookmarked a chapter
                    if($marked_chapter_id != null && $marked_chapter_id != "")
                    {
                        // START of bookmarked chapter section
                        echo "<section class='story_info_section' onclick='ChapterPage(".$marked_chapter_id.",".$story_id_chapter_title[0]['story_id'].")'>";

                            // START of story and chapter titles div
                            echo "<div class='section_div'>";

                                // Story title
                                echo "<h4>".$story_info[0]['story_title']."</h4>";

                                // Chapter title
                                echo "<h4>".$story_id_chapter_title[0]['chapter_title']."</h4>";

                            // END of story and chapter titles div
                            echo "</div>";

                            // START of story info div
                            echo "<div class='section_div'>";

                                // Author
                                echo "<p>".$story_info[0]['author']."</p>";

                                // Date
                                echo "<p>".date("d-m-Y", strtotime($story_info[0]['pub_date']))."</p>";

                                // Likes
                                echo "<p>".$story_info[0]['likes']." Likes</p>";

                                // Dislikes
                                echo "<p>".$story_info[0]['dislikes']." Dislikes</p>";

                            // END of story info div
                            echo "</div>";

                            // START of tags div
                            echo "<div class='tags_div'>";

                                // For every tag
                                for($i = 0; $i < count($tags); $i++)
                                {
                                    // If tag is not empty
                                    if($tags[$i] != "")
                                    {
                                        // Display it
                                        echo "<p>".$tags[$i]."</p>";
                                    }
                                }

                            // END of tags div
                            echo "</div>";

                        // END of bookmarked chapter section
                        echo "</section>";
                    }

                    // If user did not bookmark a chapter
                    else if($marked_chapter_id == null || $marked_chapter_id == "")
                    {
                        // START of bookmarked chapter section
                        echo "<section class='story_info_section'>";

                            // Tell user they did not bookmark any chapter
                            echo "<p>No bookmarked chapter.</p>";

                        // END of bookmarked chapter section
                        echo "</section>";  
                    }

                    

                // END of top half section
                echo "</section>";


                // START of bottom half section
                echo "<section class='user_page_half_section'>";


                    // START of Favorite Stories Story Container
                    echo "<section class='vertical_story_container'>";

                        // Section title
                        echo "<h3>Favorite Stories</h3>";

                            // If user has at least 1 story in their favs
                            if($favs_ids_array[0] != null && $favs_ids_array[0] != "")
                            {
                                // ---- GET INFO FROM FAVORITE STORIES ---- //
                                // For every favorite story
                                for($i = 0; $i < count($favs_ids_array); $i++)
                                {
                                    // Prepare query to get its info
                                    $get_current_fav_story_info = $db->prepare("SELECT story_title, chapter_ids, author, pub_date, tags, likes, dislikes FROM stories WHERE story_id = :story_id");

                                    // Binding  
                                    $get_current_fav_story_info->bindValue(":story_id", $favs_ids_array[$i]);

                                    // Execution
                                    $get_current_fav_story_info->execute();

                                    // Store current favorite story info
                                    $current_fav_story_info = $get_current_fav_story_info->fetchAll(PDO::FETCH_ASSOC);

                                    // Test
                                    // echo "<p>Info of favorite story n°".($i+1).":</p>";
                                    // var_dump($current_fav_story_info);

                                    // ---- CREATE CURRENT FAVORITE'S STORY'S TAGS ARRAY ---- //
                                    $current_fav_story_tags_array = explode(" ", $current_fav_story_info[0]["tags"]);

                                    // Test
                                    // echo "<p>Current favorite story tags array :</p>";
                                    // var_dump($current_fav_story_tags_array);

                                    // ---- DISPLAY CURRENT FAVORITE STORY'S STORY BOX ---- //
                                    // START of current favorite story's story box
                                    echo "<section class='story_info_section' onclick='Synopsis(\"".$current_fav_story_info[0]['story_title']."\",\"".$current_fav_story_info[0]['author']."\",\"".$current_fav_story_info[0]['tags']."\",\"".$current_fav_story_info[0]['chapter_ids']."\")'>";

                                        // START of story title div
                                        echo "<div>";

                                            // Story title
                                            echo "<h4>".$current_fav_story_info[0]['story_title']."</h4>";

                                        // END of story title div
                                        echo "</div>";


                                        // START of story stats div
                                        echo "<div>";

                                            // Author
                                            echo "<p>".$current_fav_story_info[0]['author']."</p>";

                                            // Date
                                            echo "<p>".date("d-m-Y", strtotime($current_fav_story_info[0]['pub_date']))."</p>";

                                            // Likes
                                            echo "<p>".$current_fav_story_info[0]['likes']." Likes</p>";

                                            // Dislikes
                                            echo "<p>".$current_fav_story_info[0]['dislikes']." Dislikes</p>";

                                        // END of story stats div
                                        echo "</div>";


                                        // START of tags div
                                        echo "<div class='tags_div'>";

                                            // For each tag
                                            foreach($current_fav_story_tags_array as $tag)
                                            {
                                                // If that tag is not empty
                                                if($tag != "")
                                                {
                                                    // Display it
                                                    echo "<p>$tag</p>";
                                                }
                                            }

                                        // END of tags div
                                        echo "</div>";

                                    // END of current favorite story's story box
                                    echo "</section>";
                                }
                            }

                            // If user has less than 1 story in their favs
                            else if($favs_ids_array[0] == null || $favs_ids_array[0] == "")
                            {
                                // Tell user they have no stories in their favorites
                                echo "<p>You have no favorite story.</p>";
                            }

                    // END of Favorite Stories section
                    echo "</section>";

                    // START of Read Later Story Container
                    echo "<section class='vertical_story_container'>";

                        // Section title
                        echo "<h3>Read Later</h3>";

                        // If user has at least 1 story in their read later
                        if($later_ids_array[0] != null && $later_ids_array[0] != "")
                        {
                            // ---- GET INFO FROM READ LATER STORIES ---- //
                            // For every Read Later story
                            for($i = 0; $i < count($later_ids_array); $i++)
                            {
                                // Prepare query to get its info
                                $get_current_later_story_info = $db->prepare("SELECT story_title, chapter_ids, author, pub_date, tags, likes, dislikes FROM stories WHERE story_id = :story_id");

                                // Binding  
                                $get_current_later_story_info->bindValue(":story_id", $later_ids_array[$i]);

                                // Execution
                                $get_current_later_story_info->execute();

                                // Store current favorite story info
                                $current_later_story_info = $get_current_later_story_info->fetchAll(PDO::FETCH_ASSOC);

                                // Test
                                // echo "<p>Info of Read Later story n°".($i+1).":</p>";
                                // var_dump($current_later_story_info);
                                // exit;

                                // ---- CREATE CURRENT READ LATER STORY'S TAGS ARRAY ---- //
                                $current_later_story_tags_array = explode(" ", $current_later_story_info[0]["tags"]);

                                // Test
                                // echo "<p>Current favorite story tags array :</p>";
                                // var_dump($current_fav_story_tags_array);

                                // ---- DISPLAY CURRENT READ LATER STORY'S STORY BOX ---- //
                                // START of current read later story's story box
                                echo "<section class='story_info_section' onclick='Synopsis(\"".$current_later_story_info[0]['story_title']."\",\"".$current_later_story_info[0]['author']."\",\"".$current_later_story_info[0]['tags']."\",\"".$current_later_story_info[0]['chapter_ids']."\")'>";

                                    // START of story title div
                                    echo "<div>";

                                        // Story title
                                        echo "<h4>".$current_later_story_info[0]['story_title']."</h4>";

                                    // END of story title div
                                    echo "</div>";


                                    // START of story stats div
                                    echo "<div>";

                                        // Author
                                        echo "<p>".$current_later_story_info[0]['author']."</p>";

                                        // Date
                                        echo "<p>".date("d-m-Y", strtotime($current_later_story_info[0]['pub_date']))."</p>";

                                        // Likes
                                        echo "<p>".$current_later_story_info[0]['likes']." Likes</p>";

                                        // Dislikes
                                        echo "<p>".$current_later_story_info[0]['dislikes']." Dislikes</p>";

                                    // END of story stats div
                                    echo "</div>";


                                    // START of tags div
                                    echo "<div class='tags_div'>";

                                        // For each tag
                                        foreach($current_later_story_tags_array as $tag)
                                        {
                                            // If that tag is not empty
                                            if($tag != "")
                                            {
                                                // Display it
                                                echo "<p>$tag</p>";
                                            }
                                        }

                                    // END of tags div
                                    echo "</div>";

                                // END of current favorite story's story box
                                echo "</section>";
                            }
                        }

                        // If user has less than 1 story in their read later
                        else if($later_ids_array[0] == null || $later_ids_array[0] == "")
                        {
                            // Tell user they have no stories to read later
                            echo "<p>You have no story to read later.</p>";
                        }

                    // END of Read Later section
                    echo "</section>";



                // END of bottom half section
                echo "</section>";
        ?>

        <?php
            } 
        ?>

    </main>

    <!-- SCRIPTS -->
    <script src="synopsis.js"></script>
    <script src="chapter_page.js"></script>
    <script src="delete_account.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>