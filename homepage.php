<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Homepage</title>

    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/back_to_top.css">
    <link rel="stylesheet" href="CSS/homepage.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Homepage</h2>

        <!-- NAVIGATION -->
        <nav>

            <!-- HOME -->
            <a href="homepage.php">
                <img src="img/home.png" alt="Home" title="Go to homepage">
            </a>

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

        <!-- BACK TO TOP LINK  -->
        <a id="back_to_top_link" href="#_header">

            <!-- BACK TO TOP IMAGE -->
            <img src="img/top.png" alt="Page top icon" id="back_to_top_img">

        </a>

        <?php
            // Start user session
            session_start();

            // DATABASE CONNECTION
            require_once("database_connection.php");

            // If user is logged in (optional)
            if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
            {
                // GET USER ID
                require_once("get_user_id.php");

                // GET BOOKMARKED CHAPTER ID

                // Prepare a query to get user's bookmarked chapter
                $get_marked_chapter = $db->prepare("SELECT bookmarked_chapter_id FROM users WHERE username = :username");

                // Binding
                $get_marked_chapter->bindValue(":username", $_SESSION["username"]);

                // Execution
                $get_marked_chapter->execute();

                // Store marked chapter ID
                $marked_chapter_id = $get_marked_chapter->fetchColumn();

                // Test
                // var_dump($marked_chapter_id);
                // exit;

                // Closing
                $get_marked_chapter->closeCursor();

                // If marked chapter ID is not null
                if($marked_chapter_id != null)
                {
                    // ---- GET BOOKMARKED CHAPTER ----

                    // Prepare a query to get bookmarked chapter's info
                    $get_chapter_info = $db->prepare("SELECT chapter_id, chapter_title FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_chapter_info->bindValue(":chapter_id", $marked_chapter_id);

                    // Execution
                    $get_chapter_info->execute();

                    // Store chapter info
                    $chapter_info = $get_chapter_info->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // var_dump($chapter_info);
                    // exit;

                    // ---- GET BOOKMARKED CHAPTER'S STORY INFO ----

                    // Prepare a query to get bookmarked chapter's story info
                    $get_story_info = $db->prepare("SELECT story_id, chapter_ids, story_title, author, tags, pub_date, likes, dislikes FROM stories WHERE chapter_ids LIKE '%$marked_chapter_id%'");

                    // Binding
                    // $get_story_info->bindValue(":chapter_id", $chapter_info[0]["chapter_id"]);

                    // Execution    
                    $get_story_info->execute();

                    // Store story info
                    $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // var_dump($story_info);
                    // exit;

                    // Closing
                    $get_story_info->closeCursor();

                    // If there's is a story retrieved
                    if($story_info != null && !empty($story_info))
                    {
                        // ---- CREATE TAGS ARRAY ---- //
                        $tags_array = explode(" ", $story_info[0]['tags']);

                        // SECTION TITLE
                        echo "<h3>Currently reading</h3>";

                        // START of bookmarked chapter story box
                        echo    "<div class='story_box' onclick='ChapterPage(".$chapter_info[0]['chapter_id'].",".  $story_info[0]['story_id'].")'>";

                                // STORY AND CHAPTER TITLES
                                echo "  <div>

                                            <h4>".$story_info[0]['story_title']."</h4>
                                            <h4>".$chapter_info[0]['chapter_title']."</h4>

                                        </div>";

                                // STATS
                                echo "  <div>

                                            <p>".$story_info[0]['author']."</p>
                                            <p>".date("d-m-Y", strtotime($story_info[0]['pub_date']))."</p>
                                            <p>".$story_info[0]['likes']." Likes</p>
                                            <p>".$story_info[0]['dislikes']." Dislikes</p>

                                        </div>";


                            // START OF TAGS DIV
                            echo "  <div class='tags_div'>";

                                    // For each tag
                                    for($i = 0; $i < count($tags_array)-1; $i++)
                                    {
                                        // Display it
                                        echo "<p>".$tags_array[$i]."</p>";
                                    }

                            // END OF TAGS DIV
                            echo "</div>";

                        // END of bookmarked chapter story box
                        echo "</div>";
                    }

                    // If there's no story retrieved
                    else if($story_info == null || empty($story_info))
                    {
                        // Tell user there's no story
                        echo "<p>No story retrieved.</p>";
                    }
                }

                // If there's no bookmarked chapter
                else if($marked_chapter_id == null)
                {
                    // Tell user there's no bookmarked chapter
                    echo "<p>No bookmarked chapter.</p>";
                }
            }

            // Get today's date
            $today_date = date("Y-m-d");

            // ---- FEATURED STORIES ---- //
            echo "<h3>Featured Stories</h3>";

            // Section START
            echo "<section>";

            // Prepare a query to get the 10 best stories of the month
            $get_featured_stories = $db->prepare("SELECT story_title, synopsis, chapter_ids, author, pub_date, likes, dislikes, tags FROM stories WHERE likes >= dislikes + 100 AND comment_count >= 30 AND DATEDIFF('$today_date', pub_date) < 31 LIMIT 12");

            // Execution
            $get_featured_stories->execute();

            // Store featured stories
            $featured_stories = $get_featured_stories->fetchAll(PDO::FETCH_ASSOC);

            // LOOP OF FEATURED STORIES
            foreach($featured_stories as $featured_story)
            {
                // Make an array of that story's tags
                $tags = explode(" ", $featured_story["tags"]);

                // Display info of that story in a div
                echo    "   <div class='story_box' onclick='Synopsis(\"".$featured_story['story_title']."\",\"".$featured_story['author']."\",\"".$featured_story['tags']."\",\"".$featured_story['chapter_ids']."\")'>

                                <div>
                                    <h4>".$featured_story['story_title']."</h4>
                                </div>

                                <div>
                                    <p>".$featured_story['author']."</p>
                                    <p>".date("d-m-Y", strtotime($featured_story['pub_date']))."</p>
                                    <p>".$featured_story['likes']." Likes</p>
                                    <p>".$featured_story['dislikes']." Dislikes</p>
                                </div>

                                <div class='tags_div'>";

                                    // For each tag
                                    for($i = 0; $i < count($tags)-1; $i++)
                                    {
                                        // Display it
                                        echo "<p>".$tags[$i]."</p>";
                                    }

                                    echo "</div>

                            </div>
                        ";
            }

            // Section END
            echo "</section>";

            // ---- NEWEST STORIES ---- //

            echo "<h3>Newest Stories</h3>";

            // Section START
            echo "<section>";

            // Prepare a query to get the 20 newest stories
            $get_newest_stories = $db->prepare("SELECT story_title, synopsis, chapter_ids, author, pub_date, likes, dislikes, tags FROM stories ORDER BY pub_date DESC LIMIT 20");

            // Execution
            $get_newest_stories->execute();

            // Store newest stories
            $newest_stories = $get_newest_stories->fetchAll(PDO::FETCH_ASSOC);

            // LOOP OF NEWEST STORIES
            foreach($newest_stories as $newest_story)
            {
                // Make an array of that story's tags
                $tags = explode(" ", $newest_story["tags"]);

                // Display info of that story in a div
                echo    "   <div class='story_box' onclick='Synopsis(\"".$newest_story['story_title']."\",\"".$newest_story['author']."\",\"".$newest_story['tags']."\",\"".$newest_story['chapter_ids']."\")'>

                                <div>
                                    <h4>".$newest_story['story_title']."</h4>
                                </div>

                                <div>
                                    <p>".$newest_story['author']."</p>
                                    <p>".date("d-m-Y", strtotime($newest_story['pub_date']))."</p>
                                    <p>".$newest_story['likes']." Likes</p>
                                    <p>".$newest_story['dislikes']." Dislikes</p>
                                </div>

                                <div class='tags_div'>";

                                    // For each tag
                                    for($i = 0; $i < count($tags)-1; $i++)
                                    {
                                        // Display it
                                        echo "<p>".$tags[$i]."</p>";
                                    }

                                    echo "</div>

                            </div>
                        ";
            }

            // Section END
            echo "</section>";
        ?>

    </main>

    <!-- SCRIPTS -->
    <script src="JS/synopsis.js"></script>
    <script src="JS/chapter_page.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>