// ---- TAGS FIELD ---- //
let tags_input = document.getElementById("tags_input");
let tags = document.getElementsByClassName("tag");

// ---- STORY TITLE ---- //
let story_title = document.getElementById("story_title");

// ---- AUTHOR  ---- //
let author = document.getElementById("author");

// ---- MININMUM WORD COUNT  ---- //
let min_word_count = document.getElementById("min_word_count");

// ---- MAXIMUM WORD COUNT  ---- //
let max_word_count = document.getElementById("max_word_count");

// ---- SEARCH DIV ---- //
let search_div = document.getElementById("search_div");

// ---- RESULTS SECTION ---- //
let results_section = document.getElementById("results_section");


// ---- FUNCTIONS ---- //

// EMPTY TAGS FIELD
function EmptyTagsField()
{
    // Assign an empty string to the tags input field
    tags_input.value = "";
}

// TOGGLE TAGS

// For every tag
for(let tagCounter = 0; tagCounter < tags.length; tagCounter++)
{
    // Log it
    // console.log(`Tag n°${tagCounter+1} : ${tags[tagCounter].innerText}.`);

    // If that tag is clicked
    tags[tagCounter].addEventListener("click", function()
    {
        // If tags input field does not contain that tag
        if(!tags_input.value.includes(tags[tagCounter].innerText))
        {
            // Add that tag to the tags input field
            tags_input.value += `${tags[tagCounter].innerText} `;
        }

        // If tags input field does contain that tag
        else if(tags_input.value.includes(tags[tagCounter].innerText))
        {
            // Remove that tag from the tags input field
            tags_input.value = tags_input.value.replace(`${tags[tagCounter].innerText} `, "");
        } 
    });
}

// PSEUDO CANCEL BUTTON
function PseudoCancel()
{
    // Empty all input fields and Results section
    tags_input.value = "";
    story_title.value = "";
    author.value = "";
    min_word_count.value = "";
    max_word_count.value = "";
    results_section.textContent = "";
}

// PSEUDO SUBMIT BUTTON
// Function to get input field values and pass them to a PHP script that will search stories
function Search()
{
    // If every field is empty
    if(tags_input.value == "" && story_title.value == "" && author.value == "" && min_word_count.value == "" && max_word_count.value == "")
    {
        // Log it
        console.log("Cannot search a story with no criteria.");

        // Show it to user
        results_section.innerHTML = "<p>Cannot search a story with no criteria.</p>";

        // End function
        return 0;
    }

    // If maximum word count is less than minimum word count
    else if(parseInt(max_word_count.value) < parseInt(min_word_count.value))
    {
        // Show logic error message in results section
        results_section.innerHTML = `<p>Logic error : maximum word count cannot be less than minimum word count.</p><p>Did you mean \"At least ${parseInt(max_word_count.value)} words, At most ${parseInt(min_word_count.value)} words\"?</p>`;

        // End function
        return 0;
    }

    // If at least 1 field is not empty
    else if(tags_input.value != "" || story_title.value != "" || author.value != "" || min_word_count.value != "" || max_word_count.value != "")
    {
        // Log it
        console.log("At least 1 criteria given.");

        // ---- AJAX REQUEST ---- //

        // AJAX object
        let xhr = new XMLHttpRequest();

        // Callback function    
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Log it
                console.log("Story search request done.");

                // If no story was found
                if(xhr.responseText == null || xhr.responseText == "")
                {
                    // Tell it to user
                    results_section.innerHTML = "<p>No story found.</p>";

                    // Log it
                    console.log("No story found.");
                }

                // If at least 1 story was found  
                else if(xhr.responseText != null && xhr.responseText != "")
                {
                    // Refresh page with found IDs
                    window.location.href = `story_search_page.php?story_ids=${xhr.responseText}`;

                    // Log it
                    console.log("At least 1 story found.");
                }              
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during story search request : ${xhr.status}.`);
        }

        // Open PHP story search script
        xhr.open("GET", `story_search.php?tags=${tags_input.value}&story_title=${story_title.value}&author=${author.value}&min_word_count=${min_word_count.value}&max_word_count=${max_word_count.value}`);

        // Send request
        xhr.send();
    }
}