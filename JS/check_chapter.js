// ---- CRITERIAS ----
let criteria_not_met = "rgb(140, 0, 0)";
let criteria_met = "rgb(0, 120, 0)";

// ---- CHAPTER TITLE ----
let chapter_title_label = document.getElementById("chapter_title_label");
let chapter_title_input_field = document.getElementById("chapter_title_input_field");
let chapter_title_word_count = document.getElementById("chapter_title_word_count");
let isChapterTitleSmall = false;

// ---- CHAPTER TEXT ----
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

// CHAPTER TITLE
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

//  CHAPTER TEXT
function ChapterTextCheck()
{
    // Store chapter text's number of words in a variable
    let chapter_text_word_num = WordCount(chapter_text_area.value);

    // Assign chapter_text_word_num to chapter_text_word_count text
    chapter_text_word_count.innerText = chapter_text_word_num;

    // If chapter text is less than 1 character long
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

    // If chapter text is at least 1 character long
    else if(chapter_text_area.value.length > 0)
    {
        // If chapter text is more than 15 000 words long
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

        // If chapter text is les than or equal to 15 000 words long
        else if(WordCount(chapter_text_area.value) <= 15000)
        {
            // Set isChapterTextSmall to true
            isChapterTextSmall = true;
            console.log(`isChapterTextSmall == ${isChapterTextSmall}.`);

            // Change chapter_text_label to green
            chapter_text_label.style.color = criteria_met;
        }
    }

    // Toggle Publish Input
    PublishCheck();
}

// PUBLISH CHECK
function PublishCheck()
{
    // If Chapter Title is small and Chapter Text is small
    if(isChapterTitleSmall && isChapterTextSmall)
    {
        // Reactivate Publish Input
        publish_input.disabled = false;

        // Confirm that chapter can be published
        console.log("Chapter can be published.");
    }

    // If Chapter Title is big or Chapter Text is big
    else if(!isChapterTitleSmall || !isChapterTextSmall)
    {
        // Deactivate Publish Input
        publish_input.disabled = true;

        // Confirm that chapter cannot be published
        console.log("Chapter cannot be published.");
    }
}

// Check if chapter title and texts are okay
ChapterTitleCheck();
ChapterTextCheck();