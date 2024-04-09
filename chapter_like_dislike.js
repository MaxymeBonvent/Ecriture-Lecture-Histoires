// CHAPTER LIKE
let like_txt = document.getElementById("like_txt");

// Function to open a PHP script to like a chapter
function LikeChapter(chapter_id)
{
    // Confirm chapter ID obtention
    console.log(`Chapter ID == ${chapter_id}.`);

    // If chapter ID exists and like is not already given
    if(chapter_id != null && like_txt.style.color != request_done_color)
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
                // window.location.href = `chapter_like.php?chapter_id=${chapter_id}`;

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
            console.log(`Error during AJAX chapter like request : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `chapter_like.php?chapter_id=${chapter_id}`);
        xhr.send();
    }

    // If chapter ID does not exist
    else if(chapter_id == null)
    {
        // Log it
        console.log("Error : no chapter ID.");
    }

    // If "Likes" is already green  
    else if(like_txt.style.color == request_done_color)
    {
        // Change color to black
        like_txt.style.color = "black";

        // Log it
        console.log("Chapter like removed.");
    }
}

// CHAPTER DISLIKE
let dislike_txt = document.getElementById("dislike_txt");

function DislikeChapter(chapter_id)
{
    // Confirm chapter ID obtention
    console.log(`Chapter ID == ${chapter_id}.`);

    // If chapter ID exists and dislike is not already given
    if(chapter_id != null && dislike_txt.style.color != request_done_color)
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
                // window.location.href = `chapter_like.php?chapter_id=${chapter_id}`;

                // Change dislike text color
                dislike_txt.style.color = request_done_color;

                // Confirm request is done
                console.log("Request done.");
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during AJAX chapter dislike request : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `chapter_dislike.php?chapter_id=${chapter_id}`);
        xhr.send();
    }

    // If chapter ID does not exist
    else if(chapter_id == null)
    {
        // Log it
        console.log("Error : no chapter ID.");
    }

    // If "Dislikes" is already green  
    else if(dislike_txt.style.color == request_done_color)
    {
        // Change color to black
        dislike_txt.style.color = "black";

        // Log it
        console.log("Chapter dislike removed.");
    }
}