const menuButton = document.getElementById("menuButton");
const menuItems = document.getElementById("menuItems");
let isMenuExpanded = false;
let isMenuHovered = false;

/* Fixar menu ao clicar no ícone principal */
menuButton.addEventListener("click", () => {
  isMenuExpanded = !isMenuExpanded;
  menuButton.classList.toggle("active", isMenuExpanded);
  menuItems.classList.toggle("menu-expanded", isMenuExpanded);
});

/* Expandir menu ao entrar na área do ícone */
menuButton.addEventListener("mouseenter", () => {
  isMenuHovered = true;
  updateMenuState();
});
/* Minimizar menu ao sair da área do ícone */
menuButton.addEventListener("mouseleave", () => {
  isMenuHovered = false;
  setTimeout(() => {
    updateMenuState();
  }, 500);
});

/* Expandir menu ao entrar na área dos itens */
menuItems.addEventListener("mouseenter", () => {
  isMenuHovered = true;
  updateMenuState();
});

/* Minimizar menu ao sair na área dos itens */
menuItems.addEventListener("mouseleave", () => {
  isMenuHovered = false;
  updateMenuState();
});

/* Função para verificar se o menu deve estar em modo expandido ou minimizado */
function updateMenuState() {
  if (isMenuExpanded || isMenuHovered) {
    menuItems.classList.add("menu-expanded");
  } else {
    menuItems.classList.remove("menu-expanded");
  }
}

// Chamando a função para aplicar o estado inicial
updateMenuState();