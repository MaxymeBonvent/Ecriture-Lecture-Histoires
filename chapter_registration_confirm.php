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
                // Tell user their chapter is in
                echo "<p>Your new chapter has been successfully registered.</p>";
            }
        ?>

    </main>

</body>

</html>