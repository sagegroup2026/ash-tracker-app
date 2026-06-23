    <!-- loader -->
    <!-- Global Loader -->
<div id="globalLoader" class="loader-overlay">
    <div class="loader-box">
        <img src="https://apollosage.in/assets/images/logo-ash.png" alt="Loading">
        <p>Please wait...</p>
    </div>
</div>
<style>
    .loader-overlay{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(255,255,255,0.95);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:999999;
    visibility:hidden;
    opacity:0;
    transition:.3s;
}

.loader-overlay.show{
    visibility:visible;
    opacity:1;
}

.loader-box{
    text-align:center;
}

.loader-box img{
    width:80px;
    animation: pulse 1.5s infinite;
}

.loader-box p{
    margin-top:15px;
    font-size:16px;
    color:var(--blue);
    font-weight:600;
}

@keyframes pulse{
    0%{transform:scale(1);}
    50%{transform:scale(1.1);}
    100%{transform:scale(1);}
}
</style>
<script>

/* =========================================================
   GLOBAL LOADER SCRIPT
   Handles:
   1. Initial page loading
   2. Form submission
   3. AJAX requests (jQuery)
   4. Internal page navigation
========================================================= */

(function () {

    /* ==========================================
       Show Loader
    ========================================== */
    window.showLoader = function () {

        const loader = document.getElementById('globalLoader');

        if (loader) {
            loader.classList.add('show');
        }

    };

    /* ==========================================
       Hide Loader
    ========================================== */
    window.hideLoader = function () {

        const loader = document.getElementById('globalLoader');

        if (loader) {
            loader.classList.remove('show');
        }

    };

    /* ==========================================
       Show Loader Immediately
       (Page Loading Start)
    ========================================== */
    showLoader();

    /* ==========================================
       Hide Loader When Full Page Loaded
    ========================================== */
    window.addEventListener('load', function () {

        hideLoader();

    });

    document.addEventListener('DOMContentLoaded', function () {

        /* ==========================================
           Show Loader On All Form Submissions
        ========================================== */
        document.querySelectorAll('form').forEach(function (form) {

            form.addEventListener('submit', function () {

                showLoader();

            });

        });

        /* ==========================================
           Show Loader On Internal Link Click
        ========================================== */
        document.querySelectorAll('a').forEach(function (link) {

            link.addEventListener('click', function () {

                const href = this.getAttribute('href');

                if (
                    href &&
                    href !== '#' &&
                    !href.startsWith('javascript:') &&
                    !href.startsWith('tel:') &&
                    !href.startsWith('mailto:') &&
                    !this.hasAttribute('target')
                ) {
                    showLoader();
                }

            });

        });

    });

    /* ==========================================
       jQuery AJAX Support
    ========================================== */
    if (typeof jQuery !== 'undefined') {

        $(document).ajaxStart(function () {

            showLoader();

        });

        $(document).ajaxStop(function () {

            hideLoader();

        });

    }

})();
</script>