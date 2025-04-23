// Theme Management
function setTheme(themeName) {
    document.body.className = themeName;
    localStorage.setItem('theme', themeName);
    
    // Salvar tema na sessão via AJAX
    fetch('save_theme.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ theme: themeName })
    });
}

// Profile Menu
document.querySelector('.profile-trigger').addEventListener('click', e => {
    e.stopPropagation();
    document.querySelector('.profile-menu').classList.toggle('active');
});

document.addEventListener('click', e => {
    const dropdown = document.querySelector('.profile-dropdown');
    const menu = document.querySelector('.profile-menu');
    if (!dropdown.contains(e.target) && menu.classList.contains('active')) {
        menu.classList.remove('active');
    }
});

// Menu Item Hover Effects
document.querySelectorAll('.profile-menu a').forEach(item => {
    item.addEventListener('mouseenter', () => {
        item.style.transform = 'translateX(4px)';
    });
    item.addEventListener('mouseleave', () => {
        item.style.transform = 'translateX(0)';
    });
});

// Submenu Toggle
document.querySelectorAll('.menu-trigger').forEach(trigger => {
    trigger.addEventListener('click', () => {
        const submenu = trigger.nextElementSibling;
        const arrow = trigger.querySelector('.arrow');
        
        // Fecha outros submenus
        document.querySelectorAll('.submenu.active').forEach(menu => {
            if (menu !== submenu) {
                menu.classList.remove('active');
                menu.previousElementSibling.querySelector('.arrow').classList.remove('active');
            }
        });
        
        submenu.classList.toggle('active');
        arrow.classList.toggle('active');
    });
});

// Search Functionality
const searchBar = document.querySelector('.search-bar');
searchBar.addEventListener('input', e => {
    const searchTerm = e.target.value.toLowerCase();
    
    // Implementar lógica de busca aqui
    // Por exemplo, filtrar itens do menu ou conteúdo
});
