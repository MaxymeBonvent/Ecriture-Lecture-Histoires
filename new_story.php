<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Story</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>New Story</h2>

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

            // If user is not logged in
            if(!isset($_SESSION['username']))
            {
                // Redirect them to log in form page
                header("Location: log_in_form.php");
            }

            // If user is logged in
            else if(isset($_SESSION['username']))
            {     
        ?>

        <!-- OUTLINE OF BACK TO TOP DIV -->
        <a id="back_to_top_outline" href="#_header">

            <!-- BACK TO TOP LINK  -->
            <div id="back_to_top"></div>

        </a>

        <!-- FORM TITLE -->
        <h3>Write a new story</h3>

        <!-- FORM -->
        <form action="register_story.php" method="post">

            <!-- STORY TITLE DIV -->
            <div class="writing_div">

                <!-- LABEL -->
                <label for="story_title_input_field" id="story_title_label">Story Title (up to 30 words)</label>

                <!-- INPUT -->
                <input type="text" id="story_title_input_field" name="story_title" placeholder="Story of a strange creature" required="true" autocomplete="off" maxlength="400" onkeyup="StoryTitleCheck()" title="Enter a title for your story">

                <!-- STORY TITLE WORD COUNTING DIV -->
                <div class="counting_div">

                    <!-- STORY TITLE WORD COUNT -->
                    <p><span id="story_title_word_count">0</span>/30</p>

                </div>

            </div>

            <!-- SYNOPSIS DIV -->
            <div class="writing_div">

                <!-- LABEL -->
                <label for="synopsis_input" id="synopsis_label">Synopsis (up to 100 words)</label>

                <!-- INPUT -->
                <textarea id="synopsis_input" name="synopsis"  cols="30" rows="10" placeholder="Once upon a time..." required="true" autocomplete="off" onkeyup="SynopsisCheck()" title="Enter a synopsis for your story"></textarea>

                <!-- SYNOPSIS WORD COUNTING DIV -->
                <div class="counting_div">

                    <!-- SYNOPSIS WORD COUNT -->
                    <p><span id="synopsis_word_count">0</span>/100</p>

                </div>
                
            </div>

            <!-- TAGS DIV -->
            <div class="writing_div">

                <!-- LABEL -->
                <label for="tags_input_field" id="tags_label">Tags (up to 6), you can only insert or remove them by click</label>

                <!-- INPUT -->
                <input type="text" id="tags_input_field" name="tags" placeholder="[First tag] [Second tag]" required="true" autocomplete="off" maxlength="60" onkeyup="EmptyTagsField()" title="Click tags for your story">

                <!-- DIV OF AVAILABLE TAGS -->
                <div id="tags_box">

                    <!-- TAG LIST -->
                    <p class="tag">Adventure</p>
                    <p class="tag">Comedy</p>
                    <p class="tag">Tragedy</p>

                    <p class="tag" title="Slice of life">S.O.L</p>
                    <p class="tag" title="Alternate Universe">A.U.</p>
                    <p class="tag">Violence</p>

                    <p class="tag">Horror</p>
                    <p class="tag">Romance</p>
                    <p class="tag">Tale</p>

                    <p class="tag">Poetry</p>
                    <p class="tag">Fantasy</p>
                    <p class="tag">Mystery</p>

                </div>

                <!-- TAGS COUNTING DIV -->
                <div class="counting_div">

                    <!-- TAGS COUNT -->
                    <p><span id="tag_count_txt">0</span>/6</p>

                </div>

            </div>

            <!-- CHAPTER TITLE DIV -->
            <div class="writing_div">

                <!-- LABEL -->
                <label for="chapter_title_input_field" id="chapter_title_label">Chapter 1 Title (up to 30 words)</label>

                <!-- INPUT -->
                <input type="text" id="chapter_title_input_field" name="chapter_title" placeholder="Chapter 1 : a small creature appears" required="true" autocomplete="off" maxlength="400" onkeyup="ChapterTitleCheck()" title="Enter the title of the first chapter of your story">

                <!-- CHAPTER TITLE WORD COUNTING DIV -->
                <div class="counting_div">

                    <!-- CHAPTER TITLE WORD COUNT -->
                    <p><span id="chapter_title_word_count">0</span>/30</p>

                </div>

            </div>

            <!-- CHAPTER TEXT DIV -->
            <div class="writing_div">

                <!-- LABEL -->
                <label for="chapter_text_area" id="chapter_text_label">Chapter 1 Text (up to 15 000 words)</label>

                <!-- DIV CONTAINING STYLE OPTIONS DIV AND COLOR OPTIONS DIV -->
                <div id="options_container">

                    <!-- STYLE OPTIONS DIV -->
                    <div id="style_options">

                        <!-- STYLE OPTIONS -->
                        <img style="cursor: pointer;" src="img/new_line.png" alt="New line symbol" title="Insert a new line" onclick="NewLine()">
                        <p class="style_option" onclick="Bold()" title="Make text bold"><b>B</b></p>
                        <p class="style_option" onclick="Italic()" title="Italize text"><i>I</i></p>
                        <p class="style_option" onclick="Underline()" title="Underline text"><u>U</u></p>

                        <p class="style_option" onclick="Strike()" title="Strike through text"><del><del>S</del></del></p>
                        <img style="cursor: pointer;" src="img/color_wheel.png" alt="Color wheel" title="Open color box" onclick="ToggleColorBox()">
                        <p class="style_option" onclick="Small()" title="Make text smaller"><small><small>SM</small></small></p>

                        <p class="style_option" onclick="Superscript()" title="Make text superscript">A<sup>sp</sup></p>
                        <p class="style_option" onclick="Subscript()" title="Make text subscript">A<sub>sb</sub></p>
                        <p class="style_option" onclick="Center()" title="Center text">-C-</p>

                        <p class="style_option" onclick="HorizontalRule()" title="Add a horizontal line"><u>HR</u></p>

                    </div>

                    <!-- COLOR OPTIONS DIV -->
                    <div id="color_options">
                        <div class="color_option" style="background-color: rgb(160, 0, 0);" onclick="Red()"></div>
                        <div class="color_option" style="background-color: rgb(0, 120, 0);" onclick="Green()"></div>
                        <div class="color_option" style="background-color: rgb(0, 60, 180);"  onclick="Blue()"></div>
                    </div>
                    
                </div>  

                <!-- INPUT -->
                <textarea id="chapter_text_area" name="chapter_text" cols="30" rows="10" placeholder="The creature opened its eyes and looked around..." required="true" autocomplete="off" maxlength="60000" onkeyup="ChapterTextCheck()" title="Enter the text of the first chapter of your story"></textarea>

                <!-- CHAPTER TEXT WORD COUNTING DIV -->
                <div class="counting_div">

                    <!-- CHAPTER TEXT WORD COUNT -->
                    <p><span id="chapter_text_word_count">0</span>/15 000</p>

                </div>

            </div>

            <!-- FORM BUTTONS -->
            <div>

                <!-- SUBMIT BUTTON -->
                <input type="submit" value="Publish Story" id="publish_input" class="formBtn">

                <!-- CANCEL BUTTON -->
                <input type="reset" value="Reset" class="formBtn">

            </div>

        </form>

    </main>

    <?php
        }
    ?>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

    <!-- SCRIPT -->
    <script src="new_story_check.js"></script>
    <script src="chapter_style.js"></script>

</body>