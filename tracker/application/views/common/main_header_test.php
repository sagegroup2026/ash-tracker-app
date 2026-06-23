

<header class="app-header px-3">
  <!-- Logo -->
  <div class="logo">
    <img src="https://apollosage.in/assets/images/logo-ash.png" alt="Logo">
  </div>

  <!-- Right -->
  <div class="header-right">

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
      <small><?php echo $this->session->userdata('email');?></small>
    </div>
  </div>
</div>


  </div>
</header>
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

