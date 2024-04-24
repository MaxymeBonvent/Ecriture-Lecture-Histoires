// Function to get ID of a comment and pass it to a PHP script that deletes chapter comments
function DeleteChapterComment(chapter_comment_id)
{
    // Confirm obtention of story comment ID
    console.log(`Chapter comment ID == ${chapter_comment_id}.`);

    // If chapter comment ID exists and is a number
    if(chapter_comment_id != null && Number.isInteger(chapter_comment_id))
    {
        // ---- AJAX REQUEST ---- //
        let xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Log it
                console.log("Chapter comment deletion request done.");

                // Refresh page so that user can immediately see that their chapter comment has been deleted
                window.location.reload();
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error message
            console.log(`Error during chapter comment deletion request : ${xhr.status}.`);
        }

        // PROCESS REQUEST
        // Open PHP script to delete clicked chapter comment
        xhr.open("GET", `chapter_comment_delete.php?chapter_comment_id=${chapter_comment_id}`, true);

        // // Send request
        xhr.send();
    }

    // If chapter comment ID does not exist and/or is not a number
    else if(chapter_comment_id == null || !Number.isInteger(chapter_comment_id))
    {
        // Log error message
        console.log("Error : chapter comment ID doesn't exist or is not a number.");
    }
}