// assets/js/scripts.js

// Example: Show a confirmation popup for delete buttons
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-danger");

    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", function (event) {
            if (!confirm("Are you sure you want to delete this item?")) {
                event.preventDefault();
            }
        });
    });
});

// Example: Auto-hide success alerts after 5 seconds
setTimeout(() => {
    let alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = 0;
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
