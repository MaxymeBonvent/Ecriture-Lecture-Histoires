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

            // ---- ALL STORIES AND CHAPTERS ----

            // Try getting user ID, their stories, their chapters and info from those chapters
            try
            {
                // --- USER ID ---

                // Prepare query to get logged in user's ID
                $get_user_id = $db->prepare("SELECT user_id FROM Users WHERE username = :username");

                // If user is logged in
                if(isset($_SESSION['username']))
                {
                    // Bind their name to the prepared username variable
                    $get_user_id->bindValue(":username", $_SESSION['username']);
                }

                // If user is not logged in
                else if(!isset($_SESSION['username']))
                {
                    // Output an error message
                    echo "<p>Error : no user.</p>";

                    // End script
                    exit;
                }

                // Execution
                $get_user_id->execute();

                // Fetch result and store it in an array
                $user_id = $get_user_id->fetch();

                // ---- GET STORY TITLES ----

                // Prepare query to get every story title from the logged in user
                $get_story_titles = $db->prepare("SELECT story_title FROM stories LEFT JOIN users ON stories.user_id = :user_id");

                // Binding
                $get_story_titles->bindValue(":user_id", $user_id[0]);

                // Execution
                $get_story_titles->execute();

                // Store the fetch of all story titles in an associative array
                $story_titles = $get_story_titles->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($story_titles);

                // ---- DISPLAY STORY TITLES ----

                // GREAT DIV THAT CONTAINS STORIES LIST DIVS AND CHAPTER INFO DIV
                echo "<div id='stories_list_and_chapter_info_container'>";

                // START of the div containing divs containing a story and its chapters
                echo "<div id='user_page_stories_list'>";

                // Loop of story titles
                foreach($story_titles as $story_title)
                {
                    // ---- GET CURRENT STORY ID ----

                    // Prepare a query to get ID of the current story
                    $get_story_id = $db->prepare("SELECT story_id FROM stories WHERE story_title = :story_title AND user_id = :user_id");

                    // Binding
                    $get_story_id->bindValue(":story_title", $story_title["story_title"]);
                    $get_story_id->bindValue(":user_id", $user_id[0]);

                    // Execution
                    $get_story_id->execute();

                    // Store current story ID in an associative array
                    $story_id = $get_story_id->fetchColumn();

                    // ---- DISPLAY CURRENT STORY TITLE ----

                    // Display current story title
                    echo "<div style='width: 100%;' class='user_page_inner_div'><h4>".$story_title["story_title"]."</h4><br>";

                    // ---- GET CHAPTER IDS AND TITLES OF THE CURRENT STORY ----

                    // Prepare query to get chapter ids and titles of the current story
                    $get_chapter_titles = $db->prepare("SELECT chapter_id, chapter_title FROM chapters WHERE story_id = :story_id");

                    // Binding
                    $get_chapter_titles->bindValue(":story_id", $story_id);

                    // Execution
                    $get_chapter_titles->execute();

                    // Store every chapter of the current story in an associative array
                    $chapter_titles = $get_chapter_titles->fetchAll(PDO::FETCH_ASSOC);

                    // ---- DISPLAY CHAPTER TITLES OF THE CURRENT STORY ----

                    // Chapter Titles List Start
                    echo "<ol>";

                    // Loop of chapter titles
                    foreach($chapter_titles as $chapter_title)
                    {
                        // Display a chapter title of the current story
                        echo "<li onclick='GetChapterInfo(".$chapter_title['chapter_id'].")' id='".$chapter_title['chapter_id']."' class='chapter_title' title='Click to manage chapter'>".$chapter_title['chapter_title']."</li>";
                    }

                    // Chapter Titles List End
                    echo "</ol></div>";
                }

                // END of the div containing divs containing a story and its chapters
                echo "</div>";

                // ---- CHAPTER INFO ----
                echo "<div id='chapter_info' class='user_page_inner_div'><h3>Click on a chapter to show it here</h3></div>";
                
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
<script src="get_chapter_info.js"></script>

<!-- FOOTER -->
<footer>
    <p>Footer</p>
</footer>

</html>