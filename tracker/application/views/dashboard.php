<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<style>
  .d-card{
    color:black;
  }
</style>
<section class="dashboard container">
    <!--<h1>Dashboard</h1>-->
    <div class="row">
        <!-- date range -->
        <div class="date-range">
            <div>
                <label class="form-label">From</label><br>
                <input type="date" class="custom-input common-date" id="fromDate"
                    value="<?= !empty($from) ? $from : date('Y-m-01'); ?>">
            </div>

            <div>
                <label class="form-label">To</label><br>
                <input type="date" class="custom-input common-date" id="toDate"
                    value="<?= !empty($to) ? $to : date('Y-m-d'); ?>">
            </div>
        </div>

        <!-- Profile Created -->
        <div class="col-6">
           <a href="<?php echo base_url();?>profile-created">
            <div class="d-card">
                
                    <div class="icon-card">
                        <div class="icon-rect">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                
                <p class="tag-line"><b>Profiles Created</b></p>
                <div class="t-line-center">
                    <div class="target text-center">
                        <b>
                            <?php echo getTotalTargetById('tracker_profile_form',$login_id);?>
                        </b><br> <span class="text">Overall</span>
                    </div>
                </div>
                <div class="t-line">
                    <div class="target">
                        <b>
                            <?php echo $target->profile_created ?? '0';?>
                        </b> <br> <span class="text">Target</span>
                    </div>
                    <div class="target text-end">
                        <b>
                            <?php echo getAchievedTargetById('tracker_profile_form',$login_id,$from,$to,'');?>
                        </b><br> <span class="text">Achieved</span>
                    </div>
                </div>
            </div>
           </a>
        </div>
        <!-- Poc Created -->
        <div class="col-6">
            <a href="<?php echo base_url();?>poc-created">
            <div class="d-card">
                
                    <div class="icon-card">
                        <div class="icon-rect" style="background:#ffe3e2;">
                            <i class="bi bi-person-plus-fill" style="color:#ffa29f;"></i>
                        </div>
                    </div>
                
                <p class="tag-line"><b>POC Onboarded</b></p>
                <div class="t-line-center">
                    <div class="target text-center">
                        <b>
                            <?php echo getTotalTargetById('tracker_poc',$login_id);?>
                        </b><br> <span class="text">Overall</span>
                    </div>
                </div>
                <div class="t-line">
                    <div class="target">
                        <b>
                            <?php echo $target->poc_onboard ?? '0';?>
                        </b><br> <span class="text">Target</span>
                    </div>
                    <div class="target text-end">
                        <b>
                            <?php echo getAchievedTargetById('tracker_poc',$login_id,$from,$to,'');?>
                        </b><br> <span class="text">Achieved</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <!-- Healthcare -->
        <div class="col-6">
             <a href="<?php echo base_url();?>healthcheckup-created">
            <div class="d-card">
               
                    <div class="icon-card">
                        <div class="icon-rect" style="color:#ffbab8; background:#aae9fd;">
                            <i class="bi bi-heart-pulse" style="color:#26c6f9;"></i>
                        </div>
                    </div>
                
                <p class="tag-line"><b>Health Checkup</b></p>
                <div class="t-line-center">
                    <div class="target text-center">
                        <b>
                            <?php echo getTotalTargetById('tracker_patient',$login_id,'Healthcheckup');?>
                        </b><br> <span class="text">Overall</span>
                    </div>
                </div>
                <div class="t-line">
                    <div class="target">
                        <b>
                            <?php echo $target->healthcheckup ?? '0';?>
                        </b><br> <span class="text">Target</span>
                    </div>
                    <div class="target text-end">
                        <b>
                            <?php echo getAchievedTargetById('tracker_patient',$login_id,$from,$to,'Healthcheckup');?>
                        </b><br> <span class="text">Achieved</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <!-- IPD -->
        <div class="col-6">
            <a href="<?php echo base_url();?>ipd-created">
            <div class="d-card">
                
                    <div class="icon-card">
                        <div class="icon-rect" style="background:#fff3dd;">
                            <i class="bi bi-hospital-fill" style="color:#fdb528;"></i>
                        </div>
                    </div>
                
                <p class="tag-line"><b>IPD</b></p>
                <div class="t-line-center">
                    <div class="target text-center">
                        <b>
                            <?php echo getTotalTargetById('tracker_patient',$login_id,$from,$to,'IPD');?>
                        </b><br> <span class="text">Overall</span>
                    </div>
                </div>
                <div class="t-line">
                    <div class="target">
                        <b>
                            <?php echo $target->ipd ?? '0';?>
                        </b><br> <span class="text">Target</span>
                    </div>
                    <div class="target text-end">
                        <b>
                            <?php echo getAchievedTargetById('tracker_patient',$login_id,$from,$to,'IPD');?>
                        </b><br> <span class="text">Achieved</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <!-- OPD -->
        <div class="col-6">
            <a href="<?php echo base_url();?>opd-created">
                <div class="d-card">
                     <div class="icon-card">
                            <div class="icon-rect" style="background:#e8fadd;">
                                <i class="bi bi-person-lines-fill" style="color:#87e548;"></i>
                            </div>
                        </div>
                    
                    <p class="tag-line"><b>OPD</b></p>
                    <div class="t-line-center">
                        <div class="target text-center">
                            <b>
                                <?php echo getTotalTargetById('tracker_patient',$login_id,$from,$to,'OPD');?>
                            </b><br> <span class="text">Overall</span>
                        </div>
                    </div>
                    <div class="t-line">
                        <div class="target">
                            <b>
                                <?php echo $target->opd ?? '0';?>
                            </b><br> <span class="text">Target</span>
                        </div>
                        <div class="target text-end">
                            <b>
                                <?php echo getAchievedTargetById('tracker_patient',$login_id,$from,$to,'OPD');?>
                            </b><br> <span class="text">Achieved</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Admission -->
        <div class="col-6">
            <a href="<?php echo base_url();?>admission-created">
            <div class="d-card">
                
                    <div class="icon-card">
                        <div class="icon-rect" style="background:#e7e7ff;">
                            <i class="bi bi-door-open-fill" style="color:#666cff;"></i>
                        </div>
                    </div>
                
                <p class="tag-line"><b>Admissions</b></p>
                <div class="t-line-center">
                    <div class="target text-center">
                        <b>
                            <?php echo getTotalTargetById('tracker_admission',$login_id);?>
                        </b><br> <span class="text">Overall</span>
                    </div>
                </div>
                <div class="t-line">
                    <div class="target">
                        <b>
                            <?php echo $target->admission ?? '0';?>
                        </b><br> <span class="text">Target</span>
                    </div>
                    <div class="target text-end">
                        <b>
                            <?php echo getAchievedTargetById('tracker_admission',$login_id,$from,$to,'');?>
                        </b><br> <span class="text">Achieved</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <!-- Booking -->
        <div class="col-6">
            <a href="<?php echo base_url();?>booking-created">
            <div class="d-card">
                
                    <div class="icon-card">
                        <div class="icon-rect" style="background:#fadafa">
                            <i class="bi bi-calendar-check-fill" style="color:#ed95ea;"></i>
                        </div>
                    </div>
                
                <p class="tag-line"><b>Bookings</b></p>
                <div class="t-line-center">
                    <div class="target text-center">
                        <b>
                            <?php echo getTotalTargetById('tracker_booking',$login_id);?>
                        </b><br> <span class="text">Overall</span>
                    </div>
                </div>
                <div class="t-line">
                    <div class="target">
                        <b>
                            <?php echo $target->booking ?? '0';?>
                        </b><br> <span class="text">Target</span>
                    </div>
                    <div class="target text-end">
                        <b>
                            <?php echo getAchievedTargetById('tracker_booking',$login_id,$from,$to,'');?>
                        </b><br> <span class="text">Achieved</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <!-- Visit -->
        <div class="col-6">
            <a href="<?php echo base_url();?>visit-created">
            <div class="d-card">
                
                    <div class="icon-card">
                        <div class="icon-card">
                            <div class="icon-rect" style="background:#dafafa">
                                <i class="bi bi-person-check" style="color:#14dfdf;"></i>
                            </div>
                        </div>
              
            </div>
             
            <p class="tag-line"><b>Visit</b></p>
            <div class="t-line-center">
                <div class="target text-center">
                    <b>
                        <?php echo getTotalTargetById('tracker_visit_form',$login_id);?>
                    </b><br> <span class="text">Overall</span>
                </div>
            </div>
            <div class="t-line">
                <div class="target">
                    <b>
                        <?php echo $target->visit ?? '0';?>
                    </b><br> <span class="text">Target</span>
                </div>
                <div class="target text-end">
                    <b>
                        <?php echo getAchievedTargetById('tracker_visit_form',$login_id,$from,$to,'');?>
                    </b><br> <span class="text">Achieved</span>
                </div>
            </div>
        </div>
        </a>
    </div>
        <!-- In House Meetings -->
        <div class="col-6">
            <a href="<?php echo base_url();?>inhousemeetings-created">
            <div class="d-card d-flex">
                <div>
                    
                        <div class="icon-card-one">
                            <div class="icon-rect" style="background:#bdffda">
                                <i class="bi bi-person-workspace" style="color:#3bc176;"></i>
                            </div>
                    
                </div>
               
                <p class="tag-line t2"><b>In House <br> Meetings</b></p>
            </div>
    
            <div class="t-line">
                <div class="target text-end">
                    <b>
                        <?php echo getAchievedTargetById('tracker_in_house_working',$login_id,$from,$to,'');?>
                    </b>
                </div>
            </div>
        </div>
         </a>
        </div>
        <!-- Agreement Preparation -->
        <div class="col-6">
            <a href="<?php echo base_url();?>agreement-preparation-created">
            <div class="d-card d-flex">
                <div>
                    
                        <div class="icon-card-one">
                            <div class="icon-rect" style="background:#a6a7fa">
                                <i class="bi bi-file-earmark-medical" style="color:#282bf8;"></i>
                            </div>
                   
                </div>
                 
                <p class="tag-line t2"><b>Agreement Preparation</b></p>
            </div>
    
            <div class="t-line">
                <div class="target text-end">
                    <b>
                        <?php echo getAchievedTargetById('tracker_operation',$login_id,$from,$to,'');?>
                    </b>
                </div>
            </div>
        </div>
        </a>
        </div>
        <!-- Events -->
        <div class="col-6">
            <a href="<?php echo base_url();?>event-created">
            <div class="d-card d-flex">
                <div>
                    
                        <div class="icon-card-one">
                            <div class="icon-rect" style="background:#ffcfcf">
                                <i class="bi bi-lightning-charge" style="color:#ff6666;"></i>
                            </div>
                   
                </div>
                 
                <p class="tag-line t2"><b>Events</b></p>
            </div>
    
            <div class="t-line">
                <div class="target text-end">
                    <b>
                        <?php echo getAchievedTargetById('tracker_event',$login_id,$from,$to,'');?>
                    </b>
                </div>
            </div>
        </div>
          </a>
        </div>
        <!-- Upcountry Events -->
        <div class="col-6">
            <a href="<?php echo base_url();?>upcountry-event">
                <div class="d-card">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="icon-rect" style="background:#d9f7df">
        
                                <i class="bi bi-globe-central-south-asia" style="color:#28a745;"></i>
        
                            </div>
                        </div>
                        <p class="tag-line t2 text-center">
                            <b>All Events</b>
                        </p>
                </div>
            </a>
        </div>
    </div>
</section>

<style>
    .dashboard {
    padding: 10px 26px 114px 26px;

    }

    .d-card {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        padding: 20px;
        border-radius: 20px;
        background: #fff;
        margin-bottom: 15px;
    }

    .d-card.d-flex {
        align-items: center;
        justify-content: space-between;
    }

    .icon-card {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-card-one {
        display: flex;
    }

    .icon-rect {
        border-radius: 10px;
        display: inline-block;
        padding: 5px 20px;
        background: #a1c7ff54;
    }

    .icon-rect i {}

    .icon-rect i {
        color: #78afff;
        font-size: 30px;
    }

    .tag-line {
        font-size: 13px;
        text-align: center;
        margin: 10px 0px;
    }

    .t2 {
        text-align: start;
    }

    .t-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .t-line-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text {
        font-size: 10px;
    }
</style>

<script>
    function filterByDate() {
        const from = document.getElementById('fromDate').value;
        const to = document.getElementById('toDate').value;

        if (from && to) {
            window.location.href =
                "<?= base_url('dashboard') ?>?from=" + from + "&to=" + to;
        }
    }

    document.getElementById('fromDate').addEventListener('change', filterByDate);
    document.getElementById('toDate').addEventListener('change', filterByDate);
</script>