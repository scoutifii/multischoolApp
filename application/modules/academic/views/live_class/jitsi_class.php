<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-headphones"></i><small> <?php echo $this->lang->line('manage_live_class'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                 
                    <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_liveclass_list" >                            
                            <div class="x_content">
                                <div id="meeting"></div>
                            </div>
                        </div> <!-- End first tab -->              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $room_name = $live_class->class_name.'-'.$live_class->section.'-'.$live_class->subject;        
?>

<script src='https://meet.jit.si/external_api.js'></script>
<script type="text/javascript">
         
const domain = 'meet.jit.si';
   const options = {
       roomName: '<?php echo $room_name; ?>',
       width: '100%',
       height: 550,
       userInfo: {
            email: '<?php echo $this->session->userdata('email'); ?>',
            displayName: '<?php echo $this->session->userdata('name'); ?>'
       },       
       enableClosePage: true,
       SHOW_PROMOTIONAL_CLOSE_PAGE: true,
       parentNode: document.querySelector('#meeting')
   };
   const api = new JitsiMeetExternalAPI(domain, options);
   
</script>
<style type="text/css">
    .fn_header_global{display: none;}
    .x_panel{padding: 0px;}
    .x_title{margin-bottom: 0px;}
</style>