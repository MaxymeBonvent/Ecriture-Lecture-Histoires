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

<body>

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
        
            // ---- DATABASE VARIABLES ----

            // Database connection variables
            $dsn = "mysql:dbname=storiesdb;host=localhost";
            $user = "root";
            $dsn_pwd = "";

            // ---- DATABASE CONNECTION ----

            // Try database connection
            try
            {
                // Database object
                $db = new PDO($dsn, $user, $dsn_pwd);
            }

            // Catch database connection failure
            catch(Exception $exc)
            {
                // Output an error message
                echo "<p>Exception caught during database connection : " . $exc->getMessage() . "</p>";

                // End script
                exit;
            }

            // ---- CHAPTER VARIABLES ----
            $story_id = htmlspecialchars($_GET["story_id"]);
            $chapter_title = htmlspecialchars($_GET["chapter_title"]);

            // ---- GET CHAPTER ID ----

            // Prepare query to get chapter ID using story ID and chapter title
            $get_chapter_id = $db->prepare("SELECT chapter_id FROM chapters WHERE story_id = :story_id AND chapter_title = :chapter_title");

            // Binding
            $get_chapter_id->bindValue(":story_id", $story_id);
            $get_chapter_id->bindValue(":chapter_title", $chapter_title);

            // Execution
            $get_chapter_id->execute();

            // Store result in a variable
            $chapter_id = $get_chapter_id->fetch();

            // ---- GET CHAPTER TEXT ----

            // Prepare query to get chapter text using story ID and chapter title
            $get_chapter_text = $db->prepare("SELECT chapter_text FROM chapters WHERE story_id = :story_id AND chapter_title = :chapter_title");

            // Binding
            $get_chapter_text->bindValue(":story_id", $story_id);
            $get_chapter_text->bindValue(":chapter_title", $chapter_title);

            // Execution
            $get_chapter_text->execute();

            // Store result in a variable
            $chapter_text = $get_chapter_text->fetch();

            // ---- CHAPTER EDIT FORM ----

            echo "<h3>Editing chapter $chapter_title</h3>";


            echo    "   <form method='post' action='update_chapter.php'>

                            <div style='display:none;'>

                                <label for='story_id'>Story ID</label>

                                <input type='text' id='story_id' value='$story_id' name='story_id'>

                            </div>

                            <div style='display:none;'>

                                <label for='chapter_id'>Chapter ID</label>

                                <input type='text' id='chapter_id' value='$chapter_id[0]' name='chapter_id'>

                            </div>


                            <div class='writing_div'>

                                <label for='chapter_title_input_field' id='chapter_title_label'>Chapter Title (up to 30 words)</label>

                                <input type='text' id='chapter_title_input_field' name='chapter_title' placeholder='Chapter ? : a small creature appears' required='true' autocomplete='off' maxlength='400' onkeyup='ChapterTitleCheck()' title='Enter the title of the next chapter of your story' value='$chapter_title'>

                                <div class='counting_div'>

                                    <p><span id='chapter_title_word_count'>0</span>/30</p>

                                </div>

                            </div>

                            <div class='writing_div'>

                                <label for='chapter_text_area' id='chapter_text_label'>Chapter Text (up to 15 000 words)</label>

                                <div id='options_container'>


                                    <div id='style_options'>

                                        <p class='style_option' onclick='Bold()'><b>B</b></p>
                                        <p class='style_option' onclick='Italic()'><i>I</i></p>
                                        <p class='style_option' onclick='Underline()'><u>U</u></p>

                                        <p class='style_option' onclick='Strike()'><del><del>S</del></del></p>
                                        <p class='style_option' onclick='Small()'><small><small>SM</small></small></p>
                                        <img class='style_option' id='color_wheel_img' src='img/color_wheel.png' alt='Color wheel' onclick='ToggleColorDiv()'>

                                        <p class='style_option' onclick='Superscript()'>A<sup>sp</sup></p>
                                        <p class='style_option' onclick='Subscript()'>A<sub>sb</sub></p>
                                        <p class='style_option' onclick='Center()'>-C-</p>

                                        <p class='style_option' onclick='HorizontalRule()'><u>HR</u></p>

                                    </div>


                                    <div id='color_options'>

                                        <div class='color_circle' style='background-color:rgb(160, 0, 0);' onclick='Red()'></div>
                                        <div class='color_circle' style='background-color:rgb(0, 130, 0);' onclick='Green()'></div>
                                        <div class='color_circle' style='background-color:rgb(0, 0, 220);' onclick='Blue()'></div>

                                    </div>


                                </div>

                                <textarea id='chapter_text_area' name='chapter_text' cols='30' rows='10' placeholder='The creature opened its eyes and looked around...' required='true' autocomplete='off' maxlength='60000' onkeyup='ChapterTextCheck()' title='Enter the text of the first chapter of your story'>$chapter_text[0]</textarea>

                                <div class='counting_div'>

                                    <p><span id='chapter_text_word_count'>0</span>/15 000</p>

                                </div>

                                
                                <div class='formBtnsDiv'>

                                    <input type='submit' value='Publish Edited Chapter' id='publish_input' class='formBtn'>

                                </div>

                            </div>

                        </form>
                    "; 
    ?>

    </main>

</body>

<!-- SCRIPT -->
<script src="check_chapter.js"></script>
<script src="chapter_style.js"></script>

<!-- FOOTER -->
<footer>
    <p>Footer</p>
</footer> 

</html>