<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('event_detail'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="<?php echo site_url('events'); ?>"><?php echo $this->lang->line('all_event'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('event_detail'); ?></a></li>
        </ul>
    </div>
</section>
<section class="page-event-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="page-event-details">
                    <div class="banner">
                        <?php if(isset($event->image) && !empty($event->image)){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>event/<?php echo $event->image; ?>" alt="">
                        <?php }else{ ?>
                            <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                        <?php } ?> 
                    </div>
                    <h2 class="title"><?php echo $event->title; ?></h2>
                    <ul class="event-meta">
                        <li class="info"><span class="icon"><i class="fas fa-user"></i></span> <?php echo $event->event_for ? $event->event_for : $this->lang->line('all'); ?> (<?php echo $this->lang->line('event_for'); ?>)</li>
                        <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($event->event_from)); ?> (<?php echo $this->lang->line('start_date'); ?>)</li>
                        <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($event->event_to)); ?> (<?php echo $this->lang->line('end_date'); ?>)</li>
                        <li class="info"><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $event->event_place; ?></li>
                    </ul>
                    <h2 class="info-title"><?php echo $this->lang->line('note'); ?> :</h2>
                    <div class="text"><?php echo $event->note; ?></div>
                </div>
            </div>
            
            <div class="col-lg-4 offset-lg-0 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h2 class="sidebar-title"><?php echo $this->lang->line('latest_event'); ?></h2>
                        <ul class="widget-event">
                            <?php if(isset($events) && !empty($events)){ ?> 
                                <?php foreach($events AS $obj){ ?>
                                <li>
                                    <a href="<?php echo site_url('event-detail/'.$obj->id); ?>">
                                        <span class="img">
                                            <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>event/<?php echo $obj->image; ?>" alt="">
                                            <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                                            <?php } ?> 
                                        </span>
                                        <span class="content">
                                            <span class="title"><?php echo $obj->title; ?></span>
                                            <span class="event-meta">
                                                <span class="info"><span class="icon"><i class="fas fa-user"></i></span> <?php echo $obj->event_for ? $obj->event_for : $this->lang->line('all'); ?> (<?php echo $this->lang->line('event_for'); ?>)</span>
                                                <span class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->event_from)); ?> (<?php echo $this->lang->line('start_date'); ?>)</span>
                                                <span class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->event_to)); ?> (<?php echo $this->lang->line('end_date'); ?>)</span>
                                                <span class="info"><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $obj->event_place; ?></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>    
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>