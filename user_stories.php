<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Stories</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Your Stories</h2>

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

    <!-- CHECK IF USER IS LOGGED IN -->
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

            // --- USER ID ---
            require_once("get_user_id.php");

            // ---- ALL STORIES AND CHAPTERS ----

            // Try getting user ID, their stories, their chapters and info from those chapters
            try
            {
                // ---- GET STORY TITLES ----

                // Prepare query to get every story title from the logged in user
                $get_story_titles = $db->prepare("SELECT pub_date, story_title FROM stories WHERE user_id = :user_id ORDER BY pub_date DESC");

                // Binding
                $get_story_titles->bindValue(":user_id", $user_id);

                // Execution
                $get_story_titles->execute();

                // Store the fetch of all story titles in an associative array
                $story_titles = $get_story_titles->fetchAll(PDO::FETCH_ASSOC);

                // Closing
                $get_story_titles->closeCursor();

                // ---- DISPLAY STORY TITLES ----

                // GREAT DIV THAT CONTAINS STORIES LIST DIVS AND CHAPTER INFO DIV
                echo "<div id='stories_list_and_chapter_info_container'>";

                // START of the div containing divs containing a story and its chapters
                echo "<div id='user_page_stories_list'>";

                // Loop of story titles and chapters
                foreach($story_titles as $story_title)
                {
                    // ---- GET CURRENT STORY ID ----

                    // Prepare a query to get ID of the current story
                    $get_story_id = $db->prepare("SELECT story_id FROM stories WHERE story_title = :story_title AND user_id = :user_id");

                    // Binding
                    $get_story_id->bindValue(":story_title", $story_title["story_title"]);
                    $get_story_id->bindValue(":user_id", $user_id);

                    // Execution
                    $get_story_id->execute();

                    // Store current story ID in an associative array
                    $story_id = $get_story_id->fetchColumn();

                    // ---- DISPLAY CURRENT STORY TITLE ----

                    // Display current story title and options
                    echo    "   <div style='width: 100%;' class='story_chapters'><h4>".$story_title["story_title"]."</h4>

                                <p class='chapter_option' onclick='NewChapter($story_id)'>Write new chapter</p>
                                <p onclick='DeleteStory($story_id,\"".$story_title["story_title"]."\")' class='delete_txt'>Delete Story</p>
                            ";

                    // ---- GET CHAPTER IDS AND TITLES OF THE CURRENT STORY ----

                    // Prepare query to get chapter ids and titles of the current story
                    $get_chapter_infos = $db->prepare("SELECT chapter_id, chapter_title FROM chapters WHERE story_id = :story_id ORDER BY chapter_id ASC");

                    // Binding
                    $get_chapter_infos->bindValue(":story_id", $story_id);

                    // Execution
                    $get_chapter_infos->execute();

                    // Store every chapter of the current story in an associative array
                    $chapter_infos = $get_chapter_infos->fetchAll(PDO::FETCH_ASSOC);

                    // ---- DISPLAY CHAPTER TITLES OF THE CURRENT STORY ----

                    // Chapter Titles List Start
                    echo "<ol>";

                    // Loop of chapter titles
                    foreach($chapter_infos as $chapter_info)
                    {
                        // Display a chapter title of the current story
                        echo "<li onclick='GetChapterInfo(".$chapter_info['chapter_id'].")' id='".$chapter_info['chapter_id']."' class='chapter_title' title='Click to manage chapter'>".$chapter_info['chapter_title']."</li>";
                    }

                    // Chapter Titles List End
                    echo "</ol></div>";
                }

                // END of the div containing divs containing a story and its chapters
                echo "</div>";

                // ---- CHAPTER INFO ----
                echo "<div id='user_stories_chapter_info' class='user_page_inner_div'><h3>Click on a chapter to show it here</h3></div>";
                
                // END OF PAGE CONTAINER
                echo "</div>";
            }

            // Catch information retrieval problems
            catch(Exception $exc)
            {
                // Output error message
                echo "<p>Exception caught during stories information retrieval : " . $exc->getMessage() . "</p>";

                // End script
                exit;
            }
        }
    ?>

    </main>

</body>

<!-- SCRIPT -->
<script src="user_stories.js"></script>

<!-- FOOTER -->
<footer>
    <p>Footer</p>
</footer>

</html>