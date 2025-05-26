<footer>
    <div class="footer-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-7 col-sm-7 col-12">
                    <div class="footer-widget">
                        <div class="fw-logo">
                            <?php if(isset($school->frontend_logo)){ ?>                            
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt=""  />
                            <?php }elseif(isset($school->logo)){ ?>                            
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt=""  />
                            <?php }else{ ?>
                                <img  width="100" height="100" src="<?php echo IMG_URL; ?>/sms-log.png">
                            <?php } ?>   
                        </div>
                        <p class="text">
                            <?php if(isset($school->about_text) && !empty($school->about_text)){ ?>
                                <?php echo strip_tags(substr($school->about_text, 0, 350)); ?>
                            <?php } ?> 
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-12">
                    <div class="footer-widget">
                        <h2 class="fw-title"> <span><?php echo $this->lang->line('quick_link'); ?></span></h2>
                        <ul class="links">
                            <li><a href="<?php echo site_url('admission-online'); ?>"><?php echo $this->lang->line('admission'); ?></a></li>
                            <li><a href="<?php echo site_url('news'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
                            <li><a href="<?php echo site_url('notice'); ?>"><?php echo $this->lang->line('notice'); ?></a></li>
                            <li><a href="<?php echo site_url('holiday'); ?>"><?php echo $this->lang->line('holiday'); ?></a></li>
                            <li><a href="<?php echo site_url('events'); ?>"><?php echo $this->lang->line('event'); ?></a></li>
                            <li><a href="<?php echo site_url('galleries'); ?>"><?php echo $this->lang->line('gallery'); ?></a></li>
                            <li><a href="<?php echo site_url('teachers'); ?>"><?php echo $this->lang->line('teacher'); ?></a></li>
                            <li><a href="<?php echo site_url('staff'); ?>"><?php echo $this->lang->line('staff'); ?></a></li>
                            <li><a href="<?php echo site_url('contact'); ?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
                            <?php if(isset($footer_pages) && !empty($footer_pages)){ ?>
                               <?php foreach($footer_pages AS $obj ){ ?>
                                    <li><a href="<?php echo site_url('page/'.$obj->page_slug); ?>"><?php echo $obj->page_title; ?></a></li>
                                <?php } ?> 
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-12">
                    <div class="footer-widget">
                        <h2 class="fw-title"><?php echo $this->lang->line('social_link'); ?></h2>
                        <ul class="social">
                            <?php if(isset($school->facebook_url) && !empty($school->facebook_url)){ ?>
                                <li><a href="<?php echo $school->facebook_url; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <?php } ?> 
                            <?php if(isset($school->twitter_url)  && !empty($school->twitter_url)){ ?>
                                <li><a href="<?php echo $school->twitter_url; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <?php } ?>                             
                            <?php if(isset($school->linkedin_url)  && !empty($school->linkedin_url)){ ?>
                                <li><a href="<?php echo $school->linkedin_url; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            <?php } ?>                             
                            <?php if(isset($school->google_plus_url)  && !empty($school->google_plus_url)){ ?>
                                <li><a href="<?php echo $school->google_plus_url; ?>" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>
                            <?php } ?>                              
                            <?php if(isset($school->youtube_url)  && !empty($school->youtube_url)){ ?>
                                <li><a href="<?php echo $school->youtube_url; ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <?php } ?>                              
                            <?php if(isset($school->instagram_url)  && !empty($school->instagram_url)){ ?>
                                <li><a href="<?php echo $school->instagram_url; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <?php } ?>                              
                            <?php if(isset($school->pinterest_url)  && !empty($school->pinterest_url)){ ?>
                                <li><a href="<?php echo $school->pinterest_url; ?>" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-7 col-sm-7 col-12">
                    <div class="footer-widget">
                        <h2 class="fw-title"><?php echo $this->lang->line('get_in_touch'); ?></h2>
                        <ul class="address">
                            <li><span class="icon"><i class="fas fa-phone"></i></span> 
                                <?php if(isset($school->phone)){ ?>
                                     <?php echo $school->phone; ?>
                                <?php } ?> 
                            </li>
                            <li><span class="icon"><i class="fas fa-envelope"></i></span>
                                <?php if(isset($school->email)){ ?>
                                     <?php echo $school->email; ?>
                                <?php } ?>
                            </li>
                            <li><span class="icon"><i class="fas fa-map-marker-alt"></i></span> 
                                <?php if(isset($school->address)){ ?>
                                     <?php echo $school->address; ?>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container text-center">
            <p class="copyright">
                <?php if(isset($school->footer)){ ?>                            
                    <?php echo $school->footer; ?>
                <?php }else{ ?>
                    <?php echo $this->global_setting->brand_footer; ?>
                <?php } ?>                 
            </p>
        </div>
    </div>
</footer>
