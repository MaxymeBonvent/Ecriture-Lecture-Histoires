<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Synopsis</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Synopsis</h2>

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

            // USER ID
            require_once("get_user_id.php");

            // ---- CLICKED STORY INFO ---- //
  
            $story_title = htmlspecialchars($_GET["story_title"]);
            $author = htmlspecialchars($_GET["author"]);
            $tags = htmlspecialchars($_GET["tags"]);
            $chapter_ids = htmlspecialchars($_GET["chapter_ids"]);

            // ---- GET STORY ID ---- //

            // Prepare a query to ghet story's ID
            $get_story_id = $db->prepare("SELECT story_id FROM stories WHERE story_title = :story_title");

            // Binding
            $get_story_id->bindValue(":story_title", $story_title);

            // Execution
            $get_story_id->execute();

            // Store story ID
            $story_id = $get_story_id->fetchColumn();

            // Closing
            $get_story_id->closeCursor();

            // GET TAGS ARRAY
            $tags_array = explode(" ", $tags);

            // ---- GET IDS OF USERS WHO FAVED ---- //
            // Prepare query
            $get_user_favs = $db->prepare("SELECT user_fav_ids FROM stories WHERE story_id = :story_id");

            // Binding
            $get_user_favs->bindValue(":story_id", $story_id);

            // Execution
            $get_user_favs->execute();

            // Store user fav IDs
            $user_fav_ids = $get_user_favs->fetchColumn();

            // Test
            // echo "<p>IDs of users who faved this story :</p>";
            // var_dump($user_fav_ids);

            // ---- GET IDS OF USERS WHO'LL READ LATER ---- //
            // Prepare query
            $get_user_later = $db->prepare("SELECT user_later_ids FROM stories WHERE story_id = :story_id");

            // Binding
            $get_user_later->bindValue(":story_id", $story_id);

            // Execution
            $get_user_later->execute();

            // Store user later IDs
            $user_later_ids = $get_user_later->fetchColumn();

            // Test
            // echo "<p>IDs of users who'll read this story later :</p>";
            // var_dump($user_later_ids);

            // ---- GET IDS OF USERS WHO LIKED ---- //
            // Prepare query
            $get_story_likes = $db->prepare("SELECT user_like_ids FROM stories WHERE story_id = :story_id");

            // Binding
            $get_story_likes->bindValue(":story_id", $story_id);

            // Execution
            $get_story_likes->execute();

            // Store likes
            $story_likes = $get_story_likes->fetchAll(PDO::FETCH_ASSOC);

            // Test
            // var_dump($story_likes);
            // exit;

            // ---- GET IDS OF USERS WHO DISLIKED ---- //
            // Prepare query
            $get_story_dislikes = $db->prepare("SELECT user_dislike_ids FROM stories WHERE story_id = :story_id");

            // Binding
            $get_story_dislikes->bindValue(":story_id", $story_id);

            // Execution
            $get_story_dislikes->execute();

            // Store dislikes
            $story_dislikes = $get_story_dislikes->fetchAll(PDO::FETCH_ASSOC);

            // Test
            // var_dump($story_dislikes);
            // exit;

            // ---- GET CHAPTERS' INFO ---- //

            // Prepare a query to get title, date, word count, likes and dislikes from every chapter of the clicked story
            $get_chapter_info = $db->prepare("SELECT chapter_id, chapter_title, pub_date, word_count, likes, dislikes FROM chapters WHERE story_id = :story_id ORDER BY chapter_id ASC");

            // Binding
            $get_chapter_info->bindValue(":story_id", $story_id);

            // Execution
            $get_chapter_info->execute();

            // Store info
            $chapter_info = $get_chapter_info->fetchAll(PDO::FETCH_ASSOC);

            // Test 
            // var_dump($chapter_info);

            // ---- GET AUTHOR'S BIO ---- //

            // Prepare a query to get author's bio
            $get_bio = $db->prepare("SELECT biography FROM users WHERE username = :username");

            // Binding  
            $get_bio->bindValue(":username", $author);

            // Execution
            $get_bio->execute();

            // Store bio
            $bio = $get_bio->fetchColumn();

            // Closing
            $get_bio->closeCursor();

            // ---- GET STORY'S LIKE COUNT AND DISLIKE COUNT ---- //

            // Prepare a query to get story's synopsis, likes and dislikes
            $get_story_info = $db->prepare("SELECT story_id, synopsis, likes, dislikes FROM stories WHERE story_title = :story_title");

            // Binding  
            $get_story_info->bindValue(":story_title", $story_title);

            // Execution
            $get_story_info->execute();

            // Store story info
            $story_info = $get_story_info->fetchAll(PDO::FETCH_ASSOC);

            // Closing
            $get_story_info->closeCursor();
        ?>

        <!-- SECTION 1 : AUTHOR INFO -->
        <section style="flex-direction:column;">

            <?php
                echo "<h3>$author</h3>";
                echo "<p>$bio</p>";
            ?>

        </section>


        <!-- SECTION 2 : STORY OPTIONS -->
        <section style="justify-content: space-evenly;">

            <?php
                // ---- CHANGE "ADD TO FAVS" COLOR ---- //
                // If at least 1 user faved that story
                if($user_fav_ids != null && $user_fav_ids != "")
                {
                    // If user's ID is part of IDs of users who faved this story
                    if(str_contains($user_fav_ids, $user_id))
                    {
                        // Display "Add to Favs" in "already in my stack" color
                        echo "<p onclick='ToggleStoryFavs($story_id)' class='story_option' id='favs_txt' style='color:rgb(0, 120, 0);'>Add to Favs</p>";
                    }
                    
                    // If user's ID is not part of IDs of users who faved this story
                    else if(!str_contains($user_fav_ids, $user_id))
                    {
                        // Display "Add to Favs" in default color
                        echo "<p onclick='ToggleStoryFavs($story_id)' class='story_option' id='favs_txt'>Add to Favs</p>";
                    }
                }

                // If nobody faved that story
                else if($user_fav_ids == null || $user_fav_ids != "")
                {
                    // Display "Add to Favs" in default color
                    echo "<p onclick='ToggleStoryFavs($story_id)' class='story_option' id='favs_txt'>Add to Favs</p>";
                }

                // ---- CHANGE "READ LATER" COLOR ---- //
                // If at least 1 user added that story to their Read Later stack
                if($user_later_ids != null && $user_later_ids != "")
                {
                    // If user's ID is part of IDs of users who added that story to their Read Later stack
                    if(str_contains($user_later_ids, $user_id))
                    {
                        // Display "Read Later" in "already in my stack" color
                        echo "<p onclick='ToggleStoryReadLater($story_id)' class='story_option' id='favs_txt' style='color:rgb(0, 120, 0);'>Read Later</p>";
                    }
                    
                    // If user's ID is not part of IDs of users who added that story to their Read Later stack
                    else if(!str_contains($user_later_ids, $user_id))
                    {
                        // Display "Read Later" in default color
                        echo "<p onclick='ToggleStoryReadLater($story_id)' class='story_option' id='favs_txt'>Read Later</p>";
                    }
                }

                // If nobody added that story to their Read Later stack
                else if($user_later_ids == null || $user_later_ids != "")
                {
                     // Display "Read Later" in default color
                        echo "<p onclick='ToggleStoryReadLater($story_id)' class='story_option' id='favs_txt'>Read Later</p>";
                }
                

                // ---- CHANGE "LIKE" COLOR ---- //
                // If at least one user liked this story
                if($story_likes[0]["user_like_ids"] != null)
                {
                    // If user ID is in Story's like IDs
                    if(str_contains($story_likes[0]["user_like_ids"], $user_id))
                    {
                        // Display like text in green
                        echo "<div class='thumb_box'> <p id='like_txt' style='color:rgb(0, 120, 0);'>".$story_info[0]['likes']." Likes</p> <img src='img/like.png' alt='Like Icon' class='thumb' onclick='LikeStory($story_id)'> </div>";
                    }

                    // If user ID is not in Story's like IDs
                    else if(!str_contains($story_likes[0]["user_like_ids"], $user_id))
                    {
                        // Display "Like" in default color
                        echo "<div class='thumb_box'><p id='like_txt'>".$story_info[0]['likes']." Likes</p> <img src='img/like.png' alt='Like Icon' class='thumb' onclick='LikeStory($story_id)'> </div>";
                    }
                }

                // If no one like this story
                else if($story_likes[0]["user_like_ids"] == null)
                {
                    // Display "Like" in default color
                    echo "<div class='thumb_box'><p id='like_txt'>".$story_info[0]['likes']." Likes</p> <img src='img/like.png' alt='Like Icon' class='thumb' onclick='LikeStory($story_id)'> </div>";
                }

                // ---- CHANGE "DISLIKE" COLOR ---- //
                // If at least one user disliked this story
                if($story_dislikes[0]["user_dislike_ids"] != null)
                {
                    // If user ID is in Story's dislike IDs
                    if(str_contains($story_dislikes[0]["user_dislike_ids"], $user_id))
                    {   
                        // Display dislike text in green
                        echo "<div class='thumb_box'> <p id='dislike_txt' style='color: forestgreen;'>".$story_info[0]['dislikes']." Dislikes</p> <img src='img/dislike.png' alt='Dislike Icon' class='thumb' onclick='DislikeStory($story_id)'> </div>";
                    }

                    // If user ID is not in Story's dislike IDs
                    else if(!str_contains($story_dislikes[0]["user_dislike_ids"], $user_id))
                    {
                        // Display dislike text in black
                        echo "<div class='thumb_box'> <p id='dislike_txt'>".$story_info[0]['dislikes']." Dislikes</p> <img src='img/dislike.png' alt='Dislike Icon' class='thumb' onclick='DislikeStory($story_id)'> </div>";
                    }
                }

                // If no one disliked this story
                else if($story_dislikes[0]["user_dislike_ids"] == null)
                {
                    // Display "Dislike" in default color
                    echo "<div class='thumb_box'> <p id='dislike_txt'>".$story_info[0]['dislikes']." Dislikes</p> <img src='img/dislike.png' alt='Dislike Icon' class='thumb' onclick='DislikeStory($story_id)'> </div>";
                } 
            ?>

        </section>


        <!-- SECTION 3 : STORY INFO -->
        <section style="flex-direction:column;">

            <?php
                // TITLE
                echo "<h3>$story_title</h3>";

                // TAGS DIV START
                echo "<div class='tags_div'>"; 

                // For each tag of the story
                foreach($tags_array as $tag)
                {
                    // If tag is not an empty string
                    if($tag != "")
                    {
                        // Display it
                        echo "<p>$tag</p>";
                    }
                }

                // TAGS DIV END
                echo "</div>";

                // SYNOPSIS
                echo "<p>".$story_info[0]['synopsis']."</p>";
            ?>

        </section>

        <!-- SECTION NAME -->
        <h3>Chapters</h3>

        <!-- SECTION 4 : CHAPTER INFO -->
        <section class="chapter_list" style="justify-content: space-evenly;">

            <?php
                // For each chapter of the clicked story
                for($i = 0; $i < count($chapter_info); $i++)
                {
                    // START of chapter info div
                    echo "<div class='chapter_info_row' onclick='ChapterPage(".$chapter_info[$i]['chapter_id'].",".$story_info[0]['story_id'].")'>";

                        echo "<p>".($i+1).". ".$chapter_info[$i]['chapter_title']."</p>";
                        echo "<p>".date("d-m-Y", strtotime($chapter_info[$i]['pub_date']))."</p>";
                        echo "<p>".$chapter_info[$i]['word_count']." Words</p>";
                        echo "<p>".$chapter_info[$i]['likes']." Likes</p>";
                        echo "<p>".$chapter_info[$i]['dislikes']." Dislikes</p>";

                    // END of chapter info div
                    echo "</div>";
                }  
            ?>

        </section>

        <!-- SECTION 5 : STORY COMMENTS -->
        <section style="flex-direction: column;">

            <h3>Story Comments</h3>

            <!-- WRITTEN COMMENTS -->

            <?php
                // ---- GET EVERY COMMENTS' TEXT, DATE AND USER ID ---- //

                // Prepare a query to get every story comments' text, date and user ID
                $get_story_comments = $db->prepare("SELECT  user_id, pub_date, comment_text FROM comments WHERE story_id = :story_id");

                // Binding  
                $get_story_comments->bindValue(":story_id", $story_id);

                // Execute
                $get_story_comments->execute();

                // Store comments
                $story_comments = $get_story_comments->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($story_comments);

                // ---- GET COMMENT'S AUTHOR ---- //

                // For each story comment
                foreach($story_comments as $story_comment)
                {
                    // Prepare a query to get comment's username
                    $get_comment_author = $db->prepare("SELECT username FROM users WHERE user_id = :user_id");

                    // Binding
                    $get_comment_author->bindValue(":user_id", $story_comment["user_id"]);

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
                                        <p class='comment'>".$story_comment['comment_text']."</p>
                                        <small class='comment_date'>Posted on ".date("d-m-Y", strtotime($story_comment['pub_date']))."</small>
                                    </div>
                                ";

                    // END of current comment div
                    echo "</div>";
                }
            ?>

            <!-- COMMENT WRITING SPACE -->

            <p>Write a comment about this story</p>

            <form style="width: 40%;" action="register_story_comment.php" method="post">

                <!-- STORY ID -->
                <?php
                    echo "<input type='text' name='story_id' value='$story_id' style='display:none;'>";
                ?>

                <!-- LABEL -->
                <label for="comment_text">Your comment (up to 3000 characters)</label>

                <!-- INPUT -->
                <textarea name="comment_text" id="comment_text" cols="40" rows="10" maxlength="3000" placeholder="What I like about this story is that...on the other hand..."></textarea>

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
    <script src="story_like_dislike.js"></script>
    <script src="story_toggles.js"></script>
    <script src="chapter_page.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>
</html>