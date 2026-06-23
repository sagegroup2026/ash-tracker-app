
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- ===== HEADER ===== -->
<!--<header class="app-header d-flex align-items-center justify-content-between px-3">-->
  <!-- Logo -->
<!--  <div class="logo">-->
<!--    <img src="https://apollosage.in/assets/images/logo-ash.png" alt="Logo">-->
<!--  </div>-->

  <!-- Menu Icon -->
<!--  <div class="dev-profile">-->
<!--     <p class="m-0"><b><?php echo ucwords($this->session->userdata('user_name'))?></b></p>-->
<!--    <i class="bi bi-person-circle" style="color:#00799E; font-size:28px;"></i> -->
<!--  </div>-->
<!--</header>-->
<header class="app-header px-3">
  <!-- Logo -->
  <a href="<?= base_url()?>dashboard">
  <div class="logo">
    <img src="https://apollosage.in/assets/images/logo-ash.png" alt="Logo">
  </div>
</a>
  <!-- Right -->
  <div class="header-right">
      
    <!-- All IPD OPD HC Data -->
   <a href="<?php echo base_url()?>AllIPDOPDHC_DataShow" title="All User IPD/OPD Data" class="icon-box">
    <i class="bi bi-people fs-5"></i>
    <i class="bi bi-plus-lg fs-6"></i>
</a> 
      

    <!-- Notification -->
    <a href="<?php echo base_url()?>followup-notification" class="icon-box">
      <i class="bi bi-bell fs-5"></i>
     
    </a>

    <!-- Profile Wrapper -->
    <div class="user-menu" tabindex="0">
    <i class="bi bi-person-circle"></i>

  <!-- Dropdown -->
  <div class="user-dropdown">
    <div class="user-info">
      <strong><?php echo ucwords($this->session->userdata('user_name'))?></strong>
    </div>
    <div class="user-info punch-out">
        <form method="POST" action="<?= base_url('save-punch-out') ?>" onsubmit="return alert('Are you sure you want to Punch Out?')">

            <!-- Location -->
            <input type="hidden" name="location" id="punchOutLocation">

            <button type="submit" class="btn user-info-btn">
                Punch Out
            </button>

    </form>
    </div>
  </div>
</div>


  </div>
</header>

<script>

document.addEventListener("DOMContentLoaded", function () {

    if (!navigator.geolocation) {
        return;
    }

    navigator.geolocation.getCurrentPosition(

        function(position){

            const locationObj = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                source: "gps"
            };

            // ONLY current form input
            document.querySelector('.punch-out #punchOutLocation').value =
                JSON.stringify(locationObj);

            console.log(locationObj);

        }

    );

});

</script>

<!-- ===== OVERLAY ===== -->
<!--<div id="overlay" onclick="closeMenu()"></div>-->

<!-- ===== SIDE MENU ===== -->
<!--<div class="side-menu" id="sideMenu">-->
<!--   Profile -->
<!--  <div class="profile text-center">-->
<!--    <img src="https://img.freepik.com/free-vector/user-blue-gradient_78370-4692.jpg?semt=ais_hybrid&w=740&q=80" class="rounded-circle mb-2">-->
<!--    <h6>Hello,</h6>-->
<!--    <p class="mb-0 text-muted"><?php echo ucwords($username);?></p>-->
<!--  </div>-->

<!--   Menu Items -->
<!--  <ul class="menu-list">-->
<!--    <li><i class="bi bi-house"></i> Home</li>-->
<!--    <li><i class="bi bi-person"></i> Profile</li>-->
<!--    <li><i class="bi bi-clock-history"></i> History</li>-->
<!--    <li><i class="bi bi-person-badge"></i> Author</li>-->
<!--    <li><i class="bi bi-bell"></i> Notifications</li>-->
<!--    <li><i class="bi bi-gear"></i> Settings</li>-->
<!--  </ul>-->

<!--  <a class="logout" href="<?php echo base_url();?>logout">-->
      
<!--    <i class="bi bi-box-arrow-right"></i> Logout-->
<!--  </a>-->
<!--</div>-->
<style>
    .app-header{
  height:60px;
  background:#fff;
  box-shadow:0 2px 10px rgba(0,0,0,.08);
  display:flex;
  align-items:center;
  justify-content:space-between;
  position:sticky;
  top:0;
  z-index:1000;
}

.logo img{
  height:45px;
}

/* Right */
.header-right{
  display:flex;
  align-items:center;
  gap:18px;
}

/* Icons */
.icon-box{
  position:relative;
  cursor:pointer;
}

.icon-box i,
.user-menu i{
  font-size:26px;
  color:#00799E;
}

.user-menu{
  position:relative;
  cursor:pointer;
  outline:none;
}


/* Dropdown hidden by default */
.user-dropdown{
  position:absolute;
  top:50px;
  right:0;
  width:240px;
  background:#fff;
  border-radius:8px;
  box-shadow:0 10px 30px rgba(0,0,0,.15);
  display:none;
  overflow:hidden;
}

/* Show on hover / focus */
.user-menu:hover .user-dropdown,
.user-menu:focus-within .user-dropdown{
  display:block;
}

/* User info */
.user-info{
  padding:15px;
  border-bottom:1px solid #eee;
}

.user-info strong{
  display:block;
}

.user-info small{
  color:#777;
}

.user-info-btn{
    padding: 5px 10px;
    color: #fff;
    background: var(--blue);
}

/* Menu */
.user-dropdown ul{
  list-style:none;
  padding:0;
  margin:0;
}

.user-dropdown li{
  padding:12px 15px;
  font-size:14px;
  cursor:pointer;
}

.user-dropdown li i{
  margin-right:8px;
}

.user-dropdown li:hover{
  background:#f5f5f5;
}

.logout{
  color:#d00;
}

/* Bell wrapper */
.notification-menu{
  position:relative;
  cursor:pointer;
  outline:none;
}

.notification-menu i{
  color:#00799E;
}

/* Badge */
.notification-menu .badge{
  position:absolute;
  top:-6px;
  right:-6px;
  background:red;
  color:#fff;
  font-size:11px;
  padding:2px 6px;
  border-radius:50%;
}

/* Dropdown box */
.notification-dropdown{
  position:absolute;
  top:45px;
  right:0;
  width:340px;
  background:#fff;
  border-radius:10px;
  box-shadow:0 10px 30px rgba(0,0,0,.2);
  padding:12px;
  display:none;
  z-index:1000;
}

/* Show dropdown */
.notification-menu:hover .notification-dropdown,
.notification-menu:focus-within .notification-dropdown{
  display:block;
}

/* Hide radios */
.notification-dropdown input{
  display:none;
}

/* Tabs */
.notification-dropdown label{
  padding:6px 14px;
  border-radius:20px;
  background:#eef4f7;
  font-size:13px;
  margin-right:6px;
  cursor:pointer;
}

/* Active tab */
#tab-today:checked + label,
#tab-pending:checked + label{
  background:#00799E;
  color:#fff;
}

/* Content */
.notify-content{
  margin-top:12px;
}

.notify-panel{
  display:none;
}

/* Show panel */
#tab-today:checked ~ .notify-content .today{
  display:block;
}

#tab-pending:checked ~ .notify-content .pending{
  display:block;
}

/* Table */
.notify-panel table{
  width:100%;
  font-size:13px;
  border-collapse:collapse;
}

.notify-panel th{
  text-align:left;
  padding-bottom:6px;
}

.empty{
  text-align:center;
  color:red;
  padding:15px 0;
}


</style>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openMenu() {
      document.getElementById("sideMenu").classList.add("active");
      document.getElementById("overlay").style.display = "block";
    }
    
    function closeMenu() {
      document.getElementById("sideMenu").classList.remove("active");
      document.getElementById("overlay").style.display = "none";
    }
</script>
