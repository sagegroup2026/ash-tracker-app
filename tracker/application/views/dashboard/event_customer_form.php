<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
<!-- Customer Lead Modal -->
          <div class="modal fade" id="customerLeadModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content customer-form">
        
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-user-plus me-2"></i>Add Customer Lead</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
        
                    <form enctype="multipart/form-data" id="eventForm" action="<?= base_url('save-event-customer-lead') ?>" method="POST">
        
                        <div class="modal-body">
        
                            <div class="row">
                                <input type="hidden" name="event_id" id="event_id">
        
                                <!-- Lead Type -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lead Type <span class="required-star">*</span></label>
        
                                    <select class="form-control custom-input" name="lead_type" id="lead_type" onchange="changeLeadOptions(this.value)" required>
                                        <option value="">Select Lead Type</option>
                                        <option value="healthcare">Healthcare</option>
                                        <option value="real_estate">Real Estate</option>
                                        <option value="education">Education</option>
                                    </select>
                                </div>
        
                                <!-- Dynamic Option -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lead For <span class="required-star">*</span></label>
        
                                    <select class="form-control custom-input" 
                                            name="lead_for" 
                                            id="lead_source"
                                            required>
        
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
        
                                <!-- Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Customer Name <span class="required-star">*</span></label>
                                    <input type="text" name="customer_name"  oninput="validateInput(event, 'name')" class="form-control custom-input" required>
                                    <span class="formerror" data-for="name"></span>
                                </div>
        
                                <!-- Mobile -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Customer Contact <span class="required-star">*</span></label>
                                    <input type="number" name="customer_mobile"  oninput="validateInput(event, 'phone')" class="form-control custom-input" required>
                                    <span class="formerror" data-for="phone"></span>
                                </div>
        
                               <!--State/City-->
                                <div class="row row-cols-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                        <label class="form-label">State <span class="required-star">*</span></label>
                                        <select class="form-control custom-input select2 select-dropdown"  name="state" id="stateId" onchange="getcitiesBystate(this.value);" required>
                                            <option value="">Select State</option>
                                                                                        
                                            <?php

                                            foreach ($state as $c) { ?>
                                                <option value="<?= $c->id ?>">
                                                    <?= $c->state_name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                        <label class="form-label">City <span class="required-star">*</span></label>
                                        <select class="form-control custom-input select2 select-dropdown" name="city" id="cities" required>
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>
        
                                <!-- Followup Date -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Followup Date <span class="required-star">*</span></label>
                                    <input type="date" name="followup_date" class="form-control custom-input" required>
                                </div>
        
                                <!-- Remark -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Remark</label>
                                    <textarea class="form-control custom-input" name="remark" rows="3"></textarea>
                                </div>
        
                            </div>
        
                        </div>
        
                        <div class="modal-footer">
                            <button type="submit" class="btn submit-btn">
                                Save Lead
                            </button>
                        </div>
        
                    </form>
        
                </div>
            </div>
          </div>
          <!-- Customer Lead Modal -->
<style>
    .required-star,.formerror{
        color:red;
    }
    
    .customer-form {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    
    .customer-form .modal-header {
        background: #00799E;
        color: #fff !important;
        border: none;
    }
       .customer-form .modal-header .modal-title{
           color:#fff;
       } 
   
    .btn-close {
        filter: brightness(0) invert(1);
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
<script src="<?php echo base_url();?>assets/plugins/select2/select2.min.js"></script> 

<script>
console.log($('#img_base64').val());

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
            console.log(response);

            let data = JSON.parse(response);

            $('#cities').html('<option value="">Select City</option>');

            data.forEach(function(city) {

                $('#cities').append(
                    '<option value="'+city.id+'">'+city.city_name+'</option>'
                );

            });
            
            // Refresh Select2
            $('#cities').select2({
                dropdownParent: $('#customerLeadModal'),
                placeholder: "Select City",
                allowClear: true,
                width: '100%'
            });
        },

        error: function(xhr)
        {
            console.log(xhr.responseText);
        }
    });
}
</script>
<script>

function changeLeadOptions(type)
{
    let options = '<option value="">Select Option</option>';

    // Healthcare
    if(type == 'healthcare')
    {
        options += `
            <option value="ASH">ASH</option>
        `;
    }

    // Real Estate
    else if(type == 'real_estate')
    {
        options += `
            <option value="Project 1">Project 1</option>
            <option value="Project 2">Project 2</option>
            <option value="Project 3">Project 3</option>
        `;
    }

    // Education
    else if(type == 'education')
    {
        options += `
            <option value="SUB">SUB</option>
            <option value="SIRT">SIRT</option>
            <option value="SUI">SUI</option>
            <option value="SIS_AN">SIS_AN</option>
            <option value="SIS_DK">SIS_DK</option>
        `;
    }

    $('#lead_source').html(options);
}

</script>
<script>
$(document).ready(function () {

    // State Select2
    $('#stateId').select2({
        dropdownParent: $('#customerLeadModal'),
        placeholder: "Select State",
        allowClear: true,
        width: '100%'
    });

    // City Select2
    $('#cities').select2({
        dropdownParent: $('#customerLeadModal'),
        placeholder: "Select City",
        allowClear: true,
        width: '100%'
    });

});
</script>