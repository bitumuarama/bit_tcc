// Selecione todos os elementos textarea e input
const allInputs = document.querySelectorAll('textarea, input');

allInputs.forEach(inputElement => {
    // Se o elemento for um textarea ou input de tipo texto
    if (inputElement.tagName === 'TEXTAREA' || inputElement.type === 'text') {
        const charCount = inputElement.parentElement.querySelector('.char-count');
        const maxChars = 255;

        // Contador de caracteres (somente para textarea)
        if (inputElement.tagName === 'TEXTAREA') {
            inputElement.addEventListener('input', function () {
                const remainingChars = maxChars - inputElement.value.length;
                charCount.textContent = `(${remainingChars} caracteres restantes)`;

                if (remainingChars < 0) {
                    inputElement.value = inputElement.value.substring(0, maxChars);
                    charCount.textContent = 'Limite de caracteres atingido';
                }
            });
        }

        // Evento tecla ESC
        inputElement.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                inputElement.value = '';
                if (charCount) {
                    charCount.textContent = `(${maxChars} caracteres restantes)`;
                }
            }
        });
    }

    // Se o elemento for um input de tipo numérico
    else if (inputElement.type === 'number') {
        inputElement.addEventListener('input', function () {
            if (isNaN(inputElement.value)) {
                inputElement.value = '';
            }
        });

        // Evento tecla ESC
        inputElement.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                inputElement.value = '';
            }
        });
    }
});
