<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<style>
 /* Text Styling */
.modal-body p {
    margin-bottom: 6px;
    font-size: 14px;
}

.modal-body strong {
    color: #222;
}

/* Corner Status Image */
.status-img {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 110px;
    opacity: 0.9;
    z-index: 10;
}

/* Mobile Optimization */
@media (max-width: 576px) {
    .status-img {
        width: 117px;
        top: 10px;
        right: 10px;
        opacity: 0.8;
    }

    .modal-title {
        font-size: 16px;
    }

    .modal-content {
        border-radius: 12px;
    }
}
</style>

<div class="main-div">
    <div class="profile-wrapper">
        <h4 class="profile-title">Punch Time</h4>
        <div class="visit-tabs mb-3">
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
        </div>
        <div class="tab-content">
        
          <!-- ALL TAB -->
          <div class="tab-pane fade show active" id="allTab">
            
           
            
            <table class="table custom-table">
              <thead>
                <tr>
                  <th class="">Date</th>  
                  <th class="">In Time</th>
                  <th class="">Out Time</th>
                </tr>
              </thead>
              <tbody id="allTbody">
                <?php
                 if(!empty($get_data)){
                 $x = 1; 
                 foreach($get_data as $row){ ?>
                  <td><?php echo date('d-m-Y',strtotime($row->created_at));?></td>
                  <td><?php echo !empty($row->in_time) ? date('h:i A', strtotime($row->in_time)) : '-';?></td>
                  <td><?php echo !empty($row->out_time) ? date('h:i A', strtotime($row->out_time)) : '-'; ?></td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="3" class="text-danger text-center">No Punch(In/Out) Found.</td></tr> 
            <?php } ?>
              </tbody>
            </table>
          </div>
          
</div>
<script>
function filterByDate() {
    const from = document.getElementById('fromDate').value;
    const to   = document.getElementById('toDate').value;

    if (from && to) {
        window.location.href =
          "<?= base_url('ipd-created') ?>?from=" + from + "&to=" + to; 
    }
}

document.getElementById('fromDate').addEventListener('change', filterByDate);
document.getElementById('toDate').addEventListener('change', filterByDate);
</script>




