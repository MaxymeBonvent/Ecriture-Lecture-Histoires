// ---- TAGS FIELD ---- //
let tags_input = document.getElementById("tags_input");
let tags = document.getElementsByClassName("tag");

// ---- STORY TITLE ---- //
let story_title = document.getElementById("story_title");

// ---- AUTHOR  ---- //
let author = document.getElementById("author");

// ---- GREATER THAN  ---- //
let min_word_count = document.getElementById("min_word_count");

// ---- LESS THAN  ---- //
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

        // Check if Search button can be activated
        // CheckSearchButton();
    });
}

// MIN AND MAX WORD COUNT INPUTS
// function CheckMinMax()
// {
//     // If maximum word count is less than minimum word count
//     if(parseInt(max_word_count.value) < parseInt(min_word_count.value))
//     {
//         // Hide Search div
//         search_div.style.display = "none";

//         // Log why Search button is off
//         console.log("Search button turned off because maximum word count is less than minimum word count.");
//     }

//     // If maximum word count is greater than or equal to minimum word count
//     else if(parseInt(max_word_count.value) >= parseInt(min_word_count.value))
//     {
//         // Hide Search div
//         search_div.style.display = "block";

//         // Log why Search button is off
//         console.log("Search button turned on because maximum word count greater than or equal to minimum word count.");
//     }
// }

// PSEUDO CANCEL BUTTON
function PseudoCancel()
{
    // Empty all input fields
    tags_input.value = "";
    story_title.value = "";
    author.value = "";
    min_word_count.value = "";
    max_word_count.value = "";

    // Confirm every field is empty
    console.log("Every field has been emptied.");
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

    // If at least 1 field is not empty
    else if(tags_input.value != "" || story_title.value != "" || author.value != "" || min_word_count.value != "" || max_word_count.value!= "")
    {
       // Log it
        console.log("At least 1 criteria given.");

        // Show it to user
        results_section.textContent = "At least 1 criteria given."; 

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

                // Redirect user to PHP story search script
                // window.location.href = `story_search.php?tags=${tags_input.value}&story_title=${story_title.value}&author=${author.value}&min_word_count=${min_word_count.value}&max_word_count=${max_word_count.value}`;

                // if no story was found
                if(xhr.responseText == null || xhr.responseText == "")
                {
                    // Tell it to user
                    results_section.innerHTML = "<p>No story found.</p>";

                    // Log it
                    console.log("No story found.");
                }

                // if at least 1 story was found  
                else if(xhr.responseText != null && xhr.responseText != "")
                {
                    // Display IDs of matching stories in the Results section
                    results_section.innerHTML = `<p id='result_ids'>${xhr.responseText}</p>`;

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