<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Homepage</title>
    <link rel="stylesheet" href="stories.css">

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

            <!-- DAY/NIGHT -->
            <img src="img/sun.png" alt="Day Symbol" title="Day Theme On">

            <!-- MAGNIFYING GLASS -->
            <img src="img/magnifying_glass.png" alt="Magnifying glass" title="Search stories">

            <!-- NOTIFICATIONS -->
            <img src="img/mail.png" alt="Mail" title="Notifications">

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

            // DATABASE CONNECTION
            require_once("database_connection.php");

            // If user is logged in
            if(isset($_SESSION["username"]))
            {
                // GET USER'S BOOKMARKED CHAPTER

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
                    // ---- GET BOOKMARKED CHAPTER'S TITLE ----

                    // Prepare a query to get bookmarked chapter's info
                    $get_chapter_info = $db->prepare("SELECT chapter_id, chapter_title FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_chapter_info->bindValue(":chapter_id", $marked_chapter_id);

                    // Execution
                    $get_chapter_info->execute();

                    // Store chapter info
                    $chapter_info = $get_chapter_info->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    var_dump($chapter_info);
                    // exit;

                    // ---- GET BOOKMARKED CHAPTER'S STORY INFO ----

                    // Prepare a query to get bookmarked chapter's story info
                    $get_story_info = $db->prepare("SELECT story_id, story_title FROM stories WHERE chapter_ids = :chapter_id");

                    // Binding
                    $get_story_info->bindValue(":chapter_id", $marked_chapter_id);

                    // Execution    
                    $get_story_info->execute();

                    // Store story info
                    $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    var_dump($story_info);
                    // exit;

                    // Closing
                    $get_story_info->closeCursor();

                    // If there's is a story retrieved
                    if($story_info != null)
                    {
                        // ---- CREATE TAGS ARRAY ---- //
                        $tags_array = explode(" ", $story_info[0]['tags']);

                        // Display story box with chapter in progress
                        echo    "   <h3>Currently reading</h3>

                                    <div class='story_div' style='width: 50%;' onclick='Synopsis(\"".$story_info[0]['story_title']."\",\"".$story_info[0]['author']."\",\"".$story_info[0]['tags']."\",\"".$story_info[0]['chapter_ids']."\")'>

                                        <div class='story_info'>

                                            <h4>".$story_info[0]['story_title']."</h4>
                                            <h4>$chapter_title</h4>

                                        </div>

                                        <div class='story_info'>

                                            <p>".$story_info[0]['author']."</p>
                                            <p>".date("d-m-Y", strtotime($story_info[0]['pub_date']))."</p>
                                            <p>".$story_info[0]['likes']." Likes</p>
                                            <p>".$story_info[0]['dislikes']." Dislikes</p>

                                        </div>

                                        <div class='tags_div'>";

                                        // For each tag
                                        for($i = 0; $i < count($tags_array)-1; $i++)
                                        {
                                            // Display it
                                            echo "<p>".$tags_array[$i]."</p>";
                                        }

                                        echo "</div>

                                    </div>
                                ";
                    }
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
                echo    "   <div class='story_div' onclick='Synopsis(\"".$featured_story['story_title']."\",\"".$featured_story['author']."\",\"".$featured_story['tags']."\",\"".$featured_story['chapter_ids']."\")'>

                                <div class='story_info'>
                                    <h4>".$featured_story['story_title']."</h4>
                                </div>

                                <div class='story_info'>
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
                echo    "   <div class='story_div' onclick='Synopsis(\"".$newest_story['story_title']."\",\"".$newest_story['author']."\",\"".$newest_story['tags']."\",\"".$newest_story['chapter_ids']."\")'>

                                <div class='story_info'>
                                    <h4>".$newest_story['story_title']."</h4>
                                </div>

                                <div class='story_info'>
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
    <script src="synopsis.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>