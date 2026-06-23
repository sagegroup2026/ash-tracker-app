<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                            <th class="text-center">Event Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $login_id = $this->session->userdata('login_id');
                $today_profiles = getTodayProfiles('tracker_event', $login_id);
                if(!empty($today_profiles)){
                $x = 1;
                foreach($today_profiles as $row){?>
                            <tr data-search="<?= strtolower($row->event_type) ?>">
                                <td colspan="4">

                                    <div class="event-card">

                                        <div class="event-header">

                                            <div class="event-left">

                                                <div class="event-icon">
                                                    <i class="bi bi-calendar-event"></i>
                                                </div>

                                                <div>
                                                    <h6 class="event-title mb-0">
                            <?= $row->event_title ?? ucfirst($row->event_type) ?>
                        </h6>

                                                    <small class="event-date">
                            <i class="bi bi-clock"></i>
                            <?= !empty($row->event_date)
                                ? date('d M Y', strtotime($row->event_date))
                                : '-' ?>
                        </small>
                                                </div>

                                            </div>

                                            <div class="dropdown">

                                                <button class="action-btn" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <?php if($row->created_by == $login_id &&date('Y-m-d') <= $row->end_date){?>
                                                    
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo base_url('edit-event/'.$row->id); ?>">
                                                                <i class="bi bi-pencil-square text-warning me-2"></i> Edit Event
                                                            </a>
                                                        </li>
                                                        <?php } ?>
                                                            <!--<li>-->
                                                            <!--    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="openDetail(-->
                                                            <!--        '<?= $row->event_title ?? '-' ?>',-->
                                                            <!--        '<?= ucfirst($row->event_type ?? '-') ?>',-->
                                                            <!--        '<?= $row->event_purpose ?? '-' ?>',-->
                                                            <!--        '<?= !empty($row->event_date) ? date('d M Y', strtotime($row->event_date)) : '-' ?>',-->
                                                            <!--        '<?= !empty($row->end_date) ? date('d M Y', strtotime($row->end_date)) : '-' ?>',-->
                                                            <!--        '<?= $row->audience_target ?? '-' ?>',-->
                                                            <!--        '<?= $row->prospect_expected ?? '-' ?>',-->
                                                            <!--        '<?= $row->person_involved ?? '-' ?>',-->
                                                            <!--        '<?= $row->manager_involved ?? '-' ?>',-->
                                                            <!--        '<?= $row->lead_count ?? 0 ?>'-->
                                                            <!--   )">-->

                                                            <!--        <i class="bi bi-eye text-info me-2"></i> View Details-->
                                                            <!--    </a>-->
                                                            <!--</li>-->

                                                </ul>

                                            </div>

                                        </div>

                                        <?php if(!empty($row->event_purpose)){ ?>
                                            <div class="event-purpose">
                                                <?= $row->event_purpose ?>
                                            </div>
                                            <?php } ?>

                                                <div class="event-footer">

                                                    <span class="event-type-badge"><?= ucfirst($row->event_type ?? '-') ?></span>

                                                    <div class="event-arrow">

                                                        <a href="javascript:void(0)" class="event-detail-btn" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="openDetail(
                                                            '<?= $row->event_title ?? '-' ?>',
                                                            '<?= ucfirst($row->event_type ?? '-') ?>',
                                                            '<?= $row->event_purpose ?? '-' ?>',
                                                            '<?= !empty($row->event_date) ? date('d M Y', strtotime($row->event_date)) : '-' ?>',
                                                            '<?= !empty($row->end_date) ? date('d M Y', strtotime($row->end_date)) : '-' ?>',
                                                            '<?= $row->audience_target ?? '-' ?>',
                                                            '<?= $row->prospect_expected ?? '-' ?>',
                                                            '<?= $row->person_involved ?? '-' ?>',
                                                            '<?= $row->manager_involved ?? '-' ?>',
                                                            '<?= $row->lead_count ?? 0 ?>'
                                                       )"><i class="bi bi-arrow-up-right"></i></a>
                                                    </div>
                                                </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } }else{ ?>
                                <tr>
                                    <td colspan="3" class="text-danger text-center">No Event Created today.</td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- ALL TAB -->
            <div class="tab-pane fade show active" id="allTab">
                <!-- date range -->
                <div class="date-range">
                    <div>
                        <label class="form-label">From</label>
                        <br>
                        <input type="date" class="custom-input common-date" id="fromDate" value="<?= !empty($from) ? $from : date('Y-m-01'); ?>">
                    </div>

                    <div>
                        <label class="form-label">To</label>
                        <br>
                        <input type="date" class="custom-input common-date" id="toDate" value="<?= !empty($to) ? $to : date('Y-m-d'); ?>">
                    </div>
                </div>

                <table class="table custom-table">
                    <thead>
                        <tr>
                            <!--<th class="text-center">S.No.</th>  -->
                            <th class="text-center">Event Details</th>
                            <!--<th class="text-center">Data Uploads</th>-->
                            <!--<th class="text-center">Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 if(!empty($get_data)){
                 $x = 1; 
                 foreach($get_data as $row){ ?>
                            <tr data-search="<?= strtolower( $row->name.' '.$row->meeting) ?>">
                                <!--<td><?php echo $x++;?></td>-->
                                <!--<td>-->
                                <!--  <?php if($row->event_title){?>-->
                                <!--  <strong>Event Name: </strong> <?= $row->event_title ?> <br>-->
                                <!--  <?php } ?>-->
                                <!--  <?php if($row->event_purpose){?>-->
                                <!--  <strong>Purpose: </strong> <?= $row->event_purpose ?> <br>-->
                                <!--  <?php } ?>-->
                                <!--  <span><strong>Event Type:</strong> <?= ucfirst($row->event_type ?? '-') ?></span><br>-->
                                <!--  <span><strong>Date:</strong> -->
                                <!--      <?= !empty($row->event_date) ? date('d-m-Y', strtotime($row->event_date)) : '-' ?>-->
                                <!--  </span><br>-->
                                <!-- </td>-->


                                <td>
                                    <div class="event-card">

                                        <!-- TOP SECTION -->
                                        <div class="event-header">

                                            <div class="event-left">

                                                <div class="event-icon">
                                                    <i class="bi bi-calendar-event"></i>
                                                </div>

                                                <div>
                                                    <h6 class="event-title mb-0"><?= $row->event_title ?? 'Untitled Event' ?></h6>

                                                    <small class="event-date">
                                                        <i class="bi bi-clock"></i>
                                                        <?= !empty($row->event_date)
                                                            ? date('d M Y', strtotime($row->event_date))
                                                            : '-' ?>
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- ACTION DROPDOWN -->
                                            <div class="dropdown">

                                                <button class="action-btn" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <?php if( $row->created_by == $login_id && date('Y-m-d') <= $row->end_date ){
                                                    ?>
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo base_url('edit-event/'.$row->id); ?>">

                                                                <i class="bi bi-pencil-square text-warning me-2"></i> Edit Event
                                                            </a>
                                                        </li>
                                                        <?php }
                                                            $login_id = $this->session->userdata('login_id');
                                                            $persons = !empty($row->person_involved) ? explode(',', $row->person_involved) : [];
                                                            $today = date('Y-m-d');
                                                            if ((in_array($login_id, $persons) || $row->created_by == $login_id) && $today >= $row->event_date && $today <= $row->end_date){?>

                                                            <li>
                                                                <a class="dropdown-item addLeadBtn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#customerLeadModal" data-id = "<?= $row->id ?>">

                                                                    <i class="bi bi-person-plus-fill text-primary me-2"></i> Add Lead
                                                                </a>
                                                            </li>

                                                            <?php } if(date('Y-m-d') >= $row->event_date){?>

                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#dataUploadModal" onclick="dataUpload(
                                                                            '<?= ucfirst($row->event_type ?? '-') ?>',
                                                                            <?php echo $login_id; ?>,
                                                                            <?php echo $row->id; ?>
                                                                       )">

                                                                        <i class="bi bi-upload text-success me-2"></i> Upload Data
                                                                    </a>
                                                                </li>
                                                                <?php }?>

                                                                    <!--<li>-->
                                                                    <!--    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="openDetail(-->
                                                                    <!--            '<?= ucfirst($row->event_type ?? '-') ?>',-->
                                                                    <!--            '<?= !empty($row->event_date) ? date('d-m-Y', strtotime($row->event_date)) : '-' ?>',-->
                                                                    <!--            '<?= $row->audience_target ?? '-' ?>',-->
                                                                    <!--            '<?= $row->prospect_expected ?? '-' ?>',-->
                                                                    <!--            '<?= $row->person_involved_names ?? '-' ?>',-->
                                                                    <!--            '<?= $row->manager_involved ?? '-' ?>'-->
                                                                    <!--       )">-->

                                                                    <!--        <i class="bi bi-eye text-info me-2"></i> View Details-->
                                                                    <!--    </a>-->
                                                                    <!--</li>-->

                                                </ul>

                                            </div>

                                        </div>

                                        <!-- PURPOSE -->
                                        <?php if(!empty($row->event_purpose)){ ?>
                                            <div class="event-purpose">
                                                <?= $row->event_purpose ?>
                                            </div>
                                            <?php } ?>

                                                <!-- FOOTER -->
                                                <div class="event-footer">

                                                    <span class="event-type-badge"> <?= ucfirst($row->event_type ?? '-') ?></span>

                                                    <div class="event-arrow">

                                                        <a href="javascript:void(0)" class="event-detail-btn" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="openDetail(
                                                            '<?= $row->event_title ?? '-' ?>',
                                                            '<?= ucfirst($row->event_type ?? '-') ?>',
                                                            '<?= $row->event_purpose ?? '-' ?>',
                                                            '<?= !empty($row->event_date) ? date('d M Y', strtotime($row->event_date)) : '-' ?>',
                                                            '<?= !empty($row->end_date) ? date('d M Y', strtotime($row->end_date)) : '-' ?>',
                                                            '<?= $row->audience_target ?? '-' ?>',
                                                            '<?= $row->prospect_expected ?? '-' ?>',
                                                            '<?= $row->person_involved_names ?? '-' ?>',
                                                            '<?= $row->manager_involved ?? '-' ?>',
                                                            '<?= $row->lead_count ?? 0 ?>'
                                                            )">

                                                            <i class="bi bi-arrow-up-right"></i>

                                                        </a>

                                                    </div>

                                                </div>

                                    </div>
                                </td>
                                <!--<td class="text-center"><i class="bi bi-upload action-icon text-success" data-bs-toggle="modal"-->
                                <!--     data-bs-target="#dataUploadModal"-->
                                <!--     onclick="dataUpload('<?= ucfirst($row->event_type ?? '-') ?>',<?php echo $login_id; ?>,<?php echo $row->id; ?>)" ></i></td>-->


                            </tr>
                            <?php } }else{ ?>
                                <tr> 
                                    <td colspan="3" class="text-danger text-center">No Event Created.</td>
                                </tr>
                                <?php } ?>
                    </tbody>
                </table>



            </div>
            <!--Data Upload Modal-->
            <div class="modal fade" id="dataUploadModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('save-event-data-upload'); ?>">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Your <span id="d_type"></span> Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                <input type="hidden" name="loginId" id="loginId" />
                                <input type="hidden" name="eventId" id="eventId" />
                                <input type="hidden" name="formType" value="EventForm" />
                            </div>

                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Number of People<span class="required-star"> *</span></label>
                                        <input type="number" name="numberOfPeople" class="form-control custom-input" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Data Type<span class="required-star"> *</span></label>
                                        <select name="dataType" class="form-control custom-input" onchange="changeDatatype(this.value)" required>
                                            <option value="">Select Your Data Type</option>
                                            <option value="captureImage">Capture Image</option>
                                            <option value="uploadFile">Upload File</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row g-3">
                                    <div class="col-6" id="captureImage" style="display:none">
                                        <label class="form-label">Click Image By Camera<span class="required-star"> *</span></label>
                                        <div class="mb-2">

                                            <button type="button" id="openBtn" class="btn submit-btn" onclick="openCamera()">
                                                Capture Image
                                            </button>

                                            <video id="video" autoplay playsinline style="width:250px; display:none;"></video>


                                            <img id="preview" style="display:none; width:250px; border:1px solid #ccc; margin-top:10px;" />

                                            <input type="hidden" name="img_base64" id="img_base64">

                                            <canvas id="canvas" style="display:none;"></canvas>

                                            <div class="d-flex mt-2">
                                                <button type="button" id="retakeBtn" class="btn cam-btn" style="display:none;">
                                                    Retake
                                                </button>

                                                <button type="button" id="captureBtn" class="btn cam-btn" style="display:none;">
                                                    Capture
                                                </button>
                                            </div>

                                            <p id="imageError" class="formerror" style="display:none;">
                                                Please capture an image before submitting.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6" id="uploadFile" style="display:none">
                                        <label class="form-label">Upload Your File Like PDF/Word/Image from Gallery<span class="required-star"> *</span></label>
                                        <input type="file" id="uploadFileInput" name="uploadFile" class="form-control custom-input">
                                    </div>
                                </div>



                            </div>



                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-success">Uploads</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Show Details Modal-->
            <!-- ================= EVENT DETAIL MODAL ================= -->

            <div class="modal fade" id="detailModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content event-modal">

                        <!-- HEADER -->
                        <div class="modal-header border-0 pb-0">

                            <div class="d-flex align-items-center gap-3">

                                <div class="modal-event-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>

                                <div>
                                    <h4 class="modal-title event-modal-title mb-1" id="m_title">
                            Event Title
                        </h4>

                                    <span class="event-modal-badge" id="m_type">
                            Event Type
                        </span>
                                </div>

                            </div>

                            <button type="button" class="btn-close custom-close" data-bs-dismiss="modal"></button>

                        </div>

                        <!-- BODY -->
                        <div class="modal-body pt-3">

                            <!-- PURPOSE -->
                            <div class="event-purpose-box" id="purposeWrapper" style="display:none;">
                                <div class="detail-label">
                                    <i class="bi bi-chat-left-text"></i> Purpose
                                </div>

                                <p class="mb-0" id="m_purpose"></p>
                            </div>

                            <!-- DETAILS GRID -->
                            <div class="row g-3 mt-1">

                                <!-- START DATE -->
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <div class="detail-icon bg-primary-subtle text-primary">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>

                                        <div>
                                            <span class="detail-title">Start Date</span>
                                            <h6 id="m_start_date">-</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- END DATE -->
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <div class="detail-icon bg-danger-subtle text-danger">
                                            <i class="bi bi-calendar-x"></i>
                                        </div>

                                        <div>
                                            <span class="detail-title">End Date</span>
                                            <h6 id="m_end_date">-</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- AUDIENCE -->
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <div class="detail-icon bg-info-subtle text-info">
                                            <i class="bi bi-people"></i>
                                        </div>

                                        <div>
                                            <span class="detail-title">Audience Target</span>
                                            <h6 id="m_audience">-</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- PROSPECT -->
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <div class="detail-icon bg-warning-subtle text-warning">
                                            <i class="bi bi-graph-up-arrow"></i>
                                        </div>

                                        <div>
                                            <span class="detail-title">Prospect Expected</span>
                                            <h6 id="m_prospect">-</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- LEAD COUNT -->
                                <div class="col-md-6" id="leadCountWrapper" style="display:none;">
                                    <div class="detail-card">
                                        <div class="detail-icon bg-success-subtle text-success">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </div>

                                        <div>
                                            <span class="detail-title">Customer Leads</span>
                                            <h6 id="m_leads">0</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- MANAGER -->
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <div class="detail-icon bg-dark-subtle text-dark">
                                            <i class="bi bi-person-workspace"></i>
                                        </div>

                                        <div>
                                            <span class="detail-title">Manager Involved</span>
                                            <h6 id="m_manager">-</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- PERSON INVOLVED -->
                            <div class="people-box mt-4" id="personWrapper" style="display:none;">

                                <div class="detail-label mb-3">
                                    <i class="bi bi-people-fill"></i> Person Involved
                                </div>

                                <div id="m_person" class="person-tags"></div>

                            </div>

                        </div>

                        <!-- FOOTER -->
                        <div class="modal-footer border-0 pt-0">

                            <button class="btn event-close-btn" data-bs-dismiss="modal">
                                Close
                            </button>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Customer Lead Modal -->
            <?php $this->load->view('dashboard/event_customer_form.php');?>
                <!-- Customer Lead Modal -->

        </div>
    </div>
</div>
<?php $this->load->view('common/form-script'); ?>
    <script>
            $(document).on('click', '.addLeadBtn', function () {
            let eventId = $(this).data('id');
            console.log(eventId)
            $('#event_id').val(eventId);
        });
        function changeDatatype(val) {
            const uploadFileInput = document.getElementById('uploadFileInput');
        
            if (val === 'captureImage') {
                $('#captureImage').show();
                $('#uploadFile').hide();
                uploadFileInput.removeAttribute('required');
            } 
            else if (val === 'uploadFile') {
                $('#uploadFile').show();
                $('#captureImage').hide();
                uploadFileInput.setAttribute('required', 'required');
            } 
            else {
                $('#captureImage').hide();
                $('#uploadFile').hide();
                uploadFileInput.removeAttribute('required');
            }
        }
        function dataUpload(type,loginId,eventId){
             document.getElementById('d_type').innerText = type;
             document.getElementById('loginId').value = loginId;
             document.getElementById('eventId').value = eventId;
        }
        
        
        function openDetail(title,type,purpose,startDate,endDate,audience,prospect,person,manager,leads = 0){
                console.log({
        title,
        type,
        purpose,
        startDate,
        endDate,
        audience,
        prospect,
        person,
        manager,
        leads
    }); 
        
            $('#m_title').text(title || 'Event Details');
        
            $('#m_type').text(type || '-');
        
            $('#m_start_date').text(startDate || '-');
        
            $('#m_end_date').text(endDate || '-');
        
            $('#m_audience').text(audience || '-');
        
            $('#m_prospect').text(prospect || '-');
        
            $('#m_manager').text(manager || '-');
        
            // PURPOSE
            if(purpose && purpose !== '-'){
                $('#purposeWrapper').show();
                $('#m_purpose').text(purpose);
            }else{
                $('#purposeWrapper').hide();
            }
        
            // LEADS
            if(leads && leads != 0){
                $('#leadCountWrapper').show();
                $('#m_leads').text(leads);
            }else{
                $('#leadCountWrapper').hide();
            }
        
            // PERSONS
            if(person && person !== '-'){
        
                $('#personWrapper').show();
                $('#m_person').text(person|| '-');
        
            }else{
                $('#personWrapper').hide();
            }
        }
    </script>
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
        
        /* ================= TABLE UI ================= */
        
        .custom-table{
            overflow: visible !important;
            border-collapse: separate;
            border-spacing: 0 14px;
            background: transparent !important;
        }
        
        .custom-table thead th{
            background: #f8faff;
            color: #4a5568;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: none !important;
            padding: 14px 16px;
        }
        
        .custom-table tbody tr{
            overflow: visible !important;
            background: #fff;
            transition: .3s ease;
            box-shadow: 0 4px 14px rgba(0,0,0,.05);
        }
        
        .custom-table tbody tr:hover{
            
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,0,0,.10);
        }
        
        .custom-table tbody td{
            vertical-align: middle;
            border: none !important;
            padding: 16px;
        }
        
        /* Rounded Row */
        .custom-table tbody td:first-child{
            border-radius: 18px 0 0 18px;
        }
        
        .custom-table tbody td:last-child{
            border-radius: 0 18px 18px 0;
        }
        
        /* HEADER */
        .event-header{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:15px;
        }
        
        .event-left{
            display:flex;
            align-items:center;
            gap:14px;
        }
        
        /* CARD */
        .event-card{
             z-index: 1;
            overflow: visible !important;
            position:relative;
            background:#fff;
            border-radius:24px;
            padding:20px;
            border:1px solid #eef2ff;
            transition:.3s ease;
            overflow:hidden;
            box-shadow:0 6px 18px rgba(0,0,0,.05);
        }
        
        .event-card:hover{
            transform:translateY(-3px);
            box-shadow:0 12px 30px rgba(0,0,0,.10);
        }
        
        /* LEFT BORDER */
        .event-card::before{
            content:'';
            position:absolute;
            left:0;
            top:0;
            width:5px;
            height:100%;
            background:linear-gradient(to bottom,var(--blue),#00c3ff);
        }
        
        /* ICON */
        .event-icon{
            width:58px;
            height:58px;
            border-radius:18px;
            background:linear-gradient(135deg,#edf4ff,#dce9ff);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            color:var(--blue);
        }
        
        /* TITLE */
        .event-title{
            font-size:17px;
            font-weight:700;
            color:#1e293b;
        }
        
        .event-date{
            font-size:12px;
            color:#64748b;
        }
        
        /* PURPOSE */
        .event-purpose{
            margin-top:16px;
            padding:14px;
            border-radius:16px;
            background:#f8fbff;
            border:1px dashed #d8e7ff;
            color:#475569;
            font-size:13px;
            line-height:1.7;
        }
        
        /* FOOTER */
        .event-footer{
            margin-top:18px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        
        /* BADGE */
        .event-type-badge{
            background:linear-gradient(135deg,var(--blue),#00c3ff);
            color:#fff;
            padding:8px 15px;
            border-radius:50px;
            font-size:11px;
            font-weight:700;
            letter-spacing:.5px;
        }
        
        /* ARROW */
        .event-arrow{
            width:40px;
            height:40px;
            border-radius:14px;
            background:#f1f5ff;
            transition:.3s ease;
        }
        
        .event-detail-btn{
            width:100%;
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--blue);
            text-decoration:none;
            font-size:18px;
        }
        
        .event-card:hover .event-arrow{
            background:var(--blue);
            transform:rotate(45deg);
        }
        
        .event-card:hover .event-detail-btn{
            color:#fff;
        }
        
        /* ACTION BUTTON */
        .action-btn{
            width:42px;
            height:42px;
            border:none;
            border-radius:14px;
            background:#f8fafc;
            transition:.3s ease;
        }
        
        .action-btn:hover{
            background:var(--blue);
            color:#fff;
        }
        
        /* DROPDOWN */
        .dropdown{
            position: relative;
        }
        
        /* MENU FIX */
        .dropdown-menu
         {
            transform: none !important;
            position: absolute !important;
            z-index: 99999 !important;
            inset: auto 0 auto auto !important;
            border: none;
            border-radius: 18px;
            padding: 10px;
            /* min-width: 220px; */
            box-shadow: 0 12px 35px rgba(0, 0, 0, .12); 
        }
        
        /* MAIN WRAPPERS */
        .main-div,
        .profile-wrapper,
        .tab-content,
        .tab-pane{
            overflow: visible !important;
        }
        
        .dropdown-item{
            border-radius:12px;
            padding:12px 14px;
            font-size:14px;
            transition:.2s ease;
        }
        
        .dropdown-item:hover{
            background:#f3f7ff;
            transform:translateX(4px);
        }
        
        /* ================= MODAL ================= */
        
        .event-modal{
            border:none;
            border-radius:30px;
            overflow:hidden;
            box-shadow:0 25px 60px rgba(0,0,0,.15);
            padding:10px;
        }
        
        /* ICON */
        
        .modal-event-icon{
            width:70px;
            height:70px;
            border-radius:22px;
            background:linear-gradient(135deg,#e8f1ff,#d8e7ff);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:32px;
            color:var(--blue);
        }
        
        /* TITLE */
        
        .event-modal-title{
            font-size:17px;
            font-weight:700;
            color:#1e293b;
        }
        
        /* BADGE */
        
        .event-modal-badge{
            display:inline-block;
            background:linear-gradient(135deg,var(--blue),#4f8cff);
            color:#fff;
            padding:7px 15px;
            border-radius:40px;
            font-size:11px;
            font-weight:700;
            letter-spacing:.5px;
        }
        
        /* PURPOSE */
        
        .event-purpose-box{
            background:#f8fbff;
            border:1px dashed #d6e4ff;
            border-radius:20px;
            padding:18px;
            margin-top:10px;
        }
        
        .detail-label{
            font-size:14px;
            font-weight:700;
            color:var(--blue);
            margin-bottom:10px;
        }
        
        /* DETAIL CARD */
        
        .detail-card{
            background:#fff;
            border:1px solid #eef2ff;
            border-radius:22px;
            padding:18px;
            display:flex;
            align-items:center;
            gap:16px;
            transition:.3s ease;
        }
        
        .detail-card:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }
        
        .detail-icon{
            width:52px;
            height:52px;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
        }
        
        .detail-title{
            font-size:12px;
            color:#64748b;
            display:block;
            margin-bottom:3px;
        }
        
        .detail-card h6{
            margin:0;
            font-size:17px;
            font-weight:700;
            color:#1e293b;
        }
        
        /* PEOPLE */
        
        .people-box{
            background:#f8fbff;
            border-radius:20px;
            padding:18px;
        }
        
        .person-tags{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
        }
        
        .person-chip{
            background:#fff;
            border:1px solid #dbeafe;
            color:var(--blue);
            padding:8px 14px;
            border-radius:40px;
            font-size:13px;
            font-weight:600;
        }
        
        /* BUTTON */
        
        .event-close-btn{
            background:var(--blue);
            color:#fff;
            border:none;
            border-radius:14px;
            padding:10px 22px;
            font-weight:600;
        }
        
        .event-close-btn:hover{
            background:#0b5ed7;
            color:#fff;
        }
        
        /* CLOSE */
        
        .custom-close{
            box-shadow:none !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



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
                  "<?= base_url('event-created') ?>?from=" + from + "&to=" + to;  
            }
        }
        document.getElementById('fromDate').addEventListener('change', filterByDate);
        document.getElementById('toDate').addEventListener('change', filterByDate);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/captureSanjay.js"></script> 