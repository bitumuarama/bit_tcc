const mobileMenu = document.getElementById("mobileMenu");
const menuTitle = document.getElementById("mobileMenuTitle");
const menuIcon = document.getElementById("mobileMenuIcon");
const iconCentralBar = document.getElementById("mobileMenuBar");
const menuItems = document.getElementById("desktopMenuItems");

let isMenuExpanded = false;
let isMenuHovered = false;

menuIcon.addEventListener("click", () => {
    isMenuExpanded = !isMenuExpanded;
    updateMenuState();
    toggleClass(mobileMenu, isMenuExpanded);
});

mobileMenu.addEventListener("mouseenter", () => {
    if (!isMenuExpanded) {
        isMenuHovered = true;
        mobileMenu.classList.add("active");
        updateMenuState();
    }
});

mobileMenu.addEventListener("mouseleave", () => {
    isMenuHovered = false;
    if (!isMenuExpanded) {
        mobileMenu.classList.remove("active");
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
