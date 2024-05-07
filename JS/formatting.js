// ---- ZONE VARIABLES ---- //
// "Format" button
let format = document.getElementById("format");

// "Text Font" button
let text_font = document.getElementById("text_font");
text_font.style.display = "none";

// "Font names" div
let font_names_div = document.getElementById("font_names_div");
font_names_div.style.display = "none";

// "Font Size" button
let font_size = document.getElementById("font_size");
font_size.style.display = "none";

// "Font size input" div
let font_size_input_div = document.getElementById("font_size_input_div");
font_size_input_div.style.display = "none";

// Font size input field
let font_size_field = document.getElementById("font_size_field");

// ---- CHAPTER VARIABLES ---- //
// Chapter title
let chaper_title = document.getElementById("chaper_title");

// Chapter text
let chaper_txt = document.getElementById("chaper_txt");



// ---- FUNCTIONS ---- //

// TOGGLE FONT SIZE INPUT DIV
function ToggleFontSizeDiv()
{
    // If font size div is hidden
    if(font_size_input_div.style.display == "none")
    {
        // Reveal it
        font_size_input_div.style.display = "flex";

        // Log apparition
        console.log("Font size input div appeared.");
    }

    // If font size div is revealed
    else if(font_size_input_div.style.display == "flex")
    {
        // Hide it
        font_size_input_div.style.display = "none";

        // Log disapparition
        console.log("Font size input div disappeared.");
    }
}

// TOGGLE FONT NAMES DIV
function ToggleFontNamesDiv()
{
    // If font names div is hidden
    if(font_names_div.style.display == "none")
    {
        // Reveal it
        font_names_div.style.display = "flex";

        // Log apparition
        console.log("Font names div appeared.");
    }

    // If font names div is revealed
    else if(font_names_div.style.display == "flex")
    {
        // Hide it
        font_names_div.style.display = "none";

        // Log disapparition
        console.log("Font names div disappeared.");
    }
}

// TOGGLE "TEXT FONT" AND "FONT SIZE" BUTTONS
function ToggleFontTypeAndSizeButtons()
{
    // If "Text Font" and "Font Size" buttons are hidden
    if(text_font.style.display == "none" && font_size.style.display == "none")
    {
        // Reveal them
        text_font.style.display = "block";
        font_size.style.display = "block";

        // Log double apparition
        console.log("\"Text Font\" and \"Font Size\" appeared.");
    }

    // If "Text Font" and "Font Size" buttons are revealed
    else if(text_font.style.display == "block" && font_size.style.display == "block")
    {
        // Hide them
        text_font.style.display = "none";
        font_size.style.display = "none";

        // Hide font names div and font size input div
        font_names_div.style.display = "none";
        font_size_input_div.style.display = "none";

        // Log double disapparition
        console.log("\"Text Font\", \"Font Size\" and their options disappeared.");
    }
}

// SET FONT TO TIMES NEW ROMAN
function SetFontTimesNewRoman()
{
    // Set chapter title and text font to Times New Roman
    chaper_title.style.fontFamily = "Times New Roman";
    chaper_txt.style.fontFamily = "Times New Roman";

    // Log font change
    console.log("Font set to Times New Roman.");
}

// SET FONT TO ARIAL
function SetFontArial()
{
    // Set chapter title's font to Arial
    chaper_title.style.fontFamily = "Arial";
    chaper_txt.style.fontFamily = "Arial";

    // Log font change
    console.log("Font set to Arial.");
}

// SET FONT TO VERDANA
function SetFontVerdana()
{
    // Set chapter title's font to Verdana
    chaper_title.style.fontFamily = "Verdana";
    chaper_txt.style.fontFamily = "Verdana";

    // Log font change
    console.log("Font set to Verdana.");
}

// SET FONT TO LUCIDA SANS UNICODE
function SetFontLucidaSansUnicode()
{
    // Set chapter title's font to Lucida Sans Unicode
    chaper_title.style.fontFamily = "Lucida Sans Unicode";
    chaper_txt.style.fontFamily = "Lucida Sans Unicode";

    // Log font change
    console.log("Font set to Lucida Sans Unicode.");
}

// CHANGE FONT SIZE
function ChangeFontSize()
{
    // if number entered is not between 14 and 28
    if(font_size_field.value < 14 || font_size_field.value > 28)
    {
        // Log error
        console.log("Error : number entered must be between 14 and 28.");
    }

    // if number entered is between 14 and 28
    else if(font_size_field.value >= 14 && font_size_field.value <= 28)
    {
        // Log input
        console.log(`Valid number entered : ${font_size_field.value}.`);

        // Store rounded value of input in a variable
        let roundedInput = Math.round(font_size_field.value);
        console.log(`roundedInput == ${roundedInput}.`);

        // Assign the rounded number as chapter text's font size property
        chaper_txt.style.fontSize = `${roundedInput}px`;
    }
}