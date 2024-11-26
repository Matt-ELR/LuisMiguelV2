// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // Get the logout button element
    const logoutButton = document.querySelector(".logout-button");

    if (logoutButton) {
        // Add a click event listener
        logoutButton.addEventListener("click", (event) => {
            // Display a confirmation dialog
            const userConfirmed = confirm("¿Estás seguro de que deseas cerrar sesión?");
            // If the user cancels, prevent the default action
            if (!userConfirmed) {
                event.preventDefault();
            }
        });
    }
});
