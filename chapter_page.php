<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chapter Reading</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Chapter Reading</h2>

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

            // DATABASE CONNECTION
            require_once("database_connection.php");

            // If user is logged in
            if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
            {
                // Get their ID
                require_once("get_user_id.php");
            }

            // URL VARIABLES
            $url_chapter_id = htmlspecialchars($_GET["chapter_id"]);
            $url_story_id = htmlspecialchars($_GET["story_id"]);

            // GET STORY INFO

            // Prepare query to get story info of the clicked chapter
            $get_story_info = $db->prepare("SELECT story_title, author, tags, synopsis FROM stories WHERE story_id = :story_id");

            // Binding
            $get_story_info->bindValue(":story_id", $url_story_id);

            // Execution
            $get_story_info->execute();

            // Store story info
            $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

            // GET TAGS ARRAY
            $tags = explode(" ", $story_info[0]["tags"]);

            // ---- GET CURRENT CHAPTER'S TITLE AND TEXT ---- //

            // Prepare a query to get clicked chapter's title and text
            $get_chapter_title_text = $db->prepare("SELECT chapter_title, chapter_text FROM chapters WHERE chapter_id = :chapter_id");

            // Binding
            $get_chapter_title_text->bindValue(":chapter_id", $url_chapter_id);

            // Execution
            $get_chapter_title_text->execute();

            // Store result
            $chapter_title_text = $get_chapter_title_text->fetchAll(PDO::FETCH_ASSOC);

            // Test
            // var_dump($chapter_title_text);

            // ---- GET EVERY CHAPTERS' INFO ---- //

            // Prepare a query to get title, date, word count, likes and dislikes from every chapter of the clicked story
            $get_chapter_info = $db->prepare("SELECT story_id, chapter_id, chapter_title, chapter_text pub_date, word_count, likes, dislikes FROM chapters WHERE story_id = :story_id");

            // Binding
            $get_chapter_info->bindValue(":story_id", $url_story_id);

            // Execution
            $get_chapter_info->execute();

            // Store info
            $chapter_info = $get_chapter_info->fetchAll(PDO::FETCH_ASSOC);

            // Test
            // var_dump($chapter_info);
            // var_dump(count($chapter_info));
            // exit;

            // ---- CREATE AN ARRAY OF CHAPTER IDS ---- //
            $chapter_ids = array();

            // For every chapter
            for($i = 0; $i < count($chapter_info); $i++)
            {
                // Place its chapter ID in the array
                array_push($chapter_ids, $chapter_info[$i]["chapter_id"]);
            }

            // Sort array by ID in ascending order
            sort($chapter_ids);

            // Test
            // var_dump($chapter_ids);


            // ---- GET PREVIOUS/NEXT CHAPTER INFO ---- //
            // If story has more than 1 chapter
            if(count($chapter_ids) > 1)
            {
                // If URL's chapter ID is also the first one in the chapter IDs array
                if($url_chapter_id == $chapter_ids[0])
                {
                    // GET CHAPTER TWO
                    // Prepare a query to get 2nd chapter's info
                    $get_chapter_two = $db->prepare("SELECT chapter_id, chapter_title, pub_date, word_count, likes, dislikes FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_chapter_two->bindValue(":chapter_id", $chapter_ids[1]);

                    // Execution
                    $get_chapter_two->execute();

                    // Store chapter two
                    $chapter_two = $get_chapter_two->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // var_dump($chapter_two);
                }

                // If URL's chapter ID is also the last one in the chapter IDs array
                else if($url_chapter_id == $chapter_ids[count($chapter_ids)-1])
                {
                    // GET NEXT TO LAST CHAPTER
                    // Prepare a query to get 2nd chapter's info
                    $get_next_to_last_chapter = $db->prepare("SELECT chapter_id, chapter_title, pub_date, word_count, likes, dislikes FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_next_to_last_chapter->bindValue(":chapter_id", $chapter_ids[count($chapter_ids)-2]);

                    // Execution
                    $get_next_to_last_chapter->execute();

                    // Store next to last chapter 
                    $next_to_last_chapter = $get_next_to_last_chapter->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // var_dump($next_to_last_chapter);
                }

                // If URL's chapter ID is not the smallest nor the biggest one in the chapter IDs array
                else if($url_chapter_id != $chapter_ids[0] && $url_chapter_id != $chapter_ids[count($chapter_ids)-1])
                {
                    // GET POSITION OF URL CHAPTER ID IN CHAPTER IDS ARRAY
                    $url_chapter_id_array_position;

                    // For every chapter ID
                    for($i = 0; $i < count($chapter_ids); $i++)
                    {
                        // If URL chapter ID has the same value as array chapter ID
                        if($url_chapter_id == $chapter_ids[$i])
                        {
                            // Assign that position to a variable
                            $url_chapter_id_array_position = $i;
                        }
                    }

                    // GET PREVIOUS CHAPTER
                    // Prepare a query to get previous chapter
                    $get_previous_chapter = $db->prepare("SELECT chapter_id, chapter_title, pub_date, word_count, likes, dislikes FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_previous_chapter->bindValue(":chapter_id", $chapter_ids[$url_chapter_id_array_position-1]);

                    // Execution
                    $get_previous_chapter->execute();

                    // Store previous chapter
                    $previous_chapter = $get_previous_chapter->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // echo "<p>Previous chapter :</p>";
                    // var_dump($previous_chapter[0]['chapter_title']);

                    // GET NEXT CHAPTER
                    // Prepare a query to get next chapter
                    $get_next_chapter = $db->prepare("SELECT chapter_id, chapter_title, pub_date, word_count, likes, dislikes FROM chapters WHERE chapter_id = :chapter_id");

                    // Binding
                    $get_next_chapter->bindValue(":chapter_id", $chapter_ids[$url_chapter_id_array_position+1]);

                    // Execution
                    $get_next_chapter->execute();

                    // Store next chapter
                    $next_chapter = $get_next_chapter->fetchAll(PDO::FETCH_ASSOC);

                    // Test
                    // echo "<p>Next chapter :</p>";
                    // var_dump($next_chapter[0]['chapter_title']);
                }
            }
        ?>

        <!-- SECTION 1 : STORY INFO, SYNOPSIS, BOOKMARK -->
        <section style="flex-direction: column;">

            <?php
                echo "<h4>".$story_info[0]['story_title']."</h4>";
                echo "<p>".$story_info[0]['author']."</p>";

                // START of tags div
                echo "<div class='tags_div'>";

                    // For each tag 
                    foreach($tags as $tag)
                    {
                        // If tag is not an empty string
                        if($tag != "" && $tag != " ")
                        {
                            // Display it
                            echo "<p>$tag</p>";
                        }
                    }

                // END of tags div
                echo "</div>";

                // Synopsis text
                echo "<p>".$story_info[0]['synopsis']."</p>";

                // START of chapter options div
                echo "<div class='chapter_options'>";

                    // Bookmark
                    echo "<p class='chapter_option' id='bookmark_txt' onclick='Bookmark($url_chapter_id, $user_id)'>Bookmark this chapter</p>";

                    // START of likes div
                    echo "<div class='thumb_box'>";

                        // Likes
                        echo "<p>".$chapter_info[0]["likes"]." Likes</p>";
                        echo "<img src='img/like.png' alt='Like icon' class='thumb'>";

                    // END of likes div
                    echo "</div>";


                    // START of dislikes div
                    echo "<div class='thumb_box'>";

                        // Likes
                        echo "<p>".$chapter_info[0]["dislikes"]." Dislikes</p>";
                        echo "<img src='img/dislike.png' alt='Dislike icon' class='thumb'>";

                    // END of dislikes div
                    echo "</div>";


                // END of chapter options div
                echo "</div>";
            ?>

        </section>

        <!-- SECTION 2 : CHAPTER TEXT  -->
        <section class="chapter_text_section">

            <?php

                // START of chapter text div
                echo "<div>";

                    // Chapter title
                    echo "<h3>".$chapter_title_text[0]['chapter_title']."</h3>";

                    // Chapter text
                    echo "<p>".$chapter_title_text[0]['chapter_text']."</p>";

                // END of chapter text div
                echo "</div>";
            ?>

        </section>

        <!-- (OPTIONAL) SECTION 3 : PREVIOUS/NEXT CHAPTER -->
        <?php
            // If this story has more than 1 chapter
            if(count($chapter_ids) > 1)
            {
                // Section title
                echo "<h3>Previous/next chapter</h3>";

                // START of section 3
                echo "<section class='list_chapter_info'>";

                // ---- CHAPTER TWO ONLY ---- //
                if($url_chapter_id == $chapter_ids[0])
                {
                    // START of chapter info div
                    echo "<div class='chapter_info_row' onclick='ChapterPage(".$chapter_two[0]['chapter_id'].",".$url_story_id.")'>";

                        echo "<p>".$chapter_two[0]['chapter_title']."</p>";
                        echo "<p>".date("d-m-Y", strtotime($chapter_two[0]['pub_date']))."</p>";
                        echo "<p>".$chapter_two[0]['word_count']." Words</p>";
                        echo "<p>".$chapter_two[0]['likes']." Likes</p>";
                        echo "<p>".$chapter_two[0]['dislikes']." Dislikes</p>";

                    // END of chapter info div
                    echo "</div>";
                }

                // ---- NEXT TO LAST CHAPTER ONLY ---- //
                else if($url_chapter_id == $chapter_ids[count($chapter_ids)-1])
                {
                    // START of chapter info div
                    echo "<div class='chapter_info_row' onclick='ChapterPage(".$next_to_last_chapter[0]['chapter_id'].",".$url_story_id.")'>";

                        echo "<p>".$next_to_last_chapter[0]['chapter_title']."</p>";
                        echo "<p>".date("d-m-Y", strtotime($next_to_last_chapter[0]['pub_date']))."</p>";
                        echo "<p>".$next_to_last_chapter[0]['word_count']." Words</p>";
                        echo "<p>".$next_to_last_chapter[0]['likes']." Likes</p>";
                        echo "<p>".$next_to_last_chapter[0]['dislikes']." Dislikes</p>";

                    // END of chapter info div
                    echo "</div>";
                }

                // ---- PREVIOUS AND NEXT CHAPTERS ---- //
                else if($url_chapter_id != $chapter_ids[0] && $url_chapter_id != $chapter_ids[count($chapter_ids)-1])
                {
                    // PREVIOUS CHAPTER

                    // START of chapter info div
                    echo "<div class='chapter_info_row' onclick='ChapterPage(".$previous_chapter[0]['chapter_id'].",".$url_story_id.")'>";

                        echo "<p>".$previous_chapter[0]['chapter_title']."</p>";
                        echo "<p>".date("d-m-Y", strtotime($previous_chapter[0]['pub_date']))."</p>";
                        echo "<p>".$previous_chapter[0]['word_count']." Words</p>";
                        echo "<p>".$previous_chapter[0]['likes']." Likes</p>";
                        echo "<p>".$previous_chapter[0]['dislikes']." Dislikes</p>";

                    // END of chapter info div
                    echo "</div>";

                    // NEXT CHAPTER

                    // START of chapter info div
                    echo "<div class='chapter_info_row' onclick='ChapterPage(".$next_chapter[0]['chapter_id'].",".$url_story_id.")'>";

                        echo "<p>".$next_chapter[0]['chapter_title']."</p>";
                        echo "<p>".date("d-m-Y", strtotime($next_chapter[0]['pub_date']))."</p>";
                        echo "<p>".$next_chapter[0]['word_count']." Words</p>";
                        echo "<p>".$next_chapter[0]['likes']." Likes</p>";
                        echo "<p>".$next_chapter[0]['dislikes']." Dislikes</p>";

                    // END of chapter info div
                    echo "</div>";
                }

                // END of section 3
                echo "</section>";
            }
        ?>

        <!-- SECTION 4 : CHAPTER COMMENTS -->
        <section style="flex-direction: column;">

            <h3>Chapter Comments</h3>

            <!-- WRITTEN COMMENTS -->

            <?php
                // ---- GET EVERY COMMENTS' TEXT, DATE AND USER ID ---- //

                // Prepare a query to get every chapter comments' tetx, date and user ID
                $get_chapter_comments = $db->prepare("SELECT  user_id, pub_date, comment_text FROM comments WHERE chapter_id = :chapter_id");

                // Binding  
                $get_chapter_comments->bindValue(":chapter_id", $url_chapter_id);

                // Execute
                $get_chapter_comments->execute();

                // Store comments
                $chapter_comments = $get_chapter_comments->fetchAll(PDO::FETCH_ASSOC);

                // ---- GET COMMENT'S AUTHOR ---- //

                // For each chapter comment
                foreach($chapter_comments as $chapter_comment)
                {
                    // Prepare a query to get comment's username
                    $get_comment_author = $db->prepare("SELECT username FROM users WHERE user_id = :user_id");

                    // Binding
                    $get_comment_author->bindValue(":user_id", $chapter_comment["user_id"]);

                    // Execution
                    $get_comment_author->execute();

                    // Store author
                    $comment_author = $get_comment_author->fetchColumn();

                    // START of current comment div
                    echo "<div class='comment_div'>";

                        // USER INFO
                        echo    "   <div>
                                        <p>$comment_author</p>
                                    </div>
                                ";

                        // COMMENT INFO
                        echo    "   <div>
                                        <p class='comment'>".$chapter_comment['comment_text']."</p>
                                        <small class='comment_date'>Posted on ".date("d-m-Y", strtotime($chapter_comment['pub_date']))."</small>
                                    </div>
                                ";

                    // END of current comment div
                    echo "</div>";
                }
            ?>

            <!-- COMMENT WRITING SPACE -->

            <p>Write a comment about this chapter</p>

            <form style="width: 40%;" action="register_chapter_comment.php" method="post">

                <!-- CHAPTER ID -->
                <?php
                    echo "<input type='text' name='chapter_id' value='$url_chapter_id' style='display:none;'>";
                ?>

                <!-- LABEL -->
                <label for="comment_text">Your comment (up to 3000 characters)</label>

                <!-- INPUT -->
                <textarea name="comment_text" id="comment_text" cols="40" rows="10" maxlength="3000" placeholder="What I like about this chapter is that...on the other hand..."></textarea>

                <!-- FORM BUTTONS DIV -->
                <div class="formBtnsDiv">

                    <!-- SUBMIT -->
                    <input class="formBtn" type="submit" value="Publish">

                    <!-- CANCEL -->
                    <input class="formBtn" type="reset" value="Cancel">

                </div>

            </form>

        </section>

    </main>

    <!-- SCRIPTS -->
    <script src="bookmark.js"></script>
    <script src="chapter_page.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>