import './bootstrap';

// Dark/Light Mode Toggle
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    
    // Get saved theme or default to dark
    const savedTheme = localStorage.getItem('theme') || 'dark';
    htmlElement.classList.toggle('dark', savedTheme === 'dark');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isDark = htmlElement.classList.contains('dark');
            
            if (isDark) {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // Mobile Menu Toggle - Versão Simplificada
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        let isOpen = false;
        
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            isOpen = !isOpen;
            
            // Toggle menu
            mobileMenu.classList.toggle('hidden', !isOpen);
            
            // Animar botão hamburger
            mobileMenuToggle.classList.toggle('menu-open', isOpen);
        });

        // Fechar ao clicar num link
        const mobileMenuLinks = mobileMenu.querySelectorAll('a, button[type="submit"]');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                isOpen = false;
                mobileMenu.classList.add('hidden');
                mobileMenuToggle.classList.remove('menu-open');
            });
        });

        // Fechar ao clicar fora
        document.addEventListener('click', function(e) {
            if (isOpen && !mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                isOpen = false;
                mobileMenu.classList.add('hidden');
                mobileMenuToggle.classList.remove('menu-open');
            }
        });
    }
});
