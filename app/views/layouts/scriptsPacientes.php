<script>
        const toggle = document.getElementById("header-menu");
        const sidebar = document.getElementById("sidebar");
        const icon = toggle.querySelector("i");

        toggle.addEventListener("click", () => {
            const isMobile = window.innerWidth <= 900;

            if (isMobile) {
                sidebar.classList.toggle("show");
                if (sidebar.classList.contains("show")) {
                    icon.classList.replace("fa-bars", "fa-xmark");
                } else {
                    icon.classList.replace("fa-xmark", "fa-bars");
                }
            } else {
                // En escritorio simplemente quitamos/ponemos hide.
                // Como empieza con hide, el primer clic lo remueve y expande el menú flotante.
                sidebar.classList.toggle("hide");

                if (sidebar.classList.contains("hide")) {
                    icon.classList.replace("fa-xmark", "fa-bars");
                } else {
                    icon.classList.replace("fa-bars", "fa-xmark");
                }
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 900) {
                sidebar.classList.remove("show"); // Resetea móvil
                sidebar.classList.add("hide");    // Vuelve a cerrado por defecto en desktop
                icon.classList.replace("fa-xmark", "fa-bars");
            }
        });
    </script>