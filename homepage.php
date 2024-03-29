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
    <header>

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

        <?php
            // Start user session
            session_start();

            // Database connection
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

                // Closing
                $get_marked_chapter->closeCursor();

                // If marked chapter ID is not null
                if($marked_chapter_id != null)
                {
                    // ---- GET BOOKMARKED CHAPTER'S TITLE ----

                    // Prepare a query to get bookmarked chapter's title
                    $get_chapter_title = $db->prepare("SELECT chapter_title FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_chapter_title->bindValue(":chapter_id", $marked_chapter_id);

                    // Execution
                    $get_chapter_title->execute();

                    // Store chapter title
                    $chapter_title = $get_chapter_title->fetchColumn();

                    // ---- GET BOOKMARKED CHAPTER'S STORY INFO ----

                    // Prepare a query to get bookmarked chapter's story info
                    $get_story_info = $db->prepare("SELECT * FROM stories WHERE chapter_ids = ' $marked_chapter_id '");

                    // Execution    
                    $get_story_info->execute();

                    // Store story info
                    $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

                    // Closing
                    $get_story_info->closeCursor();

                    // ---- CREATE TAGS ARRAY ----
                    $tags_array = explode(" ", $story_info[0]['tags']);

                    // Display chapter in progress
                    echo    "   <h3>Currently reading</h3>

                                <div class='story_div' style='width: 50%;'>

                                    <div class='story_info'>

                                        <h4>".$story_info[0]['story_title']."</h4>
                                        <h4>$chapter_title</h4>
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
        ?>

    </main>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>