// Ensure the script runs after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // Select the logout button using a more specific selector
    const logoutButton = document.querySelector(".logout-container .logout-button");

    // Check if the logout button exists
    if (logoutButton) {
        console.log("Cargado");
        logoutButton.addEventListener("click", (event) => {
            console.log("Logout button clicked"); // Debug message
            const userConfirmed = confirm("¿Estás seguro de que deseas cerrar sesión?");
            if (!userConfirmed) {
                event.preventDefault();
            }
        });
        
    } else {
        console.error("Logout button not found. Ensure the button has the correct class.");
    }
});

