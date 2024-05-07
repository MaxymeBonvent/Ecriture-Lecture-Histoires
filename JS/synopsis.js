// Function to get story's info and send it to the Synopsis page
function Synopsis(story_title, author, tags, chapter_ids)
{
    // Confirm Story Title obtention
    console.log(`Story Title == ${story_title}.`);

    // Confirm Author obtention
    console.log(`Author == ${author}.`);

    // Confirm Tags obtention
    console.log(`Tags == ${tags}.`);

    // Confirm Chapter IDs obtention
    console.log(`Chapter IDs == ${chapter_ids}.`);

    // If Story Title doesn't exists
    if(story_title == null)
    {
        // Output an error message
        console.log("Error : no story title.");
    }

    // If Author doesn't exists
    else if(author == null)
    {
        // Output an error message
        console.log("Error : no author.");
    }

    // If Tags don't exists
    else if(tags == null)
    {
        // Output an error message
        console.log("Error : no tags.");
    }

    // If Chapter IDs don't exists
    else if(chapter_ids == null)
    {
        // Output an error message
        console.log("Error : no Chapter IDs.");
    }

    // If every parameter exists
    else if(story_title != null && author != null && tags != null && chapter_ids != null)
    {
        // Redirect user to Synopsis page with clicked story's info
        window.location.href = `synopsis.php?story_title=${story_title}&author=${author}&tags=${tags}&chapter_ids=${chapter_ids}`;
    }
}