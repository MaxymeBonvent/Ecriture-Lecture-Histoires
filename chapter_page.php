<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chapter Reading</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Chapter Reading</h2>

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
            if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
            {
                // Get their ID
                require_once("get_user_id.php");
            }

            // URL VARIABLES
            $chapter_id = htmlspecialchars($_GET["chapter_id"]);
            $story_id = htmlspecialchars($_GET["story_id"]);

            // GET STORY INFO

            // Prepare query to get story info of the clicked chapter
            $get_story_info = $db->prepare("SELECT story_title, author, tags, synopsis FROM stories WHERE story_id = :story_id");

            // Binding
            $get_story_info->bindValue(":story_id", $story_id);

            // Execution
            $get_story_info->execute();

            // Store story info
            $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($story_info);

            // GET TAGS ARRAY
            $tags = explode(" ", $story_info[0]["tags"]);
            // var_dump($tags);

            // GET CHAPTER TEXT

            // Prepare query to get chapter text of the clicked chapter
            $get_chapter_text = $db->prepare("SELECT chapter_text FROM chapters WHERE chapter_id = :chapter_id");

            // Binding
            $get_chapter_text->bindValue(":chapter_id", $chapter_id);

            // Execution
            $get_chapter_text->execute();

            // Store story info
            $chapter_text = $get_chapter_text->fetchColumn();
        ?>

        <!-- SECTION 1 : STORY INFO, SYNOPSIS, BOOKMARK -->
        <section style="flex-direction: column;">

            <?php
                echo "<h4>".$story_info[0]['story_title']."</h4>";
                echo "<p>".$story_info[0]['author']."</p>";

                // START of tags div
                echo "<div class='tags_div'>";

                    // For each tag 
                    foreach($tags as $tag)
                    {
                        // If tag is not an empty string
                        if($tag != "" && $tag != " ")
                        {
                            // Display it
                            echo "<p>$tag</p>";
                        }
                    }

                // END of tags div
                echo "</div>";

                // Synopsis text
                echo "<p>".$story_info[0]['synopsis']."</p>";

                // Bookmark
                echo "<p class='chapter_option' onclick='Bookmark($chapter_id, $user_id)'>Bookmark this chapter</p>";
            ?>

        </section>

        <!-- SECTION 2 :  -->
        <section>

            <?php
                
            ?>

        </section>

    </main>

    <!-- SCRIPTS -->
    <script src="bookmark.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>