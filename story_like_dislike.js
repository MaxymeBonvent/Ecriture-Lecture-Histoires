// Request done color
request_done_color = "rgb(0, 130, 0)";

// STORY LIKE
// Likes Text
let like_txt = document.getElementById("like_txt");

// Function to call a PHP script to like a story
function LikeStory(story_id)
{
    // Confirm Story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If story ID exists and like is not already given
    if(story_id != null && like_txt.style.color != request_done_color)
    {
        // AJAX variable
        let xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Redirect user to Story Like PHP script
                // window.location.href = `story_like.php?story_id=${story_id}`;

                // Change like text color
                like_txt.style.color = request_done_color;

                // Confirm request is done
                console.log("Request done.");
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during AJAX story like request : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `story_like.php?story_id=${story_id}`);
        xhr.send();
    }

    // If story ID does not exist
    else if(story_id == null)
    {
        // Log it
        console.log("Error : no story ID.");
    }

    // If "Likes" is already green  
    else if(like_txt.style.color == request_done_color)
    {
        // Log it
        console.log("Like already given.");
    }
}