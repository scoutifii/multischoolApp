<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta charset="ISO-8859-15">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title_for_layout; ?></title>   
        <?php if($this->global_setting->favicon_icon){ ?>
            <link rel="icon" href="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->favicon_icon; ?>" type="image/x-icon" />             
        <?php }else{ ?>
            <link rel="icon" href="<?php echo IMG_URL; ?>favicon.ico" type="image/x-icon" />
        <?php } ?>
        
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/fontawesome-all.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/animate.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/meanmenu.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/jquery.fancybox.min.css">
        
        <?php if(isset($school->theme_name)){ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/theme/<?php echo $school->theme_name; ?>.css">
        <?php }else{ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/style.css">
        <?php } ?>  
        
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/responsive.css">
        
        <?php if($school->enable_rtl){ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/rtl.css">
        <?php }elseif($this->global_setting->enable_rtl){ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/rtl.css">
        <?php } ?>
         
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <script src="<?php echo JS_URL; ?>front/jquery-3.3.1.min.js"></script>
        <script src="<?php echo JS_URL; ?>jquery.validate.js"></script>
        
        <?php if(isset($this->global_setting->google_analytics) && !empty($this->global_setting->google_analytics)){ ?>         
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->global_setting->google_analytics; ?>"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', '<?php echo $this->global_setting->google_analytics; ?>');
            </script>
        <?php } ?>
           
    </head>

    <body>
        <div id="preloader"></div>
        
        <?php $this->load->view('layout/header'); ?>  
        
        <!-- page content -->        
        <?php echo $content_for_layout; ?>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php $this->load->view('layout/footer'); ?>   
        <!-- /footer content -->


        <!-- Scripts -->      
        <script src="<?php echo JS_URL; ?>front/jquery-ui.js"></script>
        <script src="<?php echo JS_URL; ?>front/owl.carousel.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.counterup.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.meanmenu.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.fancybox.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.scrollUp.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.waypoints.min.js"></script>
<!--        <script src="<?php echo JS_URL; ?>front/popper.min.js"></script>-->
        <script src="<?php echo JS_URL; ?>front/bootstrap.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/theme.js"></script> 

        <script type="text/javascript">

            jQuery.extend(jQuery.validator.messages, {
                required: "<?php echo $this->lang->line('required_field'); ?>",
                email: "<?php echo $this->lang->line('enter_valid_email'); ?>",
                url: "<?php echo $this->lang->line('enter_valid_url'); ?>",
                date: "<?php echo $this->lang->line('enter_valid_date'); ?>",
                number: "<?php echo $this->lang->line('enter_valid_number'); ?>",
                digits: "<?php echo $this->lang->line('enter_only_digit'); ?>",
                equalTo: "<?php echo $this->lang->line('enter_same_value_again'); ?>",
                remote: "<?php echo $this->lang->line('pls_fix_this'); ?>",
                dateISO: "Please enter a valid date (ISO).",
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Please enter at least {0} characters."),
                rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
                range: jQuery.validator.format("Please enter a value between {0} and {1}."),
                max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
                min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
            });
            
            
             function change_school(url){
                if(url){
                    window.location.href = url; 
                }
            }           
        </script>
    </body>
</html>