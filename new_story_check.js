// ---- CRITERIAS ----
let criteria_not_met = "rgb(140, 0, 0)";
let criteria_met = "rgb(0, 120, 0)";

// ---- STORY TITLE ----
let story_title_label = document.getElementById("story_title_label");
let story_title_input_field = document.getElementById("story_title_input_field");
let story_title_word_count = document.getElementById("story_title_word_count");
let isStoryTitleSmall = false;

// ---- SYNOPSIS ----
let synopsis_label = document.getElementById("synopsis_label");
let synopsis_input = document.getElementById("synopsis_input");
let synopsis_word_count = document.getElementById("synopsis_word_count");
let isSynopsisSmall = false;

// ---- TAG FIELD ----
let tags_label = document.getElementById("tags_label");
let tags_input_field = document.getElementById("tags_input_field");
let tags = document.getElementsByClassName("tag");
let tag_count_txt = document.getElementById("tag_count_txt");
let tagCount = 0;

// ---- CHAPTER 1 TITLE ----
let chapter_title_label = document.getElementById("chapter_title_label");
let chapter_title_input_field = document.getElementById("chapter_title_input_field");
let chapter_title_word_count = document.getElementById("chapter_title_word_count");
let isChapterTitleSmall = false;

// ---- CHAPTER 1 TEXT ----
let chapter_text_label = document.getElementById("chapter_text_label");
let chapter_text_area = document.getElementById("chapter_text_area");
let chapter_text_word_count = document.getElementById("chapter_text_word_count");
let isChapterTextSmall = false;

// ---- PUBLISH INPUT
let publish_input = document.getElementById("publish_input");
publish_input.disabled = true;

// ---- FUNCTIONS ----

// WORD COUNT
function WordCount(inputText)
{
    // If the argument is not a string
    if(typeof(inputText) != "string")
    {
        // Show an error message
        console.log(`Error : ${inputText} is not a text.`);

        // End execution
        return;
    }

    // If the argument is a string
    else
    {
        // Initial word count
        let wordCount = 0;

        // Character loop counter
        let characterCounter;

        // Punctuations (and numbers)
        let punctuations = [",", "?", "!", "(", ")", "[", "]", "{", "}", ":", ";", "-", "/", "\\", ".", "#", "°", "<", ">", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

        // Punctuation counter
        let punctuationCounter = 0;

        // --- EMPTY STRING ---
        if(inputText.length < 1)
        {
            // Show why a new word is not counted
            console.log("Text is empty.");

            // Display final word count
            console.log(`\nWord count : 0.`);

            // End execution
            return 0;
        } 

        // --- 1 CHARACTER LONG STRING ---
        else if(inputText.length == 1)
        {
            // If character is a space
            if(inputText[0] == " ")
            {
                // Show why a new word is not counted
                // console.log("Text is only a space, not counting.");

                // Display final word count
                console.log(`\nWord count : 0.`);

                // End execution
                return 0;
            }

            // For every punctuation
            for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
            {
                // Bool to check if a character is a punctuation
                let isCharPunctuation = false;

                // If character is a punctuation
                if(inputText[0] == punctuations[punctuationCounter])
                {
                    // Set isCharPunctuation to true
                    isCharPunctuation = true;

                    // Show why a new word is not counted
                    // console.log("Text is only a punctuation mark, not counting.");

                    // Display final word count
                    console.log(`\nWord count : 0.`);

                    // End execution
                    return 0;
                }

                // If character is not a space nor a punctuation
                else if(inputText[0] != " " && !isCharPunctuation)
                {
                    // Show why a new word is counted
                    // console.log("Text is only a letter, counting.");

                    // Increase word count by 1
                    wordCount++;

                    // Display final word count
                    console.log(`\nWord count : ${wordCount}.`);

                    // Return word count to use it in next functions
                    return wordCount;
                }
            }   
        }

        // --- MORE THAN 1 CHARACTER LONG STRING ---
        else
        {
            // For every character from 2nd to last
            for(characterCounter = 1; characterCounter < inputText.length; characterCounter++)
            {
                // --- NOT LAST CHARACTER ---
                if(characterCounter < inputText.length-1)
                {
                    // Bool to check if a character is a punctuation
                    let isCharPunctuation = false;

                    // For every punctuation
                    for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                    {
                        // --- CHARACTER IS A PUNCTUATION ---
                        if(inputText[characterCounter] == punctuations[punctuationCounter])
                        {
                            // Set isCharPunctuation to true
                            isCharPunctuation = true;

                            // Bool to check if previous character is a punctuation
                            let isPreviousCharPunctuation = false;

                            // For every punctuation
                            for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                            {
                                // Previous character is a punctuation ",,"
                                if(inputText[characterCounter-1] == punctuations[punctuationCounter])
                                {
                                    // Set isPreviousCharPunctuation to true
                                    isPreviousCharPunctuation = true;

                                    // Show why a new word is not counted
                                    // console.log(`Character ${inputText[characterCounter]} is a punctuation preceded by a punctuation, not counting.`);
                                }
                            }

                            // Previous character is a space " ,"
                            if(!isPreviousCharPunctuation && inputText[characterCounter-1] == " ")
                            {
                                // Show why a new word is not counted
                                // console.log(`Character ${inputText[characterCounter]} is a punctuation preceded by a space, not counting.`);
                            }

                            // Previous character is a letter "a,"
                            else if(!isPreviousCharPunctuation && inputText[characterCounter-1] != " ")
                            {
                            // Show why a new word is  counted
                                // console.log(`Character ${inputText[characterCounter]} is a punctuation preceded by a letter, counting.`);

                                // Increase word count by 1
                                wordCount++;
                            }
                        }
                    }

                    // --- CHARACTER IS A SPACE ---
                    if(!isCharPunctuation && inputText[characterCounter] == " ")
                    {
                        // Bool to check if previous character is a punctuation
                        let isPreviousCharPunctuation = false;

                        // For every punctuation
                        for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                        {
                            // Previous character is a punctuation ", "
                            if(inputText[characterCounter-1] == punctuations[punctuationCounter])
                            {
                                // Set isPreviousCharPunctuation to true
                                isPreviousCharPunctuation = true;

                                // Show why a new word is not counted
                                // console.log(`Character ${inputText[characterCounter]} is a space preceded by a punctuation, not counting.`);
                            }
                        } 

                        // Previous character is a space "  "
                        if(!isPreviousCharPunctuation && inputText[characterCounter-1] == " ")
                        {
                            // Show why a new word is not counted
                            // console.log(`Character ${inputText[characterCounter]} is a space preceded by a space, not counting.`);
                        }

                        // Previous character is a letter "a "
                        else if(!isPreviousCharPunctuation && inputText[characterCounter-1] != " ")
                        {
                            // Show why a new word is not counted
                            // console.log(`Character ${inputText[characterCounter]} is a space preceded by a letter, counting.`);

                            // Increase word count by 1
                            wordCount++;
                        }
                    }

                    // --- CHARACTER IS A LETTER ---
                    if(!isCharPunctuation && inputText[characterCounter] != " ")
                    {
                        // Bool to check if previous character is a punctuation
                        let isPreviousCharPunctuation = false;

                        // For every punctuation
                        for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                        {
                            // Previous character is a punctuation "{a"
                            if(inputText[characterCounter-1] == punctuations[punctuationCounter])
                            {
                                // Set isPreviousCharPunctuation to true
                                isPreviousCharPunctuation = true;

                                // Show why a new word is not counted
                                // console.log(`Character ${inputText[characterCounter]} is a letter preceded by a punctuation, not counting.`);
                            }
                        }

                        // Previous character is a space " a"
                        if(!isPreviousCharPunctuation && inputText[characterCounter-1] == " ")
                        {
                            // Show why a new word is counted
                            // console.log(`Character ${inputText[characterCounter]} is a letter preceded by a space, not counting.`);
                        }

                        // Previous character is a letter "aa"
                        else if(!isPreviousCharPunctuation && inputText[characterCounter-1] != " ")
                        {
                            // Show why a new word is counted
                            // console.log(`Character ${inputText[characterCounter]} is a letter preceded by a letter, not counting.`);:
                        }
                    }
                }

                // --- LAST CHARACTER ---
                else
                {
                    // Bool to check if a character is a punctuation
                    let isCharPunctuation = false;

                    // For every punctuation
                    for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                    {
                        // --- LAST CHARACTER IS A PUNCTUATION ---
                        if(inputText[characterCounter] == punctuations[punctuationCounter])
                        {
                            // Set isCharPunctuation to true
                            isCharPunctuation = true;

                            // Bool to check if previous character is a punctuation
                            let isPreviousCharPunctuation = false;

                            // For every punctuation
                            for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                            {
                                // Previous character is a punctuation "The end..."
                                if(inputText[characterCounter-1] == punctuations[punctuationCounter])
                                {
                                    // Set isPreviousCharPunctuation to true
                                    isPreviousCharPunctuation = true;

                                    // Show why a new word is not counted
                                    // console.log(`Last character ${inputText[characterCounter]} is a punctuation preceded by a punctuation, not counting.`);
                                }
                            }

                            // Previous character is a space "This is why -"
                            if(!isPreviousCharPunctuation && inputText[characterCounter-1] == " ")
                            {
                                // Show why a new word is not counted
                                // console.log(`Last character ${inputText[characterCounter]} is a punctuation preceded by a space, counting.`);

                                // Increase word count by 1
                                wordCount++;
                            }

                            // Previous character is a letter "It."
                            else if(!isPreviousCharPunctuation && inputText[characterCounter-1] != " ")
                            {
                                // Show why a new word is not counted
                                // console.log(`Last character ${inputText[characterCounter]} is a punctuation preceded by a letter, counting.`);

                                // Increase word count by 1
                                wordCount++;
                            }
                        }
                    }

                    // --- LAST CHARACTER IS A SPACE ---
                    if(!isCharPunctuation && inputText[characterCounter] == " ")
                    {
                        // Bool to check if previous character is a punctuation
                        let isPreviousCharPunctuation = false;

                        // For every punctuation
                        for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                        {
                            // Previous character is a punctuation "This is why - "
                            if(inputText[characterCounter-1] == punctuations[punctuationCounter])
                            {
                                // Set isPreviousCharPunctuation to true
                                isPreviousCharPunctuation = true;

                                // Show why a new word is not counted
                                // console.log(`Last character ${inputText[characterCounter]} is a space preceded by a punctuation, not counting.`);
                            }
                        }

                        // Previous character is a space "And  "
                        if(!isPreviousCharPunctuation && inputText[characterCounter-1] == " ")
                        {
                            // Show why a new word is not counted
                            // console.log(`Last character ${inputText[characterCounter]} is a space preceded by a space, not counting.`);
                        }

                        // Previous character is a letter "it "
                        else if(!isPreviousCharPunctuation && inputText[characterCounter-1] != " ")
                        {
                            // Show why a new word is not counted
                            // console.log(`Last character ${inputText[characterCounter]} is a space preceded by a space, counting.`);

                            // Increase word count by 1
                            wordCount++;
                        }
                    }

                    // --- LAST CHARACTER IS A LETTER ---
                    else if(!isCharPunctuation && inputText[characterCounter] != " ")
                    {
                        // Bool to check if previous character is a punctuation
                        let isPreviousCharPunctuation = false;

                        // For every punctuation
                        for(punctuationCounter = 0; punctuationCounter < punctuations.length; punctuationCounter++)
                        {
                            // Previous character is a punctuation "?a"
                            if(inputText[characterCounter-1] == punctuations[punctuationCounter])
                            {
                                // Set isPreviousCharPunctuation to true
                                isPreviousCharPunctuation = true;

                                // Show why a new word is not counted
                                // console.log(`Last character ${inputText[characterCounter]} is a letter preceded by a punctuation, not counting.`);
                            }
                        }  

                        // Previous character is a space "Hello! ha a"
                        if(!isPreviousCharPunctuation && inputText[characterCounter-1] == " ")
                        {
                            // Show why a new word is counted
                            // console.log(`Last character ${inputText[characterCounter]} is a letter preceded by a space, counting.`);

                            // Increase word count by 1
                            wordCount++;

                            // Leave this loop
                            break;
                        }

                        // Previous character is a letter "Hello! ha ha"
                        else if(!isPreviousCharPunctuation && inputText[characterCounter-1] != " ")
                        {
                            // Show why a new word is counted
                            // console.log(`Last character ${inputText[characterCounter]} is a letter preceded by a letter, counting.`);

                            // Increase word count by 1
                            wordCount++;

                            // Leave this loop
                            break;
                        }
                    }
                }
            }   
        }     

        // Display final word count
        console.log(`\nWord count : ${wordCount}.`);

        // Return word count to use it in next functions
        return wordCount;
    }
}

// STORY TITLE
function StoryTitleCheck()
{
    // Store story title's number of words in a variable
    let story_title_word_num = WordCount(story_title_input_field.value);

    // Assign story_title_word_num to story_title_word_count text
    story_title_word_count.innerText = story_title_word_num;

    // If the story title is less than 1 character long
    if(story_title_input_field.value.length < 1)
    {
        // Set isStoryTitleSmall to false (to make sure Publish Input stays inactive)
        isStoryTitleSmall = false;
        console.log(`isStoryTitleSmall == ${isStoryTitleSmall}.`);

        // Disable Publish input
        publish_input.disabled = true;

        // Change story_title_label to black
        story_title_label.style.color = "black";
    }

    // If the story title is at least 1 character long
    else if(story_title_input_field.value.length > 0)
    {
        // More than 30 words long title : The wonderful and amazing story of the small yokai who single handedly defeated the moon breaking oni with nothing but sheer will power and straightforward, unalterable and raw unstoppable persistence a

        // If the story title is more than 30 words long
        if(WordCount(story_title_input_field.value) > 30)
        {
            // Set isStoryTitleSmall to false
            isStoryTitleSmall = false;
            console.log(`isStoryTitleSmall == ${isStoryTitleSmall}.`);

            // Disable Publish input
            publish_input.disabled = true;

            // Change story_title_label to red
            story_title_label.style.color = criteria_not_met;
        }

        // If the story title is less than or equal to 30 words long
        else if(WordCount(story_title_input_field.value) <= 30)
        {
            // Set isStoryTitleSmall to true
            isStoryTitleSmall = true;
            console.log(`isStoryTitleSmall == ${isStoryTitleSmall}.`);

            // Change story_title_label to green
            story_title_label.style.color = criteria_met;
        }
    }

    // Check every criteria
    PublishCheck();
}

// SYNOPSIS
function SynopsisCheck()
{
    // Store synopsis' number of words in a variable
    let synopsis_word_num = WordCount(synopsis_input.value);

    // Assign synopsis_word_num to synopsis_word_count text
    synopsis_word_count.innerText = synopsis_word_num;

    // If the synopsis is less than 1 character long
    if(synopsis_input.value.length < 1)
    {
        // Set isSynopsisSmall to false (to make sure Publish Input stays inactive)
        isSynopsisSmall = false;
        console.log(`isSynopsisSmall == ${isSynopsisSmall}.`);

        // Disable Publish input
        publish_input.disabled = true;

        // Change synopsis_label to black
        synopsis_label.style.color = "black";
    }

    // More than 100 words text :

    /*
        a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a
    */

    // If the synopsis is at least 1 character long 
    else if(synopsis_input.value.length > 0)
    {
        // Store synopsis' number of words in a variable
        let synopsis_word_num = WordCount(synopsis_input.value);

        // Assign synopsis_word_num to synopsis_word_count text
        synopsis_word_count.innerText = synopsis_word_num;

        // If the synopsis is more than 100 words long
        if(WordCount(synopsis_input.value) > 100)
        {
            // Set isSynopsisSmall to false
            isSynopsisSmall = false;
            console.log(`isSynopsisSmall == ${isSynopsisSmall}.`);

            // Disable Publish input
            publish_input.disabled = true;

            // Change synopsis_label to red
            synopsis_label.style.color = criteria_not_met;
        }

        // If the synopsis is less than or equal to 100 words long
        else if(WordCount(synopsis_input.value) <= 100)
        {
            // Set isSynopsisSmall to true
            isSynopsisSmall = true;
            console.log(`isSynopsisSmall == ${isSynopsisSmall}.`);

            // Change synopsis_label to green
            synopsis_label.style.color = criteria_met;
        }
    }

    // Check every criteria
    PublishCheck();
}

// TAGS INPUT FIELD
function EmptyTagsField()
{
    // Assign an empty string to the tags input field
    tags_input_field.value = "";
}

// FUNCTION TO TOGGLE TAGS

// For every tag
for(let i = 0; i < tags.length; i++)
{
    // Log tag
    // console.log(`Tag n°${i+1} == ${tags[i].innerText}.`);

    // If a tag is clicked
    tags[i].addEventListener("click", function()
    {
        // If there are less than 6 tags
        if(tagCount <= 6)
        {
            // If the clicked tag is already in the tags field
            if(tags_input_field.value.includes(tags[i].innerText))
            {
                // Replace clicked tag with an empty string
                tags_input_field.value = tags_input_field.value.replace(`${tags[i].innerText} `, "");
                tags_input_field.value = tags_input_field.value.replace(tags[i].innerText, "");

                // Decrease tagCount by 1
                tagCount--;

                // Update tag_count_txt
                tag_count_txt.innerText = tagCount;
            }

            // If the clicked tag is not in the tags field
            else if(!tags_input_field.value.includes(tags[i].innerText))
            {
                // If there are less than 6 tags
                if(tagCount < 6)
                {
                    // Add clicked tag to tags field
                    tags_input_field.value += `${tags[i].innerText} `;

                    // Increase tagCount by 1
                    tagCount++;

                    // Update tag_count_txt
                    tag_count_txt.innerText = tagCount;
                }
            } 

            // Change tags label color to green
            tags_label.style.color = criteria_met;
        }

        // If there are more than 6 tags
        else if(tagCount > 6)
        {
            // Disable Publish input
            publish_input.disabled = true;

            // Change tags label color to red
            tags_label.style.color = criteria_not_met;
        }

        // Check every criteria
        PublishCheck();
    }
    )
}

// CHAPTER 1 TITLE
function ChapterTitleCheck()
{
    // Store chapter title's number of words in a variable
    let chapter_title_word_num = WordCount(chapter_title_input_field.value);

    // Assign chapter_title_word_num to chapter_title_word_count text
    chapter_title_word_count.innerText = chapter_title_word_num;

    // If the chapter title is less than 1 character long
    if(chapter_title_input_field.value.length < 1)
    {
        // Set isChapterTitleSmall to false (to make sure Publish Input stays inactive)
        isChapterTitleSmall = false;
        console.log(`isChapterTitleSmall == ${isChapterTitleSmall}.`);

        // Disable Publish input
        publish_input.disabled = true;

        // Change chapter_title_label to black
        chapter_title_label.style.color = "black";
    }

    // If the chapter title is at least 1 character long
    else if(chapter_title_input_field.value.length > 0)
    {
        // More than 30 words long title : The wonderful and amazing story of the small yokai who single handedly defeated the moon breaking oni with nothing but sheer will power and straightforward, unalterable and raw unstoppable persistence a

        // If the chapter title is more than 30 words long
        if(WordCount(chapter_title_input_field.value) > 30)
        {
            // Set isChapterTitleSmall to false
            isChapterTitleSmall = false;
            console.log(`isChapterTitleSmall == ${isChapterTitleSmall}.`);

            // Disable Publish input
            publish_input.disabled = true;

            // Change chapter_title_label to red
            chapter_title_label.style.color = criteria_not_met;
        }

        // If the chapter title is less than or equal to 30 words long
        else if(WordCount(chapter_title_input_field.value) <= 30)
        {
            // Set isChapterTitleSmall to true
            isChapterTitleSmall = true;
            console.log(`isChapterTitleSmall == ${isChapterTitleSmall}.`);

            // Change chapter_title_label to green
            chapter_title_label.style.color = criteria_met;
        }
    }

    // Check every criteria
    PublishCheck();
}

//  CHAPTER 1 TEXT
function ChapterTextCheck()
{
    // Store chapter 1 text's number of words in a variable
    let chapter_text_word_num = WordCount(chapter_text_area.value);

    // Assign chapter_text_word_num to chapter_text_word_count text
    chapter_text_word_count.innerText = chapter_text_word_num;

    // If chapter 1 text is less than 1 character long
    if(chapter_text_area.value.length < 1)
    {
        // Set isChapterTextSmall to false (to make sure Publish Input stays inactive)
        isChapterTextSmall = false;
        console.log(`isChapterTextSmall == ${isChapterTextSmall}.`);

        // Disable Publish input
        publish_input.disabled = true;

        // Change chapter_text_label to black
        chapter_text_label.style.color = "black";
    }

    // More than 100 words text :

    /*
        a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a
    */

    // If chapter 1 text is at least 1 character long
    else if(chapter_text_area.value.length > 0)
    {
        // If chapter 1 text is more than 15 000 words long
        if(WordCount(chapter_text_area.value) > 15000)
        {
            // Set isChapterTextSmall to false
            isChapterTextSmall = false;
            console.log(`isChapterTextSmall == ${isChapterTextSmall}.`);

            // Disable Publish input
            publish_input.disabled = true;

            // Change chapter_text_label to red
            chapter_text_label.style.color = criteria_not_met;
        }

        // If chapter 1 text is les than or equal to 15 000 words long
        else if(WordCount(chapter_text_area.value) <= 15000)
        {
            // Set isChapterTextSmall to true
            isChapterTextSmall = true;
            console.log(`isChapterTextSmall == ${isChapterTextSmall}.`);

            // Change chapter_text_label to green
            chapter_text_label.style.color = criteria_met;
        }
    }

    // Check every criteria
    PublishCheck();
}

// PUBLISH CHECK
function PublishCheck()
{
    // If Story Title is small and Synopsis is small and there are less than 7 tags and Chapter Title is small and Chapter Text is small
    if(isStoryTitleSmall && isSynopsisSmall && tagCount < 7 && isChapterTitleSmall && isChapterTextSmall)
    {
        // Reactivate Publish Input
        publish_input.disabled = false;

        // Confirm that story can be published
        console.log("Story can be published.");
    }

    // If Story Title is big or Synopsis is big or there are more than 6 tags or Chapter Title is big or Chapter Text is big
    else if(!isStoryTitleSmall || !isSynopsisSmall || tagCount > 6 || !isChapterTitleSmall || !isChapterTextSmall)
    {
        // Deactivate Publish Input
        publish_input.disabled = true;

        // Confirm that story cannot be published
        console.log("Story cannot be published.");
    }
}