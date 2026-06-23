<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
        <div class="visit-tabs mb-3">
            
          <div class="search-box mb-3">
              <i class="bi bi-search"></i>
              <input type="search" class="form-control search-input common-filter" placeholder="Search by name, mobile, ID..." id="searchText">
          </div>  
          
          <ul class="nav nav-pills nav-fill custom-tabs">
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#todayTab">
                Today
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allTab">
                All
              </button>
            </li>
          </ul>
        </div>
        <div class="tab-content">
        
          <!-- TODAY TAB -->
          <div class="tab-pane fade" id="todayTab">
            <table class="table custom-table">
              <thead>
                <tr>
                  <th class="text-center">S.No.</th> 
                  <th class="text-center">Details</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
            <?php 
                $login_id = $this->session->userdata('login_id');
                $today_profiles = getTodayProfiles('tracker_poc', $login_id);
            if(!empty($today_profiles)){
                $x = 1;
                foreach($today_profiles as $row){
            ?>
             <tr data-search="<?= strtolower( $row->name.' '.$row->contact.' '.$row->profile_id) ?>" >
                 <td><?php echo $x++;?></td>
                  <td>
                    <span class=""><?php echo $row->profile_id ?></span><br>
                    <span class=""><?php echo $row->name ?></span><br>
                    <span class=""><?php echo $row->contact ?></span><br>
                  </td>
            
                  <td class="text-center">
                    <!--<a href="<?php echo base_url()?>edit-profile/<?php echo $row->id; ?>"><i class="bi bi-pencil-square action-icon text-primary"></i></a>-->
                    <i class="bi bi-eye action-icon text-success"
                       data-bs-toggle="modal"
                       data-bs-target="#detailModal"
                       onclick="openDetail(
                        '<?= $row->profile_id ?>',
                        '<?= $row->name ?>',
                        '<?= $row->contact ?>',
                         '<?= $row->designation ?>',
                         '<?= !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : '-' ?>' 
                         
                       )">
                    </i> 
                  </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="3" class="text-danger text-center">No POC Created today.</td></tr>
           <?php } ?>
              </tbody>
            </table>
          </div>
        
          <!-- ALL TAB -->
          <div class="tab-pane fade show active" id="allTab">
              <!-- date range -->
            <div class="date-range">
                <div>
                    <label class="form-label">From</label><br>
                    <input type="date"
                           class="custom-input common-date"
                           id="fromDate"
                           value="<?= !empty($from) ? $from : date('Y-m-01'); ?>">
                </div>
            
                <div>
                    <label class="form-label">To</label><br>
                    <input type="date"
                           class="custom-input common-date"
                           id="toDate"
                           value="<?= !empty($to) ? $to : date('Y-m-d'); ?>">
                </div>
            </div> 
           
            <table class="table custom-table">
              <thead>
                <tr>
                  <th class="text-center">S.No.</th>  
                  <th class="text-center">Details</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $login_id = $this->session->userdata('login_id');
                // $get_data = getAllDataById('tracker_poc',$login_id);
                
                 if(!empty($get_data)){
                 $x = 1; 
                 foreach($get_data as $row){ ?>
                <tr data-search="<?= strtolower( $row->name.' '.$row->contact.' '.$row->profile_id) ?>" >
                  <td><?php echo $x++;?></td>
                  <td>
                    <span class=""><?php echo $row->profile_id ?></span><br>
                    <span class=""><?php echo $row->name ?></span><br>
                    <span class=""><?php echo $row->contact ?></span><br>
                    
                  </td>
            
                  <td class="text-center">
                    <!--<a href="<?php echo base_url()?>edit-profile/<?php echo $row->id; ?>"><i class="bi bi-pencil-square action-icon text-primary"></i></a>-->
                   <i class="bi bi-eye action-icon text-success"
                       data-bs-toggle="modal"
                       data-bs-target="#detailModal"
                       onclick="openDetail(
                        '<?= $row->profile_id ?>',
                        '<?= $row->name ?>',
                        '<?= $row->contact ?>',
                         '<?= !empty($row->designation) ? $row->designation : '-' ?>',
                         '<?= !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : '-' ?>' 
                         
                       )">
                    </i>


                  </td>
                </tr>
            <?php } }else{ ?>
               <tr><td colspan="3" class="text-danger text-center">No POC Created.</td></tr>
            <?php } ?>
              </tbody>
            </table>
        

        
          </div>
          
          <div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">POC Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>Profile Id:</strong> <span id="m_profileId"></span></p>
        <p><strong>Name:</strong> <span id="m_name"></span></p>
        <p><strong>Mobile:</strong> <span id="m_mobile"></span></p>
        <p><strong>Designation:</strong> <span id="m_designation" class="text-uppercase"></span></p>  
        <p><strong>Date:</strong> <span id="m_date"></span></p>
        <!--<p><strong>Visit Type:</strong> <span id="m_type"></span></p>-->
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
function openDetail(profile_id, name,mobile,designation,date){
  document.getElementById('m_profileId').innerText = profile_id;
  document.getElementById('m_name').innerText = name;
  document.getElementById('m_mobile').innerText = mobile;
  document.getElementById('m_designation').innerText = designation;
  document.getElementById('m_date').innerText = date;
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
          "<?= base_url('poc-created') ?>?from=" + from + "&to=" + to; 
    }
}

document.getElementById('fromDate').addEventListener('change', filterByDate);
document.getElementById('toDate').addEventListener('change', filterByDate);
</script>
