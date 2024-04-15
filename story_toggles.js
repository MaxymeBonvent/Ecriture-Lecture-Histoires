// Color for when request is done
let request_done_color = "rgb(0, 130, 0)";

// ---- FAVORITES ---- //
// Add to Favs text
let favs_txt = document.getElementById("favs_txt");

// TOGGLE COLOR OF "ADD TO FAVS" ON CLICK
favs_txt.addEventListener("click", function()
{
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
})

// Function to toggle a story from/to user's Favorites stack
function ToggleStoryFavs(story_id)
{
    // Confirm story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If there is a Story ID
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
                // Redirect user to PHP script that adds clicked story to their favorites
                // window.location.href = `toggle_story_favs.php?story_id=${story_id}`;

                // Log that story is part of user's favorites
                console.log("Favorites toggle done.");
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during AJAX request to add/remove story to/from favorites : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `toggle_story_favs.php?story_id=${story_id}`);
        xhr.send();
    }

    // If there's no story ID
    else if(story_id == null)
    {
        // Log it
        console.log("Error : no story ID.");
    }
}

// ---- READ LATER ---- //
// Read later text
let read_later_txt = document.getElementById("read_later_txt");

// Function to toggle a story from/to user's Read Later stack
function ToggleStoryReadLater(story_id)
{
    // Confirm story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If there is a Story ID
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
                // Redirect user to PHP script that adds clicked story to their favorites
                // window.location.href = `toggle_story_read_later.php?story_id=${story_id}`;

                // Log that story is part of user's read later
                console.log("Read Later toggle done.");
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during AJAX request to add/remove story to/from Read Later : ${xhr.status}.`);
        }

        // SEND REQUEST
        xhr.open("GET", `toggle_story_read_later.php?story_id=${story_id}`);
        xhr.send();
    }

    // If there's no story ID
    else if(story_id == null)
    {
        // Log it
        console.log("Error : no story ID.");
    }
}