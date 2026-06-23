
<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
      <h4 class="profile-title">Bulk Profile Upload</h4>
        <?php if ($this->session->flashdata('register-message')): ?>
        <div class="mb-2" id="login-alert">
            <?= $this->session->flashdata('register-message'); ?>
        </div>         
        <?php endif; ?>
        
        <a class="btn btn-warning btn-sm float-end mb-3" href="<?php echo base_url();?>assets/pdf/tracker_profile.xlsx"><i class="bi bi-download me-1"></i>Download Excel Preview</a>
         <form enctype="multipart/form-data" id="bulkProfileDropzone">
            <div class="mb-2">
                <label class="form-label">Upload Excel<span class="required-star"> *</span></label>
                 <input class="form-control" name="excel_file" id="excel_file" type="file" accept=".xls,.xlsx" required> 
            </div>
    
            <div class="needsclick">
            </div>
            <button type="submit" id="uploadBtn" class="btn btn-primary">Upload Excel</button>
        </form>
</div>
</div>
<?php $this->load->view('common/form-script'); ?>
<style>
    .formerror{
        color:red;
    }
</style>

<!--<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->

<script>
$(document).ready(function () {

    $('#uploadBtn').on('click', function (e) {
        e.preventDefault();

        let fileInput = $('#excel_file')[0];

        // File check
        if (!fileInput || fileInput.files.length === 0) {
            alert("Please select a file");
            return;
        }

        let formData = new FormData();
        formData.append('excel_file', fileInput.files[0]);

        let btn = $('#uploadBtn');

        // Prevent double click
        if (btn.prop('disabled')) return;

        // Disable button + loader text
        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm"></span> Uploading...'
        );

        $.ajax({
            url: "<?= base_url('bulkprofileUpload/import_excel_ajax') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json", 

            // Loader show
            beforeSend: function () {
                $('#loader').show();
            },

            success: function (res) {

                if (res.status === 'success') {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                }
            },

            error: function (xhr) {
                console.log("ERROR:", xhr.responseText);
                alert("Something went wrong!");
            },

            // Loader hide + button enable
            complete: function () {
                $('#loader').hide();
                btn.prop('disabled', false).html('Upload Excel');
            }
        });
    });

});
</script>