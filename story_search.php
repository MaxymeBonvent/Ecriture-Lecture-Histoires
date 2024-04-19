<?php
    // DATABASE CONNECTION
    require_once("database_connection.php");

    // URL VARIABLES
    $tags = htmlspecialchars($_GET["tags"]);
    $story_title = htmlspecialchars($_GET["story_title"]);
    $author = htmlspecialchars($_GET["author"]);
    $min_word_count = htmlspecialchars($_GET["min_word_count"]);
    $max_word_count = htmlspecialchars($_GET["max_word_count"]);

    // Test 
    var_dump($tags);
    var_dump($story_title);
    var_dump($author);
    var_dump($min_word_count);
    var_dump($max_word_count);
    exit;
?>