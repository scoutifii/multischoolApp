<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('contact_us'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('contact_us'); ?></a></li>
        </ul>
    </div>
</section>

<section>
    <div class="container text-center">        
        <?php $this->load->view('layout/message'); ?> 
    </div>
</section>

<section class="page-contact-area">
    <div class="container">
        <div id="mymap"></div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="contact-form-area">
                    <h2 class="contact-page-title"><?php echo $this->lang->line('contact_us'); ?></h2>
                    <form action="<?php echo site_url('contact'); ?>" method="post" id="contact_us" name="contact_us" >
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="contact-input-box">
                                    <input type="text" name="name" id="name" required="required" placeholder="<?php echo $this->lang->line('name'); ?> *">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="contact-input-box">
                                    <input type="email" name="email" id="email" required="required"  placeholder="<?php echo $this->lang->line('email'); ?> *">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="contact-input-box">
                                    <input  type="text" name="phone" id="phone" placeholder="<?php echo $this->lang->line('phone'); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="contact-input-box">
                                    <input type="text" name="subject" id="subject"  placeholder="<?php echo $this->lang->line('subject'); ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-input-box">
                                    <textarea name="message" id="message" required="required"  placeholder="<?php echo $this->lang->line('message'); ?> *"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-input-box text-right">
                                    <input class="glbscl-link-btn hvr-bs" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('submit'); ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <h2 class="contact-page-title"><?php echo $this->lang->line('get_in_touch'); ?></h2>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="single-contact-info">
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                            <p class="info">
                                <?php if(isset($school->address)){ ?>
                                     <?php echo $school->address; ?>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="single-contact-info">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                            <a class="info" href="mailto:<?php echo $school->email; ?>"><?php echo $this->lang->line('email'); ?>: <?php echo $school->email; ?></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="single-contact-info">
                            <span class="icon"><i class="fas fa-phone-volume"></i></span>
                            <a class="info" href="tel:<?php echo $school->phone; ?>"><?php echo $this->lang->line('phone'); ?>: <?php echo $school->phone; ?></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="single-contact-info">
                            <span class="icon"><i class="fas fa-fax"></i></span>
                            <p class="info"><?php echo $this->lang->line('school_fax'); ?>: <?php echo $school->school_fax; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function myMap() {
        var myCenter = new google.maps.LatLng(<?php echo $school->school_lat; ?>,<?php echo $school->school_lng; ?>);
        var mapCanvas = document.getElementById("mymap");
        var mapOptions = {center: myCenter, zoom: 16};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position: myCenter});
        marker.setMap(map);
        
        var contentString = '<div id="content">'+
                                '<div id="siteNotice">'+
                                '</div>'+
                                '<h3 id="firstHeading" class="firstHeading"><?php echo $school->school_name; ?></h3>'+
                                '<div id="bodyContent">'+
                                '<p><b><?php echo $this->lang->line('address'); ?>:</b> <?php echo $school->address; ?><br/>' +
                                '<b><?php echo $this->lang->line('phone'); ?>:</b> <?php echo $school->phone; ?><br/> '+
                                '<b><?php echo $this->lang->line('email'); ?>:</b> <?php echo $school->email; ?><br/>'+
                                '<b><?php echo $this->lang->line('school_fax'); ?>:</b> <?php echo $school->school_fax; ?><br/>'+                                
                                '</p>'+                                
                                '</div>'+
                                '</div>';
      
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });        
        infowindow.open(map, marker);
    }

    $('#contact_us').validate();
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $school->map_api_key; ?>&callback=myMap"></script>

<style type="text/css">
    label.error{
        color: red;
    }    
</style>