// ---- LIKE ---- //



// STORY COMMENT LIKE ICONS AND TEXTS
let comment_like_icon = document.getElementsByClassName("comment_like_icon");
let comment_like_txt = document.getElementsByClassName("comment_like_txt");

// TOGGLE STORY COMMENTS' "LIKE" TEXT COLOR
// For every comment like icon
for(let i = 0; i < comment_like_icon.length; i++)
{
    // If current like icon exists
    if(comment_like_icon[i] != null)
    {
        // If like icon is clicked
        comment_like_icon[i].addEventListener("click", function()
        {
            // If "Like" is not green
            if(comment_like_txt[i].style.color != request_done_color)
            {
                // Set it to green
                comment_like_txt[i].style.color = request_done_color;

                // Log color change
                // console.log(`\"Like\" n°${i} from story comments changed to green.`);
            }

            // If "Like" is green
            else if(comment_like_txt[i].style.color == request_done_color)
            {
                // Set it to default color
                comment_like_txt[i].style.color = "black";

                // Log color change
                // console.log(`\"Like\" n°${i} from story comments changed to black.`);
            }
        })
    }
}

// Function to pass story comment ID and user ID to a PHP script to toggle story comment liking
function ToggleStoryCommentLike(story_comment_id, user_id)
{
    // If both IDs exists and are numbers
    if(story_comment_id != null && Number.isInteger(story_comment_id) && user_id != null && Number.isInteger(user_id))
    {
        // ---- AJAX ---- //
        xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Log it
                console.log("Toggling of story comment like request done.");

                // Confirm variables obtention
                console.log(`Story comment ID == ${story_comment_id}.`);
                console.log(`User ID == ${user_id}.`);

                // Redirect user to PHP script that toggles story comment likes
                // window.location.href = `toggle_story_comment_like.php?story_comment_id=${story_comment_id}&user_id=${user_id}`;
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during toggling of story comment like request : ${xhr.status}.`);
        }

        // Open PHP script
        xhr.open("GET", `toggle_story_comment_like.php?story_comment_id=${story_comment_id}&user_id=${user_id}`, true);

        // Send request
        xhr.send();
    }

    // If either ID does not exist and/or is not a number
    else if(story_comment_id == null || !Number.isInteger(story_comment_id) || user_id == null || !Number.isInteger(user_id))
    {
        // Log error
        console.log("Error : one ID does not exist or is not a number");
    }
}



// ---- DISLIKE ---- //



// STORY COMMENT DISLIKE ICONS AND TEXTS
let comment_dislike_icon = document.getElementsByClassName("comment_dislike_icon");
let comment_dislike_txt = document.getElementsByClassName("comment_dislike_txt");

// TOGGLE STORY COMMENTS' "DISLIKE" TEXT COLOR
// For every comment dislike icon
for(let i = 0; i < comment_dislike_icon.length; i++)
{
    // If current dislike icon exists
    if(comment_dislike_icon[i] != null)
    {
        // If dislike icon is clicked
        comment_dislike_icon[i].addEventListener("click", function()
        {
            // If "Dislike" is not green
            if(comment_dislike_txt[i].style.color != request_done_color)
            {
                // Set it to green
                comment_dislike_txt[i].style.color = request_done_color;

                // Log color change
                // console.log(`\"Dislike\" n°${i} from story comments changed to green.`);
            }

            // If "Dislike" is green
            else if(comment_dislike_txt[i].style.color == request_done_color)
            {
                // Set it to default color
                comment_dislike_txt[i].style.color = "black";

                // Log color change
                // console.log(`\"Dislike\" n°${i} from story comments changed to black.`);
            }
        })
    }
}