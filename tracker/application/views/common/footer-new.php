<div class="bg-light">

    <!-- Bottom Footer / Tab Bar -->
    <footer class="app-footer fixed-bottom">
      <div class="footer-inner ">
    
        <!-- Dashboard Tab -->
        <a href="<?php echo base_url();?>dashboard" class="footer-tab active" id="dashboardTab">
          <i class="bi bi-grid-fill"></i>
          <span class="fontweight800" >Dashboard</span>
        </a>
    
        <!-- Menu Tab -->
        <button class="footer-tab"
                data-bs-toggle="offcanvas"
                data-bs-target="#menuOffcanvas" id="menuTab">
          <i class="bi bi-list"></i>
          <span class="fontweight800">Menu</span>
        </button>
     
      </div>
      <div class="footerSpace"></div>
    </footer>
    
<style>
  .footerSpace{
    position: fixed;
    bottom: -2px; 
    left: 0;
    width: 100%;
    height: 50px;
    background: #A1D5ED;
    z-index: 1000;
  }
  .footer-inner {
      
  }
  
  .list-group.list-group-flush {
      padding-bottom:70px;
}
</style>
  <!-- Offcanvas menu (slide panel) -->
  <div class="offcanvas offcanvas-bottom rounded-top" tabindex="-1" id="menuOffcanvas"
       aria-labelledby="menuOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
      <h6 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h6>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
              aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
      <div class="list-group list-group-flush">
        <a href="<?php echo base_url();?>attendance-list" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-card-checklist me-3 fs-5"></i>
          Punch Records
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
        <a href="<?php echo base_url();?>profile" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-person-bounding-box me-3 fs-5"></i>
          Profiles
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
         <!--<a href="<?php //echo base_url();?>visit" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-person-walking me-3 fs-5"></i>
         Visit
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>-->
        <a href="<?php echo base_url();?>poc" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-people me-3 fs-5"></i> 
         Point of Contact
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
        <a href="<?php echo base_url();?>in-house" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-house-door me-3 fs-5"></i>
        In House Meetings
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
         <a href="<?php echo base_url();?>senior" class="list-group-item list-group-item-action d-flex align-items-center">
          <!--<i class="bi bi-building me-3 fs-5"></i>-->
          <i class="bi bi-person-check me-3 fs-5"></i>
        Time With Senior 
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
         <a href="<?php echo base_url();?>operation" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-newspaper me-3 fs-5"></i>
            Agreement Preparation
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
        <!--<a href="<?php echo base_url();?>upcountry" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-globe-asia-australia me-3 fs-5"></i>
         Upcountry
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>-->
         
        <a href="<?php echo base_url();?>event" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-calendar-event me-3 fs-5"></i>
         Event
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
       <hr>
       <a href="<?php echo base_url();?>patient" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-building me-3 fs-5"></i>
        IPD/OPD/HC
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
        <a href="<?php echo base_url();?>booking" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-house-check me-3 fs-5"></i>
         SR Booking
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
        <a href="<?php echo base_url();?>admission" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-backpack2 me-3 fs-5"></i>
         Educational Admission
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
        <a href="<?php echo base_url();?>target" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-calendar-check me-3 fs-5"></i>
        Set Target
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
       
        <!--<a href="<?php echo base_url();?>target-achieved" class="list-group-item list-group-item-action d-flex align-items-center">-->
        <!--  <i class="bi bi-bullseye me-3 fs-5"></i>--> 
        <!-- Target Achieved-->
        <!--  <i class="bi bi-chevron-right ms-auto"></i>-->
        <!--</a>-->
        
        
       
       
        <a href="<?php echo base_url();?>logout" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-box-arrow-right me-3 fs-5"></i>
          Logout
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
         <a href="<?php echo base_url();?>" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bi bi-chevron-right ms-auto"></i>
        </a>
      </div>
    </div>
  </div>

</div>

</div>
</div>
</body>
</html>

<style>
.footerSpace{
    
}
/* Mobile screan */
@media (max-width: 480px) {
    .app-footer {
        width: auto !important;
    }  
}

/*.footer-spacer {*/
  /*height: 76px;      60 footer + ~16 nav bar */
/*  width: 100%;*/
/*  flex-shrink: 0;*/
/*}*/

 
.app-footer{
  margin:auto;
  width:480px;
  background:#fff;
  height:115px;
  border-radius: 10px;
  border-top:1px solid #e5e7eb;
  box-shadow:0 -4px 12px rgba(0,0,0,.05);
  z-index:1050;
}

.footer-inner{
  display:flex;
  /*height:100%;*/
      padding: 5px;
}

.footer-tab{
  flex:1;
  border:none;
  background:transparent;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  color:#6b7280;
  font-size:0.7rem;
  
}
.fontweight800{
    font-weight:800;
}
.footer-tab i{
  font-size:1.5rem;
  margin-bottom:2px;
}

.footer-tab.active{
  color:#00799E;
}

.footer-tab:focus{
  outline:none;
}
    /* colors you can tune */
:root {
  --primary: #00799E;
  --accent: #FAB600;
  --text-muted: #52606d;
  --bg-light: #f4f6f8;
}

body {
  font-family: 'Inter', sans-serif;
  background: var(--bg-light);
  margin: 0;
}

.content-wrapper {
  min-height: calc(100vh - 60px); /* space above the bottom bar */
}

.icon-btn {
  font-size: 1.7rem;
  color: var(--text-muted);
}

.icon-btn:hover {
  color: var(--primary);
}

.nav-tabs-custom {
  background: #fff;
  border-top: 1px solid #e5e7eb;
  height: 60px;
  display: flex;
  align-items: center;
}

.tab-btn {
  flex-grow: 1;
  color: var(--text-muted);
  background: transparent;
  border: none;
  outline: none;
}

.tab-btn i {
  font-size: 1.3rem;
}

.tab-btn .small {
  font-size: 0.65rem;
}

.tab-btn:hover, .tab-btn:focus {
  color: var(--primary);
}

.offcanvas-bottom {
  margin:auto;
  width:480px;
  border-top-left-radius: 18px;
  border-top-right-radius: 18px;
}

/* header border in offcanvas */
.offcanvas-header {
  border-bottom: 1px solid #e5e7eb;
}

/* menu list items */
.list-group-item {
  padding: 12px 16px;
  font-size: 0.9rem;
  color: #374151;
}

.list-group-item i {
  color: var(--primary);
}

.list-group-item:hover {
  background: #f8fafc;
}

.offcanvas.offcanvas-bottom {
    height: auto !important;
    }
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {

  const dashboardTab = document.getElementById("dashboardTab");
  const menuTab = document.getElementById("menuTab");
  const menuOffcanvas = document.getElementById("menuOffcanvas");

  const path = window.location.pathname.toLowerCase();

  // Reset first (DEFAULT: both inactive)
  dashboardTab.classList.remove("active");
  menuTab.classList.remove("active");

  // ONLY dashboard page
  if (path.includes("dashboard")) {
    dashboardTab.classList.add("active");
  }

  // Menu open → menu active
  menuOffcanvas.addEventListener("show.bs.offcanvas", function () {
    dashboardTab.classList.remove("active");
    menuTab.classList.add("active");
  });

  // Menu close → back to dashboard ONLY if on dashboard
  menuOffcanvas.addEventListener("hidden.bs.offcanvas", function () {
    menuTab.classList.remove("active");
    if (path.includes("dashboard")) {
      dashboardTab.classList.add("active");
    }
  });

});
</script>

<script>
// document.addEventListener("DOMContentLoaded", function () {

//     function isAndroid() {
//         return /Android/i.test(navigator.userAgent);
//     }

//     document.querySelectorAll('.common-date').forEach(function (el) {

//         // Android spinner kill
//         if (isAndroid()) {
//             el.type = "text";
//         }

//         let options = {
//             disableMobile: true,
//             dateFormat: "Y-m-d",
//             altInput: true,
//             altFormat: "d/m/Y",
//             allowInput: false,
//         };
        
        
//          //only fields having default-today class
//         if (el.classList.contains('default-today')) {
//           options.defaultDate = "today";
//         }
    
//         // Past dates disable
//         if (el.classList.contains('date-no-past')) {
//             options.minDate = "today";
//         }

//         // Future dates disable
//         if (el.classList.contains('date-no-future')) {
//             options.maxDate = "today";
//         }

//         // Only today allowed
//         if (el.classList.contains('date-today-only')) {
//             options.minDate = "today";
//             options.maxDate = "today";
//             options.defaultDate = "today";
//         }

//         flatpickr(el, options);
//     });

// });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    function isAndroid() {
        return /Android/i.test(navigator.userAgent);
    }

    document.querySelectorAll('.common-date').forEach(function (el) {

        if (isAndroid()) {
            el.type = "text";
        }

        let options = {
            disableMobile: true,
            allowInput: false
        };

        // ✅ MONTH PICKER
        if (el.classList.contains('month-picker')) {
            options.dateFormat = "F";        // june
            options.altFormat  = "F";
            options.defaultDate = "today";
            options.plugins = [
                new monthSelectPlugin({
                    shorthand: false,
                    dateFormat: "F",
                    altFormat: "F",
                })
            ];
        }

        // ✅ YEAR PICKER
        else if (el.classList.contains('year-picker')) {
            options.dateFormat = "Y";
            options.altFormat  = "Y";
            options.defaultDate = new Date().getFullYear();
            options.onReady = function(selectedDates, dateStr, instance) {
                instance.currentYearElement.disabled = false;
            };
        }

        // ✅ NORMAL DATE PICKER
        else {
            options.dateFormat = "Y-m-d";
            options.altInput = true;
            options.altFormat = "d/m/Y";

            if (el.classList.contains('default-today')) {
                options.defaultDate = "today";
            }

            if (el.classList.contains('date-no-past')) {
                options.minDate = "today";
            }

            if (el.classList.contains('date-no-future')) {
                options.maxDate = "today";
            }

            if (el.classList.contains('date-today-only')) {
                options.minDate = "today";
                options.maxDate = "today";
                options.defaultDate = "today";
            }
        }

        flatpickr(el, options);
    });

});
</script>





<script src="<?php echo base_url();?>assets/scripts/plugins/flatpickr.js"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
<script src="<?php echo base_url();?>assets/scripts/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/scripts/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/scripts/image_capture.js"></script>
