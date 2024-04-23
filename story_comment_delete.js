// Function to get ID of a comment and pass it to a PHP script that deletes story comments
function DeleteStoryComment(story_comment_id)
{
    // Confirm obtention of story comment ID
    console.log(`Story comment ID == ${story_comment_id}.`);

    // ---- AJAX REQUEST ---- //
    let xhr = new XMLHttpRequest();

    // Callback function
    xhr.onload = function()
    {
        // If request is done
        if(xhr.status == 200)
        {
            // Log it
            console.log("Story comment deletion request done.");

            // Refresh page so that user can immediately see that their story comment has been deleted
            window.location.reload();
        }
    }

    // Error handler
    xhr.onerror = function()
    {
        // Log error message
        console.log(`Error during story comment deletion request : ${xhr.status}.`);
    }

    // PROCESS REQUEST
    // Open PHP script to delete clicked story comment
    xhr.open("GET", `story_comment_delete.php?story_comment_id=${story_comment_id}`, true);

    // // Send request
    xhr.send();
}