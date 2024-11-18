    // Predefined credentials
    const validUsername = "Dammy Larey";
    const validPassword = "Oreoluwa01";

    function login() {
        // Get input values
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Message container
        const message = document.getElementById('message');

        // Validate credentials
        if (username === validUsername && password === validPassword) {
            message.style.color = "green";
            message.textContent = "Login successful! Redirecting...";
            setTimeout(() => {
                // Redirect to the dashboard or another page
                window.location.href = "dashboard.html";
            }, 1500);
        } else {
            message.style.color = "red";
            message.textContent = "Invalid username or password. Try again.";
        }
    }