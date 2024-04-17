<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Story Search</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Story Search</h2>

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

        <!-- SECTION TITLE -->
        <h3>Search Stories</h3>

        <!-- TOP HALF -->
        <section>

            <!-- SEARCH FORM -->
            <form action="story_search.php" method="get">

                <!-- TAG INPUT DIV -->
                <div>
                    <!-- LABEL -->
                    <label for="tags">Tags</label>

                    <!-- INPUT -->
                    <input class="form_input_field" id="tags" name="tags" type="text" required="off" autocomplete="off" placeholder="[First Tag] [Second Tag] [Third Tag] [Fourth Tag] [Fifth Tag] [Sixth Tag]">

                    <!-- TAGS SELECTION DIV -->
                    <div id="tags_select_div">

                        <!-- TAG LIST -->
                        <p class="tag">Adventure</p>
                        <p class="tag">Comedy</p>
                        <p class="tag">Tragedy</p>

                        <p class="tag" title="Slice of life">S.o.L</p>
                        <p class="tag" title="Alternate Universe">A.U.</p>
                        <p class="tag">Violence</p>

                        <p class="tag">Horror</p>
                        <p class="tag">Romance</p>
                        <p class="tag">Tale</p>

                        <p class="tag">Poetry</p>
                        <p class="tag">Fantasy</p>
                        <p class="tag">Mystery</p>

                    </div>

                </div>
  
            </form>

        </section>


        <!-- SECTION TITLE -->
        <h3>Results</h3>


        <!-- BOTTOM HALF -->
        <section>

        </section>
        

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

            // If user is logged in (optional)
            if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
            {
                // GET USER ID
                require_once("get_user_id.php");
            }
        ?>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>