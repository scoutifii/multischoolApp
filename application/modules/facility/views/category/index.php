<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa fa-calendar-check-o"></i><small> <?php echo $this->lang->line('manage_school_facility_categories'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_category_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                      <?php if(has_permission(ADD, 'facility', 'facility')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('facility/category/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('category'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_category"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('category'); ?></a> </li>                          
                             <?php } ?>
                           
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li class="active"><a href="#tab_edit_category"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('category'); ?></a> </li>                          
                        <?php } ?>  
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_category_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('category_name'); ?></th>
                                        <th><?php echo $this->lang->line('category_type'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($facility_categories) && !empty($facility_categories)){ ?>
                                        <?php foreach($facility_categories as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->category_name; ?></td>
                                            <td><?php echo $obj->category_type; ?></td>
                                            <td>
                                                  <?php if(has_permission(EDIT, 'facility', 'category')){ ?>
                                                    <a href="<?php echo site_url('facility/category/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                               
                                               <?php if(has_permission(VIEW, 'facility', 'category')){ ?>
                                                    <a  onclick="get_category_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-category-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                    
                                                <?php if(has_permission(DELETE, 'facility', 'category')){ ?>
                                                    <a href="<?php echo site_url('category/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_category">
                            <div class="x_content"> 
                                <div class="well">
                               <?php echo form_open_multipart(site_url('facility/category/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?> 
                                <div class="item form-group">
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php $this->load->view('layout/school_list_form'); ?>
                                </div>
                                </div>
                                <div class="item form-group">

                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                    <label class="control-label" for="category_type"><?php echo $this->lang->line('category_type'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_type"  id="category_type" required="required" >
                                             <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             <?php $school_facility_cat = get_school_facility_category(); ?>
                                                <?php foreach($school_facility_cat as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($facility_categories->category_type == $key ) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
                                                <?php } ?>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_type'); ?></div>
                                    </div>
                                    </div>
                                </div>       
                                <div class="item form-group">
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                    <label class="control-label" for="name"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_name"  id="category_name" required="required" >
                                             <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             <?php $school_facility_cat_name = get_school_facility_category_name(); ?>
                                                <?php foreach($school_facility_cat_name as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($facility_categories->category_name == $key ) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
                                                <?php } ?>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_name'); ?></div>
                                    </div>
                                </div>                         
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('facility/category'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        </div> 
                    </div>

                        <?php if(isset($edit)){ ?>
                        <!--<div class="tab-pane fade in active" id="tab_edit_category">-->
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_category">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('facility/category/edit/'.$category->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_type"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('type'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="category_type"  id="category_type" value="<?php echo isset($category->category_type) ?  $category->category_type : $post['category_type']; ?>" placeholder="<?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('category_type'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('category_type'); ?></div>
                                    </div>
                                </div> 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_name"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="category_name"  id="category_name" value="<?php echo isset($category->category_name) ?  $category->category_name : $post['category_name']; ?>" placeholder="<?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('category_name'); ?></div>
                                    </div>
                                </div>                               
                                                       
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($category) ? $category->id : '' ?>" name="id" />
                                        <a href="<?php echo site_url('facility/category/index/'. $category_id); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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

        <div class="modal fade bs-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('information'); ?></h4>
        </div>
        <div class="modal-body fn_category_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_category_modal(category_id){
         
        $('.fn_category_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('facility/category/get_single_school_facility_category'); ?>",
          data   : {category_id : category_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_category_data').html(response);
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
