const mobileMenu = document.getElementById("mobileMenu");
const menuTitle = document.getElementById("mobileMenuTitle");
const menuIcon = document.getElementById("mobileMenuIcon");
const iconCentralBar = document.getElementById("mobileMenuBar");
const menuItems = document.getElementById("desktopMenuItems");


let isMenuExpanded = false;

menuIcon.addEventListener("click", () => {
    isMenuExpanded = !isMenuExpanded;
    updateMenuState();
    toggleClass(mobileMenu, isMenuExpanded);
});

function toggleClass(element, condition) {
    element.classList.toggle("active", condition);
}

function updateMenuState() {
    toggleClass(menuIcon, isMenuExpanded);
    toggleClass(iconCentralBar, isMenuExpanded);

    if(isMenuExpanded){
        setTimeout(() => {
            toggleClass(menuTitle, isMenuExpanded);
            toggleClass(menuItems, isMenuExpanded);
        }, 250);
    } else {
        toggleClass(menuTitle, isMenuExpanded);
        toggleClass(menuItems, isMenuExpanded);
    }
}

// Selecione todas as tags <a> dentro do mobileMenu
const menuLinks = mobileMenu.querySelectorAll('h2');

// Função para fechar o menu
function closeMenu() {
    isMenuExpanded = false;
    updateMenuState();
    toggleClass(mobileMenu, isMenuExpanded);
}

// Adicione ouvinte de evento de clique para cada tag <a>
menuLinks.forEach(link => {
    link.addEventListener('click', closeMenu);
});