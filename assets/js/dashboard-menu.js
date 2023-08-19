const menu = document.getElementById("menu");
const menuTitle = document.getElementById("menuTitle");
const menuIcon = document.getElementById("menuIcon");
const iconCentralBar = document.getElementById("centralBar");
const menuItems = document.getElementById("menuItems");

let isMenuExpanded = false;
let isMenuHovered = false;

menuIcon.addEventListener("click", () => {
    isMenuExpanded = !isMenuExpanded;
    updateMenuState();
    toggleClass(menu, isMenuExpanded);
});

menu.addEventListener("mouseenter", () => {
    if (!isMenuExpanded) {
        isMenuHovered = true;
        menu.classList.add("active");
        updateMenuState();
    }
});

menu.addEventListener("mouseleave", () => {
    isMenuHovered = false;
    if (!isMenuExpanded) {
        menu.classList.remove("active");
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
        }, 500);
    } else {
        toggleClass(menuTitle, isMenuExpanded || isMenuHovered);
        toggleClass(menuItems, isMenuExpanded || isMenuHovered);
    }
}
