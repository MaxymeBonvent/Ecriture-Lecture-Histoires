//  --- USERNAME ----
let user_label = document.getElementById("user_label");
let user_input = document.getElementById("username");
let user_existence = document.getElementById("username_existence");
let isUsernameSmall = false;
let doesUsernameExist = true;

// ---- MAIL ----
let mail_input = document.getElementById("mail");
let mail_existence = document.getElementById("mail_existence");
let doesMailExist = true;

// ---- AVATAR ----
// let avatar_txt = document.getElementById("avatar_label");
// let avatar = document.getElementById("avatar");
// let max_avatar_size = Math.pow(10, 7); // 10^7 octets = 10 000 000  octets = 10 Mo
// let isAvatarSmall = false;

// ---- PASSWORDS ----
// Reference to password
let pwd = document.getElementById("password");
let pwd_counter;

// Reference to password check
let pwd_check = document.getElementById("password_check");
let arePasswordsEqual = false;

// ---- PASSWORD LENGTH  ----
let password_char_num = document.getElementById("pwd_char_num");
let hasPasswordEnoughChars = false;

// Password Equality Text variable
let pwd_equal_txt = document.getElementById("pwd_equal_txt");

// ---- CRITERIAS ----
// Criteria not met color
let criteria_not_met = "rgb(110, 0, 0)";

// Criteria met color
let criteria_met = "rgb(0, 120, 0)";

// ---- LOWERCASE ----
// lowercase letter text
let lowercase = document.getElementById("one_lower");
let hasLowercase = false;

// Lowercase letters array
let lowercase_letters = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
let lowercounter;

// ---- UPPERCASE ----
// uppercase letter text
let uppercase = document.getElementById("one_upper");
let hasUppercase = false;

// Uppercase letters array
let uppercase_letters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
let uppercounter;

// ---- SPECIAL ----
// special character
let special = document.getElementById("one_special");
let hasSpecial = false;

// Special characters array
let special_chars = ["&", "~", "#", "'", "{", "}", "(", ")", "[", "]", "-", "|", "`", "_", "\\", "/", "^", "@", "°", "=", "+", "-", "*", "?", "!", ",", ";", ".", "§", "ù", "$", "£", "¤", "µ", "%"];
let special_counter;

// ---- NUMBER ----
// Number text
let number = document.getElementById("one_num");
let number_counter;

// Number array
let numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
let hasNumber = false;

// ---- SUBMIT INPUT  ----
// Reference to Submit Input
let sub = document.getElementById("submit_btn");

// Deactivate Submit Input
sub.disabled = true;

// ---- FUNCTIONS ----

// Function to check username length and existence
function UsernameCheck()
{
    // ---- LENGTH ----

    // If the username is more than 20 characters
    if(user_input.value.length > 20)
    {
        // Set isUsernameSmall to false
        isUsernameSmall = false;
        console.log(`isUsernameSmall == ${isUsernameSmall}.`);

        // Change Username label to red
        user_label.style.color = criteria_not_met;
    }

    // If the username is less than or equal 20 characters
    else
    {
        // Set isUsernameSmall to true
        isUsernameSmall = true;
        console.log(`isUsernameSmall == ${isUsernameSmall}.`);

        // Change Username label to black
        user_label.style.color = "black";
    }

    // ---- EXISTENCE ----

    // If there's less than 1 character in the username field
    if(user_input.value.length < 1)
    {
        // Set doesUsernameExist to true (to make sure the Submit Input will be closed)
        doesUsernameExist = true;
        console.log(`doesUsernameExist == ${doesUsernameExist}.`);

        // Erase availability text
        user_existence.innerText = "";
    }

    // If there's at least 1 character in the username field
    else
    {
        // XMLHttpRequest Object
        let xhr = new XMLHttpRequest();

        // Open the PHP script
        xhr.open("GET", "username_existence_check.php?username=" + user_input.value, true);

        // Callback function
        xhr.onreadystatechange = function()
        {
            // If request is done
            if(xhr.readyState === XMLHttpRequest.DONE)
            {
                // Confirm request is done
                console.log("Username check request done.");

                // If status is 200
                if(xhr.status == 200)
                {
                    // Confirm request is done
                    console.log(`xhr.status == ${xhr.status}.`);

                    // Response
                    let response = xhr.responseText; // If correct, anything after "echo" in the PHP script is the response

                    // If number of identical usernames is undefined
                    if(response == undefined)
                    {
                        // Confirm it
                        console.log(`response == ${response}.`);
                    }

                    // If the number of identical usernames is defined and there's at least 1 identical username
                    else if(response != undefined && response > 0)
                    {
                        // Set doesUsernameExist to true
                        doesUsernameExist = true;
                        console.log(`doesUsernameExist == ${doesUsernameExist}.`);

                        // Tell it to the user
                        user_existence.innerText = "Username unavailable.";
                        user_existence.style.color = criteria_not_met;
                    }

                    // If the username is unique
                    else if(response != undefined && response < 1)
                    {
                        // Set doesUsernameExist to false
                        doesUsernameExist = false;
                        console.log(`doesUsernameExist == ${doesUsernameExist}.`);

                        // Tell it to the user
                        user_existence.innerText = "Username available.";
                        user_existence.style.color = criteria_met;
                    }
                }
            }
        }

        // Send request
        xhr.send();
    }
}

// Function to check if mail already exists
function MailExistenceCheck()
{
    // Function call confirmation message
    console.log("MailExistenceCheck() called.");

    // If there's less than 1 character in the mail field
    if(mail_input.value.length < 1)
    {
        // Set doesMailExist to true (to make sure the Submit Input will be closed)
        doesMailExist = true;
        console.log(`doesMailExist == ${doesMailExist}.`);

        // Erase availability text
        mail_existence.innerText = "";
    }

    // If there's at least 1 character in the mail field
    else
    {
        // XMLHttpRequest Object
        let xhr = new XMLHttpRequest();

        // Open the PHP script
        xhr.open("GET", "mail_existence_check.php?mail=" + mail_input.value, true);

        // Callback function
        xhr.onreadystatechange = function()
        {
            // If request is done
            if(xhr.readyState === XMLHttpRequest.DONE)
            {
                // Confirm request is done
                console.log("Mail check request done.");

                // If status is 200
                if(xhr.status == 200)
                {
                    // Confirm request is done
                    console.log(`xhr.status == ${xhr.status}.`);

                    // Response
                    let response = xhr.responseText; // If correct, anything after "echo" in the PHP script is the response

                    // If the number of identical mails is defined and there's at least 1 identical mail
                    if(response > 0)
                    {
                        // Set doesMailExist to true
                        doesMailExist = true;
                        console.log(`doesMailExist == ${doesMailExist}.`);

                        // Tell it to the user
                        mail_existence.innerText = "Mail unavailable.";
                        mail_existence.style.color = criteria_not_met;
                    }

                    // If the mail is unique
                    else if(response < 1)
                    {
                        // Set doesMailExist to false
                        doesMailExist = false;
                        console.log(`doesMailExist == ${doesMailExist}.`);

                        // Tell it to the user
                        mail_existence.innerText = "Mail available.";
                        mail_existence.style.color = criteria_met;
                    }
                }
            }
        }

        // Send request
        xhr.send();
    }
}

// Function to check password length
function PasswordLengthCheck()
{
    // If the password is less than 12 characters long
    if(pwd.value.length < 12)
    {
        // Switch hasPasswordEnoughChars to false
        hasPasswordEnoughChars = false;
        console.log(`hasPasswordEnoughChars == ${hasPasswordEnoughChars}.`);

        // The character quantity text turns red
        password_char_num.style.color = criteria_not_met;
    }

    // If the password is less at least 12 characters long
    else if(pwd.value.length >= 12)
    {
        // Switch hasPasswordEnoughChars to true
        hasPasswordEnoughChars = true;
        console.log(`hasPasswordEnoughChars == ${hasPasswordEnoughChars}.`);

        // The character quantity text turns green
        password_char_num.style.color = criteria_met;
    }
}

// Function to check if the password has at least 1 lowercase letter
function LowercaseCheck()
{
    // If the password is empty
    if(pwd.value.length < 1)
    {
        // Switch hasLowercase to false
        hasLowercase = false;
        console.log(`hasLowercase == ${hasLowercase}.`);

        // The lowercase letter text turns red
        lowercase.style.color = criteria_not_met;
    }

    // If the password is not empty
    else
    {
        // For every lowercase letter
        for(lowercounter = 0; lowercounter < lowercase_letters.length; lowercounter++)
        {
            // For every character in the password
            for(pwd_counter = 0; pwd_counter < pwd.value.length; pwd_counter++)
            {
                // If the character in the password is a lowercase letter
                if(pwd.value[pwd_counter] == lowercase_letters[lowercounter])
                {
                    // Switch hasLowercase to true
                    hasLowercase = true;
                    console.log(`hasLowercase == ${hasLowercase}.`);

                    // The lowercase letter text turns green
                    lowercase.style.color = criteria_met;

                    // Leave function
                    return;
                }

                // If the character in the password is not a lowercase letter
                else if(pwd.value[pwd_counter] != lowercase_letters[lowercounter])
                {
                    // Switch hasLowercase to false
                    hasLowercase = false;
                    console.log(`hasLowercase == ${hasLowercase}.`);

                    // The lowercase letter text turns red
                    lowercase.style.color = criteria_not_met;
                }
            }
        }
    }
}

// Function to check if the password has at least 1 uppercase letter
function UppercaseCheck()
{
    // If password is empty
    if(pwd.value.length < 1)
    {
        // Switch hasUppercase to false
        hasUppercase = false;
        console.log(`hasUppercase == ${hasUppercase}.`);

        // The uppercase letter text turns red
        uppercase.style.color = criteria_not_met;
    }

    // If the password is not empty
    else
    {
        // For every uppercase letter
        for(uppercounter = 0; uppercounter < uppercase_letters.length; uppercounter++)
        {
            // For every character in the password
            for(pwd_counter = 0; pwd_counter < pwd.value.length; pwd_counter++)
            {
                // If the character in the password is an uppercase letter
                if(pwd.value[pwd_counter] == uppercase_letters[uppercounter])
                {
                    // Switch hasUppercase to true
                    hasUppercase = true;
                    console.log(`hasUppercase == ${hasUppercase}.`);

                    // The uppercase letter text turns green
                    uppercase.style.color = criteria_met;

                    // Leave function
                    return;
                }

                // If the character in the password is not an uppercase letter
                else if(pwd.value[pwd_counter] != uppercase_letters[uppercounter])
                {
                    // Switch hasUppercase to false
                    hasUppercase = false;
                    console.log(`hasUppercase == ${hasUppercase}.`);

                    // The uppercase letter text turns red
                    uppercase.style.color = criteria_not_met;
                }
            }
        }
    }
}

// Function to check if the password contains at least 1 special characters
function SpecialCharsCheck()
{
    // If the password is empty
    if(pwd.value.length < 1)
    {
        // Set hasSpecial to false
        hasSpecial = false;
        console.log(`hasSpecial == ${hasSpecial}.`);

        // Turn special character text to red
        special.style.color = criteria_not_met;
    }

    // If the password is not empty
    else
    {
        // For every special character
        for(special_counter = 0; special_counter < special_chars.length; special_counter++)
        {
            // For every password character
            for(pwd_counter = 0; pwd_counter < pwd.value.length; pwd_counter++)
            {
                // If the character is special
                if(pwd.value[pwd_counter] == special_chars[special_counter])
                {
                    // Set hasSpecial to true
                    hasSpecial = true;
                    console.log(`hasSpecial == ${hasSpecial}.`);

                    // Change special text to green
                    special.style.color = criteria_met;

                    // Leave function
                    return;
                }

                // If the character is not special
                else if(pwd.value[pwd_counter] != special_chars[special_counter])
                {
                    // Set hasSpecial to false
                    hasSpecial = false;
                    console.log(`hasSpecial == ${hasSpecial}.`);

                    // Change special text to red
                    special.style.color = criteria_not_met;
                }
            }
        }
    }
}

// Function to check if the password contains at least 1 number
function NumberCheck()
{
    // If the password is empty
    if(pwd.value.length < 1)
    {
        // Set hasNumber to false
        hasNumber = false;
        console.log(`hasNumber == ${hasNumber}.`);

        // Change number criteria text to red
        number.style.color = criteria_not_met;
    }

    // If the password is not empty
    else
    {
        // For every number
        for(number_counter = 0; number_counter < numbers.length; number_counter++)
        {
            // For every password character
            for(pwd_counter = 0; pwd_counter < pwd.value.length; pwd_counter++)
            {
                // If the character is a number
                if(pwd.value[pwd_counter] == numbers[number_counter])
                {
                    // Set hasNumber to true
                    hasNumber = true;
                    console.log(`hasNumber == ${hasNumber}.`);

                    // Change number criteria text to green
                    number.style.color = criteria_met;

                    // Leave function
                    return;
                }

                // If the character is a not number
                else if(pwd.value[pwd_counter] != numbers[number_counter])
                {
                    // Set hasNumber to false
                    hasNumber = false;
                    console.log(`hasNumber == ${hasNumber}.`);

                    // Change number criteria text to red
                    number.style.color = criteria_not_met;
                }
            }
        }
    }
}

// Function to check if both passwords are equal
function PasswordsEqualityCheck()
{
    // If password is empty
    if(pwd.value.length < 1)
    {
        // Erase password equality text
        pwd_equal_txt.innerHTML = "";
    }

    // If password is not empty and passwords are equal
    else if(pwd.value.length > 0 && pwd.value == pwd_check.value)
    {
        // Set arePasswordsEqual to true
        arePasswordsEqual = true;
        console.log(`arePasswordsEqual == ${arePasswordsEqual}.`);

        // Tell user the passwords are equal
        pwd_equal_txt.innerText = "Passwords are equal.";
        pwd_equal_txt.style.color = criteria_met;
    }

    // If passwords are not equal 
    else
    {
        // Set arePasswordsEqual to false
        arePasswordsEqual = false;
        console.log(`arePasswordsEqual == ${arePasswordsEqual}.`);

        // Tell user the passwords are not equal
        pwd_equal_txt.innerText = "Passwords are different.";
        pwd_equal_txt.style.color = criteria_not_met;
    }
}

// Function to check every password criteria
function AllPasswordCriteriasCheck()
{
    // Check each criteria
    PasswordLengthCheck();
    LowercaseCheck();
    UppercaseCheck();
    SpecialCharsCheck();
    NumberCheck();
    PasswordsEqualityCheck();

    // If every criteria is met
    if(isUsernameSmall && !doesUsernameExist && !doesMailExist && hasPasswordEnoughChars && hasLowercase && hasUppercase && hasSpecial && hasNumber && arePasswordsEqual)
    {
        // Confirm that all criterias are met
        console.log("All criterias met.");

        // Reactivate Submit Input
        sub.disabled = false;
    }
}