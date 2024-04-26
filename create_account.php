<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>
    <link rel="stylesheet" href="stories.css">

</head>

<body>

    <!-- HEADER -->
    <header id="_header">

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Create an account</h2>

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

        <!-- NEW ACCOUNT FORM TITLE -->
        <h3>New account form</h3>

        <!-- REQUIRED SYMBOL -->
        <p><span class="required_star">*</span> = required</p>

        <!-- FORM -->
        <form action="register_user.php" method="post">

            <!-- USERNAME DIV -->
            <div class="form_div_row">

                <!-- LABEL -->
                <label id="user_label" for="username">Username (max. 20 char.)<span class="required_star">*</span></label>

                <!-- INPUT -->
                <input type="text" name="username" id="username" placeholder="Your name" required="true" autocomplete="on" maxlength="20" oninput="UsernameCheck()">

            </div>

            <!-- USERNAME EXISTENCE -->
            <p id="username_existence">Username availability text</p>

            <!-- MAIL DIV -->
            <div class="form_div_row">

                <!-- LABEL -->
                <label for="mail">Mail<span class="required_star">*</span></label>

                <!-- INPUT -->
                <input type="email" name="mail" id="mail" placeholder="your.adress@example.com" required="true" autocomplete="on" maxlength="50" oninput="MailExistenceCheck()">

            </div>

            <!-- MAIL EXISTENCE -->
            <p id="mail_existence">Mail availability text</p>

            <!-- aA0%aA0%aA0% -->

            <!-- PASSWORD DIV -->
            <div class="form_div_row">

                <!-- LABEL -->
                <label for="password">Password<span class="required_star">*</span></label>

                <!-- INPUT -->
                <input type="password" name="password" id="password" placeholder="************" required="true" autocomplete="off" maxlength="50" oninput="AllPasswordCriteriasCheck()">

            </div>

            <!-- PASSWORD CRITERIAS DIV -->
            <div class="form_div_col">

                <!-- SUBTITLE -->
                <h4>Your password must have at least :</h4>

                <!-- CRITERIAS LIST -->
                <ul>

                    <li id="pwd_char_num">12 characters</li>

                    <li id="one_lower">1 lowercase letter (a)</li>

                    <li id="one_upper">1 uppercase letter (A)</li>

                    <li id="one_special">1 special character (%)</li>

                    <li id="one_num">1 number (0)</li>

                </ul>

            </div>

            <!-- PASSWORD CHECK DIV -->
            <div class="form_div_row">

                <!-- LABEL -->
                <label for="password_check">Repeat Password<span class="required_star">*</span></label>

                <!-- INPUT -->
                <input type="password" name="password_check" id="password_check" placeholder="************" required="true" autocomplete="off" maxlength="50" oninput="AllPasswordCriteriasCheck()">

            </div>

            <!-- PASSWORD EQUALITY TEXT -->
            <p id="pwd_equal_txt">Password equality text</p>

            <!-- LOGIN SUGGESTION -->
            <p>Already have an account? <a href="log_in_form.php">Log in.</a></p>

            <!-- FORM END BUTTONS -->
            <div class="form_btns_div">

                <!-- SUBMIT BUTTON -->
                <input id="submit_btn" type="submit" value="Create account" class="formBtn">

                <!-- CANCEL BUTTON -->
                <input type="reset" value="Cancel" class="formBtn">

            </div>

        </form>

    </main>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>

</body>

<script src="new_account_form_check.js"></script>

</html>