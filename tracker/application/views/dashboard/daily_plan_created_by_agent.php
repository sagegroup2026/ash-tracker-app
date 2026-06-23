<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
        <!--<div class="visit-tabs mb-3">-->
        <!--    <div class="search-box mb-3">-->
        <!--      <i class="bi bi-search"></i>-->
        <!--      <input type="search" class="form-control search-input common-filter" placeholder="Search by name, mobile, ID..." id="searchText">-->
        <!--  </div> -->
          
        <!--  <ul class="nav nav-pills nav-fill custom-tabs">-->
        <!--    <li class="nav-item">-->
        <!--      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#todayTab">-->
        <!--        Today-->
        <!--      </button>-->
        <!--    </li>-->
        <!--    <li class="nav-item">-->
        <!--      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allTab">-->
        <!--        All-->
        <!--      </button>-->
        <!--    </li>-->
        <!--  </ul>-->
        <!--</div>-->
        <!--<div class="tab-content">-->
        
          <!-- TODAY TAB -->
          <!--<div class="tab-pane fade" id="todayTab">-->
            <table class="table custom-table">
              <thead>
                <tr>
                  <th class="">S.No.</th> 
                  <th class="">Profile</th>
                  <th class="">Action</th>
                </tr>
              </thead>
             <tbody>
<?php //if(isset($plans) && !empty($plans)){ 
$i = 1;
foreach($plans as $row){ ?>

<tr>

<td><?= $i++; ?></td>

<td><strong><?= $row->name ?></strong></td>

<td>
<button class="btn btn-success btn-sm">
Start Meeting
</button>
</td>

</tr>

<?php }?>


<?php // } ?>

</tbody>
            </table>
          <!--</div>-->
        
          <!-- ALL TAB -->

          
          <div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

       <div class="modal-body">
                    <p><strong>Status:</strong> <span id="m_profileId"></span></p>
                    <p><strong>Project Name:</strong> <span id="m_profileType" class="text-uppercase"></span></p>  
                    <p><strong>Customer Name:</strong> <span id="m_name"></span></p>
                    <p><strong>Deal By:</strong> <span id="f_name"></span></p>
                    <p><strong>Date:</strong> <span id="m_address"></span></p>
        </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

        
        </div>
    </div>
</div>
<style>
.visit-tabs .nav-link{
  border-radius:14px;
  color:#333;
}

.visit-tabs .nav-link.active{
  background:var(--blue);
}

.visit-card{
  background:#fff;
  border-radius:14px;
  padding:15px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:10px;
  box-shadow:0 4px 10px rgba(0,0,0,0.08);
  cursor:pointer;
}

.card-right{
  display:flex;
  align-items:center;
  gap:6px;
  color:#1e88e5;
  font-weight:500;
}

.arrow{
  transition:0.3s ease;
  font-size:18px;
}

.visit-card.active .arrow{
  transform:rotate(180deg);
}

.card-body-custom{
  background:#fff;
  padding:15px;
  border-radius:0 0 14px 14px;
  box-shadow:0 6px 12px rgba(0,0,0,0.05);
}

.custom-table{
  background:#fff;
  border-radius:10px;
  overflow:hidden;
}

.action-icon{
  font-size:18px;
  cursor:pointer;
  margin:0 6px;
}

.action-icon:hover{
  transform:scale(1.1);
}

</style>

<script>
function openDetail(profile_id, profile_type, name,mobile,address,type){
  document.getElementById('m_profileId').innerText = lead_or_comfirmed;
  document.getElementById('m_profileType').innerText = customer_name;
  document.getElementById('m_name').innerText = project_name;
  document.getElementById('m_mobile').innerText = mobile;
  document.getElementById('m_address').innerText = address;
//   document.getElementById('m_type').innerText = type;
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

  const searchInput = document.querySelector('.search-input');

  searchInput.addEventListener('input', function () {

    const keyword = this.value.toLowerCase().trim();

    // Active tab ka tbody
    const activeTab = document.querySelector('.tab-pane.active');
    if (!activeTab) return;

    const rows = activeTab.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const rowText = row.dataset.search || '';
      row.style.display = rowText.includes(keyword) ? '' : 'none';
    });

  });

});
</script>
<script>
function filterByDate() {
    const from = document.getElementById('fromDate').value;
    const to   = document.getElementById('toDate').value;

    if (from && to) {
        window.location.href =
          "<?= base_url('booking-created') ?>?from=" + from + "&to=" + to;
    }
}

document.getElementById('fromDate').addEventListener('change', filterByDate);
document.getElementById('toDate').addEventListener('change', filterByDate);
</script>