<?php $path = (isset($user)) && !empty($user) ? '../' : ''; ?>
<style type="text/css">   
.login_wrapper {
    right: 0px;
    margin: 0px auto;
    margin-top: 2%;
    max-width: 450px;
    position: relative
}
.login_wrapper h1{
    padding: 20px 0px;
    border-radius: 10px 10px 0px 0px;
}
.login_form{
    border-radius: 10px 10px 10px 10px;
}
.login_content{
    padding: 20px;
}
.login_box {
    padding: 20px;
    margin: auto
}
.demo-note{               
    margin: 10px;
    font-size: 18px;
}
.demo-button{               
    margin: 8px;
    font-size: 16px;
    padding: 5px 12px !important;
}

<?php if($this->global_setting->theme_name == 'slate-gray'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/slate-gray.jpg);   
        background-color: #132436;
    }   
    .login_form{
        background: #2A3F54; 
    }
    .login-button{
        color: #000 !important;
        background-color: #6b8198 !important;
        border: .5px solid #c5c2c2 !important;
    }
    .login-button:hover{
        background-color: #43607d !important;
    }
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #2A3F54;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'black'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/black.jpg);   
        background-color: #020202;
    } 
    .login_form{
        background: #23282d; 
    }
    .login-button{
        color: #fff !important;
        background-color: #444141 !important;
        border: .5px solid #a7a7a7 !important;
    }
   
    .login-button:hover{
        background-color: #353333 !important;
    }
    .login_wrapper h1{   
        background: #000000;
        color: #d4d0d0; 
   }
   .form-control.has-feedback-left {
        border: .5px solid #23282d;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'light-sea-green'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/light-sea-green.jpg);  
        background-color: #21b3aa;
    } 
    .login_form{
        background: #20B2AA; 
    }
    .login-button{
        color: #000 !important;
        background-color: #3defe5 !important;
        border: .5px solid #ffffff !important;
    }

    .login-button:hover{
        background-color: #30d6cd !important;
    }
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #20B2AA;     
   } 
    
<?php }elseif($this->global_setting->theme_name == 'medium-purple'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/medium-purple.jpg);    
        background-color: #6d3dd0;
    } 
    .login_form{
        background: #6345a0; 
    }
    .login-button{
            color: #151515 !important;
            background-color: #9e76f1 !important;
            border: .5px solid #b5b5b5 !important;
    }
    .login-button:hover{
        background-color: #8b6bce !important;
    }
    .login_wrapper h1{   
        background: #3c3a3a;
        color: #e4dcdc; 
   }
   .form-control.has-feedback-left {
        border: .5px solid #6345a0;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'navy-blue'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/navy-blue.jpg); 
        background-color: #041b54;
    }
    .login_form{
        background: #001f67; 
    }    
    .login-button{
        color: #fff !important;
        background-color: #4368bf !important;
        border: .5px solid #c3c3c3 !important;
    }
    .login-button:hover{
        background-color: #2b55b5 !important;
    }   
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }   
   .form-control.has-feedback-left {
        border: .5px solid #001f67;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'rebecca-purple'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/rebecca-purple.jpg);
        background-color: #612e95;
    } 
    .login_form{
        background: #663399; 
    }
    .login-button{
        color: #131313 !important;
        background-color: #b073ec !important;
        border: .5px solid #d4d4d4 !important;
    }
    .login-button:hover{
        background-color: #8c51c5 !important;
    }
    .login_wrapper h1{   
        background: #383838;
        color: #e2e2e2;
   }
   .form-control.has-feedback-left {
        border: .5px solid #663399;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'red'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/red.jpg);       
        background-color: #e90101;
    }
    .login_form{
        background: #f31717; 
    }    
    .login-button{
        color: #000 !important;
        background-color: #ff6666 !important;
        border: .5px solid #dedede !important;
    }
    .login-button:hover{
        background-color: #f35e5e !important;
    }
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #f31717;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'dodger-blue'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/dodger-blue.jpg);     
        background-color: #1f92ff;
    }
    .login_form{
        background: #1E90FF; 
    }    
    .login-button{
        color: #171515 !important;
        background-color: #79bcff !important;
        border: .5px solid #e2e1e1 !important;
    }
    .login-button:hover{
        background-color: #6fb1f3 !important;
    }
    .login_wrapper h1{   
        background: #444444;
        color: #eae6e6;  
   }    
   .form-control.has-feedback-left {
        border: .5px solid #1E90FF;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'maroon'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/maroon.jpg);     
        background-color: #650506;
    }
    .login_form{
        background: #b92525; 
    }    
    .login-button{
        color: #000 !important;
        background-color: #ff5f5f !important;
        border: .5px solid #cecece !important;
    }
    .login-button:hover{
        background-color: #e84e4e !important;
    }
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #b92525;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'dark-orange'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/dark-orange.jpg);      
        background-color: #ff8d00;
    }
    .login_form{
        background: #FF8C00; 
    }     
    .login-button{
        color: #000 !important;
        background-color: #ffb254 !important;
        border: .5px solid #d6cbcb !important;
    }
    .login-button:hover{
        background-color: #efa54b !important;
    }    
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #FF8C00;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'deep-pink'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/deep-pink.jpg);   
        background-color: #ff1695;
    }
    .login_form{
        background: #FF1493; 
    }     
    .login-button{
        color: #000 !important;
        background-color: #ff6bbb !important;
        border: .5px solid #d0c7c7 !important;
    }
    .login-button:hover{
        background-color: #f952ac !important;
    }    
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #FF1493;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'lime-green'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/lime-green.jpg);  
        background-color: #33ce34;
    }
    .login_form{
        background: #49c549; 
    }     
    .login-button{
        color: #2d2d2d !important;
        background-color: #6fe66f !important;
        border: .5px solid #e0e0e0 !important;
    }
    .login-button:hover{
        background-color: #6ad26a !important;
    }
    .login_wrapper h1{   
        background: #3e3d3d;
        color: #e2e2e2; 
   }
   .form-control.has-feedback-left {
        border: .5px solid #49c549;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'jazzberry-jam'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/jazzberry-jam.jpg);    
        background-color: #66072f;
    }
    .login_form{
        background: #9F134E; 
    }    
    .login-button{
        color: #0e0e0e !important;
        background-color: #d2588c !important;
        border: .5px solid #b9b1b5 !important;
    }
    .login-button:hover{
        background-color: #da397d !important;
    }
    .login_wrapper h1{   
        background: #272727;
        color: #d6d0d0;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #9F134E;     
   }
    
<?php }elseif($this->global_setting->theme_name == 'umber'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/umber.jpg);         
        background-color: #5f4802;
    }
    .login_form{
        background: #745D0B; 
    }    
    .login-button{
        color: #000 !important;
        background-color: #d0aa25 !important;
        border: .5px solid #cccccc !important;
    }
    .login-button:hover{
        background-color: #b39322 !important;
    }
   .login_wrapper h1{   
        background: #2f2d2d;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #745D0B;     
    }
    
        
<?php }elseif($this->global_setting->theme_name == 'trinidad'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/trinidad.jpg);      
        background-color: #a85135;
    }
    .login_form{
        background: #CC4F26; 
    }    
    .login-button{
        color: #000 !important;
        background-color: #fd7448 !important;
        border: .5px solid #cacaca !important;
    }
    .login-button:hover{
        background-color: #ec6e45 !important;
    }
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }
   .form-control.has-feedback-left {
        border: .5px solid #CC4F26;     
   }
   
        
<?php }elseif($this->global_setting->theme_name == 'radical-red'){ ?>

    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/radical-red.jpg); 
        background-color: #de314e;
    }
    .login_form{
        background: #ff4261; 
    }    
    .login-button{
        color: #000 !important;
        background-color: #ff647c !important;
        border: .5px solid #f5f5f5 !important;
    }
    .login-button:hover{
        background-color: #ec6a7e !important
    }
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
    }
   .form-control.has-feedback-left {
        border: .5px solid #ff4261;     
   }
    
<?php }else{ ?>
    
 
    .login{    
        background: url(<?php echo $path; ?>assets/images/login-screen/navy-blue.jpg); 
        background-color: #041b54;
    }
    .login_form{
        background: #001f67; 
    }    
    .login-button{
        color: #fff !important;
        background-color: #4368bf !important;
        border: .5px solid #c3c3c3 !important;
    }
    .login-button:hover{
        background-color: #2b55b5 !important;
    }   
    .login_wrapper h1{   
        background: #1d1c1c;
        color: #fff;  
   }   
   .form-control.has-feedback-left {
        border: .5px solid #001f67;     
   }
    
<?php } ?>
    
    .login{  
        background-repeat: no-repeat;
        background-size: 100% auto;
        background-position: center top;
        background-attachment: fixed; 
        background-repeat: no-repeat;   
    }
    
</style>