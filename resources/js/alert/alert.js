function customAlert(type = 'info', message = '') {
    const bgColors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500',
    };

    // Créer ou récupérer le conteneur global
    let container = document.getElementById('custom-alert-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-alert-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-4 flex flex-col items-end';
        document.body.appendChild(container);
    }

    // Créer l'alerte
    const alert = document.createElement('div');
    alert.className = `
        relative text-white px-4 py-2 rounded-xl shadow-lg w-72 flex items-center justify-between
        transition-opacity duration-300 ease-in-out opacity-0 
    `;

    alert.innerHTML = `
              <div class="${bgColors[type] || bgColors.info} w-2 absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

        <div class="flex-1 pl-4 pr-2">
            <p class="text-black">${message}</p>
        </div>
        <div class="text-right">
            <button class="text-black hover:text-gray-300 text-lg font-bold" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;

    container.appendChild(alert);

    // Lancer la transition (opacity: 1)
    setTimeout(() => {
        alert.classList.remove('opacity-0');
    }, 10);

    // Auto suppression
    setTimeout(() => {
        alert.classList.add('opacity-0');
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

window.customAlert = customAlert;
