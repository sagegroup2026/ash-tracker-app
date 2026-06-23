<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
        <div class="visit-tabs mb-3">
           <div class="search-box mb-3">
              <i class="bi bi-search"></i>
              <input type="search" class="form-control search-input common-filter" placeholder="Search by name, mobile, ID..." id="searchText">
            </div>
             
            <!--<div class="date-range">-->
            <!--   <div>-->
            <!--       <label class="form-label">From</label> <br>-->
            <!--       <input type="date" class="custom-input common-date common-filter" id="fromDate">-->
            <!--   </div> -->
            <!--   <div>-->
            <!--       <label class="form-label">To</label> <br>-->
            <!--       <input type="date" class="custom-input common-date common-filter" id="toDate">-->
            <!--   </div> -->
            <!--</div> -->
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
              <tbody id="todayTbody">
            <?php 
                $login_id = $this->session->userdata('login_id');
                $today_profiles = getTodayProfiles('tracker_patient', $login_id,'OPD');
            if(!empty($today_profiles)){
                $x = 1;
                foreach($today_profiles as $row){
            ?>
            <tr data-search="<?= strtolower( $row->team_name.' '.$row->patient_name.' '.$row->patient_contact) ?>" >


                 <td><?php echo $x++;?></td>
                  <td>
                    <span class=""><?php echo $row->team_name ?></span><br>
                    <span class=""><?php echo $row->patient_name ?></span><br>
                    <span class=""><?php echo $row->patient_contact ?></span><br>
                  </td>
            
                  <td class="text-center">
                    <!--<a href="<?php echo base_url()?>edit-profile/<?php echo $row->id; ?>"><i class="bi bi-pencil-square action-icon text-primary"></i></a>-->
                   <i class="bi bi-eye action-icon text-success"
                       data-bs-toggle="modal"
                       data-bs-target="#detailModal"
                       onclick="openDetail(
                         '<?= $row->team_name ?>',
                         '<?= $row->patient_name ?>',
                         '<?= $row->patient_contact ?>',
                         '<?= $row->ref_by ?>',
                         '<?= htmlspecialchars($row->poc, ENT_QUOTES) ?>',
                         '<?= !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : '-' ?>'
                       )">
                    </i> 
                  </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="3" class="text-danger text-center">No OPD Done today.</td></tr>
           <?php } ?>
              </tbody>
            </table>
          </div>
        
          <!-- ALL TAB -->
          <div class="tab-pane fade show active" id="allTab">
            
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
              <tbody id="allTbody">
                <?php
                 if(!empty($get_data)){
                 $x = 1; 
                 foreach($get_data as $row){ ?>
                 <tr data-search="<?= strtolower( $row->team_name.' '.$row->patient_name.' '.$row->patient_contact) ?>" >
                  <td><?php echo $x++;?></td>
                  <td>
                    <span class=""><?php echo $row->team_name ?></span><br>
                    <span class=""><?php echo $row->patient_name ?></span><br>
                    <span class=""><?php echo $row->patient_contact ?></span><br>
                  </td>
            
                  <td class="text-center">
                    <!--<a href="<?php echo base_url()?>edit-profile/<?php echo $row->id; ?>"><i class="bi bi-pencil-square action-icon text-primary"></i></a>-->
                   <i class="bi bi-eye action-icon text-success"
                       data-bs-toggle="modal"
                       data-bs-target="#detailModal"
                       onclick="openDetail(
                         '<?= $row->team_name ?>',
                         '<?= $row->patient_name ?>',
                         '<?= $row->patient_contact ?>',
                         '<?= $row->ref_by ?>',
                         '<?= htmlspecialchars($row->poc, ENT_QUOTES) ?>',
                         '<?= !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : '-' ?>'
                       )">
                    </i>



                  </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="3" class="text-danger text-center">No OPD Done.</td></tr> 
            <?php } ?>
              </tbody>
            </table>
        

        
          </div>
          
         <div class="modal fade" id="detailModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
        
              <div class="modal-header">
                <h5 class="modal-title">OPD Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
        
              <div class="modal-body">
                <p><strong>Team Name:</strong> <span id="m_team"></span></p>
        
                <p><strong>Patient Name:</strong> <span id="m_patient"></span></p>
                <p><strong>Patient Contact:</strong> <span id="m_patient_contact"></span></p>
        
                <p><strong>Referred By:</strong> <span id="m_ref_by"></span></p>
        
                <hr>
                <h6>POC Details</h6>
                <div id="m_poc"></div>
        
                <hr>
                <p><strong>Date:</strong> <span id="m_date"></span></p>
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
<script>
function openDetail(team, patient, patient_contact, ref_by, poc_json, date) {

  document.getElementById('m_team').innerText = team;
  document.getElementById('m_patient').innerText = patient;
  document.getElementById('m_patient_contact').innerText = patient_contact;
  document.getElementById('m_ref_by').innerText = ref_by;
  document.getElementById('m_date').innerText = date;

  let pocBox = document.getElementById('m_poc');
  pocBox.innerHTML = '';

  try {
    let pocData = JSON.parse(poc_json);

    pocData.forEach((poc, index) => {
      pocBox.innerHTML += `
        <div class="border rounded p-2 mb-2">
          <strong>POC ${index + 1}</strong><br>
          <b>Name:</b> ${poc.name ?? '-'} <br>
          <b>Type:</b> ${poc.poc_type ?? '-'} <br>
          <b>Contact:</b> ${poc.contact ?? '-'} <br>
          ${poc.comment ? `<b>Comment:</b> ${poc.comment}` : ''}
        </div>
      `;
    });

  } catch (e) {
    pocBox.innerHTML = '<span class="text-danger">Invalid POC data</span>';
  }
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
          "<?= base_url('opd-created') ?>?from=" + from + "&to=" + to; 
    }
}

document.getElementById('fromDate').addEventListener('change', filterByDate);
document.getElementById('toDate').addEventListener('change', filterByDate);
</script>




