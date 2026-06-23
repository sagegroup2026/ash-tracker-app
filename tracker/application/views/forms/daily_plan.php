<link href="<?php echo base_url();?>assets/stylesheet/common/form.css" rel="stylesheet" />
<div class="main-div">
    <div class="profile-wrapper">
  <h4 class="profile-title">Daily Plan</h4>
    <?php if ($this->session->flashdata('register-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('register-message'); ?>
    </div>         
    <?php endif; ?>
  <form method="POST" enctype="multipart/form-data"
        action="<?php echo base_url('save-daily-plan'); ?>">
    
     <!-- Profile Name -->
    <div class="mb-3">
    <label class="form-label">Profile<span class="required-star"> *</span></label>
    
        <div class="multi-select">
        
            <div class="select-btn" onclick="toggleDropdown()">
                <span id="selectedText">Select Option</span>
             <span class="arrow"><i class="bi bi-chevron-down"></i></span>
            </div>
        
            <div class="dropdown-list" id="dropdownList">
    
                <?php foreach($profile as $p){ ?>
                <label class="option">
                    <input type="checkbox" value="<?= $p->id;?>" name="profileName[]">&#32;<?= $p->name;?> 
                </label>
                <?php }?>
            </div>
        </div>
    </div>

    <div class="">
      <button type="submit" class="btn submit-btn">Submit</button> 
    </div>

  </form>
</div>
</div>
<?php $this->load->view('common/form-script'); ?>
<style>
    .formerror{
        color:red;
    }
    
    .multi-select{
    width:100%;
    position:relative;
    }
    
    .select-btn{
        border:1px solid #ccc;
        padding:10px;
        border-radius:6px;
        background:#fff;
        cursor:pointer;
        display:flex;
        justify-content:space-between;
    }
    
    .dropdown-list{
        display:none;
        position:absolute;
        width:100%;
        background:#fff;
        border:1px solid #ddd;
        border-radius:6px;
        margin-top:5px;
        padding:10px;
        box-shadow:0 4px 8px rgba(0,0,0,0.1);
    }
    
    .option{
        display:block;
        margin-bottom:8px;
        cursor:pointer;
    }
    
    .show{
        display:block !important;
    }
</style>

<script>
    function toggleDropdown(){
    document.getElementById("dropdownList").classList.toggle("show");
}

document.querySelectorAll(".option input").forEach(function(el){
    el.addEventListener("change", updateSelected);
});

function updateSelected(){
    
    let checked = document.querySelectorAll(".option input:checked");
    let text = document.getElementById("selectedText");

    if(checked.length === 0){
        text.innerHTML = "Select Option";
    }else{
        text.innerHTML = checked.length + " Selected";
    }
}
</script>


