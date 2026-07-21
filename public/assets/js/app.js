document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");

    const overlay = document.getElementById("sidebarOverlay");

    const toggle = document.getElementById("toggleSidebar");


    if (toggle && sidebar) {

        toggle.addEventListener("click", function () {

            if (window.innerWidth >= 992) {

                document.body.classList.toggle(
                    "sidebar-collapsed"
                );

            } else {

                sidebar.classList.toggle("show");

                if (overlay) {

                    overlay.classList.toggle("show");

                }

            }

        });

    }


    if (overlay && sidebar) {

        overlay.addEventListener("click", function () {

            sidebar.classList.remove("show");

            overlay.classList.remove("show");

        });

    }

});