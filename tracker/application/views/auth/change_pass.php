<link href="<?php echo base_url();?>assets/stylesheet/common/auth.css" rel="stylesheet" />
<section class="welcome-page">
<div class="app-phone">
  <div class="app-center">
    <h2 class="app-primary">Change Password</h2>
    <hr>
    <p class="app-small">Please enter your new password below.</p>
  </div>
          <?php if ($this->session->flashdata('login-message')): ?>
    <div class="mb-2" id="login-alert">
        <?= $this->session->flashdata('login-message'); ?>
    </div>         
<?php endif; ?>

        <form method="POST" action ="<?php echo base_url(); ?>password-change-form">
             
            <div class="app-field form-group mb-3">
                            <label class="app-label" >New Password</label>
                            <div class="input-group">
                              <input id="new_password" name="new_password" type="password" placeholder="New Password"  class="app-input validate  login-form  form-control"> <i class="bi bi-eye me-3 fs-5" id="toggleNew"></i>
                            </div>
                    <small class="text-danger" id="password_error"></small>
            </div>
            
            <div class="app-field form-group mb-3">
                            <label class="app-label" >Confirm Password</label>
                            <div class="input-group">
                              <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" class="app-input validate  login-form  form-control">
                              <i class="bi bi-eye me-3 fs-5" id="toggleConfirm"></i>
                            </div>
                            <small class="text-danger" id="confirmpassword_error"></small>
            </div>

            <button class="app-btn">Change Password</button>
        </form>
   </div> 
</section>
<?php $this->load->view('common/form-script'); ?>
<style>
    .app-phone {
    width: 100%;
    }
      .formerror{
      color:red;
  }
</style>


<script>
function validateField(id, errorId, pattern, message) {
  const value = document.getElementById(id).value.trim();
  const err   = document.getElementById(errorId);

  if (/^\s|\s{2,}|\s$/.test(value)) {
    err.textContent = "No extra spaces allowed.";
    return false;
  }
  if (!pattern.test(value)) {
    err.textContent = message;
    return false;
  }
  err.textContent = "";
  return true;
}

function validatePasswordMatch() {
  const pass  = document.getElementById("new_password").value;
  const cpass = document.getElementById("confirm_password").value;
  const err   = document.getElementById("confirmpassword_error");
  if (pass !== cpass) {
    err.textContent = "Passwords do not match.";
    return false;
  }
  err.textContent = "";
  return true;
}

function validateForm() {
  const validPass  = validateField("new_password","password_error",/^.{8,}$/,"Password must be at least 8 characters");
  const validMatch = validatePasswordMatch();
  return validPass && validMatch;
}

// live validation
document.getElementById("new_password").addEventListener("input", () =>
  validateField("new_password","password_error",/^.{8,}$/,"Password must be at least 8 characters"));
document.getElementById("confirm_password").addEventListener("input", validatePasswordMatch);

// toggle eye icons
function toggleVisibility(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  icon.addEventListener("click", () => {
    const type = input.type === "password" ? "text" : "password";
    input.type = type;
    icon.classList.toggle("ri-eye-off-line");
    icon.classList.toggle("ri-eye-line");
  });
}
toggleVisibility("new_password","toggleNew");
toggleVisibility("confirm_password","toggleConfirm");
</script>
