<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta charset="ISO-8859-15">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="cache-control" content="no-store" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="pragma" content="no-store" />
        <title><?php echo SMS; ?></title>
        <link rel="icon" href="<?php echo IMG_URL; ?>favicon.ico" type="image/x-icon" />
        <!-- Bootstrap -->
        <link href="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
        <!-- Custom Theme Style -->       
        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet">       
        <link href="<?php echo CSS_URL; ?>theme/jazzberry-jam.css" rel="stylesheet">
      
        <!-- jQuery -->
        <script src="<?php echo JS_URL; ?>jquery-1.11.2.min.js"></script>
        <script src="<?php echo JS_URL; ?>jquery.validate.js"></script>
        
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>toastr/toastr.min.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- danger: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
        
        <style>
            body {
                font-family: Roboto, Sans-Serif,Arial;
            }
            .container {
                width: 90%;
                padding: 0;
                margin: 0 auto;
            }                     
            .header {           
                background: #9f134e;
                padding: 10px 0;
                display: inline-block;
                width: 100%;
                margin-bottom: 5px;
                box-shadow: 0 3px 6px rgba(0,0,0,.16),0 3px 6px rgba(0,0,0,.23);
            }
            .header img {
                display:block;
                width: 60px;
            }
            .title{
                margin:0;
                color: white;
                text-align: left;
                font-weight: bold;
                padding-top:3px;
            }
            .left-side-tab {
                display: block;
                position:relative;
                min-height: 100%;
                background: #323438;
                width: 100%;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
                border-radius: 0px;
                margin-bottom: 10px;
                border: 2px solid #fff;
                color: #fff;
                padding: 5px;
            }
            .left-side-tab i{
                position: absolute;
                left: 0;
                min-width: 50px;
                min-height: 100%;
                font-size: 24px;
                background: #96003f;
                top: 0;
                text-align: center;
                padding-top: 10px;
            }
            .left-side-tab h5{
                padding-left: 60px;
            }
            .complete-bg {
                background: #ff006b !important;
                color:#fff;
            }
            
            .in-complete-bg {
                border:2px solid #e4e5e7;
                border-radius:2px;
            }
            .form-box {
                position: relative;
                padding: 10px 20px 20px;
                border-radius: 3px;
                background: #ffffff;
                border-top: 3px solid #d2d6de;
                margin-bottom: 20px;
                width: 100%;
                box-shadow: 0 1px 1px rgba(0,0,0,0.1);
                min-height:226px;
                border-top-color: #ff006b;
                box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
            }
             
            .btn-primary, .btn-primary:active {
                color: #fff !important;
                background-color: #9f134e !important;
                border-color: #9f134e !important;
            }
            
             .form-control{                 
                border-radius: 5px;
                padding: 6px !important;
                box-shadow: none !important;
            }           
            
            @media (min-width:768px) and (max-width:992px){
                .left-side-tab h5{padding-left: 45px;}
                .left-side-tab i{min-width:45px}
            }
            
        </style>
    </head>
    <body>
        <section class="header">
            <div class="container">
                <div class="row">                    
                    <div class="col-md-3">
                        <img src="<?php echo IMG_URL; ?>/sms-logo-50.png" alt="" width="80">
                    </div>
                    <div class="col-md-9">
                        <h3 class="title"><?php echo SMS; ?> - Installation</h3>
                    </div>                    
                </div><!--./row-->
            </div><!--./container-->
        </section><!--./row-->
        
        <section>
            <div class="container">
                <div class="row">               
                    <div class="col-md-3 col-sm-3">
                        <div class="left-side-tab <?php if ($instructions == true || $form == 1) { echo 'complete-bg';  } ?>">
                            <i class="fa fa-file-word-o"></i> <h5>Instructions</h5>
                        </div>
                        <div class="left-side-tab <?php if ($requirements || $form == 2) {  echo 'complete-bg'; } else { echo 'in-complete-bg'; } ?>">
                            <i class="fa fa-list-ol"></i> <h5> Requirements</h5>
                        </div>
                        <div class="left-side-tab <?php if ($purchase || $form == 3) {  echo 'complete-bg'; } else { echo 'in-complete-bg'; } ?>">
                            <i class="fa fa-shopping-cart"></i> <h5> Purchase Code</h5>
                        </div>
                        <div class="left-side-tab <?php if ($database || $form == 4) {  echo 'complete-bg'; } else { echo 'in-complete-bg'; } ?>">
                            <i class="fa fa-database"></i> <h5> Database Info</h5>
                        </div>
                        <div class="left-side-tab <?php if ($superadmin || $form == 5) { echo 'complete-bg'; } else {  echo 'in-complete-bg'; } ?>">
                            <i class="fa fa-user"></i> <h5> Super Admin</h5>
                        </div>
                        <div class="left-side-tab <?php if ($installation || $form == 6) { echo 'complete-bg'; } else { echo 'in-complete-bg'; } ?>">
                            <i class="fa fa-thumbs-o-up"></i> <h5> Complete!</h5>
                        </div>
                    </div><!--./col-md-3-->
                    
                    <div class="col-md-9 col-sm-9">
                        <div class="form-box">
                            <p><?php echo $debug_msg; ?></p>
                            <?php if (isset($error_msg) && $error_msg != '') { ?>
                                <div class="alert alert-danger text-left">
                                    <?php echo $error_msg; ?>
                                </div>
                            <?php } ?>
                            
                            <?php if ($form == 1) { ?>
                            
                                <?php include_once('instructions.php');  ?>                        
                                                     
                            <?php }elseif ($form == 2) { ?>  
                            
                               <?php include_once('requirements.php');  ?>   
                            
                            <?php }elseif ($form == 3) { ?>
                            
                                <?php include_once('purchase.php');  ?> 
                            
                            
                            <?php }elseif ($form == 4) { ?>
                            
                                <?php include_once('database.php');  ?> 
                            
                                                            
                            <?php } else if ($form == 5) { ?>
                                
                                  <?php include_once('superadmin.php');  ?> 
                                
                            <?php } else if ($form == 6) { ?>
                                
                                <h4>Installation Successful!</h4>
                                <p>Due to security reasons you must delete the installation directory.</p>
                                <a href="javascript:void();" class="btn btn-primary_">Delete Installation Directory [ application/controllers/installation ] and Login to Admin Panel</a>
                                <a  href="<?php echo site_url('welcome'); ?>" class="btn btn-primary">Login to Admin Panel</a>
                              
                            <?php } ?>
                                
                        </div>
                    </div>                    
               
            </div><!--./row-->
        </div><!--./container-->
        </section>
        <script type="text/javascript">        
            $("#purchase").validate();  
            $("#dbform").validate();     
            $("#superadmin").validate();     
        </script>
        
    </body>
</html>
