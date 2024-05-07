<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chapter Reading</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="back_to_top.css">
    <link rel="stylesheet" href="chapter_page.css">
    <link rel="stylesheet" href="comments.css">

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

            // URL VARIABLES
            $url_chapter_id = htmlspecialchars($_GET["chapter_id"]);
            $url_story_id = htmlspecialchars($_GET["story_id"]);

            // ---- GET IDS OF USERS WHO BOOKMARKED THIS CHAPTER ---- //
            // Prepare query
            $get_user_marked_ids = $db->prepare("SELECT user_bookmark_ids FROM chapters WHERE chapter_id = :chapter_id");   

            // Binding
            $get_user_marked_ids->bindValue(":chapter_id", $url_chapter_id);

            // Execution
            $get_user_marked_ids->execute();

            // Store IDs of users who bookmarked this chapter
            $user_marked_ids = $get_user_marked_ids->fetchColumn();

            // Test 
            // echo "<p>IDs of users who bookmarked this chapter : </p>";
            // var_dump($user_marked_ids);

            // ---- GET IDS OF USERS WHO LIKED CHAPTER ---- //
            // Prepare query
            $get_user_like_ids = $db->prepare("SELECT user_like_ids FROM chapters WHERE chapter_id = :chapter_id");   

            // Binding
            $get_user_like_ids->bindValue(":chapter_id", $url_chapter_id);

            // Execution
            $get_user_like_ids->execute();

            // Store IDs of users who liked this chapter
            $user_like_ids = $get_user_like_ids->fetchColumn();

            // Test 
            // echo "<p>IDs of users who liked this chapter : </p>";
            // var_dump($user_like_ids);

            // ---- GET IDS OF USERS WHO DISLIKED CHAPTER ---- //
            // Prepare query
            $get_user_dislike_ids = $db->prepare("SELECT user_dislike_ids FROM chapters WHERE chapter_id = :chapter_id");   

            // Binding
            $get_user_dislike_ids->bindValue(":chapter_id", $url_chapter_id);

            // Execution
            $get_user_dislike_ids->execute();

            // Store IDs of users who disliked this chapter
            $user_dislike_ids = $get_user_dislike_ids->fetchColumn();

            // Test 
            // echo "<p>IDs of users who disliked this chapter : </p>";
            // var_dump($user_dislike_ids);

            // ---- GET STORY INFO ---- //
            // Prepare query
            $get_story_info = $db->prepare("SELECT story_title, author, tags, synopsis FROM stories WHERE story_id = :story_id");

            // Binding
            $get_story_info->bindValue(":story_id", $url_story_id);

            // Execution
            $get_story_info->execute();

            // Store story info
            $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

            // ---- CREATE TAGS ARRAY ---- //
            $tags = explode(" ", $story_info[0]["tags"]);

            // ---- GET CURRENT CHAPTER'S TITLE AND TEXT ---- //
            // Prepare query
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
            // Prepare query
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

        <!-- SECTION 1 : STORY INFO, SYNOPSIS, CHAPTER BOOKMARK -->
        <section id="story_info">

            <?php
                echo "<h3>".$story_info[0]['story_title']."</h3>";
                echo "<p>".$story_info[0]['author']."</p>";

                // START of tags div
                echo "<div id='tags_div'>";

                    // For each tag 
                    foreach($tags as $tag)
                    {
                        // If tag is not an empty string
                        if($tag != "" && $tag != " ")
                        {
                            // Display it
                            echo "<p class='tag_txt'>$tag</p>";
                        }
                    }

                // END of tags div
                echo "</div>";

                // Synopsis text
                echo "<p id='synopsis'>".$story_info[0]['synopsis']."</p>";

                // START of chapter options div
                echo "<div id='chapter_options'>";

                    // CHANGE "BOOKMARK THIS CHAPTER" COLOR
                    // If at least 1 user bookmarked this chapter
                    if($user_marked_ids != null && $user_marked_ids != "")
                    {
                        // If user's ID is already in the list of users who bookmarked this chapter
                        if(str_contains($user_marked_ids, $user_id))
                        {
                            // Display "Bookmark this chapter" in "already bookmarked" color
                            echo "<p class='chapter_option' id='bookmark_txt' onclick='Bookmark($url_chapter_id, $user_id)' style='color: rgb(0, 120, 0);'>Bookmark this chapter</p>";
                        }

                        // If user's ID is not in the list of users who bookmarked this chapter
                        else if(!str_contains($user_marked_ids, $user_id))
                        {
                            // Display "Bookmark this chapter" in default color
                            echo "<p class='chapter_option' id='bookmark_txt' onclick='Bookmark($url_chapter_id, $user_id)'>Bookmark this chapter</p>";
                        }
                    }

                    // If nobody bookmarked this chapter
                    else if($user_marked_ids == null || $user_marked_ids != "")
                    {
                        // Display "Bookmark this chapter" in default color
                        echo "<p class='chapter_option' id='bookmark_txt' onclick='Bookmark($url_chapter_id, $user_id)'>Bookmark this chapter</p>";
                    }

                    // ---- CHANGE "LIKE" COLOR ---- //
                    // If at least 1 user liked this chapter
                    if($user_like_ids != null && $user_like_ids != "")
                    {
                        // If user ID is in list of users who liked this chapter
                        if(str_contains($user_like_ids, $user_id))
                        {
                            // Display "Like" text in "already liked" color
                            echo "<p id='like_txt' style='color:rgb(0, 120, 0);'>".$chapter_info[0]['likes']." Likes</p> <img src='img/like.png' alt='Like Icon' class='thumb' onclick='LikeChapter($url_chapter_id)' id='like_icon'>";
                        }

                        // If user ID is not in list of users who liked this chapter
                        else if(!str_contains($user_like_ids, $user_id))
                        {
                            // Display "Like" in default color
                            echo "<p id='like_txt'>".$chapter_info[0]['likes']." Likes</p> <img src='img/like.png' alt='Like Icon' class='thumb' onclick='LikeChapter($url_chapter_id)' id='like_icon'>";
                        }
                    }

                    // If nobody liked this chapter
                    else if($user_like_ids == null || $user_like_ids == "")
                    {
                        // Display "Like" in default color
                        echo "<p id='like_txt'>".$chapter_info[0]['likes']." Likes</p> <img src='img/like.png' alt='Like Icon' class='thumb' onclick='LikeChapter($url_chapter_id)' id='like_icon'>";
                    }

                    // ---- CHANGE "DISLIKE" COLOR ---- //
                    // If at least 1 user disliked this chapter
                    if($user_dislike_ids != null && $user_dislike_ids != "")
                    {
                        // If user ID is in list of users who disliked this chapter
                        if(str_contains($user_dislike_ids, $user_id))
                        {
                            // Display "Dislike" text in "already liked" color
                            echo "<p id='dislike_txt' style='color:rgb(0, 120, 0);'>".$chapter_info[0]['dislikes']." Dislikes</p> <img src='img/dislike.png' alt='Dislike Icon' class='thumb' onclick='DislikeChapter($url_chapter_id)' id='dislike_icon'>";
                        }

                        // If user ID is not in list of users who disliked this chapter
                        else if(!str_contains($user_dislike_ids, $user_id))
                        {
                            // Display "Dislike" in default color
                            echo "<p id='dislike_txt'>".$chapter_info[0]['dislikes']." Dislikes</p> <img src='img/dislike.png' alt='Dislike Icon' class='thumb' onclick='DislikeChapter($url_chapter_id)' id='dislike_icon'>";
                        }
                    }

                    // If nobody disliked this chapter
                    else if($user_dislike_ids == null || $user_dislike_ids == "")
                    {
                        // Display "Dislike" in default color
                        echo "<p id='dislike_txt'>".$chapter_info[0]['dislikes']." Dislikes</p> <img src='img/dislike.png' alt='Dislike Icon' class='thumb' onclick='DislikeChapter($url_chapter_id)' id='dislike_icon'>";
                    }


                // END of chapter options div
                echo "</div>";
            ?>

        </section>

        <!-- SECTION 2 : FORMATTING -->
        <section id="formatting_section">

            <!-- FORMAT DIV -->
            <p class="formatting" id="format" onclick="ToggleFontTypeAndSizeButtons()">Format</p>

            <!-- TEXT FONT DIV -->
            <p class="formatting" id="text_font" onclick="ToggleFontNamesDiv()">Text Font</p>

            <!-- FONT NAMES DIV -->
            <div id="font_names_div">

                <p onclick="SetFontTimesNewRoman()">Times New Roman</p>
                <p onclick="SetFontArial()">Arial</p>
                <p onclick="SetFontVerdana()">Verdana</p>
                <p onclick="SetFontLucidaSansUnicode()">Lucida Sans Unicode</p>

            </div>

            <!-- FONT SIZE DIV -->
            <p class="formatting" id="font_size" onclick="ToggleFontSizeDiv()">Font Size</p>

            <!-- FONT SIZE INPUT DIV -->
            <div id="font_size_input_div">

                <!-- LABEL -->
                <label for="font_size_field">Enter a font size (in pixels) between 14 and 28 :</label>

                <!-- INPUT -->
                <input type="number" id="font_size_field" placeholder="00" maxlength="2">

                <!-- SUBMIT -->
                <button id="font_size_btn" onclick="ChangeFontSize()">Change Font Size</button>

            </div>

        </section>

        <!-- SECTION 3 : CHAPTER TITLE AND TEXT  -->
        <section id="chapter_title_txt">

            <?php

                // Chapter title
                echo "<h3 id='chaper_title'>".$chapter_title_text[0]['chapter_title']."</h3>";

                // Chapter text
                echo "<p id='chaper_txt'>".$chapter_title_text[0]['chapter_text']."</p>";
            ?>

        </section>

        <!-- (OPTIONAL) SECTION 4 : PREVIOUS/NEXT CHAPTER -->
        <?php
            // If this story has more than 1 chapter
            if(count($chapter_ids) > 1)
            {
                // Section title
                echo "<h3>Previous/next chapter</h3>";

                // START of section 3
                echo "<section class='chapter_list'>";

                // ---- CHAPTER TWO ONLY ---- //
                if($url_chapter_id == $chapter_ids[0])
                {
                    // START of chapter info div
                    echo "<div class='chapter' onclick='ChapterPage(".$chapter_two[0]['chapter_id'].",".$url_story_id.")'>";

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
                    echo "<div class='chapter' onclick='ChapterPage(".$next_to_last_chapter[0]['chapter_id'].",".$url_story_id.")'>";

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
                    echo "<div class='chapter' onclick='ChapterPage(".$previous_chapter[0]['chapter_id'].",".$url_story_id.")'>";

                        echo "<p>".$previous_chapter[0]['chapter_title']."</p>";
                        echo "<p>".date("d-m-Y", strtotime($previous_chapter[0]['pub_date']))."</p>";
                        echo "<p>".$previous_chapter[0]['word_count']." Words</p>";
                        echo "<p>".$previous_chapter[0]['likes']." Likes</p>";
                        echo "<p>".$previous_chapter[0]['dislikes']." Dislikes</p>";

                    // END of chapter info div
                    echo "</div>";

                    // NEXT CHAPTER

                    // START of chapter info div
                    echo "<div class='chapter' onclick='ChapterPage(".$next_chapter[0]['chapter_id'].",".$url_story_id.")'>";

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

        <!-- SECTION 5 : CHAPTER COMMENTS -->
        <section id="comments">

            <h3>Chapter Comments</h3>

            <!-- WRITTEN COMMENTS -->

            <?php
                // ---- GET INFO OF CHAPTER COMMENTS ---- //
                // Prepare query
                $get_chapter_comments = $db->prepare("SELECT comment_id, user_id, pub_date, comment_text, likes, dislikes, user_like_ids, user_dislike_ids FROM comments WHERE chapter_id = :chapter_id");

                // Binding  
                $get_chapter_comments->bindValue(":chapter_id", $url_chapter_id);

                // Execute
                $get_chapter_comments->execute();

                // Store comments
                $chapter_comments = $get_chapter_comments->fetchAll(PDO::FETCH_ASSOC);

                // Test
                // echo "<p>Chapter comments :</p>";
                // var_dump($chapter_comments);
                // exit;

                // For each chapter comment
                foreach($chapter_comments as $chapter_comment)
                {
                    // GET CURRENT COMMENT INFO
                    // Prepare query
                    $get_comment_info = $db->prepare("SELECT comment_id, user_id, pub_date, comment_text, likes, dislikes, user_like_ids, user_dislike_ids FROM comments WHERE comment_id = :comment_id");

                    // Binding
                    $get_comment_info->bindValue(":comment_id", $chapter_comment["comment_id"]);

                    // Execution
                    $get_comment_info->execute();

                    // Store info
                    $comment_info = $get_comment_info->fetchAll(PDO::FETCH_ASSOC);

                    // Test 
                    // echo "<p>Single chapter comment info :</p>";
                    // var_dump($comment_info);
                    // exit;
              
                    // GET CURRENT COMMENT AUTHOR
                    // Prepare query
                    $get_comment_author = $db->prepare("SELECT username FROM users WHERE user_id = :user_id");

                    // Binding
                    $get_comment_author->bindValue(":user_id", $comment_info[0]["user_id"]);

                    // Execution
                    $get_comment_author->execute();

                    // Store author
                    $author = $get_comment_author->fetchColumn();

                    // Test
                    // echo "<p>Chapter comment author :</p>";
                    // var_dump($comment_author);
                    // exit;

                    // START of current comment div
                    echo "<div class='comment_div'>";

                            // START of author div
                            echo "<div class='author_div'>";

                                // Author
                                echo "<p class='comment_author'>$author</p>";

                            // END of author div
                            echo "</div>";

                            // START of comment delete and quote div 
                            echo "<div class='comment_del_quote'>";

                                // If user is logged in and the comment is theirs
                                if(isset($_SESSION["username"]) && !empty($_SESSION["username"]) && $_SESSION["username"] == $author)
                                {
                                    // Display delete icon
                                    echo "<img src='img/delete.png' alt='Delete icon' class='delete_icon' onclick='DeleteChapterComment(".$chapter_comment["comment_id"].")'>";
                                }

                                // Quote icon
                                echo "<img src='img/quote.png' alt='Quote icon' class='quote_icon' onclick='QuoteComment(\"".$author."\", \"".htmlspecialchars($chapter_comment['comment_text'])."\", \"".date("d-m-Y", strtotime($chapter_comment['pub_date']))."\")'>";

                            // END of comment delete and quote div  
                            echo "</div>";

                            // START of comment like and dislike div
                            echo "<div class='comment_like_dislike'>";

                                // ---- LIKES ---- //

                                // START of comment likes div
                                echo "<div class='thumb_box'>";

                                    // If user is not logged in
                                    if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
                                    {
                                        // Display number of likes with default color
                                        echo "<p class='comment_like_txt'>".$chapter_comment["likes"]." Likes</p>";

                                        // Display like icon without functions
                                        echo "<img class='thumb' src=img/like.png alt='Like icon'>";
                                    }

                                    // If user is logged in
                                    else if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
                                    {
                                        // If at least one user liked this comment
                                        if($comment_info[0]["user_like_ids"] != null && $comment_info[0]["user_like_ids"] != "")
                                        {
                                            // If user liked this comment
                                            if(str_contains($comment_info[0]["user_like_ids"], $user_id))
                                            {
                                                // Display number of likes with "valid" color
                                                echo "<p class='comment_like_txt' style='color: rgb(0, 120, 0);'>".$chapter_comment["likes"]." Likes</p>";

                                                // Display like icon with functions
                                                echo "<img class='comment_like_icon' onclick='ToggleStoryCommentLike(".$chapter_comment["comment_id"].", ".$user_id.")' src=img/like.png alt='Like icon'>";
                                            }

                                            // If user did not like this comment
                                            else if(!str_contains($comment_info[0]["user_like_ids"], $user_id))
                                            {
                                                // Display number of likes with default color
                                                echo "<p class='comment_like_txt'>".$chapter_comment["likes"]." Likes</p>";

                                                // Display like icon with functions
                                                echo "<img class='comment_like_icon' onclick='ToggleStoryCommentLike(".$chapter_comment["comment_id"].", ".$user_id.")' src=img/like.png alt='Like icon'>";
                                            }
                                        }
                                        
                                        // If nobody liked this comment
                                        else if($chapter_comment["user_like_ids"] == null || $chapter_comment["user_like_ids"] == "")
                                        {
                                            // Display number of likes with default color
                                            echo "<p class='comment_like_txt'>".$chapter_comment["likes"]." Likes</p>";

                                            // Display like icon with functions and default color
                                            echo "<img class='comment_like_icon' onclick='ToggleStoryCommentLike(".$chapter_comment["comment_id"].", ".$user_id.")' src=img/like.png alt='Like icon'>";  
                                        }   
                                    }

                                // END of comment likes div
                                echo "</div>";


                                // ---- DISLIKES ---- //


                                // START of comment dislikes div
                                echo "<div class='thumb_box'>";

                                    // If user is not logged in
                                    if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
                                    {
                                        // Display number of dislikes with default color
                                        echo "<p class='comment_dislike_txt'>".$chapter_comment["dislikes"]." Dislikes</p>";

                                        // Display dislike icon without functions
                                        echo "<img class='thumb' src=img/dislike.png alt='Dislike icon'>";
                                    }

                                    // If user is logged in
                                    else if(isset($_SESSION["username"]) && !empty($_SESSION["username"]))
                                    {
                                        // If at least one user disliked this comment
                                        if($comment_info[0]["user_dislike_ids"] != null && $comment_info[0]["user_dislike_ids"] != "")
                                        {
                                            // If user disliked this comment
                                            if(str_contains($comment_info[0]["user_dislike_ids"], $user_id))
                                            {
                                                // Display number of dislikes with "valid" color
                                                echo "<p class='comment_dislike_txt' style='color: rgb(0, 120, 0);'>".$chapter_comment["dislikes"]." Dislikes</p>";

                                                // Display dislike icon with functions
                                                echo "<img class='comment_dislike_icon' onclick='ToggleStoryCommentDislike(".$chapter_comment["comment_id"].", ".$user_id.")' src=img/dislike.png alt='Dislike icon'>";
                                            }

                                            // If user did not dislike this comment
                                            else if(!str_contains($comment_info[0]["user_dislike_ids"], $user_id))
                                            {
                                                // Display number of dislikes with default color
                                                echo "<p class='comment_dislike_txt'>".$chapter_comment["dislikes"]." Dislikes</p>";

                                                // Display dislike icon with functions
                                                echo "<img class='comment_dislike_icon' onclick='ToggleStoryCommentDislike(".$chapter_comment["comment_id"].", ".$user_id.")' src=img/dislike.png alt='Dislike icon'>";
                                            }
                                        }
                                        
                                        // If nobody disliked this comment
                                        else if($chapter_comment["user_dislike_ids"] == null || $chapter_comment["user_dislike_ids"] == "")
                                        {
                                            // Display number of dislikes with default color
                                            echo "<p class='comment_dislike_txt'>".$chapter_comment["dislikes"]." Dislikes</p>";

                                            // Display dislike icon with functions and default color
                                            echo "<img class='comment_dislike_icon' onclick='ToggleStoryCommentDislike(".$chapter_comment["comment_id"].", ".$user_id.")' src=img/dislike.png alt='Dislike icon'>";  
                                        }    
                                    }

                                // END of comment dislikes div
                                echo "</div>";

                            // END of comment like and dislike div  
                            echo "</div>";

                        // Comment text
                        echo "<p class='comment_txt'>".$chapter_comment['comment_text']."</p>";

              
                        // Publication date
                        echo "<small id='comment_date'>Posted on ".date("d-m-Y", strtotime($chapter_comment['pub_date']))."</small>";

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
                <label for="comment_textarea">Your comment (max. 3000 characters)</label>

                <!-- INPUT -->
                <textarea name="comment_textarea" id="comment_textarea" cols="40" rows="10" maxlength="3000" placeholder="What I like about this chapter is that...on the other hand..."></textarea>

                <!-- FORM BUTTONS DIV -->
                <div id="form_btns_div">

                    <!-- SUBMIT -->
                    <input class="formBtn" type="submit" value="Publish">

                    <!-- CANCEL -->
                    <input class="formBtn" type="reset" value="Cancel">

                </div>

            </form>

        </section>

    </main>

    <!-- SCRIPTS -->
    <script src="chapter_page.js"></script>
    <script src="formatting.js"></script>
    <script src="toggle_bookmark.js"></script>
    <script src="chapter_like_dislike.js"></script>
    <script src="chapter_comment_delete.js"></script>
    <script src="chapter_comment_like_dislike.js"></script>
    <script src="quote_comment.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>