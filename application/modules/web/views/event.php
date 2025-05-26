<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('event'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href='javascript:void(0);'><?php echo $this->lang->line('all_event'); ?></a></li>
        </ul>
    </div>
</section>

<section class="page-event-area">
    <div class="container">
        <div class="row justify-content-center">
        <?php if(isset($events) && !empty($events)){ ?>
            <?php foreach($events AS $obj){ ?>
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
        <?php }else{ ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
            </div>
        <?php } ?>
        </div>
    </div>
</section>