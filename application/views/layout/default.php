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
        

        <title>Scoutifii | Schoolify</title>
        <link rel="icon" href="<?php echo IMG_URL; ?>olify.png" type="image/x-icon" />
        <!-- Bootstrap -->
        <link href="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo VENDOR_URL; ?>dist/css/dropify.min.css" rel="stylesheet">
        <link href="<?php echo VENDOR_URL; ?>select2/select2.min.css" rel="stylesheet">
        <link href="<?php echo VENDOR_URL; ?>dist/css/nprogress.css" rel="stylesheet">
        
    
        <!-- Custom Theme Style -->
         <?php if($this->global_setting->enable_rtl){ ?>
            <link href="<?php echo CSS_URL; ?>rtl/custom-rtl.css" rel="stylesheet">             
        <?php }else{ ?>
            <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet">
        <?php } ?>
        
        <?php if($this->session->userdata('theme')){ ?>
            <link href="<?php echo CSS_URL; ?>theme/<?php echo $this->session->userdata('theme'); ?>.css" rel="stylesheet">
        <?php }else{ ?>
            <link href="<?php echo CSS_URL; ?>theme/navy-blue.css" rel="stylesheet">
        <?php } ?>
        
        <!-- jQuery -->
        <!--script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script-->
        <script src="<?php echo JS_URL; ?>jquery-1.11.2.min.js"></script>
        <script src="<?php echo JS_URL; ?>jquery.validate.js"></script>
        
         <script type="text/javascript" src="<?php echo VENDOR_URL; ?>toastr/toastr.min.js"></script>
        
        <?php if($this->global_setting->google_analytics){ ?>         
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->global_setting->google_analytics; ?>"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', '<?php echo $this->global_setting->google_analytics; ?>');
            </script>
        <?php } ?>
        <style type="text/css">
            .content {
                min-height: 250px;
                padding: 15px;
                margin-right: auto;
                margin-left: auto;
                padding-left: 15px;
                padding-right: 15px;
            }
            .box.box-primary {
                border-top-color: #faa21c;
                border-top: 4px solid #faa21c;
                box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
            }

            .box {
                position: relative;
                border-radius: 3px;
                background: #ffffff;
                border-top: 20px solid #d2d6de;
                margin-bottom: 20px;
                width: 100%;
                box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            }
            .skin-blue .main-header .navbar {
                background-color: #424242;
            }
            .main-header>.navbar {
                -webkit-transition: margin-left .3s ease-in-out;
                -o-transition: margin-left .3s ease-in-out;
                transition: margin-left .3s ease-in-out;
                margin-bottom: 0;
                margin-left: 200px;
                border: none;
                min-height: 50px;
                border-radius: 0;
            }
        </style>
        
    </head>

    <body class="nav-md ">
        <div id="preloader"></div>
        
        <div class="container body" style="background-color: #143246;">
            <div class="main_container ">
                 <?php $this->load->view('layout/left-side'); ?>   
                <!-- top navigation -->
                 <?php $this->load->view('layout/header'); ?>   
                <!-- /top navigation -->
                
                <div class="<?php echo $this->global_setting->enable_rtl ? 'left_col' : 'right_col'; ?>" role="main" >                  
                    <?php $this->load->view('layout/message'); ?>
                    <!-- page content -->
                    <?php echo $content_for_layout; ?>
                    <!-- /page content -->
                </div>
                <!-- footer content -->
                <?php $this->load->view('layout/footer'); ?>   
                <!-- /footer content -->
            </div>
        </div>

        
        <!-- Bootstrap -->
        <script src="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.js"></script>   
        
        <!--   Start   -->        
        <link href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css" rel="stylesheet"> 
        <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">         
        <link href="<?php echo VENDOR_URL; ?>datatables/buttons.dataTables.min.css" rel="stylesheet"> 
        <link href="<?php echo VENDOR_URL; ?>datatables/dataTables.bootstrap.css" rel="stylesheet"> 
        <script src="<?php echo VENDOR_URL; ?>datatables/tools/jquery.dataTables.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>datatables/tools/dataTables.buttons.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>datatables/tools/pdfmake.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>datatables/tools/jszip.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>datatables/tools/vfs_fonts.js"></script>
        <script src="<?php echo VENDOR_URL; ?>datatables/tools/buttons.html5.min.js"></script> 
        <script src="<?php echo VENDOR_URL; ?>datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo VENDOR_URL; ?>select2/select2.min.js"></script> 
        <script src="<?php echo VENDOR_URL; ?>tinymce/tinymce.min.js"></script> 
        <script src="<?php echo VENDOR_URL; ?>tinymce/jquery.tinymce.min.js"></script>

        <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script> 
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> 
        <!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNfYoctRzjcijDJqZM-6m3m59IH_-UU7M&libraries=places&callback=initAutocomplete"></script>
        script async defer src="https://maps.googleapis.com/maps/api/js?sensor=false=places&callback=initAutocomplete"></script-->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNfYoctRzjcijDJqZM-6m3m59IH_-UU7M&libraries=places&callback=initAutocomplete&v=weekly"></script>
        
        <!-- Mapbox GL JS -->
        <script src="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.js"></script>
        <link href="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.css" rel="stylesheet">

        <!-- Mapbox Search JS -->
        <script id="search-js" defer src="https://api.mapbox.com/search-js/v1.5.0/web.js"></script>
       
        <!-- dataTable with buttons end -->       
        <link href="<?php echo VENDOR_URL; ?>toastr/toastr.min.css" rel="stylesheet">
       <!-- Custom Theme Scripts -->       
       
        <?php if($this->global_setting->enable_rtl){ ?>
                       
        <?php }else{ ?>
        <?php } ?>
        <script src="<?php echo JS_URL; ?>custom.js"></script>  
        <!--script src="<?php echo JS_URL; ?>backend/js/biometric.js"></script--> 
        
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
            
            toastr.options = {
                "closeButton": true,               
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "300",
                "timeOut": "3000",              
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
              }


        $(window).on('load', function() {
            $('#preloader').fadeOut('slow', function() { $(this).remove(); });
        });
  
       </script>

</body>
</html>