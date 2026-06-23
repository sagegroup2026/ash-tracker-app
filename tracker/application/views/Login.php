<link href="<?php echo base_url();?>assets/stylesheet/common/auth.css" rel="stylesheet" />
<section class="welcome-page">
<div class="app-phone">
  <div class="app-center">
    <h2 class="app-primary">Login Here</h2>
    <p class="app-small">Welcome back you’ve been missed!</p>
  </div>
<?php if($this->session->flashdata('login_msg')): ?>
    <?= $this->session->flashdata('login_msg'); ?>
<?php endif; ?>


        <form method="POST" action ="<?php echo base_url(); ?>check-login">
            
            <div class="app-field">
                <label class="app-label">Email</label>
                <input id="email" class="app-input"  name="email" type="text" placeholder=" Enter Your Email" oninput="validateInput(event, 'email')">
                <span class="formerror" data-for="email"></span>
            </div>
            <div class="app-field">
                <label class="app-label">Password</label>
                <input id="password" class="app-input" name="password" type="password" placeholder="Password">
                <span class="formerror" data-for="password"></span>
            </div>
            <button class="app-btn">Sign In</button>
            
             <p class=" app-small" style="margin-top:15px; text-align:end;"><a href="<?php echo base_url();?>forgot-password" class="text-success">Forgot password?</a> </p>
            
            <hr>
        
            <!--<div class="row">-->
            <!--  <label for="Email" class="input-label">Email</label>-->
            <!--  <div class="input-field">-->
            <!--    <input id="email" class="login-input-field"  name="email" type="text"  placeholder=" Enter Your Email" oninput="validateInput(event, 'email')">-->
            <!--  </div>-->
            <!--  <span class="formerror" data-for="email"></span>-->
        
            <!--</div>-->
        
        <!--    <div class="row">-->
        <!--     <label for="Password"  class="input-label">Password</label>-->
              <!--<div class="input-field">-->
        <!--        <input id="password" class="login-input-field" name="password" type="password" placeholder="Password">-->
        <!--         <span class="formerror" data-for="password"></span>-->
        
        <!--    </div>-->
       
                
        <!--<div class="row center">-->
        <!--    <button class="waves-effect waves-light btn btn-large" style="background:#49ae52" type="submit" id="popsubmit" >Login</button>-->
          <!--<a class="waves-effect waves-light btn-large" style="background:#49ae52" type="submit">Login</a> -->
          <!--<div class="spacer"></div>-->
          <!--<div class="links">-->
        
            <!--<a href="#" >Forgot Password</a><span class="sep">|</span><a href="" >Register</a></div>-->
        
          <!--  <div class="spacer"></div>-->
          
        
        <!--</div>-->
        </form>
      <p class="app-center app-small" style="margin-top:15px;">
        Don't have an account? <a href="<?php echo base_url();?>register" class="app-primary">Sign Up</a>
      </p>
   </div> 
</section>

<?php $this->load->view('common/form-script'); ?>



<!--  

<!--  <p class="app-center app-small" style="margin-top:15px;">-->
<!--    Create new account-->
<!--  </p>-->
<!--</div>-->


<style>


.formerror{
    color:red;
}

.app-phone {
    width: 100%;
}
  
/*.layout {*/
/*    height: 100vh;*/
/*}*/
/*.log-sign {*/
/*    padding: 70px 30px;*/
/*}*/

/*section.tracker-login {*/
/*    heigth:100vh;*/
/*}*/

/*.log-page{*/
/*    padding:0px 30px;*/
/*}*/

/*.input-label{*/
/*        font-weight: 600;*/
/*    font-size: 20px;*/
/*}*/
/*.login-input-field{*/
/*        border: none;*/
/*    border-bottom: 1px solid var(--blue);*/
/*    padding: 10px;*/
/*    margin-bottom: 20px;*/
/*}*/

/*button.close.b-cloo {*/
/*    background: transparent;*/
/*    border-radius: 40px;*/
    
/*    border: none;*/
/*    font-size: 18px;*/
   
/*    margin-right: 6px;*/
/*}*/
</style>