<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Homepage</title>

    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/process_confirm.css">

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

        <?php
            // Start user session
            session_start();

            // Database connection
            require_once("database_connection.php");

            // If user is not logged in
            if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
            {
                // Redirect user to log in page
                header("Location: log_in_form.php");
            }

            // If user is logged in
            else if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
            {
                // Tell user their story is gone
                echo "<p>Your story has been successfully deleted.</p>";
            }
        ?>

    </main>

    <!-- FOOTER -->
    <footer>
        <p>&copy; Développé par Maxyme Bonvent.</p>
    </footer>

</body>
</html>