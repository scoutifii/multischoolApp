<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-certificate"></i><small> <?php echo $this->lang->line('manage_certificate'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                <?php $this->load->view('quick-link'); ?> 
            </div>
            
            
            <div class="x_content"> 
                <?php echo form_open_multipart(site_url('certificate/index'), array('name' => 'generate', 'id' => 'generate', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                
                     <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12"  name="class_id"  id="class_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                <?php if(isset($classes) && !empty($classes)){ ?>
                                    <?php foreach($classes as $obj ){ ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
                                    <?php } ?> 
                                <?php } ?> 
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('certificate_type'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12"  name="certificate_id"  id="certificate_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                <?php if(isset($certificates) && !empty($certificates)){ ?>
                                    <?php foreach($certificates as $obj ){ ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($certificate_id) && $certificate_id == $obj->id){ echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
                                    <?php } ?> 
                                <?php } ?> 
                            </select>
                            <div class="help-block"><?php echo form_error('certificate_id'); ?></div>
                        </div>
                    </div>
                
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                    
                </div>
                <?php echo form_close(); ?>
            </div>
            
             <div class="x_content">
                <div class="" data-example-id="togglable-tabs">                    
                    <ul  class="nav nav-tabs bordered">                 
                        <li  class="active"><a href="#tab_user_list" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-group"></i> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></a></li>                          
                    </ul>
                    <br/>
                     <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_user_list" >
                           
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('photo'); ?></th>                                                                    
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('created'); ?></th>                                            
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody id="fn_mark">   
                                    <?php
                                    $count = 1;
                                    if (isset($students) && !empty($students)) {
                                        ?>
                                        <?php foreach ($students as $obj) { ?>
                                         
                                            <tr>
                                                <td><?php echo $count++;  ?></td>
                                                <td>
                                                    <?php if ($obj->photo != '') { ?>                                        
                                                        <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="60" /> 
                                                    <?php } else { ?>
                                                        <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="60" /> 
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo ucfirst($obj->name); ?></td>
                                                <td><?php echo $obj->phone; ?></td>
                                                <td><?php echo $obj->email; ?></td>   
                                                <td><?php echo date($this->global_setting->date_format, strtotime($obj->created_at)); ?></td>   
                                                <td>    
                                                    <?php if(has_permission(VIEW, 'certificate', 'certificate')){ ?>
                                                    <a target="_blank" href="<?php echo site_url('certificate/generate/'.$obj->school_id.'/'.$obj->id.'/'.$class_id .'/'.$certificate_id); ?>"  class="btn btn-success btn-xs"><i class="fa fa-certificate"> <?php echo $this->lang->line('generate'); ?></i></a>
                                                    <?php } ?>
                                                </td>   
                                            </tr>
                                        <?php } ?>
                                    <?php } ?> 

                                </tbody>
                            </table> 
                        </div> 
                        </div>
                 </div>
            </div>

            
        </div>
    </div>
</div>
</div>

<!-- Super admin js START  -->
 <script type="text/javascript">
     
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>
            $("#school_id").trigger('change');
         <?php } ?>
    });
     
    $('#school_id').on('change', function(){
      
        var school_id = $(this).val();
        var class_id = '';
        var certificate_id = '';
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            class_id =  '<?php echo $class_id; ?>';
            certificate_id =  '<?php echo $certificate_id; ?>';
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                  
                    $('#class_id').html(response);                                    
                    get_certificate_type_by_school(school_id, certificate_id);
               }
            }
        });
    }); 
    
    
    function get_certificate_type_by_school(school_id, certificate_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_certificate_type_by_school'); ?>",
            data   : { school_id:school_id, certificate_id: certificate_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                      
                    $('#certificate_id').html(response);                   
               }
            }
        });
    }
    
  </script>
<!-- Super admin js end -->
  

 <script type="text/javascript">

        $(document).ready(function() {
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
        
     $("#generate").validate();    
</script> 
