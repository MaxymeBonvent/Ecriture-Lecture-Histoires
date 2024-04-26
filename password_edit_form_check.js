// ---- COLORS ----//

// Valid
let criteria_met = "rgb(0, 120, 0)";

// Invalid
let criteria_not_met = "rgb(120, 0, 0)";

// ---- LOOP MANAGERS ---- //

// New password character index
let newPwdCounter;

// Criteria list counter
let charListCounter;

// ---- INPUTS --- //

// New password input
let new_password = document.getElementById("new_password");

// Repeat new password input
let repeat_new_password = document.getElementById("repeat_new_password");
let arePwdsIdentical = false;

// ---- CRITERIAS ---- //

// Length
let new_pwd_length = document.getElementById("new_pwd_length");
let isLong = false;

// Uppercase
let upp_txt = document.getElementById("upp_txt");
let upper_chars = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
let hasUpper = false;

// Lowercase
let lower_txt = document.getElementById("lower_txt");
let lower_chars = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
let hasLower = false;

// Number
let num_txt = document.getElementById("num_txt");
let numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
let hasNumber = false;

// Special character
let spec_char_txt = document.getElementById("spec_char_txt");
let special_chars = ["~", "#", "{", "}", "(", ")", "[", "]", "-", "|", "`", "_", "\\", "/", "^", "@", "°", "=", "+", "-", "*", "?", "!", ",", ";", ".", "§", "ù", "$", "£", "¤", "µ", "%"];
let hasSpec = false;

// ---- TEXTS ---- //
// New password text
let pwds_identity_txt = document.getElementById("pwds_identity_txt");

// ---- PUBLISH ---- //

// Edit button
let edit_btn = document.getElementById("edit_btn");
edit_btn.disabled = true;

// ---- FUNCTIONS ---- //
// Function to check if new password is long enough
function NewPasswordLengthCheck()
{
    // If password has less than 12 characters
    if(new_password.value.length < 12)
    {
        // Set isLong to false
        isLong = false;

        // Change color of "12 characters" to invalid color
        new_pwd_length.style.color = criteria_not_met;

        // Log new password length
        console.log(`Length of new password == ${new_password.value.length}, too short.`);
    }

    // If password has at least 12 characters
    else if(new_password.value.length >= 12)
    {
        // Set isLong to true
        isLong = true;

        // Change color of "12 characters" to valid color
        new_pwd_length.style.color = criteria_met;

        // Log new password length
        console.log(`Length of new password == ${new_password.value.length}, long enough.`);
    }
}

// Function to check if new password has an uppercase character
function NewPasswordUpperCheck()
{
    // If new password has at least 1 character
    if(new_password.value.length > 0)
    {
        // For every new password character from 1st to last
        for(newPwdCounter = 0; newPwdCounter < new_password.value.length; newPwdCounter++)
        {
            // For every uppercase character
            for(charListCounter = 0; charListCounter < upper_chars.length; charListCounter++)
            {
                // If that character is not an uppercase one
                if(new_password.value[newPwdCounter] != upper_chars[charListCounter])
                {
                    // Set boolean to false
                    hasUpper = false;

                    // Set criteria text to invalid color
                    upp_txt.style.color = criteria_not_met;

                    // Log criteria invalidation
                    console.log(`${new_password.value[newPwdCounter]} is not an uppercase letter.`);
                }

                // If that character is an uppercase one
                else if(new_password.value[newPwdCounter] == upper_chars[charListCounter])
                {
                    // Set boolean to true
                    hasUpper = true;

                    // Set criteria text to valid color
                    upp_txt.style.color = criteria_met;

                    // Log criteria validation
                    console.log(`${new_password.value[newPwdCounter]} is an uppercase letter.`);

                    // Leave function
                    return;
                }
            }
        }
    }
}

// Function to check if new password has a lowercase character
function NewPasswordLowerCheck()
{
    // If new password has at least 1 character
    if(new_password.value.length > 0)
    {
        // For every new password character from 1st to last
        for(newPwdCounter = 0; newPwdCounter < new_password.value.length; newPwdCounter++)
        {
            // For every lowercase character
            for(charListCounter = 0; charListCounter < lower_chars.length; charListCounter++)
            {
                // If that character is not a lowercase one
                if(new_password.value[newPwdCounter] != lower_chars[charListCounter])
                {
                    // Set boolean to false
                    hasLower = false;

                    // Set criteria text to invalid color
                    lower_txt.style.color = criteria_not_met;

                    // Log criteria invalidation
                    console.log(`${new_password.value[charListCounter]} is not a lowercase letter.`);
                }

                // If that character is a lowercase one
                else if(new_password.value[newPwdCounter] == lower_chars[charListCounter])
                {
                    // Set boolean to true
                    hasLower = true;

                    // Set criteria text to valid color
                    lower_txt.style.color = criteria_met;

                    // Log criteria validation
                    console.log(`${new_password.value[newPwdCounter]} is a lowercase letter.`);

                    // Leave function
                    return;
                }
            }
        }
    }  
}

// Function to check if new password has a number
function NewPasswordNumCheck()
{
    // If new password has at least 1 character
    if(new_password.value.length > 0)
    {
        // For every new password character from 1st to last
        for(newPwdCounter = 0; newPwdCounter < new_password.value.length; newPwdCounter++)
        {
            // For every number character
            for(charListCounter = 0; charListCounter < numbers.length; charListCounter++)
            {
                // If that character is not a number
                if(new_password.value[newPwdCounter] != numbers[charListCounter])
                {
                    // Set boolean to false
                    hasNumber = false;

                    // Set criteria text to invalid color
                    num_txt.style.color = criteria_not_met;

                    // Log criteria invalidation
                    console.log(`${new_password.value[charListCounter]} is not a number.`);
                }

                // If that character is a number
                else if(new_password.value[newPwdCounter] == numbers[charListCounter])
                {
                    // Set boolean to true
                    hasNumber = true;

                    // Set criteria text to valid color
                    num_txt.style.color = criteria_met;

                    // Log criteria validation
                    console.log(`${new_password.value[newPwdCounter]} is a number.`);

                    // Leave function
                    return;
                }
            }
        }
    }   
}

// Function to check if new password has a special character
function NewPasswordSpecCheck()
{
    // If new password has at least 1 character
    if(new_password.value.length > 0)
    {
        // For every new password character from 1st to last
        for(newPwdCounter = 0; newPwdCounter < new_password.value.length; newPwdCounter++)
        {
            // For every special character character
            for(charListCounter = 0; charListCounter < special_chars.length; charListCounter++)
            {
                // If that character is not a special character 
                if(new_password.value[newPwdCounter] != special_chars[charListCounter])
                {
                    // Set boolean to false
                    hasSpec = false;

                    // Set criteria text to invalid color
                    spec_char_txt.style.color = criteria_not_met;

                    // Log criteria invalidation
                    console.log(`${new_password.value[charListCounter]} is not a special character.`);
                }

                // If that character is a special character
                else if(new_password.value[newPwdCounter] == special_chars[charListCounter])
                {
                    // Set boolean to true
                    hasSpec = true;

                    // Set criteria text to valid color
                    spec_char_txt.style.color = criteria_met;

                    // Log criteria validation
                    console.log(`${new_password.value[newPwdCounter]} is a special character.`);

                    // Leave function
                    return;
                }
            }
        }
    }
}

// Function to check if both new passwords are identical
function NewPasswordsIdentityCheck()
{
    // If repeat new password has at least 1 character
    if(repeat_new_password.value.length > 0)
    {
        // If new passwords are not identical   
        if(new_password.value != repeat_new_password.value)
        {
            // Set boolean to false
            arePwdsIdentical = false;

            // Write "Passwords are not identical"
            pwds_identity_txt.innerHTML = "<p>Passwords are not identical.</p>";

            // Set text to invalid color
            pwds_identity_txt.style.color = criteria_not_met;

            // Log that new passwords are different
            console.log(`${new_password.value} and ${repeat_new_password.value} are not identical.`);
        }

        // If new passwords are identical   
        else if(new_password.value == repeat_new_password.value)
        {
            // Set boolean to true
            arePwdsIdentical = true;

            // Write "Passwords are identical"
            pwds_identity_txt.innerHTML = "<p>Passwords are identical.</p>";

            // Set text to valid color
            pwds_identity_txt.style.color = criteria_met;

            // Log that new passwords are identical
            console.log(`${new_password.value} and ${repeat_new_password.value} are identical.`);
        }
    }

    // If repeat new password has less than 1 character
    else if(repeat_new_password.value.length < 1)
    {
        // Erase passwords identity text
        pwds_identity_txt.textContent = "";
    }
}

// Function to check all new password criterias
function CheckAllNewPasswordCriterias()
{
    // If new password has at least 1 character
    if(new_password.value.length > 0)
    {
        // Log new password
        console.log(`New password == ${new_password.value}.`);

        // Check all criterias
        NewPasswordLengthCheck();
        NewPasswordUpperCheck();
        NewPasswordLowerCheck();
        NewPasswordNumCheck();
        NewPasswordSpecCheck();
        NewPasswordsIdentityCheck();

        console.log(`old_pwd_owner_txt.textContent == ${old_pwd_owner_txt.textContent}.`);

        // If old password is owned by user and new password meets all criterias and both new passwords are identical
        if(old_pwd_owner_txt.textContent == "Password is yours." && isLong && hasUpper && hasLower && hasNumber && hasSpec && arePwdsIdentical)
        {
            // Activate Edit button
            edit_btn.disabled = false;

            // Log that password can be changed
            console.log("All criterias met, password can be changed.");
        }

        // If either old password is not owned by user or new password does not meet at least one criteria or both new passwords are not identical
        else if(old_pwd_owner_txt.textContent != "Password is yours." || !isLong || !hasUpper || !hasLower || !hasNumber || !hasSpec || !arePwdsIdentical)
        {
            // Deactivate Edit button
            edit_btn.disabled = true;

            // Log that password cannot be changed
            console.log("At least one criteria not met, password cannot be changed.");
        }
    }
}

// Function of the Cancel button
function ResetValues()
{
    // Set all booleans to false
    isLong = false;
    hasUpper = false;
    hasLower = false;
    hasNumber = false;
    hasSpec = false;
    arePwdsIdentical = false;

    // Deactivate Edit button
    edit_btn.disabled = true;

    // Reset all texts  
    old_pwd_owner_txt.textContent = "";
    new_pwd_length.style.color = "black";
    upp_txt.style.color = "black";
    lower_txt.style.color = "black";
    num_txt.style.color = "black";
    spec_char_txt.style.color = "black";
    pwds_idenity_txt.textContent = "";
}