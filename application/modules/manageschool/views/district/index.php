<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-folder-open"></i><small> <?php echo $this->lang->line('manage_district'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_district_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'manageschool', 'district')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('manageschool/district'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('district'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_district"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('district'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>                
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_district"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('district'); ?></a> </li>                          
                        <?php } ?>                
                        <?php if(isset($detail)){ ?>
                            <li  class="active"><a href="#tab_view_district"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> <?php echo $this->lang->line('district'); ?></a> </li>                          
                        <?php } ?>
                           
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_district_list" >
                            <div class="x_content">
                             <table id="datatable-responsive" class="table table-striped table-condensed table-hover" cellspacing="0" width="100%">
                              <thead>
                                    <tr>
                                    	<th>ID</th>
                                        <th><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('code'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($districts) && !empty($districts)){ ?>
                                        <?php foreach($districts as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $obj->district_name; ?></td>
                                            <td><?php echo $obj->district_code; ?></td>
                                           
                                            <td>
                                                <?php if(has_permission(VIEW, 'manageschool', 'district')){ ?>
                                                    <a  onclick="get_district_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-district-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>    
                                                <?php if(has_permission(EDIT, 'manageschool', 'district')){ ?>
                                                    <a href="<?php echo site_url('manageschool/district/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'manageschool', 'district')){ ?>
                                                    <a href="<?php echo site_url('manageschool/district/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_district">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('manageschool/district/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/region_list_form'); ?> 

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub_region_id"><?php echo $this->lang->line('subregion'); ?> <?php echo $this->lang->line('name'); ?><span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 select2"  name="sub_region_id"  id="sub_region_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                                                       
                                        </select>
                                        <div class="help-block"><?php echo form_error('sub_region_id'); ?></div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="district_name"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="district_name"  id="district_name" value="<?php echo isset($post['district_name']) ?  $post['district_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('district_name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('district_name'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="district_code"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('code'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="district_code"  id="coddistrict_codee" value="<?php echo isset($post['district_code']) ?  $post['district_code'] : ''; ?>" placeholder="<?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('district_code'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('district_code'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('manageschool/district/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_district">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('manageschool/district/edit/'.$district->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <?php $this->load->view('layout/region_list_edit_form_5'); ?>
                                    </div> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <?php $this->load->view('layout/subregion_list_edit_form_5'); ?>
                                    </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="district_name"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('district_name'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="district_name"  id="district_name" value="<?php echo isset($district->district_name) ?  $district->district_name : $post['district_name']; ?>" placeholder="<?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('district_name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('district_name'); ?></div>
                                    </div>
                                </div>
                                </div>
                                <!--div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('code'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="district_code"  id="code" value="<?php echo isset($district->district_code) ?  $district->district_code : $post['district_code']; ?>" placeholder="<?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('district_code'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('district_code'); ?></div>
                                    </div>
                                </div-->
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($district) ? $district->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('manageschool/district/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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


<div class="modal fade bs-district-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('information'); ?></h4>
        </div>
        <div class="modal-body fn_district_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_district_modal(district_id){
         
        $('.fn_district_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('manageschool/district/get_single_district'); ?>",
          data   : {district_id : district_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_district_data').html(response);
             }
          }
       });
    }
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