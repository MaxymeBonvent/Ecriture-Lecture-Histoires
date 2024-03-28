// ---- COLOR OPTIONS DIV ----
let color_options = document.getElementById("color_options");
color_options.style.display = "none";

// ---- STYLE OPTIONS ---- //

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

// TOGGLE COLOR DIV
function ToggleColorDiv()
{
    // If the color circles div's display is none
    if(color_options.style.display == "none")
    {
        // Assign flex to the color circles div's display
        color_options.style.display = "flex";
        color_options.style.justifyContent = "space-evenly";
    }

    // If the color circles div's display is flex
    else if(color_options.style.display == "flex")
    {
        // Assign none to the color circles div's display
        color_options.style.display = "none";
    }
}

// RED
function Red()
{
    // Add a red filter to the text area
    chapter_text_area.value += "<p style='color: rgb(140, 0, 0);'></p>";
}

// GREEN
function Green()
{
    // Add a green filter to the text area
    chapter_text_area.value += "<p style='color: rgb(0, 130, 0);'></p>";
}

// BLUE
function Blue()
{
    // Add a blue filter to the text area
    chapter_text_area.value += "<p style='color: rgb(0, 0, 220);'></p>";
}