// Request done color
request_done_color = "rgb(0, 120, 0)";

// STORY LIKE
// Like Text
let like_txt = document.getElementById("like_txt");
// console.log(`like_txt == ${like_txt}.`);

// Like icon
let like_icon = document.getElementById("like_icon");
// console.log(`like_icon == ${like_icon}.`);

// TOGGLE COLOR OF "LIKES" ON CLICK
// If there is an element with a "like_icon" ID
if(like_icon != null)
{
    like_icon.addEventListener("click", function()
    {
        // If text is not green
        if(like_txt.style.color != request_done_color)
        {
            // Set its color to green
            like_txt.style.color = request_done_color;

            // Confirm color toggle
            console.log("\"Likes\" changed to green.");
        }

        // If text is green
        else if(like_txt.style.color == request_done_color)
        {
            // Set its color to default
            like_txt.style.color = "black";

            // Confirm color toggle
            console.log("\"Likes\" changed to black.");
        }
    })
}



// Function to call a PHP script to like a story
function LikeStory(story_id)
{
    // Confirm Story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If story ID exists and like is not already given
    if(story_id != null)
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

                // Confirm request is done
                console.log("Request done.");

                // LIKE COLOR
                // If text is not green
                if(favs_txt.style.color != request_done_color)
                {
                    // Set its color to green
                    favs_txt.style.color = request_done_color;

                    // Confirm color toggle
                    console.log("\"Add to Favs\" changed to green.");
                }

                // If text is green
                else if(favs_txt.style.color == request_done_color)
                {
                    // Set its color to default
                    favs_txt.style.color = "black";

                    // Confirm color toggle
                    console.log("\"Add to Favs\" changed to black.");
                }
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
}

// STORY DISLIKE
// Dislike Text
let dislike_txt = document.getElementById("dislike_txt");
// console.log(`dislike_txt == ${dislike_txt}.`);

// Dislike Icon
let dislike_icon = document.getElementById("dislike_icon");
// console.log(`dislike_icon == ${dislike_icon}.`);

// TOGGLE COLOR OF "LIKES" ON CLICK
// If there is an element with a "dislike_icon" ID
if(dislike_icon != null)
{
    dislike_icon.addEventListener("click", function()
    {
        // If text is not green
        if(dislike_txt.style.color != request_done_color)
        {
            // Set its color to green
            dislike_txt.style.color = request_done_color;

            // Confirm color toggle
            console.log("\"Dislikes\" changed to green.");
        }

        // If text is green
        else if(dislike_txt.style.color == request_done_color)
        {
            // Set its color to default
            dislike_txt.style.color = "black";

            // Confirm color toggle
            console.log("\"Dislikes\" changed to black.");
        }
    })
}

// Function to call a PHP script to dislike a story
function DislikeStory(story_id)
{
    // Confirm Story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If story ID exists
    if(story_id != null)
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
        xhr.open("GET", `story_dislike.php?story_id=${story_id}`);
        xhr.send();
    }

    // If story ID does not exist
    else if(story_id == null)
    {
        // Log it
        console.log("Error : no story ID.");
    }
}