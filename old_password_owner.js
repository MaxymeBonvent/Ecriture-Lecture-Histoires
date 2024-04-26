// OLD PASSWORD INPUT
let old_password = document.getElementById("old_password");

// OLD PASSWORD OWNER TEXT
let old_pwd_owner_txt = document.getElementById("old_pwd_owner_txt");

// Function to check if inputed old password does belong to logged in user
function CheckOldPasswordOwner()
{
    // Log typed old password
    console.log(`Old password == ${old_password.value}.`);

    // If there's at least 1 character
    if(old_password.value.length > 0)
    {
        // AJAX
        xhr = new XMLHttpRequest();

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Log that request is done
                console.log("Old password owner check request done.");

                // Redirect user to PHP script that checks if password is theirs
                // window.location.href = `old_password_owner.php?old_password=${old_password.value}`;

                // Tell user if password is theirs or not
                old_pwd_owner_txt.innerHTML = xhr.responseText;
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Log error
            console.log(`Error during old password owner check request : ${xhr.status}.`);
        }

        // Send request
        xhr.open("GET", `old_password_owner.php?old_password=${old_password.value}`, true);
        xhr.send();
    }

    // If there's no character to evaluate
    else if(old_password.value.length < 1)
    {
        // Erase old password owner text
        old_pwd_owner_txt.textContent = "";
    }
}