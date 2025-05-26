<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('gallery'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('all_gallery'); ?></a></li>
        </ul>
    </div>
</section>

<section class="page-gallery-area">
    <div class="container">
     <div class="row">    
    <?php if(isset($galleries) && !empty($galleries)){ ?>
        <?php foreach($galleries AS $obj){ ?>
        <?php $images = get_gallery_images($obj->school_id, $obj->id); ?> 
            <?php if(!empty($images)){ ?>
                <div class="gallery-section-title">
                    <h2 class="title"><?php echo $obj->title; ?></h2>
                    <div class="text"><?php echo $obj->note; ?></div>
                </div>
                <div class="gallery-carousel owl-carousel">
                    <?php foreach($images as $img){ ?>
                        <div class="single-gallery">
                            <a href="<?php echo UPLOAD_PATH; ?>gallery/<?php echo $img->image; ?>" data-fancybox="images">
                                <span class="icon"><i class="fas fa-search-plus"></i></span>
                                <img src="<?php echo UPLOAD_PATH; ?>gallery/<?php echo $img->image; ?>" alt="<?php echo $img->caption; ?>" />
                            </a>
                        </div>   
                    <?php } ?> 
                </div>        
            <?php } ?> 
    <?php } ?> 
    <?php }else{ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
        </div>
    <?php } ?>
       </div>  
    </div>
</section>
