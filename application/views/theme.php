<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-cubes"></i><small> <?php echo $this->lang->line('manage_theme'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>

        <div class="x_content">
            <div class="row">                
                <?php if(isset($themes) && !empty($themes)){ ?>
                    <?php $counter = 0; foreach($themes as $obj ){ ?>
                    <div class="col-md-3 col-sm-3 col-xs-6" style="<?php if($counter%4 == 0){ echo 'float:left; clear:both;'; } ?>">
                        <div class="theme-box">
                            <img src="<?php echo IMG_URL; ?>theme/<?php echo $obj->slug; ?>.png" alt="" />
                            <a href="<?php echo site_url('theme/activate/'.$obj->id); ?>"><button class="btn btn-success" style="background: <?php echo $obj->color_code; ?>;border: 1px solid <?php echo $obj->color_code; ?>;">  <?php echo $this->session->userdata('theme') == $obj->slug ? '<i class="fa fa-check"></i> '. $this->lang->line('active') : $this->lang->line('activate'); ?></button></a>
                        </div>
                    </div>
                    <?php $counter++; } ?>
                <?php } ?>
            </div> 
            </div> 
        </div>
    </div>
</div>

