<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
   #loader-wrapper{
    position: fixed;
    inset: 0;
    background: rgba(255,255,255,0.7);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
}

#loader-box{
    text-align: center;
}

#loader-box img{
    width: 80px;
    max-width: 20vw;
    height: auto;
}
</style>
<!-- Loader Structure -->
<!--<div id="loader-wrapper" style="display:none;">-->
<!--    <div id="loader">-->
<!--        <img src="<?php // echo base_url('assets/mainLoader.gif'); ?>" alt="Loading...">-->
<!--    </div>-->
<!--</div>-->

<div class="main-div">
  <div class="profile-wrapper">

 <h4 class="profile-title">Follow Ups</h4>

    <!-- Tabs -->
    <div class="visit-tabs mb-3">
      <ul class="nav nav-pills nav-fill custom-tabs">
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pendingTab">
            Pending
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#todayTab">
            Today
          </button>
        </li>
      </ul>
    </div>
    
    

    <div class="tab-content">

      <!-- TODAY FOLLOWUPS -->
      <div class="tab-pane fade show active" id="todayTab">
        <button class="btn btn-warning btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addPlanModal">
            <i class="bi bi-plus"></i> Add plan
        </button>
        <table class="table custom-table">
          <thead>
            <tr>
              <th class="">S.No.</th>
              <th class="">Details</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $login_id = $this->session->userdata('login_id');
              $today_followups = getTodayfollowups($login_id);
             //echo $this->db->last_query();
            //   echo "<pre>";print_r($today_followups);
              if(!empty($today_followups)){
                $x = 1;
                foreach($today_followups as $g){
            ?>
            <tr>
              <td class="text-center"><?php echo $x++; ?></td>
              <td>
                  <?php if(!empty($g->profile_id)){ ?>
                    <strong class="text-info"><?php echo $g->profile_id; ?></strong><br>
                  <?php } ?>
                  
                  <?php if(!empty($g->profile_name)){ ?>
                    <strong><?php echo $g->profile_name; ?><br>(<?php echo $g->follow_up_date; ?>)</strong><br>
                  <?php } ?>
                
                  <?php if(!empty($g->profile_add)){ ?>
                    <small><?php echo $g->profile_add; ?></small><br>
                  <?php } ?>
                
                  <?php if(!empty($g->poc_name) || !empty($g->poc_contact)){ ?>
                    <span class="meta">
                      POC:
                      <?php if(!empty($g->poc_name)) echo $g->poc_name; ?>
                      <?php if(!empty($g->poc_contact)) echo ' ('.$g->poc_contact.')'; ?>
                    </span>
                  <?php } ?>
                </td>
            
               <td>
                <?php if($g->status == '2' || ($g->status == '1' && $g->follow_up_date == date('Y-m-d')) ){ ?>
                <a href="javascript:void(0)"
                   class="btn btn-success btn-sm meeting-btn"
                   data-profileid="<?php echo $g->profile_id;?>"
                   data-name="<?php echo $g->profile_name;?>"
                   onclick="startMeeting(this)">
                   Start Meeting
                </a>
                <?php } else if($g->status == '1' && date('Y-m-d', strtotime($g->created_at)) == date('Y-m-d')) { ?>
                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm meeting-btn"  onclick="doneMeeting(this)">
                      Done
                    </a>
                <?php } else if($g->status == '3'){ ?>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm meeting-btn meetingActive" data-profileid="<?php echo $g->profile_id;?>" data-name="<?php echo $g->profile_name;?>"  onclick="endMeeting(this)">End Meeting</a>
                <?php }?>
                </td>
            </tr>
            <?php } } else { ?>
            <tr>
              <td colspan="3" class="text-danger text-center">
                No Today Followups.
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <!-- PENDING FOLLOWUPS -->
      <div class="tab-pane fade" id="pendingTab">
        <table class="table custom-table">
          <thead>
            <tr>
              <th class="">S.No.</th>
              <th class="">Details</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $pending_followups = getPendingfollowups($login_id);

              if(!empty($pending_followups)){
                $x = 1;
                foreach($pending_followups as $g){
            ?>
            <tr>
              <td class="text-center"><?php echo $x++; ?></td>
              <td>
                  <?php if(!empty($g->profile_name)){ ?>
                    <strong><?php echo $g->profile_name; ?></strong><br>
                  <?php } ?>
                
                  <?php if(!empty($g->profile_add)){ ?>
                    <small><?php echo $g->profile_add; ?></small><br>
                  <?php } ?>
                
                  <?php if(!empty($g->poc_name) || !empty($g->poc_contact)){ ?>
                    <span class="meta">
                      POC:
                      <?php if(!empty($g->poc_name)) echo $g->poc_name; ?>
                      <?php if(!empty($g->poc_contact)) echo ' ('.$g->poc_contact.')'; ?>  
                    </span>
                  <?php } ?>
                </td>
                
               <td>
                <?php 
                
                if($g->status == '2' || ($g->status == '1' && $g->follow_up_date < date('Y-m-d')) ){ ?>
                <a href="javascript:void(0)"
                   class="btn btn-success btn-sm meeting-btn"
                   data-profileid="<?php echo $g->profile_id;?>"
                   data-name="<?php echo $g->profile_name;?>"
                   onclick="startMeeting(this)">
                   Start Meeting
                </a>
                <?php } else if($g->status == '1' && date('Y-m-d', strtotime($g->created_at)) == date('Y-m-d')) { ?>
                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm meeting-btn"  onclick="doneMeeting(this)">
                      Done
                    </a>
                <?php } else if($g->status == '3'){ ?>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm meeting-btn meetingActive" data-profileid="<?php echo $g->profile_id;?>" data-name="<?php echo $g->profile_name;?>"  onclick="endMeeting(this)">End Meeting</a>
                <?php }?>
                </td>

            </tr>
            <?php } } else { ?>
            <tr>
              <td colspan="3" class="text-danger text-center">
                No Pending Followups.
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>
    
    <?php
        $today_ids = [];
        
        
        if(!empty($today_followups)){
            foreach($today_followups as $t){
                $today_ids[] = $t->profile_id;
            }
        }
    ?>
    <div class="modal fade" id="addPlanModal">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <div class="modal-header">
            <h5 class="modal-title">Add Plan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
            
             <form method="POST" id="planForm" action="<?php echo base_url('test/save_add_plan'); ?>">
            
                <div class="mb-3">
            
                    <label class="form-label">Profile*</label>
                    
                    <select class="form-control select2-users" name="profileName[]" multiple>
                    <?php 
                    $today_followups = getTodayfollowups($login_id);
                    // print_r($profile);
                    foreach($profile as $p){ 

                        $selected = in_array($p->profile_id, $today_ids) ? 'selected' : '';
                        $disabled = in_array($p->profile_id, $today_ids) ? 'disabled' : '';
                        if(empty($disabled)){
                        ?>
                        
                        <option value="<?= $p->profile_id ?>" <?= $selected ?> <?= $disabled ?>>
                            <?= $p->name ?>
                        </option>
                        
                        <?php } } ?>
                    
                    </select>
                    
                    </div>
            
                <div class="text-end">
                <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                </div>
            
            </form>
            
            </div>
            </div>
        </div>
    </div>
  </div>
</div>

<style>
    .formerror{
        color:red;
    }
    
    .select2-container--default .select2-selection--multiple{
border:1px solid #ced4da;
min-height:42px;
padding:5px;
border-radius:6px;
}

.select2-dropdown{
border-radius:8px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.select2-results__option{
padding:8px 12px;
}

.select2-results__option:before{
content:"☐ ";
margin-right:6px;
}

/* selected options */
.select2-results__option--selected:before{
content:"☑ ";
}

/* disabled + selected options (already added profiles) */
.select2-results__option[aria-disabled=true].select2-results__option--selected:before{
content:"☑ ";
}

/* disabled grey */
.select2-results__option[aria-disabled=true]{
color:#999;
background:#f5f5f5;
}
    
</style>




<script>

let meetingActive = false;

function startMeeting(btn){

    if (document.querySelector('.meetingActive')) {
        alert("A meeting is already running. Please end the current meeting first.");
        return;
    }else{
        
            $("#loader-wrapper").show();
            
        
                // if(meetingActive){
                //     alert("A meeting is already running. Please end the current meeting first.");
                //     return;
                // }
            
                let profileid = btn.getAttribute("data-profileid");
                let name = btn.getAttribute("data-name");
            
                $.ajax({
                    url: "<?= base_url('visit-start-meeting') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        profile_id: profileid,
                        profile_name: name
                    },
                    success: function(res){
                        if(res.status == "success"){
                            meetingActive = true;
                            alert("Meeting Started Successfully");
                            $(".meeting-btn").prop("disabled", true);
                            $(btn).prop("disabled", false);
                            $(btn).removeClass("btn-success").addClass("btn-danger meetingActive").text("End Meeting").attr("onclick","endMeeting(this)");
                           $("#loader-wrapper").hide();
                        }
                    },
                    error:function(){
                        alert("Something went wrong while starting meeting.");
                    }
                });


        }
}


function endMeeting(btn){

    let profileid = btn.getAttribute("data-profileid");
    let profileName = btn.getAttribute("data-name");
    window.location.href =
    "<?= base_url('test-visit') ?>?profile_id="+profileid+"&profile_name=" + encodeURIComponent(profileName);
}

function doneMeeting(btn){
    alert("Visit Already Done!")
}

</script>
<script>

$(document).ready(function(){

$('.select2-users').select2({
placeholder: "Select Users",
closeOnSelect:false,
width:'100%',
dropdownParent: $('#addPlanModal')
});

});



</script>
<script>
document.getElementById("planForm").addEventListener("submit", function(e) {
    let form = this;
    let submitBtn = document.getElementById("submitBtn");

    if (form.dataset.submitted === "true") {
        e.preventDefault();
        return false;
    }

    form.dataset.submitted = "true";
    submitBtn.disabled = true;
    submitBtn.innerText = "Submitting...";

    document.getElementById("loader-wrapper").style.display = "block";
});
</script>