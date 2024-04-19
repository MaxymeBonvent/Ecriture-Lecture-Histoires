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

    <!-- MAIN -->
    <main>

        <!-- OUTLINE OF BACK TO TOP DIV -->
        <a id="back_to_top_outline" href="#_header">

            <!-- BACK TO TOP LINK  -->
            <div id="back_to_top"></div>

        </a>

        <!-- SECTION TITLE -->
        <h3>Search Stories</h3>

        <!-- TELL USER EVERY FIELD IS OPTIONAL -->
        <p>Each field is optional</p>

        <!-- SEARCH SECTION -->
        <section id="search_section">

            <!-- SEARCH PSEUDO FORM -->
        
            <!-- TAGS DIV -->
            <div class="search_div_col">

                <!-- LABEL -->
                <label for="tags_input">Tags, you can only insert or remove them by click</label>

                <!-- INPUT -->
                <input onkeyup="EmptyTagsField()" class="form_input_field" id="tags_input" name="tags" type="text" maxlength="100" autocomplete="off" placeholder="[First Tag] [Second Tag] [Third Tag] [Fourth Tag] [Fifth Tag] [Sixth Tag]">

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

            <!-- STORY TITLE -->
            <div class="search_div_row">

                <!-- LABEL -->
                <label for="story_title">Story Title (max. 100 char.)</label>

                <!-- INPUT -->
                <input id="story_title" name="story_title" type="text" autocomplete="off" maxlength="100" placeholder="Story title">

            </div>

            <!-- AUTHOR -->
            <div class="search_div_row">

                <!-- LABEL -->
                <label for="author">Author (max. 100 char.)</label>

                <!-- INPUT -->
                <input id="author" name="author" type="text" autocomplete="off" maxlength="100" placeholder="Author's name">

            </div>

            <!-- STORY WORD COUNT DIV -->
            <div class="search_div_row">

                <!-- GREATER THAN DIV -->
                <div class="word_count_div">

                    <!-- LABEL -->
                    <label for="min_word_count">At least</label>

                    <!-- INPUT -->
                    <input id="min_word_count" name="min_word_count" type="number" autocomplete="off" maxlength="10" placeholder="00000">

                    <!-- TEXT -->
                    <p>words</p>

                </div>

                <!-- LESS THAN DIV -->
                <div class="word_count_div">

                    <!-- LABEL -->
                    <label for="max_word_count">At most</label>

                    <!-- INPUT -->
                    <input id="max_word_count" name="max_word_count" type="number" autocomplete="off" maxlength="10" placeholder="00000">

                    <!-- TEXT -->
                    <p>words</p>

                </div>

            </div>

            <!-- PSEUDO FORM END BUTTONS -->
            <div class="form_btns_div">

                <!-- PSEUDO SUBMIT BUTTON -->
                <div onclick="Search()" id="search_div" class="pseudoBtn">Search</div>

                <!-- PSEUDO CANCEL BUTTON -->
                <div onclick="PseudoCancel()" id="cancel_div" class="pseudoBtn">Cancel</div>

            </div>
  
            

        </section>


        <!-- SECTION TITLE -->
        <h3>Results</h3>


        <!-- RESULTS SECTION -->
        <section id="results_section">

        </section>

    </main>

    <!-- SCRIPTS -->
    <script src="story_search_form_check.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>