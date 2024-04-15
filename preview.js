// BODY
let body = document.querySelector("body");
console.log(`Window's height == ${window.height}.`);

// PREVIEW BACKGROUND ON
let preview_bck_on = document.getElementById("preview_bck_on");

// Function to position preview background at the page's center
function CenterPreviewBackground()
{
    // Place preview background's top right corner at vertical center
    preview_bck_on.style.top = `${1080/2}px`;
}

CenterPreviewBackground();