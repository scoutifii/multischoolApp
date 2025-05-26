<?php if(isset($sliders) && !empty($sliders)){ ?>
<section class="slider-area owl-carousel">
    <?php foreach($sliders AS $obj ){ ?>
        <div class="single-slider">
            <div class="img">
                <img src="<?php echo UPLOAD_PATH; ?>slider/<?php echo $obj->image; ?>" alt="">
            </div>
            <div class="content">
                <div class="container">
                    <h3 class="intro animated"><?php echo $this->lang->line('welcome_to'); ?></h3>
                    <h2 class="title animated">
                        <?php if($obj->title != ''){ ?>
                            <?php echo $obj->title; ?>
                        <?php }elseif(isset($school->school_name)){ ?>
                            <?php echo $school->school_name; ?>
                        <?php }else{ ?>
                            <?php echo SMS; ?>
                        <?php } ?>
                    </h2>
                    <a class="link animated glbscl-link-btn hvr-bs" href="<?php echo site_url('admission-online'); ?>"><?php echo $this->lang->line('admission_now'); ?></a>
                </div>
            </div>
        </div>    
      
    <?php } ?>
</section>
<?php } ?>

<?php if(isset($school->about_text) && !empty($school->about_text)){ ?>
<section class="top-banner-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="top-banner-content">
                    <h3 class="intro"><?php echo $this->lang->line('welcome_to'); ?></h3>
                    <h2 class="title">
                        <?php if(isset($school->school_name)){ ?>
                            <?php echo $school->school_name; ?>
                        <?php }else{ ?>
                              <?php echo SMS; ?>
                        <?php } ?>
                    </h2>
                    <p class="text">                        
                        <?php echo strip_tags(substr($school->about_text, 0, 550)); ?>...  
                    </p>
                    <div class="more text-right">
                        <a class="link glbscl-link-btn hvr-bs" href="<?php echo site_url('about'); ?>"><?php echo $this->lang->line('read_more'); ?></a>
                    </div>
                </div>
            </div>            
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center">
                <div class="top-banner-img">
                    <?php if(isset($school->about_image) && !empty($school->about_image)){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>about/<?php echo $school->about_image; ?>" alt="">
                    <?php }else{ ?>
                            <img src="<?php echo IMG_URL; ?>about-image.jpg" alt="">
                    <?php } ?>                                       
                </div>
            </div>
        </div>
    </div>
</section>
 <?php } ?> 

<section class="facilities-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title"><?php echo $this->lang->line('our'); ?> <span class="inner"><?php echo $this->lang->line('facilities'); ?></span></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-faclities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/experience-teacher.png" alt="">
                    </div>
                    <h4 class="name"><?php echo $this->lang->line('teacher'); ?></h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-faclities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/library.png" alt="">
                    </div>
                    <h4 class="name"><?php echo $this->lang->line('library'); ?></h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-faclities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/transport.png" alt="">
                    </div>
                    <h4 class="name"><?php echo $this->lang->line('transport'); ?></h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-faclities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/hostel.png" alt="">
                    </div>
                    <h4 class="name"><?php echo $this->lang->line('hostel'); ?></h4>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(isset($events) && !empty($events)){ ?>
<section class="latest-event">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title"><?php echo $this->lang->line('latest'); ?> <span class="inner"><?php echo $this->lang->line('event'); ?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <?php foreach($events AS $obj){  ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-event">
                        <div class="img">
                            <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>event/<?php echo $obj->image; ?>" alt="">
                            <?php }else{ ?>
                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                            <?php } ?>  
                        </div>
                        <div class="content">
                            <h2 class="title"><a href="<?php echo site_url('event-detail/'.$obj->id); ?>"><?php echo $obj->title; ?></a></h2>
                            <ul class="list">
                                <li class="info"><span class="icon"><i class="fas fa-user"></i></span><?php echo $obj->event_for ? $obj->event_for : $this->lang->line('all'); ?> (<?php echo $this->lang->line('event_for'); ?>)</li>
                                <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span><?php echo date($this->global_setting->date_format, strtotime($obj->event_from)); ?> (<?php echo $this->lang->line('start_date'); ?>)</li>
                                <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span><?php echo date($this->global_setting->date_format, strtotime($obj->event_to)); ?> (<?php echo $this->lang->line('end_date'); ?>)</li>
                                <li class="info"><span class="icon"><i class="fas fa-map-marker-alt"></i></span><?php echo $obj->event_place; ?></li>
                            </ul>
                            <div class="more text-center">
                                <a href="<?php echo site_url('event-detail/'.$obj->id); ?>" class="link glbscl-link-btn hvr-bs"><?php echo $this->lang->line('read_more'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>            
        </div>
    </div>
</section>
<?php } ?>


<section class="achivement-area bg-with-black">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title"><?php echo $this->lang->line('our'); ?> <span class="inner"><?php echo $this->lang->line('achivement'); ?></span></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/teacher.png" alt="">                         
                    </div>
                    <div class="content">
                        <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">
                            <?php if(isset($teacher)){ ?>
                                <?php echo $teacher; ?>
                            <?php } ?>
                        </h2>
                        <p class="name"><?php echo $this->lang->line('teacher'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/student.png" alt="">                      
                    </div>
                    <div class="content">
                        <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">
                            <?php if(isset($student)){ ?>
                                <?php echo $student; ?>
                            <?php } ?>
                        </h2>
                        <p class="name"><?php echo $this->lang->line('student'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/staff.png" alt="">
                    </div>
                    <div class="content">
                        <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">
                            <?php if(isset($staff)){ ?>
                                <?php echo $staff; ?>
                            <?php } ?>
                        </h2>
                        <p class="name"><?php echo $this->lang->line('staff'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <span><i class="fas fa-users"></i></span>
                    </div>
                    <div class="content">
                        <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">
                            <?php if(isset($user)){ ?>
                                <?php echo $user; ?>
                            <?php } ?>
                        </h2>
                        <p class="name"><?php echo $this->lang->line('user'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(isset($news) && !empty($news)){ ?>
<section class="latest-news-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title"><?php echo $this->lang->line('latest'); ?> <span class="inner"><?php echo $this->lang->line('news'); ?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <?php foreach($news AS $obj){ ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-12">
                    <div class="single-news">
                        <div class="img">
                            <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $obj->image; ?>" alt="">
                            <?php }else{ ?>
                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                            <?php } ?>  
                        </div>
                        <div class="content">
                            <ul class="meta">
                                <li class="info"><span class="icon"><i class="fas fa-user"></i></span><?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></li>
                                <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span><?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></li>
                            </ul>
                            <h2 class="title"><a href="<?php echo site_url('news-detail/'.$obj->id); ?>"><?php echo $obj->title; ?></a></h2>
                            <p class="text">
                                <?php echo substr($obj->news, 0, 180); ?> ...
                            </p>
                            <div class="more text-right">
                                <a class="link glbscl-link-btn hvr-bs" href="<?php echo site_url('news-detail/'.$obj->id); ?>"><?php echo $this->lang->line('read_more'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>           
        </div>
    </div>
</section>
<?php } ?>

<?php if(isset($feedbacks) && !empty($feedbacks)){ ?>
<section class="testimonial-area bg-with-black">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title white text-center">
                    <h2 class="title"><?php echo $this->lang->line('what_guardian_say'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-md-12 offset-lg-1 col-sm-12 col-12">
                <?php foreach($feedbacks AS $obj){ ?>
                <div class="testimonial-carousel owl-carousel">
                    <div class="single-testimonial">
                        <div class="auth-img">
                            <?php if(isset($obj->photo) && !empty($obj->photo)){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>guardian-photo/<?php echo $obj->photo; ?>" alt="">
                            <?php }else{ ?>
                                <img src="<?php echo IMG_URL; ?>default-user.png" alt="">
                            <?php } ?>                            
                        </div>
                        <div class="content">
                            <h2 class="name"><?php echo $obj->name; ?></h2>
                            <p class="text"><?php echo $obj->feedback; ?></p>
                        </div>
                    </div>             
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<section class="apply-now-area">
    <div class="container">
        <div class="apply-now">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-8 col-12">
                    <h2 class="title"><?php echo $this->lang->line('apply_now_for_your_kid'); ?></h2>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-12">
                    <a href="<?php echo site_url('admission-online'); ?>" class="link glbscl-link-btn hvr-bs" style="color: #007bff !important;"><?php echo $this->lang->line('apply_now'); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>