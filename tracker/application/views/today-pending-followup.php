<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />

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
        <table class="table custom-table">
          <thead>
            <tr>
              <th class="">S.No.</th>
              <th class="">Details</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $login_id = $this->session->userdata('login_id');
              $today_followups = getTodayfollowups($login_id);

              if(!empty($today_followups)){
                $x = 1;
                foreach($today_followups as $g){
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

            </tr>
            <?php } } else { ?>
            <tr>
              <td colspan="2" class="text-danger text-center">
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

            </tr>
            <?php } } else { ?>
            <tr>
              <td colspan="2" class="text-danger text-center">
                No Pending Followups.
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
