<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa fa-calendar-check-o"></i><small> <?php echo $this->lang->line('manage_school_facilities'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content quick-link">
              <div  class="well">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'facility', 'category')){ ?>
                    <a href="<?php echo site_url('facility/category'); ?>"><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('category'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'facility', 'facility')){ ?>
                   | <a href="<?php echo site_url('facility/index'); ?>"><?php echo $this->lang->line('facility'); ?></a>
                <?php } ?>
            </div>
        </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_facility_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'facility', 'facility')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('facility/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('facility'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_facility"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('facility'); ?></a> </li>                          
                             <?php } ?>
                           
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_facility"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('facility'); ?></a> </li>                          
                        <?php } ?> 

                        <li class="li-class-list">
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                            
                                <?php echo form_open(site_url('facility/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id"  onchange="get_facility_by_school(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select>
                                    <select  class="form-control col-md-7 col-xs-12" id="filter_facility_id" name="facility_id"  style="width:auto;" onchange="this.form.submit();">
                                         <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php if(isset($categories) && !empty($categories)){ ?>
                                            <?php foreach($categories as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>"><?php echo $obj->facility_name; ?></option> 
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                   <?php echo form_close(); ?>
                            
                            <?php }?>
                            </li> 
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_facility_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('facility_name'); ?></th>
                                        <th><?php echo $this->lang->line('facility_no'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($school_facilities) && !empty($school_facilities)){ ?>
                                        <?php foreach($school_facilities as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->facility_name; ?></td>                                            
                                            <td><?php echo $obj->facility_no; ?></td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'facility', 'facility')){ ?>
                                                    <a href="<?php echo site_url('facility/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                               <?php if(has_permission(VIEW, 'facility', 'facility')){ ?>
                                                    <a  onclick="get_facility_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-facility-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                    
                                                <?php if(has_permission(DELETE, 'facility', 'facility')){ ?>
                                                    <a href="<?php echo site_url('facility/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_facility">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('facility/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="item form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php $this->load->view('layout/school_list_form'); ?>
                                </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_id"  id="add_category_id" required="required" >
                                             <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             
                                            <?php foreach($categories as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($post['category_id']) && $post['category_id'] == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->category_name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_id'); ?></div>
                                    </div>
                                </div>      

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="facility_name"  id="facility_name" value="<?php echo isset($post['facility_name']) ?  $post['facility_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('facility_name'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facility_no"><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('number'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="facility_no"  id="facility_no" value="<?php echo isset($post['facility_no']) ?  $post['facility_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('facility_no'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('facility_no'); ?></div>
                                    </div>
                                </div>                                
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('facility'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_facility">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('facility/edit/'.$facility->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_id"  id="edit_category_id" required="required" >
                                             <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             
                                            <?php foreach($categories as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($post['category_id']) && $post['category_id'] == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->category_name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facility_name"><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="facility_name"  id="facility_name" value="<?php echo isset($facility->facility_name) ?  $facility->facility_name : $post['facility_name']; ?>" placeholder="<?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('facility_name'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facility_no"><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('number'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="facility_no"  id="facility_no" value="<?php echo isset($facility->facility_no) ?  $facility->facility_no : $post['facility_no']; ?>" placeholder="<?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('facility_no'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('tifacility_notle'); ?></div>
                                    </div>
                                </div>                                
                                                       
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($facility) ? $facility->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('facility'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>  

        <div class="modal fade bs-facility-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('information'); ?></h4>
        </div>
        <div class="modal-body fn_facility_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_facility_modal(facility_id){
         
        $('.fn_facility_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('facility/get_single_facility'); ?>",
          data   : {facility_id : facility_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_facility_data').html(response);
             }
          }
       });
    }


    function check_category_type(category_id) {

    if (category_id == "toilets") {

           $('.fn_toilets').show();                
           $('#facility_name').prop('required', true);
           $('#facility_no').prop('required', true);               

       }else{         

           $('.fn_toilets').hide();  
           $('#facility_name').prop('required', false);
           $('#facility_no').prop('required', true);              
       } 
    }
</script>

<script type="text/javascript">
    $("document").ready(function() {
         <?php if(isset($edit) && !empty($edit)){ ?>
            $("#edit_school_id").trigger('change');
         <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var category_id = '';
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            category_id =  '<?php echo $facility->category_id; ?>';
            
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_facility_by_school'); ?>",
            data   : { school_id:school_id, category_id:category_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(category_id){
                       $('#edit_category_id').html(response);   
                   }else{
                       $('#add_category_id').html(response);   
                   }
                    
               }
            }
        });
    }); 
    

    <?php if(isset($filter_facility_id)){ ?>
        get_facility_by_school('<?php echo $filter_school_id; ?>', '<?php echo $filter_facility_id; ?>');
    <?php } ?>
    
    function get_facility_by_school(school_id, category_id){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_facility_by_school'); ?>",
            data   : { school_id : school_id, category_id : category_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#filter_facility_id').html(response);                     
               }
            }
        });
    } 
</script>

<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
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
    
    $("#add").validate();     
    $("#edit").validate();  
  </script>  
