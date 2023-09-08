const desktopMenu = document.getElementById("desktopMenu");
const menuTitle = document.getElementById("menuTitle");
const menuIcon = document.getElementById("desktopMenuIcon");
const iconCentralBar = document.getElementById("centralBar");
const menuItems = document.getElementById("menuItems");

let isMenuExpanded = false;
let isMenuHovered = false;

menuIcon.addEventListener("click", () => {
    isMenuExpanded = !isMenuExpanded;
    updateMenuState();
    toggleClass(desktopMenu, isMenuExpanded);
});

desktopMenu.addEventListener("mouseenter", () => {
    if (!isMenuExpanded) {
        isMenuHovered = true;
        desktopMenu.classList.add("active");
        updateMenuState();
    }
});

desktopMenu.addEventListener("mouseleave", () => {
    isMenuHovered = false;
    if (!isMenuExpanded) {
        desktopMenu.classList.remove("active");
        updateMenuState();
    }
});

function toggleClass(element, condition) {
    element.classList.toggle("active", condition);
}

function updateMenuState() {
    toggleClass(menuIcon, isMenuExpanded);
    toggleClass(iconCentralBar, isMenuExpanded);

    if(isMenuExpanded || isMenuHovered){
        setTimeout(() => {
            toggleClass(menuTitle, isMenuExpanded || isMenuHovered);
            toggleClass(menuItems, isMenuExpanded || isMenuHovered);
        }, 250);
    } else {
        toggleClass(menuTitle, isMenuExpanded || isMenuHovered);
        toggleClass(menuItems, isMenuExpanded || isMenuHovered);
    }
}
