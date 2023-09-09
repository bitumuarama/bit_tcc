document.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.getElementById("toggleMobileMenu");
    const list = document.getElementById("lista-items");

    checkbox.addEventListener("change", () => {
        console.log("changed");
        if (checkbox.checked) {
            list.classList.add("active");
        } else {
            list.classList.remove("active");
        }
    });
});
