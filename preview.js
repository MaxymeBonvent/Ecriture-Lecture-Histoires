// ---- PREVIEW VARIABLES ---- //

// PREVIEW BACKGROUND
let preview_bck = document.getElementById("preview_bck");

// Hide preview div
preview_bck.style.display = "none";

// CHAPTER TITLE PREVIEW
let chapter_title_pre = document.getElementById("chapter_title_preview");

// CHAPTER TEXT PREVIEW
let chapter_text_pre = document.getElementById("chapter_txt_preview");

// ---- TEXT VARIABLES ---- //

// CHAPTER TITLE
let chapter_title = document.getElementById("chapter_title_input_field");

// CHAPTER TEXT
let chapter_text = document.getElementById("chapter_text_area");

// Function to toggle preview background on or off
function TogglePreviewBackground()
{
    // If preview background's display is "none"
    if(preview_bck.style.display == "none")
    {
        // Set it to "flex"
        preview_bck.style.display = "flex";

        // Change position of internal elements
        preview_bck.style.justifyContent = "center";
        preview_bck.style.alignItems = "center";

        // Log change
        console.log("Preview background's display set to FLEX.");

        // Place chapter title into its preview version
        chapter_title_pre.innerText = chapter_title.value;

        // Place chapter text into its preview version
        chapter_text_pre.innerHTML = chapter_text.value;
    }

    // If preview background's display is "flex"
    else if(preview_bck.style.display == "flex")
    {
        // Set it to "none"
        preview_bck.style.display = "none";

        // Log change
        console.log("Preview background's display set to NONE.");
    }
}