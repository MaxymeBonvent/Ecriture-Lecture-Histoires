// Function to call a PHP script that deletes user's chapters, stories, and account
function DeleteAccount(user_id)
{
    // ---- START ---- //

    // Confirm user ID obtention
    console.log(`User ID == ${user_id}.`);

    // Ask user if they really want to delete their account and store their answer
    let answer = confirm("WARNING : You're about to DELETE your own account. This operation cannot be undone. Are you sure?");

    // If user clicks OK
    if(answer == true)
    {
        // Request Object
        let xhr = new XMLHttpRequest();

        // ---- END ----

        // Callback function
        xhr.onload = function()
        {
            // If request is done
            if(xhr.status == 200)
            {
                // Confirm request was done
                console.log("Request done.");

                // Redirect user to account deletion confirmation page
                window.location.href = "user_delete_confirm.php";

                // Test redirection
                // window.location.href = "delete_account.php?user_id="+user_id;
            }

            // If request is not done
            else if(xhr.status != 200)
            {
                // Log that request is not done
                console.log("Request not done.");
                console.log(`xhr.status == ${xhr.status}.`);
            }
        }

        // Error handler
        xhr.onerror = function()
        {
            // Show error
            console.log(`Error during AJAX request for account deletion : ${xhr.status}.`);
        }

        // ---- REQUEST ----

        // Open PHP script
        xhr.open("GET", "delete_account.php?user_id="+user_id);

        // Send request
        xhr.send();
    }
}