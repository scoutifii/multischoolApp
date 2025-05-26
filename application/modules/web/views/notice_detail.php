<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('notice_detail'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>">Home</a></li>
            <li><a href="<?php echo site_url('notice'); ?>"><?php echo $this->lang->line('all_notice'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('notice_detail'); ?></a></li>
        </ul>
    </div>
</section>

<section class="page-notice-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="page-notice">
                    <h2 class="title"><?php echo $notice->title; ?></h2>
                    <ul class="meta">
                        <li class="info"><span class="icon"><i class="fas fa-user"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $notice->name; ?></li>
                        <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($notice->date)); ?></li>
                    </ul>
                    <ul class="meta">
                        <li class="info"><span class="icon"><i class="fas fa-users"></i></span> <?php echo $this->lang->line('notice_for'); ?>: <?php echo $notice->notice_for ? $notice->notice_for : $this->lang->line('all'); ?></li>
                    </ul>
                    <div class="text"><?php echo $notice->notice; ?></div>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-0 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h2 class="sidebar-title"><?php echo $this->lang->line('latest_notice'); ?></h2>
                        <ul class="widget-notice">
                            <?php if(isset($notices) && !empty($notices)){ ?>
                                <?php foreach($notices AS $obj){ ?>
                                <li>
                                    <a href="<?php echo site_url('notice-detail/'.$obj->id); ?>">
                                        <span class="title"><?php echo $obj->title; ?></span>
                                        <span class="date"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></span>
                                        <span class="date"><span class="icon"><i class="fas fa-user"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></span>
                                        <span class="date"><span class="icon"><i class="fas fa-users"></i></span> <?php echo $this->lang->line('notice_for'); ?>: <?php echo $obj->notice_for ? $obj->notice_for : $this->lang->line('all'); ?></span>
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