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
        <h3>All IPD/OPD/HC Data</h3><br><br>
        <div class="visit-tabs mb-3">
         
             
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
            <div class="search-box mb-3">
              <i class="bi bi-search"></i>
              <input type="search" class="form-control search-input common-filter" placeholder="Search by name, mobile, ID..." id="searchText">
            </div>
            <table class="table custom-table">
              <thead>
                <tr>
                  <th>S.No.</th> 
                  <th>Details</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="todayTbody">
            <?php 
                $login_id = $this->session->userdata('login_id');
            if(!empty($get_todayIPDOPDdata)){
                $x = 1;
                foreach($get_todayIPDOPDdata as $row){
            ?>
            <tr data-search="<?= strtolower( $row->team_name.' '.$row->patient_name.' '.$row->patient_contact.''.$row->agent_name.''.$row->agent_contact.''.$row->type) ?>" >
                  <td><?php echo $x++;?></td>
                  <td>
                    <span class=""><strong><?php echo $row->type ?></strong></span><br>
                    <span class=""><?php echo date('d-m-Y', strtotime($row->created_at)) ?></span><br>
                    <span class=""><?php echo $row->patient_name ?></span><br>
                    <span class=""><?php echo $row->patient_contact ?></span><br>
                    
                  </td>
            
                  <td>
                    <span class=""><?php echo $row->agent_name ?></span><br>
                    <span class=""><?php echo $row->agent_contact ?></span><br>   
                  </td>
            </tr>
            <?php } }else{ ?>
                <tr><td colspan="3" class="text-danger text-center">No IPD Done today</td></tr>
           <?php } ?>
              </tbody>
            </table>
          </div>
        
          <!-- ALL TAB -->
          <div class="tab-pane fade show active" id="allTab">
            <div class="custom-datatable-wrapper">
                <table id="patientTable" class="table custom-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>  
                            <th>Patient Details</th>
                            <th>Executive Details</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
</div>

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

<style>
    /* TABLE CARD LOOK */
.custom-datatable-wrapper {
    background: #f8fafc;
    padding: 15px;
    border-radius: 20px;
}

/* TABLE */
#patientTable {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
}

/* HEADER */
#patientTable thead {
    background: #f1f5f9;
    font-weight: 600;
}

/* PAGINATION CONTAINER */
.dataTables_wrapper .dataTables_paginate {
    text-align: center;
    margin-top: 15px;
}

/* PAGINATION BUTTONS */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    background: #eef2f7 !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 6px 12px !important;
    margin: 2px;
    font-size: 13px;
    color: #333 !important;
}

/* ACTIVE BUTTON */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #ffc107 !important;
    color: #fff !important;
}

/* HOVER */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: var(--blue) !important;
}

/* INFO TEXT (1-10 of 230) */
.dataTables_info {
    text-align: center;
    font-size: 13px;
    color: #6b7280;
    margin-top: 10px;
}

/* LENGTH DROPDOWN */
.dataTables_length {
    float: left;
}

.dataTables_length select {
    border-radius: 20px;
    padding: 5px 10px;
    border: 1px solid #ddd;
}

/* SEARCH BOX */
.dataTables_filter input {
    border-radius: 20px;
    padding: 5px 10px;
    border: 1px solid #ddd;
}

/* FLEX ALIGN (TOP BAR) */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 10px;
}
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
// $(document).ready(function() {

//     $('#patientTable').DataTable({
//         "processing": true,
//         "serverSide": true,
//         "pageLength": 10,
//         "lengthMenu": [10, 25, 50, 100],

//         "ajax": {
//             "url": "<?= base_url('Ajax/get_patient_data') ?>",
//             "type": "POST"
//         },

//         "columns": [
//             { 
//                 "data": "id",
//                 "render": function(data, type, row, meta){
//                     return meta.row + meta.settings._iDisplayStart + 1;
//                 }
//             },
//             { 
//                 "data": null,
//                 "render": function(data){
//                     return `
//                         <strong>${data.type}</strong><br>
//                         ${data.created_at}<br>
//                         ${data.patient_name}<br>
//                         ${data.patient_contact}
//                     `;
//                 }
//             },
//             { 
//                 "data": null,
//                 "render": function(data){
//                     return `
//                         ${data.agent_name}<br>
//                         ${data.agent_contact}
//                     `;
//                 }
//             }
//         ]
//     });

// });
$('#patientTable').DataTable({
    processing: true,
    // serverSide: true,
    pageLength: 10,

    ajax: {
        url: "<?= base_url('Ajax/get_patient_data') ?>",
        type: "POST"
    },

    dom: '<"top"lf>rt<"bottom"ip><"clear">', // UI layout control

    language: {
        lengthMenu: "_MENU_ rows",
        info: "Showing _START_–_END_ of _TOTAL_",
        paginate: {
            previous: "‹",
            next: "›"
        }
    },

    columns: [
        { 
            data: "id",
            render: function(data, type, row, meta){
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { 
            data: null,
            render: function(data){
                return `
                    <strong>${data.type}</strong><br>
                    ${new Date(data.created_at).toLocaleDateString('en-GB').replaceAll('/','-')}<br>
                    ${data.patient_name}<br>
                    ${data.patient_contact}
                `;
            }
        },
        { 
            data: null,
            render: function(data){
                return `
                    ${data.agent_name}<br>
                    ${data.agent_contact}
                `;
            }
        }
    ]
});
</script>




