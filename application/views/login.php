<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $this->lang->line('login'). ' | ' . SMS;  ?></title>
        
        <?php if($this->gsms_setting->favicon_icon){ ?>
            <link rel="icon" href="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->gsms_setting->favicon_icon; ?>" type="image/x-icon" />             
        <?php }else{ ?>
            <link rel="icon" href="<?php echo IMG_URL; ?>favicon.ico" type="image/x-icon" />
        <?php } ?>
            <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
         <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Bootstrap -->
        <link href="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome --> 
        <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">    
        <!-- Custom Theme Style -->
        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet">
       <!--<?php $this->load->view('layout/login-css'); ?> -->

        <style type="text/css">
body {
  font-family: 'Montserrat', sans-serif;
  transition: 3s;
  background-color: navy;
}

.login-container {
  margin-top: 5%;
  border: 1px solid #CCD1D1;
  border-radius: 5px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  max-width: 50%;
  max-height: 30%;
}

.ads {
  background-color: #A569BD;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
  color: #fff;
  padding: 15px;
  text-align: center;
}

.ads h1 {
  margin-top: 10%;
}
@media (max-width: 760px) {
    .ads {
  display: none;
  
}
    .ads h1 {
   display: none;
}
}
@media (max-width: 460px) {
    .ads {
  display: none;
  
}
    .ads h1 {
   display: none;
}
}

#fl {
  font-weight: 600;
}

#sl {
  font-weight: 100 !important;
}

.profile-img {
  text-align: center;
}

.profile-img img {
  border-radius: 50%;
  /* animation: mymove 2s infinite; */
}

@keyframes mymove {
  from {border: 1px solid #F2F3F4;}
  to {border: 8px solid #F2F3F4;}
}

.login-form {
  padding: 30px;
}

.login-form h3 {
  text-align: center;
  padding-top: 30px;
  padding-bottom: 30px;
}

.form-control {
  font-size: 18px;
}

.forget-password a {
  font-weight: 500;
  text-decoration: none;
  font-size: 18px;
}

</style>  
    </head>
    <body>

    <div class="container login-container">
      <div class="row">
        <div class="col-md-6 col-sm-12 ads">

           <h1><span id="fl">Welcome</span><span id="sl">To</span><h1><br><h3><span class="school-name" style="font-size: 20px; font-weight: 900"><?php echo $this->global_setting->brand_name; ?> <?php echo $this->global_setting->brand_title; ?></span></h3><br><br><br>
               <?php if(isset($this->global_setting->brand_logo) && !empty($this->global_setting->brand_logo)){ ?>
                        <img  src="<?php echo UPLOAD_PATH.'logo/'.$this->global_setting->brand_logo; ?>" style="max-width: 50px;max-height:50px;" alt="">
                    <?php }else{ ?>
                        <img  width="100" height="100" src="<?php echo IMG_URL; ?>/sms-logo.png">
                    <?php } ?>                    
          
        </div>
        <div class="col-md-6 login-form">
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <p class="red"><?php echo $this->session->flashdata('error'); ?></p>
            <p class="green"><?php echo $this->session->flashdata('success'); ?></p>
         </div>
         <div class="form login_form">
            <section><h1 class="text-center"><?php echo $this->lang->line('login'); ?></h1></section>
             <label>User Name</label>
            <?php echo form_open(site_url('auth/login'), array('name' => 'login', 'id' => 'login'), ''); ?>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                <input type="text" name="username" class="form-control has-feedback-left" placeholder="<?php echo $this->lang->line('username'); ?>" autocomplete="off">
                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                <label>Password</label>
                <input type="password" name="password" class="form-control has-feedback-left" id="inputSuccess2" placeholder="<?php echo $this->lang->line('password'); ?>" autocomplete="off">
                <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span><br>
            </div>
                    
            <div class="col-md-6 col-sm-12 col-xs-12">              
              <input type="submit" name="submit" value="<?php echo $this->lang->line('login'); ?>" class="btn btn-success btn-lg login-button"/>
            </div>
            <!--div class="col-md-6 col-sm-12 col-xs-12">
                <a class="reset_pass btn btn-warning btn-lg login-button" href="<?php echo site_url('forgot') ?>"><?php echo $this->lang->line('lost_your_password'); ?></a>;
            </div-->

        <div class="clearfix"></div>                        
         <?php echo form_close(); ?>
        </div>
      </div>
    </div>
</div>
    </body>
</html>
