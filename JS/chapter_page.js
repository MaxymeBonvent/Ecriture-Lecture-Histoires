// Function to get clicked chapter's ID and send it to Chapter Page's URL
function ChapterPage(chapter_id, story_id)
{
    // Confirm Chapter ID obtention
    console.log(`Chapter ID == ${chapter_id}.`);

    // Confirm Story ID obtention
    console.log(`Story ID == ${story_id}.`);

    // If there's no chapter ID
    if(chapter_id == null)
    {
        // Log an error
        console.log("Error: no chapter ID.");
    }

    // If there's no story ID
    else if(story_id == null)
    {
        // Log an error
        console.log("Error: no story ID.");
    }

    // If there's a chapter ID and a story ID
    else if(chapter_id != null && story_id != null)
    {
        // Redirect user to Chapter Page with that ID in it URL
        window.location.href = `chapter_page.php?chapter_id=${chapter_id}&story_id=${story_id}`;
    }
}