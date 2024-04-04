// Function to bookmark a chapter
function Bookmark(chapter_id, user_id)
{
    // If there's no chapter ID
    if(chapter_id == null)
    {
        // Send an error message
        console.log("Error : no chapter ID.");

        // End function
        return;
    }

    // If there's no user ID
    else if(user_id == null)
    {
        // Send an error message
        console.log("Error : no user ID.");

        // End function
        return;
    }

    // If there are both a chapter ID and a user ID
    else if(chapter_id != null && user_id != null)
    {
        // Confirm Chapter ID obtention
        console.log(`Chapter ID == ${chapter_id}.`);

        // Confirm User ID obtention
        console.log(`User ID == ${user_id}.`);

        // XMLHttpRequest Object
        let xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Confirm request is done
                console.log("Request done.");

                // Redirect user to PHP Bookmark script
                // window.location.href = `bookmark.php?chapter_id=${chapter_id}&user_id=${user_id}`;
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error message
            console.log(`Error during AJAX Bookmark request : ${xhr.status}.`);
        }

        // Try to open Bookmark PHP script
        try
        {
            // Open PHP script to bookmark a chapter
            xhr.open("GET" ,`bookmark.php?chapter_id=${chapter_id}&user_id=${user_id}`);

            // Send request
            xhr.send();
        }

        // Catch any problem
        catch(exc)
        {
            // Log exception message
            console.log(`Exception caught during bookmarking : ${exc}`);
        }
    }
}