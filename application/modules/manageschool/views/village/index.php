<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-folder-open"></i><small> <?php echo $this->lang->line('manage_village'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
              <div  class="well">
                 <?php $this->load->view('quick-link'); ?>
            </div>
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_village_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'manageschool', 'village')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('manageschool/village/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('village'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_village"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('village'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>                
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_village"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('village'); ?></a> </li>                          
                        <?php } ?>                
                        <?php if(isset($detail)){ ?>
                            <li  class="active"><a href="#tab_view_village"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> <?php echo $this->lang->line('village'); ?></a> </li>                          
                        <?php } ?>
                            
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_village_list" >
                            <div class="x_content">
                             <table id="datatable-responsive" class="table table-striped table-condensed table-hover" cellspacing="0" width="100%">
                              <thead>
                                    <tr>
                                    	<th>ID</th>
                                        <th><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('code'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($villages) && !empty($villages)){ ?>
                                        <?php foreach($villages as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <!--td><?php echo $obj->sub_county_code; ?></td-->
                                            <td><?php echo $obj->village_name; ?></td>
                                            <td><?php echo $obj->village_code; ?></td>
                                           
                                            <td>
                                                <?php if(has_permission(VIEW, 'manageschool', 'village')){ ?>
                                                    <a  onclick="get_village_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-village-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>    
                                                <?php if(has_permission(EDIT, 'manageschool', 'village')){ ?>
                                                    <a href="<?php echo site_url('manageschool/village/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'manageschool', 'village')){ ?>
                                                    <a href="<?php echo site_url('manageschool/village/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_village">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('manageschool/village/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/region_list_form'); ?> 

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('subregion'); ?> <?php echo $this->lang->line('name'); ?><span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 select2"  name="sub_region_id"  id="sub_region_id" required="required" onchange="get_district_by_subregion(this.value, '','');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                        
                                        </select>
                                        <div class="help-block"><?php echo form_error('sub_region_id'); ?></div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="district_id"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="district_id"  id="district_id" required="required" onchange="get_subcounty_by_district(this.value, '','');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        </select>
                                        <div class="help-block"><?php echo form_error('district_id'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub_county_id"><?php echo $this->lang->line('subcounty'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="sub_county_id"  id="sub_county_id" required="required" onchange="get_village_by_parish(this.value, '','');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        </select>
                                        <div class="help-block"><?php echo form_error('sub_county_id'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parish_id"><?php echo $this->lang->line('parish'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="parish_id"  id="parish_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        </select>
                                        <div class="help-block"><?php echo form_error('parish_id'); ?></div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="village_name"><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="village_name"  id="village_name" value="<?php echo isset($post['village_name']) ?  $post['village_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('village_name'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="village_code"><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('code'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="village_code"  id="village_code" value="<?php echo isset($post['village_code']) ?  $post['village_code'] : ''; ?>" placeholder="<?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('code'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('village_code'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('manageschool/village/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_village">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('manageschool/village/edit/'.$village->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $this->load->view('layout/region_list_edit_form_2'); ?>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $this->load->view('layout/subregion_list_edit_form_2'); ?>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $this->load->view('layout/district_list_edit_form_2'); ?>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $this->load->view('layout/subcounty_list_edit_form_1'); ?>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $this->load->view('layout/parish_list_edit_form_2'); ?>
                                    </div> 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="village_name"><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="village_name"  id="village_name" value="<?php echo isset($village) ?  $village->village_name : $post['village_name']; ?>" placeholder="<?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('village_name'); ?></div>
                                    </div>
                                </div>
                            </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($village) ? $village->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('manageschool/village/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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


<div class="modal fade bs-village-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('information'); ?></h4>
        </div>
        <div class="modal-body fn_village_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_village_modal(village_id){
         
        $('.fn_village_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('manageschool/village/get_single_village'); ?>",
          data   : {village_id : village_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_village_data').html(response);
             }
          }
       });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() { 
      $("#edit_district_id").select2();
      $("#edit_region_id").select2();
      $("#edit_sub_region_id").select2();
      $("#add_region_id").select2();
  });
 </script>
 
<!-- Super admin js START  -->
 <script type="text/javascript">
     
    var edit = false;
    <?php if(isset($edit)){ ?>
        edit = true;
    <?php } ?>         
    
     
    $('.fn_region_id').on('change', function(){
      
        var region_id = $(this).val();
        var sub_region_id = '';
               
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subregion_by_region'); ?>",
            data   : { region_id:region_id, sub_region_id:sub_region_id},                
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(edit){
                       $('#edit_sub_region_id').html(response);   
                   }else{
                       $('#sub_region_id').html(response);   
                   }
               }
            }
        });
    }); 
    
  </script>
<!-- Super admin js end -->

    <script type="text/javascript">

    <?php if(isset($sub_region_id) && isset($district_id)){ ?>
        get_district_by_subregion('<?php echo $sub_region_id; ?>', '<?php echo $district_id; ?>');
    <?php } ?>

    function get_district_by_subregion(sub_region_id, district_id){       
       
        if(edit){
            var region_id = $('#edit_region_id').val();
        }else{
            var region_id = $('#add_region_id').val();
        } 

        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_district_by_subregion'); ?>",
            data   : {region_id:region_id, sub_region_id : sub_region_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                       $('#edit_district_id').html(response);
                   }else{
                       $('#district_id').html(response);
                   }
                   
               }
            }
        });
    }
    </script>

    <script type="text/javascript">
        <?php if(isset($district_id) && isset($sub_county_id)){ ?>
        get_subcounty_by_district('<?php echo $district_id; ?>', '<?php echo $sub_county_id; ?>');
    <?php } ?> 
    function get_subcounty_by_district(district_id, sub_county_id){ 
       
        if(edit){
            var region_id = $('#edit_region_id').val();
        }else{
            var region_id = $('#add_region_id').val();
        } 
        var sub_region_id = $('#sub_region_id').val();
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subcounty_by_district'); ?>",
            data   : {region_id:region_id, sub_region_id : sub_region_id, district_id:district_id, sub_county_id:sub_county_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                       $('#edit_sub_county_id').html(response);
                   }else{
                       $('#sub_county_id').html(response);
                   }
                   
               }
            }
        });
    }
    </script>

    <script type="text/javascript">
        <?php if(isset($parish_id) && isset($village_id)){ ?>
        get_village_by_parish('<?php echo $parish_id; ?>', '<?php echo $village_id; ?>');
    <?php } ?> 
    function get_village_by_parish(parish_id, village_id){ 
       
        if(edit){
            var region_id = $('#edit_region_id').val();
        }else{
            var region_id = $('#add_region_id').val();
        } 
        var sub_region_id = $('#sub_region_id').val();
        var district_id = $('#district_id').val();
        var sub_county_id = $('#sub_county_id').val();
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_village_by_parish'); ?>",
            data   : {region_id:region_id, sub_region_id : sub_region_id, district_id:district_id, sub_county_id:sub_county_id, parish_id:parish_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                       $('#edit_parish_id').html(response);
                   }else{
                       $('#parish_id').html(response);
                   }
                   
               }
            }
        });
    }
    </script>

<!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {
          $('#datatable-responsive').DataTable({
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

