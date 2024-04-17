// ---- STYLE OPTIONS ---- //

// NEW LINE
function NewLine()
{
    // Add a new line to chapter 1 text area
    chapter_text_area.value += "<br>";
}

// BOLD
function Bold()
{
    // Add a bold filter to chapter 1 text area
    chapter_text_area.value += "<b></b>";
}

// ITALIC
function Italic()
{
    // Add an italic filter to chapter 1 text area
    chapter_text_area.value += "<i></i>";
}

// UNDERLINE
function Underline()
{
    // Add an underline to chapter 1 text area
    chapter_text_area.value += "<u></u>";
}

// STRIKETHROUGH
function Strike()
{
    // Add a strikethrough filter to chapter 1 text area
    chapter_text_area.value += "<del></del>";
}

// SMALL
function Small()
{
    // Add a small filter to chapter 1 text area
    chapter_text_area.value += "<small></small>";
}

// SUPERSCRIPT
function Superscript()
{
    // Add a superscript filter to chapter 1 text area
    chapter_text_area.value += "<sup></sup>";
}

// SUBSCRIPT
function Subscript()
{
    // Add a subscript filter to chapter 1 text area
    chapter_text_area.value += "<sub></sub>";
}

// CENTER
function Center()
{
    // Add a center filter to chapter 1 text area
    chapter_text_area.value += "<p style='text-align: center;'></p>";
}

// HORIZONTAL RULE
function HorizontalRule()
{
    // Add a horizontal rule to chapter 1 text area
    chapter_text_area.value += "<hr>\n";
}

// ---- COLOR OPTIONS ---- //

// COLOR OPTIONS DIV
let color_box = document.getElementById("color_options");

// Hide color box
color_box.style.display = "none";

// Function to toggle color box
function ToggleColorBox()
{
    // Confirm function call
    console.log("ToggleColorBox() called.");

    // If box is hidden
    if(color_box.style.display == "none")
    {
        // Reveal color box
        color_box.style.display = "flex";

        // Distribute color options evenly in the box
        color_box.style.justifyContent = "space-evenly";
    }

    // If box is on screen
    else if(color_box.style.display = "flex")
    {
        // Hide color box
        color_box.style.display = "none";
    }
}

// RED
function Red()
{
    // Add red filter to chapter text area
    chapter_text_area.value += "<span style='color: rgb(160, 0, 0);'></span>";
}

// GREEN
function Green()
{
    // Add green filter to chapter text area
    chapter_text_area.value += "<span style='color: rgb(0, 120, 0);'></span>";
}

// BLUE
function Blue()
{
    // Add green filter to chapter text area
    chapter_text_area.value += "<span style='color: rgb(0, 60, 180);'></span>";
}