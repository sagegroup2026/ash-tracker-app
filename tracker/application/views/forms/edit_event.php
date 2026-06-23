<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Event</h4>
    <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('update-event'); ?>">
      
    <input type="hidden" name="id" value="<?php echo $event->id ?>">  
    <!-- Type of Event -->
    <div class="mb-3">
      <label class="form-label">Type of Event<span class="required-star"> *</span></label>
      <!--<input type="text" name="event_type" class="form-control custom-input">-->
      
      <select name="event_type" class="form-control custom-input" required>
          <option value="">Select Type of Event</option>
           <?php foreach($event_types as $key => $value): ?>
                <option value="<?= $key ?>" <?php if($event->event_type == $key){ echo 'selected'; } ?>>
                    <?= $value ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <!-- Event Title -->
    <div class="mb-3">
      <label class="form-label">Event Title<span class="required-star">*</span></label>
      <input type="text" name="event_title" value="<?php echo $event->event_title; ?>" class="form-control custom-input" required>
    </div>
    
    <!-- Purpose of Event-->
    <div class="mb-3">
      <label class="form-label">Event Purpose<span class="required-star">*</span></label>
      <input type="text" name="event_purpose" value="<?php echo $event->event_purpose; ?>" class="form-control custom-input" required>
    </div>
    
    <!--Event Date-->
    <div class="row row-cols-2">
        <div class="col-md-6">
            <!-- Start Date -->
            <div class="mb-3">
              <label class="form-label">Start Date <span class="required-star">*</span></label>
              <input type="date" name="event_date" value="<?php echo $event->event_date; ?>" class="form-control custom-input common-date date-no-past" required>
            </div>
        </div>
        <div class="col-md-6">
            <!-- End Date -->
            <div class="mb-3">
              <label class="form-label">End Date <span class="required-star">*</span></label>
              <input type="date" name="end_date" value="<?php echo $event->end_date; ?>"  class="form-control custom-input common-date date-no-past" required>
            </div>
        </div>
    </div>
    
    <!--State/City-->
    <div class="row row-cols-2">
        <div class="col-md-6">
            <div class="mb-3">
            <label class="form-label">State<span class="required-star">*</span></label>
            <select class="form-control select2 select-dropdown"  name="state" id="stateId" onchange="getcitiesBystate(this.value);" required>
                <option value="">Select State</option>
                <?php foreach ($state as $c) { ?>
                    <option value="<?= $c->id ?>" <?php if($event->state == $c->id){ echo 'selected'; } ?>>
                        <?= $c->name ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
            <label class="form-label">City<span class="required-star">*</span></label>
            <select class="form-control select2 select-dropdown" name="city" id="cities" data-selected="<?php echo $event->city; ?>" required>
                <option value="">Select City</option>
            </select>
        </div>
        </div>
    </div>
    
    <!-- Target Audience -->
    <div class="mb-3">
      <label class="form-label">Target Audience<span class="required-star">*</span></label>
      <input type="number" name="audience_target" value="<?php echo $event->audience_target; ?>"  min="1" class="form-control custom-input" required>
    </div>
    
    <!-- Prospect expected -->
    <div class="mb-3">
      <label class="form-label">No. of Prospect Expected<span class="required-star">*</span></label>
      <input type="number" name="prospect_expected" value="<?php echo $event->prospect_expected; ?>"  min="1" class="form-control custom-input" required>
    </div> 
    
    <!-- Manager Involved -->
    <div class="mb-3">
      <label class="form-label">Manager Involved<span class="required-star">*</span></label>
      <div>
        <input type="radio" name="manager_involved" value="Yes" <?php if($event->manager_involved == 'Yes'){ echo 'checked'; } ?> id="refPoc" required>
        <span class="form-label">Yes</span>
    
        <input type="radio" name="manager_involved" value="No" <?php if($event->manager_involved == 'No'){ echo 'checked'; } ?> id="refDoctor" class="ms-3">
        <span class="form-label">No</span>
      </div>
    </div>
    
    <!-- Person Involved -->
    <div class="mb-3">
      <label class="form-label">No. of Person Involved<span class="required-star">*</span></label>
       <select class="form-control select2 select-dropdown" name="person_involved[]" id="person_involved" multiple required>
        <?php $persons = explode(',', $event->person_involved); ?>

        <?php foreach ($getAgentInvolved as $c) { ?> 
            <option value="<?= $c->id ?>"
                <?php if(in_array($c->id, $persons)){ echo 'selected'; } ?>>
                <?= $c->name ?>
            </option>
        <?php } ?>
        </select>
    </div>
    <!--Image Upload-->
    <div class="mb-3">
      <label class="form-label">Image</label>
      <input type="file" name="event_image" class="form-control custom-input">
    </div>
    
    <div class="">
      <button type="submit" class="btn submit-btn">Update</button>
    </div>

  </form>
</div>
</div>

<style>
    .required-star{
        color:red;
    }
    
    .select2-container .select2-selection--single,
.select2-container .select2-selection--multiple{
    min-height: 38px;
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 36px;
}

.select2-container .select2-search--inline .select2-search__field {
    margin-top: 8px;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function getcitiesBystate(stateId)
{
    $.ajax({
        url: "<?php echo base_url('get-state-city-ajax'); ?>",
        type: "POST",
        data: {
            type: "getCities",
            state_id: stateId
        },

        success: function(response)
        {
            let data = JSON.parse(response);

            let selectedCity = $('#cities').attr('data-selected');

            $('#cities').html('<option value="">Select City</option>');

            data.forEach(function(city) {

                let selected = '';

                if(selectedCity == city.id){
                    selected = 'selected';
                }

                $('#cities').append(
                    '<option value="'+city.id+'" '+selected+'>'+city.name+'</option>'
                );

            });

            $('#cities').trigger('change');
        },

        error: function(xhr)
        {
            console.log(xhr.responseText);
        }
    });
}
</script>
<script>
$(document).ready(function () {

    // State Select2
    $('#stateId').select2({
        placeholder: "Select State",
        allowClear: true,
        width: '100%'
    });

    // City Select2
    $('#cities').select2({
        placeholder: "Select City",
        allowClear: true,
        width: '100%'
    });

    // Agent Multi Select
    $('#person_involved').select2({
        placeholder: "Select Agents",
        allowClear: true,
        width: '100%'
    });
    
     // Load cities on edit page
    let stateId = $('#stateId').val();

    if(stateId != ''){
        getcitiesBystate(stateId);
    }

});
</script>
<script>
    const form = document.querySelector('form');

    form.addEventListener('submit', function() {
      const submitButton = form.querySelector('button[type="submit"]');
      
      // Disable the button to prevent further clicks
      submitButton.disabled = true;
      
      // Optional: Provide visual feedback
      submitButton.innerText = 'Submitting...';
    });

</script>