<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!--<meta name="robots" content="noindex, nofollow">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">

          
      <link rel="icon" href="assets/images/logo/favicon.ico" sizes="32x32" />
      <link rel="icon" href="assets/images/logo/favicon.ico" sizes="192x192" />
      <link rel="apple-touch-icon" href="assets/images/logo/favicon.ico" />
    <title>
        <?php if(!empty($title)){echo $title;}else{echo 'ASH';} ?>
    </title>
    <meta name="description" content="<?php if(!empty($description)){echo $description;} else{echo 'Apollo Sage Hospitals';} ?>">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link rel="canonical" href="<?php $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; echo $url; ?>">
   
    <link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheet/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheet/plugins/flatpickr.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheet/common.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheet/login.css">
</head>
<body>
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
<!--loader end-->
<div class="layout">
    <div class="layout-container">