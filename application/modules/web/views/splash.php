<!DOCTYPE html>
<html lang="en">
    <head>
        <!--- Basic Page Needs  -->
        <meta charset="utf-8">
        <title><?php echo SMS; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile Specific Meta  -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/style.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/responsive.css">     
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="<?php echo IMG_URL; ?>front/favicon.ico">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        
        <style type="text/css">  
            <?php if(isset($this->global_setting->splash_image) && !empty($this->global_setting->splash_image)){ ?> 
                .login-area {
                    background: rgba(0, 0, 0, 0) url("<?php echo IMG_URL; ?>front/<?php echo $this->global_setting->splash_image; ?>") no-repeat scroll center top / cover;
                    min-height: 800px;;
                    max-height: 1500px;
                    padding: 100px 0;                   
                }
            <?php }else{ ?>
                .login-area {
                    background: rgba(0, 0, 0, 0) url("<?php echo IMG_URL; ?>front/splash-bg.jpg") no-repeat scroll center top / cover;
                    min-height: 4000px;
                    padding: 100px 0;
                }
            <?php } ?>
        </style>      
        
    </head>

    <body>
        <div id="preloader"></div>
        <div class="login-area bg-with-black">
            <div class="container login-area-all-box">
                <div class="row">
                    
                    <?php if(isset($schools) && !empty($schools)){ ?> 
                        <?php foreach($schools as $obj ){ ?> 
                    
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 login-box-col">
                                <div class="single-login-box">
                                    <h2 class="title"><?php echo $obj->school_name; ?></h2>
                                    <div class="links">
                                        <a class="link glbscl-link-btn hvr-bs" href="<?php echo site_url('school/'.$obj->id); ?>"><?php echo $this->lang->line('visit_school'); ?></a>
                                        <a class="link glbscl-link-btn hvr-bs float-right" href="<?php echo site_url('login'); ?>"><?php echo $this->lang->line('login_to_school'); ?></a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        
        <!-- Scripts -->       
        <script src="<?php echo JS_URL; ?>front/jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
            
            $(window).on('load', function() {
                $('#preloader').fadeOut('slow', function() { $(this).remove(); });
            });
        </script>
        
    </body>
</html>
