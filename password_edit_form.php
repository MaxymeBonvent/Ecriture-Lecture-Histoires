<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password edit</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Password edit</h2>

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
                // ---- DATABASE CONNECTION ---- //
                require_once("database_connection.php");

                // ---- GET USER ID ---- //
                require_once("get_user_id.php");


                // ---- PAGE LAYOUT ---- //
                echo "<h3>Edit your password</h3>";

                // REQUIREMENT HINT
                echo "<p><span class='required_star'>*</span>= required</p>";

                // FORM START
                echo "<form method='get' action='edit_password.php'>";

                    // OLD PASSWORD DIV START
                    echo "<div class='form_div_row'>";

                        // LABEL
                        echo "<label for='old_password'>Old password<span class='required_star'>*</span></label>";

                        // INPUT
                        echo "<input id='old_password' name='old_password' type='password' required autocomplete='off' maxlength='100' placeholder='********' onkeyup='CheckOldPasswordOwner()'>";

                    // OLD PASSWORD DIV END
                    echo "</div>";

                    // OLD PASSWORD OWNER TEXT
                    echo "<p id='old_pwd_owner_txt'>Password is yours/is not yours</p>";

                    // NEW PASSWORD DIV START
                    echo "<div class='form_div_row'>";

                        // LABEL
                        echo "<label for='new_password'>New password<span class='required_star'>*</span></label>";

                        // INPUT
                        echo "<input id='new_password' name='new_password' type='password' required autocomplete='off' maxlength='100' placeholder='********' onkeyup='CheckAllNewPasswordCriterias()'>";

                    // NEW PASSWORD DIV END
                    echo "</div>";


                    // PASSWORD CRITERIAS DIV START
                    echo "<div class='form_div_col'>";

                        // NEW PASSWORD CRITERIA WARNING
                        echo "<p>New password must have at least :</p>";

                            // LIST START
                            echo "<ul>";

                                // LIST
                                echo "<li id='new_pwd_length'>12 characters</li>";
                                echo "<li id='upp_txt'>1 uppercase letter (A)</li>";
                                echo "<li id='lower_txt'>1 lowercase letter (a)</li>";
                                echo "<li id='num_txt'>1 number (0)</li>";
                                echo "<li id='spec_char_txt'>1 special character (%)</li>";

                            // LIST END
                            echo "</ul>";

                    // PASSWORD CRITERIAS DIV END
                    echo "</div>";

                    // REPEAT NEW PASSWORD DIV START
                    echo "<div class='form_div_row'>";

                        // LABEL
                        echo "<label for='repeat_new_password'>Repeat new password<span class='required_star'>*</span></label>";

                        // INPUT
                        echo "<input id='repeat_new_password' name='repeat_new_password' type='password' required autocomplete='off' maxlength='100' placeholder='********' onkeyup='NewPasswordsIdentityCheck(), CheckAllNewPasswordCriterias()'>";

                    // REPEAT NEW PASSWORD DIV END
                    echo "</div>";

                    // NEW PASSWORDS IDENTITY
                    echo "<p id='pwds_identity_txt'>Passwords are identical/not identical</p>";

                    // FORM BUTTONS DIV START
                    echo "<div id='form_buttons_div'>";

                        // SEARCH   
                        echo "<input id='edit_btn' type='submit' value='Edit' class='formBtn'>";

                        // CANCEL   
                        echo "<input type='reset' value='Cancel' class='formBtn' onclick='ResetValues()'>";

                    // FORM BUTTONS DIV END
                    echo "</div>";

                // FORM END
                echo "</form>";
            }
        ?>

        <!-- Test password : Aa0%Cd1m9Pax -->

    </main>

    <!-- SCRIPTS -->
    <script src="old_password_owner.js"></script>
    <script src="password_edit_form_check.js"></script>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>

</html>