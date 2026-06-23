<div class="navigation">
	<ul class="listWrap">
		<li class="list <?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
			<a href="<?php echo base_url('dashboard'); ?>">
				<i class="icon bi bi-people"></i>
				<span class="text">Profile</span>
			</a>
		</li>

		<li class="list <?php echo ($this->uri->segment(1) == 'visit') ? 'active' : ''; ?>">
			<a href="<?php echo base_url('visit'); ?>">
				<i class="icon bi bi-hospital"></i>
				<span class="text">Visit</span>
			</a>
		</li>

		<!--<li class="indicator"></li>-->
	</ul>
</div>




</div>
</div>

<style>
    
:root {
  --bg-default: #222327;
  --primary-white: #ffffff;
  --primary-red: #ff3c41;
}

/* ===== FOOTER FIXED ===== */
.navigation {
    position: fixed;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    width:100%;
    max-width: 480px; 
    height: 70px;
    background: var(--primary-white);
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 14px;
    padding: 0 20px;
    z-index: 999;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .15);
}

/* ===== LIST WRAP ===== */
.navigation .listWrap {
  list-style: none;
  display: flex;
  justify-content: space-around;
  width: 100%;
  padding: 0;
  margin: 0;
}

/* ===== ITEMS ===== */
.navigation .listWrap li {
  width: 70px;
  height: 70px;
  position: relative;
  z-index: 1;
}

.navigation .listWrap li a {
  text-decoration: none;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 100%;
}

/* ===== ICON ===== */
.navigation .listWrap li a .icon {
  line-height: 70px;
  font-size: 25px;
  transition: 0.4s;
  color: var(--bg-default);
}

/* ===== TEXT ===== */
.navigation .listWrap li a .text {
  position: absolute;
  font-size: 13px;
  color: var(--bg-default);
  transition: 0.4s;
  transform: translateY(20px);
  opacity: 0;
}

/* ===== ACTIVE ===== */
.navigation .listWrap li.active a .icon {
  color: var(--primary-white);
  transform: translateY(-32px);
}

.navigation .listWrap li.active a .text {
  opacity: 1;
  transform: translateY(10px);
}

/* ===== INDICATOR ===== */
.navigation .listWrap li.indicator {
    position: absolute;
    width: 70px;
    height: 70px;
    top: -50%;
    border-radius: 50%;
    border: 6px solid #f3eae6;
    background: var(--blue);
    transition: 0.3s;
    z-index: 0;
}

/* ===== INDICATOR POSITION (ONLY 2) ===== */
.navigation .listWrap li:nth-child(1).active ~ .indicator {
   transform: translateX(-110px);
}

.navigation .listWrap li:nth-child(2).active ~ .indicator {
  transform: translateX(110px); /* 70px * 2 */
}

</style>

<script>
    const listItem = document.querySelectorAll('.list');

function activateLink() {
	listItem.forEach( item => {
		item.classList.remove('active');
	});
	this.classList.add('active');
}

listItem.forEach( item => {
	item.addEventListener('click', activateLink);
});

</script>

<!--<script src="<?php echo base_url(); ?>assets/scripts/bootstrap/bootstrap.bundle.min.js"></script>-->
<!-- <script src="resources/scripts/header.js"></script> -->
<!--<script src="<?php echo base_url(); ?>assets/scripts/bootstrap/owl.carousel.min.js"></script>-->
</body>

</html>