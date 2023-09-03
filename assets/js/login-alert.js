// Seletor dos elementos
const loginAlert = document.querySelector(".login-alert");
const mensagem = document.querySelector(".mensagem");
const barra = document.querySelector(".barra");

// Variáveis de controle
let isAlertWarn = false;

// Iniciar a animação da barra
function startBarAnimation() {
    setTimeout(() => {
        barra.style.width = "0";
    }, 0);
}

// Ocultar a mensagem
function hideMessage() {
    mensagem.style.display = "none";
}

// Carregamento da página
window.addEventListener("load", () => {
    isAlertWarn = true;
    loginAlert.classList.add("slide-in");
    startBarAnimation();

    // Obter a duração da animação da barra
    const duracaoAnimacao = parseFloat(getComputedStyle(barra).getPropertyValue("transition-duration")) * 1000;

    // Ocultar a mensagem após a animação da barra
    setTimeout(() => { hideMessage(); isAlertWarn = false; }, duracaoAnimacao);
});

// Eventos de hover do alerta
loginAlert.addEventListener("mouseenter", () => {
    if (!isAlertWarn) {
        loginAlert.classList.add("hovered");
        mensagem.style.display = "flex";
    }
});

loginAlert.addEventListener("mouseleave", () => {
    if (!isAlertWarn) {
        loginAlert.classList.remove("hovered");
        hideMessage();
    }
});
