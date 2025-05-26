<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('news_detail'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="<?php echo site_url('news'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('news_detail'); ?></a></li>
        </ul>
    </div>
</section>

<section class="page-news-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="page-news-details">
                    
                    <div class="banner">
                        <?php if(isset($news->image) && !empty($news->image)){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $news->image; ?>" alt="">
                        <?php }else{ ?>
                            <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                        <?php } ?>
                    </div>
                    
                    <ul class="meta">
                        <li class="info"><span class="icon"><i class="fas fa-user"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $news->name; ?></li>
                        <li class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($news->date)); ?></li>
                    </ul>
                    
                    <h2 class="title"><?php echo $news->title; ?></h2>                   
                    <p class="text"><?php echo $news->news; ?></p>                   
                    <div class="share-news" style="display: none;">
                        <h4 class="name">Share :</h4>
                        <ul class="social">
                            <li><a class="icon" href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="icon" href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a class="icon" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a class="icon" href="#"><i class="fab fa-google-plus-g"></i></a></li>
                        </ul>
                    </div>                    
                </div>
            </div>
            
            
            <div class="col-lg-4 offset-lg-0 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h2 class="sidebar-title"><?php echo $this->lang->line('latest_news'); ?></h2>
                        <ul class="widget-news">
                           <?php if(isset($latest_news) && !empty($latest_news)){ ?> 
                                <?php foreach($latest_news AS $obj ){ ?> 
                                 <li>
                                     <a href="<?php echo site_url('news-detail/'.$obj->id); ?>">
                                         <span class="img">
                                             <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $obj->image; ?>" alt="">
                                            <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                                            <?php } ?>  
                                         </span>
                                         <span class="content">
                                             <span class="meta">
                                                 <span class="info"><span class="icon"><i class="fas fa-user"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></span>
                                                 <span class="info"><span class="icon"><i class="far fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></span>
                                             </span>
                                             <span class="title"><?php echo $obj->title; ?></span>
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
