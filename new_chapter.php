<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Stories</title>

    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/preview.css">
    <link rel="stylesheet" href="CSS/back_to_top.css">
    <link rel="stylesheet" href="CSS/chapter_work.css">

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

        <!-- PREVIEW BACKGROUND -->
        <div id="preview_bck">

            <!-- DIV CONTAINING CHAPTER TITLE AND TEXT PREVIEW -->
            <div id="preview_div">

                <!-- CHAPTER TITLE PREVIEW -->
                <h3 id="chapter_title_preview"></h3>

                <!-- CHAPTER TEXT PREVIEW -->
                <p id="chapter_txt_preview"></p>

            </div>

        </div>

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

            // ---- STORY ID ----
            $story_id = htmlspecialchars($_GET["story_id"]);

            // ---- GET STORY TITLE ----

            // Prepare query to get story title of the story whose ID is the one passed in the URL
            $get_story_title = $db->prepare("SELECT story_title FROM stories WHERE story_id = :story_id");

            // Binding
            $get_story_title->bindValue(":story_id", $story_id);

            // Execution
            $get_story_title->execute();

            // Store result
            $story_title = $get_story_title->fetch();

            // ---- NEW CHAPTER FORM ----

            echo "<h3>Write a new chapter for $story_title[0]</h3>";

            echo "<p><span class='required_star'>*</span> = required</p>";

            echo    "   <form method='post' action='register_chapter.php'>

                            <div style='display:none;'>

                                <label for='story_id'>Story ID</label>

                                <input type='text' id='story_id' value='$story_id' name='story_id'>

                            </div>

                            

                            <label for='chapter_title_input_field' id='chapter_title_label'>Chapter Title (up to 30 words)<span class='required_star'>*</span></label>

                            <input id='chapter_title_input_field' type='text' class='form_input_field' name='chapter_title' placeholder='Chapter ? : a small creature appears' required='true' autocomplete='off' maxlength='400' onkeyup='ChapterTitleCheck()' title='Enter the title of the next chapter of your story'>

                            <p><span id='chapter_title_word_count'>0</span>/30</p>
                            
                            <label for='chapter_text_area' id='chapter_text_label'>Chapter Text (up to 15 000 words)<span class='required_star'>*</span></label>

                            <!-- STYLE OPTIONS DIV -->
                            <div class='options_div'>

                                <!-- STYLE OPTIONS -->
                                <img style='cursor: pointer;' src='img/new_line.png' alt='New line symbol' title='Insert a new line' onclick='NewLine()'>
                                <p class='style_option' onclick='Bold()' title='Make text bold'><b>B</b></p>
                                <p class='style_option' onclick='Italic()' title='Italize text'><i>I</i></p>
                                <p class='style_option' onclick='Underline()' title='Underline text'><u>U</u></p>

                                <p class='style_option' onclick='Strike()' title='Strike through text'><del><del>S</del></del></p>
                                <img style='cursor: pointer;' src='img/color_wheel.png' alt='Color wheel' title='Open color box' onclick='ToggleColorBox()'>
                                <p class='style_option' onclick='Small()' title='Make text smaller'><small><small>SM</small></small></p>

                                <p class='style_option' onclick='Superscript()' title='Make text superscript'>A<sup>sp</sup></p>
                                <p class='style_option' onclick='Subscript()' title='Make text subscript'>A<sub>sb</sub></p>
                                <p class='style_option' onclick='Center()' title='Center text'>-C-</p>

                                <p class='style_option' onclick='HorizontalRule()' title='Add a horizontal line'><u>HR</u></p>

                                <!-- COLOR OPTIONS DIV -->
                                <div class='options_div' id='color_box'>

                                    <img src='img/red_circle.png' alt='Red circle' class='color_option' onclick='Red()'></img>
                                    <img src='img/green_circle.png' alt='Green circle' class='color_option' onclick='Green()'></img>
                                    <img src='img/blue_circle.png' alt='Blue circle' class='color_option' onclick='Blue()'></img>

                                </div>
                                
                            </div>

                            <textarea id='chapter_text_area' name='chapter_text' cols='30' rows='10' placeholder='The creature opened its eyes and looked around...' required='true' autocomplete='off' maxlength='60000' onkeyup='ChapterTextCheck()' title='Enter the text of the first chapter of your story'></textarea>

                            <p><span id='chapter_text_word_count'>0</span>/15 000</p>

                            <p id='preview_toggle' onclick='TogglePreviewBackground()' style='z-index: 1;'>Preview</p>

                            
                            <div class='form_btns_div'>

                                <input type='submit' value='Publish Chapter' id='publish_input' class='formBtn'>

                                <input type='reset' value='Cancel' class='formBtn'>

                            </div>

                            

                        </form>
                    ";
        }
    ?>

    </main>

</body>

<!-- SCRIPT -->
<script src="JS/preview.js"></script>
<script src="JS/check_chapter.js"></script>
<script src="JS/chapter_style.js"></script>

<!-- FOOTER -->
<footer>
    <p>Footer</p>
</footer> 

</html>