<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
    <link rel="stylesheet" href="stories.css">

</head>
<body>

    <!-- HEADER -->
    <header>

        <!-- TITLE -->
        <h1>The Reading &amp; Writing Place</h1>

        <!-- SUBTITLE -->
        <h2>Login</h2>

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

        <!-- LOGIN FORM TITLE -->
        <h3>Login form</h3>

        <!-- REQUIRED SYMBOL -->
        <p><span class="required_star">*</span> = required</p>

        <!-- FORM -->
        <form action="login.php" method="post">

            <!-- USERNAME DIV -->
            <div class="account_div">

                <!-- LABEL -->
                <label id="user_label" for="username">Username<span class="required_star">*</span></label>

                <!-- INPUT -->
                <input type="text" name="username" id="username" placeholder="Your name" required="true" autocomplete="on">

            </div>

            <!-- PASSWORD DIV -->
            <div class="account_div">

                <!-- LABEL -->
                <label for="password">Password<span class="required_star">*</span></label>

                <!-- INPUT -->
                <input type="password" name="password" id="password" placeholder="************" required="true" autocomplete="off">

            </div>


            <!-- NEW ACCOUNT SUGGESTION -->
            <p>Don't have an account yet? <a href="create_account.php">Create one.</a></p>

            <!-- FORM BUTTONS -->
            <div class="form_btns_div">

                <!-- SUBMIT BUTTON -->
                <input type="submit" value="Login" class="formBtn">

                <!-- CANCEL BUTTON -->
                <input type="reset" value="Reset" class="formBtn">

            </div>

        </form>

    </main>

    <!-- FOOTER -->
    <footer>
        <p>Footer</p>
    </footer>    

</body>
</html>