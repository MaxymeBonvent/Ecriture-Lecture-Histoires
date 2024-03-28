// Document body
let body = document.querySelector("body");

// Clicked chapter info div
let chapter_info = document.getElementById("chapter_info");

// Function to call a PHP script that will get info of the clicked chapter and display it on the page
function GetChapterInfo(chapter_id)
{
    // ---- START ----

    // XMLHttpRequest Object
    let xhr = new XMLHttpRequest();

    // ---- END ----

    // Callback function
    xhr.onload = function()
    {
        // If request is done
        if(xhr.status == 200)
        {
            // Store JSON parsed response
            let json_response = JSON.parse(xhr.responseText);

            // Store each component in a variable
            let json_story_id = json_response[0]["story_id"];

            let json_chapter_title = json_response[0]["chapter_title"];

            let json_text = json_response[0]["chapter_text"];
            // console.log(`Chapter text == ${json_text}`);

            let json_likes = json_response[0]["likes"];

            let json_dislikes = json_response[0]["dislikes"];

            // Create a new div
            let container = document.createElement("div");

            // Container's properties
            container.className = "chapter_info";

            // Container's new text
            container.innerHTML = 
            `<div> 

                    <h4>Story n°${json_story_id}</h4>
                    <h4>${json_chapter_title}</h4> 

                    <div id='chapter_txt'>${json_text}</div> 

                    <div class='chapter_info_inner_div'>
                        
                        <p class='chapter_option' onclick="EditChapter(${json_story_id}, '${json_chapter_title}')">Edit</p>
                        <p class='chapter_option' onclick="NewChapter(${json_story_id})">Write new chapter</p>
                        <p class='chapter_option' onclick="DeleteChapter(${json_story_id}, '${json_chapter_title}')">Delete</p>

                    </div> 

                    <div class='chapter_info_inner_div'> 

                        <p>${json_likes} Likes</p> <p>${json_dislikes} Dislikes</p>

                    </div> 
            </div>`;

            // Empty chapter_info div before filling it with new info
            chapter_info.innerText = "";

            // Append container to the page's chapter_info div
            chapter_info.appendChild(container);
        }
    }

    // ---- REQUEST THROW ----

    // Create FormData object
    let formData = new FormData();
    formData.append("chapter_id", chapter_id);

    // Open PHP script
    xhr.open("POST", "get_chapter_info.php");

    // Send request with the FormData object
    xhr.send(formData);
}

// Function to get chapter's story ID and title to the Edit page
function EditChapter(json_story_id, json_chapter_title)
{
    // ---- START ----

    // XMLHttpRequest Object
    let xhr = new XMLHttpRequest();

    // ---- END ----

    // Callback function
    xhr.onload = function()
    {
        // If request is done
        if(xhr.status == 200)
        {
            // Redirect user to Edit page
            window.location.href = "edit_chapter.php?story_id="+json_story_id+"&chapter_title="+json_chapter_title;
        }

        // If request is not done
        else if(xhr.status != 200)
        {
            // Log that request is not done
            console.log("Request not done.");
            console.log(`xhr.status == ${xhr.status}.`);
        }
    }

    // Error handler
    xhr.onerror = function()
    {
        // Show error
        console.log(`Error : ${xhr.status}.`);
    }

    // ---- REQUEST THROW ----

    // Open PHP script
    xhr.open("GET", "edit_chapter.php?story_id="+json_story_id+"&chapter_title="+json_chapter_title);

    // Send request with the FormData object
    xhr.send();
}

// Function to get the clicked chapter's Story ID and use it in the New Chapter Page
function NewChapter(json_story_id)
{
    // ---- START ----

    // XMLHttpRequest Object
    let xhr = new XMLHttpRequest();

    // ---- END ----

    // Callback function
    xhr.onload = function()
    {
        // If request is done
        if(xhr.status == 200)
        {
            // Redirect user to Edit page
            window.location.href = "new_chapter.php?story_id="+json_story_id;
        }

        // If request is not done
        else if(xhr.status != 200)
        {
            // Log that request is not done
            console.log("Request not done.");
            console.log(`xhr.status == ${xhr.status}.`);
        }
    }

    // Error handler
    xhr.onerror = function()
    {
        // Show error
        console.log(`Error : ${xhr.status}.`);
    }

    // ---- REQUEST THROW ----

    // Open PHP script
    xhr.open("GET", "new_chapter.php?story_id="+json_story_id);

    // Send request
    xhr.send();
}

// Function to get chapter's title and story ID to the chapter delete script
function DeleteChapter(json_story_id, json_chapter_title)
{
    // ---- INFO ----

    // Confirm function call
    console.log("DeleteChapter() called.");

    // Confirm info obtention
    console.log(`Story ID == ${json_story_id}.`);
    console.log(`Chapter Title == ${json_chapter_title}.`);

    // ---- QUESTION ----

    let answer = confirm(`WARNING : You're about to DELETE chapter ${json_chapter_title}, this operation cannot be undone and will also delete the story if that chapter is its only one. Are you sure?`);

    // ---- DELETE AJAX REQUEST ----

    // If OK is pressed
    if(answer == true)
    {
        // Confirm OK was clicked
        console.log("OK pressed.");

        // ---- START ----

        // XMLHttpRequest Object
        let xhr = new XMLHttpRequest();

        // ---- END ----

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Confirm request was done
                console.log("Request done.");

                // Redirect user to PHP chapter deletion confirmation page
                window.location.href = "chapter_delete_confirm.php";
            }

            // If request is not done
            else if(xhr.status != 200)
            {
                // Log that request is not done
                console.log("Request not done.");
                console.log(`xhr.status == ${xhr.status}.`);
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Show error
            console.log(`Error during AJAX request for chapter info obtention : ${xhr.status}.`);
        }

        // ---- REQUEST ----

        // Open PHP script
        xhr.open("GET", "delete_chapter.php?story_id="+json_story_id+"&chapter_title="+json_chapter_title);

        // Send request
        xhr.send();
    }
}