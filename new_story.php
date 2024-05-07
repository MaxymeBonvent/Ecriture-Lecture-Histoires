<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Story</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="preview.css">
    <link rel="stylesheet" href="back_to_top.css">
    <link rel="stylesheet" href="new_story.css">

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

        <!-- BACK TO TOP LINK  -->
        <a id="back_to_top_link" href="#_header">

            <!-- BACK TO TOP IMAGE -->
            <img src="img/top.png" alt="Page top icon" id="back_to_top_img">

        </a>

        <!-- PREVIEW BACKGROUND -->
        <section id="preview_bck">

            <!-- PREVIEW DIV -->
            <div id="preview_div">

                <!-- CHAPTER TITLE PREVIEW -->
                <h3 id="chapter_title_preview"></h3>

                <!-- CHAPTER TEXT PREVIEW -->
                <p id="chapter_txt_preview"></p>

            </div>

        </section>

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

        <!-- FORM TITLE -->
        <h3>Write a new story</h3>

        <!-- REQUIRED SYMBOL -->
        <p><span class="required_star">*</span> = required</p>

        <!-- FORM -->
        <form action="register_story.php" method="post">

            <!-- LABEL -->
            <label for="story_title_input_field" id="story_title_label">Story Title (max. 30 words)<span class="required_star">*</span></label>

            <!-- INPUT -->
            <input type="text" class="form_input_field" id="story_title_input_field" name="story_title" placeholder="Story of a strange creature" required="true" autocomplete="off" maxlength="400" onkeyup="StoryTitleCheck()" title="Enter a title for your story">

            <!-- STORY TITLE WORD COUNT -->
            <p class="count_txt"><span id="story_title_word_count">0</span>/30</p>

            <!-- LABEL -->
            <label for="synopsis_input" id="synopsis_label">Synopsis (max. 100 words)<span class="required_star">*</span></label>

            <!-- INPUT -->
            <textarea class="form_input_field" id="synopsis_input" name="synopsis"  cols="30" rows="10" placeholder="Once upon a time..." required="true" autocomplete="off" onkeyup="SynopsisCheck()" title="Enter a synopsis for your story"></textarea>

            <!-- SYNOPSIS WORD COUNT -->
            <p class="count_txt"><span id="synopsis_word_count">0</span>/100</p>

            <!-- TAGS -->

            <!-- LABEL -->
            <label for="tags_input_field" id="tags_label">Tags (max. 6), toggle in/out by click<span class="required_star">*</span></label>

            <!-- INPUT -->
            <input type="text" class="form_input_field" id="tags_input_field" name="tags" placeholder="[Tag 1] [...] [Tag 6]" required="true" autocomplete="off" maxlength="60" onkeyup="EmptyTagsField()" title="Click tags for your story">

            <!-- SECTION OF AVAILABLE TAGS -->
            <section id="tags_section">

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

            </section>

            <!-- TAGS COUNT -->
            <p class="count_txt"><span id="tag_count_txt">0</span>/6</p>

            <!-- CHAPTER 1 TITLE LABEL -->
            <label for="chapter_title_input_field" id="chapter_title_label">Chapter 1 Title (max. 30 words)<span class="required_star">*</span></label>

            <!-- INPUT -->
            <input type="text" class="form_input_field" id="chapter_title_input_field" name="chapter_title" placeholder="Chapter 1 : Dawn" required="true" autocomplete="off" maxlength="400" onkeyup="ChapterTitleCheck()" title="Enter the title of the first chapter of your story">

            <!-- CHAPTER TITLE WORD COUNT -->
            <p class="count_txt"><span id="chapter_title_word_count">0</span>/30</p>

            <!-- LABEL -->
            <label for="chapter_text_area" class="form_input_field" id="chapter_text_label">Chapter 1 Text (max. 15 000 words)<span class="required_star">*</span></label>

            <!-- SECTION CONTAINING STYLE OPTIONS DIV AND COLOR OPTIONS DIV -->
            <section id="options_container">

                <!-- STYLE OPTIONS DIV -->
                <div>

                    <!-- STYLE OPTIONS -->
                    <img class="style_option" src="img/new_line.png" alt="New line symbol" title="Insert a new line" onclick="NewLine()">
                    <p class="style_option" onclick="Bold()" title="Make text bold"><b>B</b></p>
                    <p class="style_option" onclick="Italic()" title="Italize text"><i>I</i></p>
                    <p class="style_option" onclick="Underline()" title="Underline text"><u>U</u></p>

                    <p class="style_option" onclick="Strike()" title="Strike through text"><del><del>S</del></del></p>
                    <img class="style_option" src="img/color_wheel.png" alt="Color wheel" title="Open color box" onclick="ToggleColorBox()">
                    <p class="style_option" onclick="Small()" title="Make text smaller"><small><small>SM</small></small></p>

                    <p class="style_option" onclick="Superscript()" title="Make text superscript">A<sup>sp</sup></p>
                    <p class="style_option" onclick="Subscript()" title="Make text subscript">A<sub>sb</sub></p>
                    <p class="style_option" onclick="Center()" title="Center text">-C-</p>

                    <p class="style_option" onclick="HorizontalRule()" title="Add a horizontal line"><u>HR</u></p>

                </div>

                <!-- COLOR OPTIONS DIV -->
                <div id="color_options">

                    <img src="img/red_circle.png" alt="Red circle" class="color_option" onclick="Red()"></img>
                    <img src="img/green_circle.png" alt="Green circle" class="color_option" onclick="Green()"></img>
                    <img src="img/blue_circle.png" alt="Blue circle" class="color_option" onclick="Blue()"></img>

                </div>
                
            </section>  

            <!-- INPUT -->
            <textarea id="chapter_text_area" name="chapter_text" cols="30" rows="10" placeholder="The creature opened its eyes and looked around..." required="true" autocomplete="off" maxlength="60000" onkeyup="ChapterTextCheck()" title="Enter the text of the first chapter of your story"></textarea>

            <!-- CHAPTER TEXT WORD COUNT -->
            <p class="count_txt"><span id="chapter_text_word_count">0</span>/15 000</p>

            <!-- PREVIEW TOGGLE -->
            <p id="preview_toggle" onclick="TogglePreviewBackground()" style="z-index: 1;">Preview</p>

            <!-- FORM BUTTONS -->
            <div class="form_btns_div">

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
    <script src="preview.js"></script>
    <script src="new_story_check.js"></script>
    <script src="chapter_style.js"></script>

</body>