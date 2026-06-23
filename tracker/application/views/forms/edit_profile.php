<link href="<?= base_url('assets/stylesheet/common/form.css'); ?>" rel="stylesheet" />

<div class="main-div">
  <div class="profile-wrapper">
    <h4 class="profile-title">Edit Profile</h4>

    <?php if ($this->session->flashdata('register-message')): ?>
      <div class="mb-2">
        <?= $this->session->flashdata('register-message'); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('update-profile'); ?>">

      <!-- REQUIRED -->
      <input type="hidden" name="profile_id" value="<?= $profile->profile_id ?>">
      <input type="hidden" name="location" value="<?= $profile->location ?>">

      <!-- PROFILE TYPE -->
      <div class="mb-2">
        <label class="form-label">Profile Type</label>
        <select class="form-control" name="profile_type" onchange="toggleForm(this.value)" required>
          <option value="">Select</option>
          <option value="doctor"   <?= $profile->profile_type=='doctor'?'selected':'' ?>>Doctor</option>
          <option value="pharmacy" <?= $profile->profile_type=='pharmacy'?'selected':'' ?>>Pharmacy</option>
          <option value="lab"      <?= $profile->profile_type=='lab'?'selected':'' ?>>Lab</option>
          <option value="hr"       <?= $profile->profile_type=='hr'?'selected':'' ?>>HR</option>
        </select>
      </div>

      <!-- NAME -->
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="<?= $profile->name ?>" class="form-control" required>
      </div>

      <!-- CONTACT -->
      <div class="mb-3">
        <label class="form-label">Contact</label>
        <input type="text" name="contact" value="<?= $profile->contact ?>" class="form-control" required>
      </div>

      <!-- ADDRESS -->
      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" value="<?= $profile->address ?>" class="form-control">
      </div>

      <!-- DOCTOR FIELDS -->
      <div class="doctor-fields" style="display:<?= $profile->profile_type=='doctor'?'block':'none' ?>">

        <div class="mb-2">
          <label class="form-label">Degree</label>
          <input type="text" name="degree" class="form-control" value="<?= $profile->degree ?> ">
        </div>

        <div class="mb-2">
          <label class="form-label">Specialty</label>
          <input type="text" name="specialty" class="form-control" value="<?= $profile->specialty ?>">
        </div>

        <div class="mb-2">
          <label class="form-label">Experience</label>
          <input type="number" name="experience" class="form-control" value="<?= $profile->experience ?>">
        </div>

        <div class="mb-2">
          <label class="form-label">Other Details</label>
          <textarea name="other_detail" class="form-control" ><?= $profile->other_detail ?></textarea>
        </div>

        <!-- SOCIAL MEDIA -->
        <?php $social = $profile->social ?? []; ?>
        <h6 class="mt-3">Social Media</h6>

        <?php foreach(['whatsapp','facebook','instagram','linkedin'] as $sm): ?>
          <label class="d-block text-capitalize"><?= $sm ?></label>
          <?php foreach(['connected','not_connected','request_sent'] as $val): ?>
            <input type="radio" name="<?= $sm ?>" value="<?= $val ?>"
              <?= ($social[$sm] ?? '') == $val ? 'checked' : '' ?>>
            <?= ucfirst(str_replace('_',' ',$val)) ?>
          <?php endforeach; ?>
          <br>
        <?php endforeach; ?>

      </div>

      <!-- HR / PHARMACY / LAB -->
      <div class="hr-fields" style="display:<?= in_array($profile->profile_type,['hr','pharmacy','lab'])?'block':'none' ?>">
        <div class="mb-2">
          <label class="form-label">Company / Shop / Lab Name</label>
          <input type="text" name="company_name" value="<?= $profile->company_name ?>" class="form-control">
        </div>
      </div>

      <hr>

      <!-- POC -->
      <h6>POC Details</h6>
      <?php if(!empty($profile->poc)){ foreach($profile->poc as $poc){ ?>
        <div class="border p-2 mb-2">
          <input type="text" name="poc_name[]" value="<?= $poc['name'] ?>" placeholder="Name">
          <input type="text" name="poc_designation[]" value="<?= $poc['designation'] ?>" placeholder="Designation">
          <input type="text" name="poc_contact[]" value="<?= $poc['contact'] ?>" placeholder="Contact">
        </div>
      <?php }} ?>

      <hr>

      <!-- HOSPITAL -->
      <h6>Hospital</h6>
      <?php if(!empty($profile->hospital)){ foreach($profile->hospital as $h){ ?>
        <div class="border p-2 mb-2">
          <input type="text" name="h_name[]" value="<?= $h['hospital_name'] ?>" placeholder="Hospital Name">
          <input type="text" name="h_city[]" value="<?= $h['city'] ?>" placeholder="City">
        </div>
      <?php }} ?>

      <hr>

      <!-- VALIDITY -->
      <div class="row">
        <div class="col-6">
          <label class="form-label">Valid From</label>
          <input type="date" name="valid_from" class="form-control" value="<?= $profile->valid_from ?>">
        </div>
        <div class="col-6">
          <label class="form-label">Valid To</label>
          <input type="date" name="valid_to" class="form-control" value="<?= $profile->valid_to ?>">
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn submit-btn">Update Profile</button>
        <a href="<?= base_url('profile-created') ?>" class="btn btn-secondary">Cancel</a>
      </div>

    </form>
  </div>
</div>

<script>
function toggleForm(type){
  document.querySelector('.doctor-fields').style.display = (type==='doctor')?'block':'none';
  document.querySelector('.hr-fields').style.display =
    (type==='hr'||type==='pharmacy'||type==='lab')?'block':'none';
}
</script>
