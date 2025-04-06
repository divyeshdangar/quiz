(function () {
    "use strict";

    window.onload = function () {
        // Preloader JS
        const getPreloaderId = document.getElementById('preloader');
        if (getPreloaderId) {
            getPreloaderId.style.display = 'none';
        }

        try {
            console.log(message)
            if (message) {
                Swal.fire(message.title, message.description, message.type);
            }
        } catch (err) {}

    };

    try {
        feather.replace();
    } catch (error) {
        console.log(error)
    }

    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Header Burger Button
    const getHeaderBurgerMenuId = document.getElementById('header-burger-menu');
    if (getHeaderBurgerMenuId) {
        const switchtoggle = document.querySelector(".header-burger-menu");
        const savedTheme = localStorage.getItem("splash_sidebar");
        if (savedTheme) {
            document.body.setAttribute("sidebar-data-theme", savedTheme);
        }
        switchtoggle.addEventListener("click", function () {
            if (document.body.getAttribute("sidebar-data-theme") === "sidebar-hide") {
                document.body.setAttribute("sidebar-data-theme", "sidebar-show");
                localStorage.setItem("splash_sidebar", "sidebar-show");
            } else {
                document.body.setAttribute("sidebar-data-theme", "sidebar-hide");
                localStorage.setItem("splash_sidebar", "sidebar-hide");
            }
        });
    }

    // Sidebar Burger Button
    const getSidebarBurgerMenuId = document.getElementById('sidebar-burger-menu');
    if (getSidebarBurgerMenuId) {
        const switchtoggle = document.querySelector(".sidebar-burger-menu");
        const savedTheme = localStorage.getItem("splash_sidebar");
        if (savedTheme) {
            document.body.setAttribute("sidebar-data-theme", savedTheme);
        }
        switchtoggle.addEventListener("click", function () {
            if (document.body.getAttribute("sidebar-data-theme") === "sidebar-hide") {
                document.body.setAttribute("sidebar-data-theme", "sidebar-show");
                localStorage.setItem("splash_sidebar", "sidebar-show");
            } else {
                document.body.setAttribute("sidebar-data-theme", "sidebar-hide");
                localStorage.setItem("splash_sidebar", "sidebar-hide");
            }
        });
    }

})();
