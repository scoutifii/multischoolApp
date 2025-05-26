<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $page->page_title; ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $page->page_title; ?></a></li>
        </ul>
    </div>
</section>

<?php if(isset($page) && !empty($page)){ ?>
<section class="top-banner-area">
    <div class="container">
        <div class="row">
            
            <?php if(isset($page->page_image) && !empty($page->page_image)){ ?>
            
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="top-banner-content">                      
                        <!--<h2 class="title"><?php echo $page->page_title; ?>  </h2>-->
                        <div class="text">                        
                            <?php echo $page->page_description; ?>                       
                        </div>                     
                    </div>
                </div>            
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center">
                    <div class="top-banner-img">
                        <?php if(isset($page->page_image) && !empty($page->page_image)){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>page/<?php echo $page->page_image; ?>" alt="">
                        <?php } ?>                     
                    </div>
                </div>
            
            <?php }else{ ?>
            
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="top-banner-content">  
                        <!--<h2 class="title"><?php echo $page->page_title; ?>  </h2>-->
                        <div class="text">                        
                             <?php echo $page->page_description; ?>                       
                        </div>                    
                    </div>
                </div>  
            
            <?php } ?>
            
        </div>
    </div>
</section>
 <?php } ?> 
