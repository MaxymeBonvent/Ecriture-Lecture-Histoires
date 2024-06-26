<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Story Search</title>

    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/back_to_top.css">
    <link rel="stylesheet" href="CSS/story_search.css">

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


        // If a story search has been done
        if(isset($_GET["story_ids"]) && !empty($_GET["story_ids"]))
        {
            // Get URL's story IDs
            $story_ids = htmlspecialchars($_GET["story_ids"]);

            // Array of story IDs
            $story_ids_array = explode(" ", $story_ids);
        }
    ?>

    <!-- MAIN -->
    <main>

        <!-- BACK TO TOP LINK  -->
        <a id="back_to_top_link" href="#_header">

            <!-- BACK TO TOP IMAGE -->
            <img src="img/top.png" alt="Page top icon" id="back_to_top_img">

        </a>

        <!-- SECTION TITLE -->
        <h3>Search Stories (max. 100)</h3>

        <!-- TELL USER EVERY FIELD IS OPTIONAL -->
        <p>At least one field must be filled to run a search</p>

        <!-- SEARCH SECTION -->
        <section id="search_section">

            <!-- PSEUDO SEARCH FORM -->
        
            <!-- LABEL -->
            <label for="tags_input">Tags, you can only insert or remove them by click</label>

            <!-- INPUT -->
            <input onkeyup="EmptyTagsField()" class="form_input_field" id="tags_input" name="tags" type="text" maxlength="100" autocomplete="off" placeholder="[Tag 1] [Tag 2] ... [Tag N]">

            <!-- TAGS SELECTION DIV -->
            <div class="tags_div">

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
            
            <!-- LABEL -->
            <label for="story_title">Story Title (max. 100 char.)</label>

            <!-- INPUT -->
            <input id="story_title" name="story_title" type="text" autocomplete="off" maxlength="100" placeholder="Story title">

            <!-- LABEL -->
            <label for="author">Author (max. 100 char.)</label>

            <!-- INPUT -->
            <input id="author" name="author" type="text" autocomplete="off" maxlength="100" placeholder="Author's name">

            <!-- LABEL -->
            <label for="min_word_count">Min. word count</label>

            <!-- INPUT -->
            <input id="min_word_count" name="min_word_count" type="number" autocomplete="off" maxlength="10" placeholder="00000">    

            <!-- LABEL -->
            <label for="max_word_count">Max. word count</label>

            <!-- INPUT -->
            <input id="max_word_count" name="max_word_count" type="number" autocomplete="off" maxlength="10" placeholder="99999">
            
            <!-- PSEUDO FORM END BUTTONS -->
            <div id="form_btns_div">

                <!-- PSEUDO SUBMIT BUTTON -->
                <p onclick="Search()" id="search_div" class="pseudoBtn">Search</p>

                <!-- PSEUDO CANCEL BUTTON -->
                <p onclick="PseudoCancel()" id="cancel_div" class="pseudoBtn">Cancel</p>

            </div>
  
        </section>


        <!-- SECTION TITLE -->
        <h3>Results</h3>


        <!-- RESULTS SECTION -->
        <section id="results_section">

            <?php
                // If a story search has been done
                if(isset($_GET["story_ids"]) && !empty($_GET["story_ids"]))
                {
                    // ---- NUMBER OF STORIES MESSAGE ---- //
                    // If only one story was found
                    if(count($story_ids_array) == 1)
                    {
                        // Message with singular form
                        echo "<p>".count($story_ids_array)." story found :</p>";
                    }

                    // If more than one story was found
                    else if(count($story_ids_array) > 1)
                    {
                        // Message with plural form
                        echo "<p>".count($story_ids_array)." stories found :</p>";
                    }

                    // ---- STORY BOXES DISPLAY ---- //
                    // For each ID in story IDs array
                    foreach($story_ids_array as $story_id)
                    {
                        // GET INFO OF CURRENT STORY
                        // Prepare query
                        $get_story_info = $db->prepare("SELECT story_title, author, pub_date, likes, dislikes, tags, chapter_ids FROM stories WHERE story_id = :story_id");

                        // Binding  
                        $get_story_info->bindValue(":story_id", $story_id);

                        // Execution
                        $get_story_info->execute();

                        // Store result
                        $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

                        // Test
                        // echo "<p>Info of story n°$story_id :</p>";
                        // var_dump($story_info);
                        // exit;

                        // CREATE TAGS ARRAY
                        $tags_array = explode(" ", $story_info[0]["tags"]);

                        // Test
                        // echo "<p>Tags array of story n°$story_id :</p>";
                        // var_dump($tags_array);


                        // START of current story div
                        echo "<div class='story_box' onclick='Synopsis(\"".$story_info[0]['story_title']."\", \"".$story_info[0]['author']."\", \"".$story_info[0]['tags']."\", \"".$story_info[0]['chapter_ids']."\")'>";


                            // START of story title div
                            echo "<div class='story_title'>";

                                // Story title
                                echo "<h4>".$story_info[0]['story_title']."</h4>";

                            // END of story title div
                            echo "</div>";


                            // START of info and stats div
                            echo "<div class='story_info'>";

                                // Author
                                echo "<p>".$story_info[0]['author']."</p>";

                                // Publication date
                                echo "<p>".date("d-m-Y", strtotime($story_info[0]['pub_date']))."</p>";

                                // Likes
                                echo "<p>".$story_info[0]['likes']." Likes</p>";

                                // Dislikes
                                echo "<p>".$story_info[0]['dislikes']." Dislikes</p>";

                            // END of info and stats div
                            echo "</div>";


                            // START of tags div
                            echo "<div class='tags_div'>";

                                // For each tag
                                foreach($tags_array as $tag)
                                {
                                    // If that tag is not empty
                                    if($tag != null && $tag != "")
                                    {
                                        // Display it
                                        echo "<p class='tag'>$tag</p>";
                                    }
                                }

                            // END of tags div
                            echo "</div>";

                        // END of current story div
                        echo "</div>";
                    }
                }
            ?>

        </section>

    </main>

    <!-- SCRIPTS -->
    <script src="JS/story_search_form_check.js"></script>
    <script src="JS/synopsis.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>&copy; Développé par Maxyme Bonvent.</p>
    </footer>

</body>
</html>