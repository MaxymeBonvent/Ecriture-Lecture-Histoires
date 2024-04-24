// Textarea
let comment_textarea = document.getElementById("comment_textarea");
// console.log(`comment_textarea == ${comment_textarea}.`);

// Method to add a quoted text in the textarea
function QuoteComment(comment_author, comment_txt, comment_date)
{
    // Confirm variables obtention
    console.log(`Comment author == ${comment_author}.`);
    console.log(`Comment text == ${comment_txt}.`);
    console.log(`Comment date == ${comment_date}.`);

    // Insert set selected comment text, its author and date, with a quote style in the comment input
    comment_textarea.innerHTML = `<span id='quote'>${comment_author} wrote on ${comment_date} : ${comment_txt}</span><br><br>`; 
}