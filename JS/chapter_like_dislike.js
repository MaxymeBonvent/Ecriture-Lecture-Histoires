// CHAPTER "LIKE" TEXT
let like_txt = document.getElementById("like_txt");

// LIKE ICON
let like_icon = document.getElementById("like_icon");

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

                // Confirm request is done
                console.log("Request done.");

                // ---- TOGGLE LIKE COLOR ---- //
                // If text is not green
                if(like_txt.style.color != request_done_color)
                {
                    // Set text color to green
                    like_txt.style.color = request_done_color;

                    // Log color change
                    console.log("\"Likes\" changed to green.");
                }

                // If text is green
                else if(like_txt.style.color == request_done_color)
                {
                    // Set text color to default
                    like_txt.style.color = "black";

                    // Log color change
                    console.log("\"Likes\" changed to black.");
                }
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

// DISLIKE ICON
let dislike_icon = document.getElementById("dislike_icon");

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

                // ---- TOGGLE DISLIKE COLOR ---- //

                // If text is not green
                if(dislike_txt.style.color != request_done_color)
                {
                    // Set text color to green
                    dislike_txt.style.color = request_done_color;

                    // Log color change
                    console.log("\"Dislikes\" changed to green.");
                }

                // If text is green
                else if(dislike_txt.style.color == request_done_color)
                {
                    // Set text color to default
                    dislike_txt.style.color = "black";

                    // Log color change
                    console.log("\"Dislikes\" changed to black.");
                }
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