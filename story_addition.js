// Color for when request is done
let request_done_color = "rgb(0, 130, 0)";

// ---- FAVORITES ---- //
// Add to Favs text
let favs_txt = document.getElementById("favs_txt");

function AddStoryToFavs(story_id)
{
    // Confirm story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If there is a Story ID and "Add to Favs" is not green
    if(story_id != null && favs_txt.style.color != request_done_color)
    {
        // AJAX variable
        let xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Redirect user to PHP script that adds clicked story to their favorites
                // window.location.href = `add_story_favs.php?story_id=${story_id}`;

                // Visual indication of request completion
                favs_txt.style.color = request_done_color;

                // Log that story is part of user's favorites
                console.log("Request done.");
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during AJAX request to add story to favorites : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `add_story_favs.php?story_id=${story_id}`);
        xhr.send();
    }

    // If there's no story ID
    else if(story_id == null)
    {
        // Log it
        console.log("Error : no story ID.");
    }

    // If "Add to favs" is already green
    else if(favs_txt.style.color == request_done_color)
    {
        // Log that request is already done
        console.log("Story already added to favorites.");
    }
}

// ---- READ LATER ---- //
// Read later text
let read_later_txt = document.getElementById("read_later_txt");

function AddStoryToReadLater(story_id)
{
    // Confirm story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If there is a Story ID and "Read Later" is not green
    if(story_id != null && read_later_txt.style.color != request_done_color)
    {
        // AJAX variable
        let xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Redirect user to PHP script that adds clicked story to their favorites
                // window.location.href = `add_story_read_later.php?story_id=${story_id}`;

                // Visual indication of request completion
                read_later_txt.style.color = request_done_color;

                // Log that story is part of user's read later
                console.log("Request done.");
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during AJAX request to add story to Read Later : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `add_story_read_later.php?story_id=${story_id}`);
        xhr.send();
    }

    // If there's no story ID
    else if(story_id == null)
    {
        // Log it
        console.log("Error : no story ID.");
    }

    // If "Add to favs" is already green
    else if(read_later_txt.style.color == request_done_color)
    {
        // Log that request is already done
        console.log("Story already added to Read Later.");
    }
}