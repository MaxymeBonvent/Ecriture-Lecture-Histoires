// ---- LIKE ---- //

// CHAPTER COMMENT LIKE ICONS AND TEXTS
let comment_like_icon = document.getElementsByClassName("comment_like_icon");
console.log(`comment_like_icon == ${comment_like_icon}.`);
console.log(`Number of comment_like_icon == ${comment_like_icon.length}.`);

let comment_like_txt = document.getElementsByClassName("comment_like_txt");
console.log(`comment_like_txt == ${comment_like_txt}.`);
console.log(`Number of comment_like_txt == ${comment_like_txt.length}.`);

// Function to pass chapter comment ID and user ID to a PHP script to toggle chapter comment liking
function ToggleChapterCommentLike(chapter_comment_id, user_id)
{
    // If both IDs exists and are numbers
    if(chapter_comment_id != null && Number.isInteger(chapter_comment_id) && user_id != null && Number.isInteger(user_id))
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
                console.log("Toggling of chapter comment like request done.");

                // Confirm variables obtention
                console.log(`Chapter comment ID == ${chapter_comment_id}.`);
                console.log(`User ID == ${user_id}.`);

                // Redirect user to PHP script that toggles story comment likes
                // window.location.href = `toggle_chapter_comment_like.php?chapter_comment_id=${chapter_comment_id}&user_id=${user_id}`;

                // ---- TOGGLE LIKE COLOR ---- //

                // If "Like" is not green
                if(comment_like_txt[i].style.color != request_done_color)
                {
                    // Set it to green
                    comment_like_txt[i].style.color = request_done_color;

                    // Log color change
                    console.log(`\"Like\" n°${i} from chapter comments changed to green.`);
                }

                // If "Like" is green
                else if(comment_like_txt[i].style.color == request_done_color)
                {
                    // Set it to default color
                    comment_like_txt[i].style.color = "black";

                    // Log color change
                    console.log(`\"Like\" n°${i} from chapter comments changed to black.`);
                }
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during toggling of chapter comment like request : ${xhr.status}.`);
        }

        // Open PHP script
        xhr.open("GET", `toggle_chapter_comment_like.php?chapter_comment_id=${chapter_comment_id}&user_id=${user_id}`, true);

        // Send request
        xhr.send();
    }

    // If either ID does not exist and/or is not a number
    else if(chapter_comment_id == null || !Number.isInteger(chapter_comment_id) || user_id == null || !Number.isInteger(user_id))
    {
        // Log error
        console.log("Error : one ID does not exist or is not a number.");
    }
}



// ---- DISLIKE ---- //



// STORY COMMENT DISLIKE ICONS AND TEXTS
let comment_dislike_icon = document.getElementsByClassName("comment_dislike_icon");
// console.log(`Number of dislike icons == ${comment_dislike_icon.length}.`);

let comment_dislike_txt = document.getElementsByClassName("comment_dislike_txt");
// console.log(`Number of dislike texts == ${comment_dislike_txt.length}.`);

// Function to pass chapter comment ID and user ID to a PHP script to toggle chapter comment disliking
function ToggleChapterCommentDislike(chapter_comment_id, user_id)
{
    // If both IDs exists and are numbers
    if(chapter_comment_id != null && Number.isInteger(chapter_comment_id) && user_id != null && Number.isInteger(user_id))
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
                // console.log("Toggling of chapter comment dislike request done.");

                // Confirm variables obtention
                // console.log(`Chapter comment ID == ${story_comment_id}.`);
                // console.log(`User ID == ${user_id}.`);

                // Redirect user to PHP script that toggles story comment dislikes
                // window.location.href = `toggle_chapter_comment_dislike.php?chapter_comment_id=${chapter_comment_id}&user_id=${user_id}`;

                // ---- TOGGLE DISLIKE COLOR ---- //

                // If "Dislike" is not green
                if(comment_dislike_txt[i].style.color != request_done_color)
                {
                    // Set it to green
                    comment_dislike_txt[i].style.color = request_done_color;

                    // Log color change
                    console.log(`\"Dislike\" n°${i} from story comments changed to green.`);
                }

                // If "Dislike" is green
                else if(comment_dislike_txt[i].style.color == request_done_color)
                {
                    // Set it to default color
                    comment_dislike_txt[i].style.color = "black";

                    // Log color change
                    console.log(`\"Dislike\" n°${i} from story comments changed to black.`);
                }
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during toggling of chapter comment dislike request : ${xhr.status}.`);
        }

        // Open PHP script
        xhr.open("GET", `toggle_chapter_comment_dislike.php?chapter_comment_id=${chapter_comment_id}&user_id=${user_id}`, true);

        // Send request
        xhr.send();
    }

    // If either ID does not exist and/or is not a number
    else if(chapter_comment_id == null || !Number.isInteger(chapter_comment_id) || user_id == null || !Number.isInteger(user_id))
    {
        // Log error
        console.log("Error : one ID does not exist or is not a number.");
    }
}