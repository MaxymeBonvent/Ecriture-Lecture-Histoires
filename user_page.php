<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User page</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>User page</h2>

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

        <!-- OUTLINE OF BACK TO TOP DIV -->
        <a id="back_to_top_outline" href="#_header">

            <!-- BACK TO TOP LINK  -->
            <div id="back_to_top"></div>

        </a>

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

                // ---- GET USER ID ----
                require_once("get_user_id.php");

                // TOP HALF DIV OF USER AND BOOKMARKED CHAPTER DIV
                echo   "<div class='user_page_half_div'> 

                            <div class='user_page_inner_div'>

                                <h2 id='username'>".

                                    $_SESSION['username']."

                                </h2>

                                <div id='user_page_options_div'>

                                    <a href='story_count_check.php'>Your stories</a>

                                    <a href='log_out.php'>Log out</a>

                                    <p id='account_delete_txt' onclick='DeleteAccount($user_id)'>Delete your account</p>

                                </div>

                            </div>
     
                            <div class='user_page_inner_div'>

                                <h3>Bookmarked Chapter</h3>

                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <h5 class='title'>Chapter title</h5>

                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>
                                        
                                    </div>
                                    
                            </div>

                        </div>
                            

                        </div>";

            // BOTTOM HALF DIV OF USER STORIES, FAV STORIES AND READ LATER STORIES
            echo    "<div class='user_page_half_div'>

                        <div div class='user_page_inner_div'>

                            <h3>Favorite Stories</h3>

                            <div class='vertical_story_container'>

                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                            </div>

                        </div>

                        <div div class='user_page_inner_div'>

                            <h3>Read Later Stories</h3>

                            <div class='vertical_story_container'>

                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                                <div class='story_div'>

                                    <h4 class='title'>Story Title</h4>
                                    <p class='author_name'>Author</p>

                                    <div class='tags_div'>

                                        <p>Slice of life1</p><p>Slice of life2</p><p>Slice of life3</p>
                                        <p>Slice of life4</p><p>Slice of life5</p><p>Slice of life6</p>

                                    </div>
                                      
                                </div>


                            </div>

                        </div>

                    </div>
                    ";
        ?>

        <?php
            } 
        ?>

    </main>

    <!-- SCRIPTS -->
    <script src="delete_account.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>