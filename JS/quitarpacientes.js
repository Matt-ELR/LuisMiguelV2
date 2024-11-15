document.addEventListener("DOMContentLoaded", function() {
    const removeButtons = document.querySelectorAll('.remove-button');

    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pacienteId = this.getAttribute('data-paciente-id');

            // First confirmation
            if (confirm("¿Estás seguro de que deseas eliminar este paciente?")) {
                // Second confirmation
                if (confirm("Esta acción no se puede deshacer. ¿Estás seguro?")) {
                    // Final confirmation
                    if (confirm("Por favor, confirma una vez más que deseas eliminar este paciente.")) {
                        // Redirect to the PHP processing file
                        window.location.href = `../0-php/quitarpaciente.php?paciente_id=${pacienteId}`;
                    }
                }
            }
        });
    });
});