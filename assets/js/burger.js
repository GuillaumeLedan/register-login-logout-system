document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById("menu-toggle");
    const menuClose = document.getElementById("menu-close");
    const navContent = document.getElementById("nav-content");
    const navLinks = document.querySelectorAll(".nav-list a");  // Sélectionner tous les liens dans .nav-list
    const body = document.body;  // Référence à l'élément body

    // Fonction pour fermer le menu
    function closeMenu() {
        document.documentElement.classList.remove("no-scroll");
        if (navContent) {
            navContent.classList.remove("fullscreen");
        }
        if (menuClose) {
            menuClose.style.display = "none";  // Cacher le bouton de fermeture
        }
        body.classList.remove("no-scroll");  // Réactiver le défilement
    }

    if (menuToggle) {
        menuToggle.addEventListener("click", function() {
            document.documentElement.classList.add("no-scroll");
            if (navContent) {
                navContent.classList.add("fullscreen");
            }
            if (menuClose) {
                menuClose.style.display = "block";  // Afficher le bouton de fermeture
            }
            body.classList.add("no-scroll");  // Désactiver le défilement
        });
    }

    if (menuClose) {
        menuClose.addEventListener("click", closeMenu);
    }

    // Fermer le menu lorsque l'un des liens est cliqué
    if (navLinks.length > 0) {
        navLinks.forEach((link) => {
            link.addEventListener("click", closeMenu);
        });
    }
});