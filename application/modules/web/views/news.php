<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('news'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('news'); ?></a></li>
        </ul>
    </div>
</section>

<section class="page-news-area">
    <div class="container">
        <div class="row justify-content-center">
        <?php if(isset($news) && !empty($news)){ ?>
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
                        <div class="text">
                            <?php echo strip_tags(substr($obj->news, 0, 180)); ?> ...
                        </div>
                        <div class="more text-right">
                            <a class="link glbscl-link-btn hvr-bs" href="<?php echo site_url('news-detail/'.$obj->id); ?>"><?php echo $this->lang->line('read_more'); ?></a>
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