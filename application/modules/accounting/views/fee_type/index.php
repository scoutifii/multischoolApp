<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> <?php echo $this->lang->line('manage_fee_type'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                 <?php $this->load->view('quick-link'); ?>   
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_feetype_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'accounting', 'feetype')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('accounting/feetype/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_feetype"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                            <?php } ?> 
                        <?php } ?>
                            
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_feetype"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>
                        
                        <li class="li-class-list">
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                             <select  class="form-control col-md-7 col-xs-12" onchange="get_feetype_by_school(this.value);">
                                     <option value="<?php echo site_url('accounting/feetype/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                 <?php foreach($schools as $obj ){ ?>
                                     <option value="<?php echo site_url('accounting/feetype/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                 <?php } ?>   
                             </select>
                         <?php } ?>  
                        </li>       
                            
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_feetype_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('title'); ?></th>
                                        <th><?php echo $this->lang->line('note'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($feetypes) && !empty($feetypes)){ ?>
                                        <?php foreach($feetypes as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>  
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->title; ?></td>                                           
                                            <td><?php echo $obj->note; ?></td>
                                            <td> 
                                                <?php if(has_permission(VIEW, 'accounting', 'feetype')){ ?>
                                                    <a  onclick="get_feetype_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-feetype-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php  } ?>
                                                <?php if(has_permission(EDIT, 'accounting', 'feetype')){ ?>
                                                    <a href="<?php echo site_url('accounting/feetype/edit/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'accounting', 'feetype')){ ?>
                                                    <a href="<?php echo site_url('accounting/feetype/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>                                  
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_feetype">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('accounting/feetype/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                 <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="head_type"><?php echo $this->lang->line('fee_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="head_type" id="fee_type" onchange="show_class_amount(this.value, false);">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="fee" <?php if(isset($post['head_type']) && $post['head_type'] == 'fee'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('general_fee'); ?></option>                                           
                                            <option value="hostel" <?php if(isset($post['head_type']) && $post['head_type'] == 'hostel'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('hostel'); ?> </option>                                           
                                            <option value="transport" <?php if(isset($post['head_type']) && $post['head_type'] == 'transport'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('transport'); ?> </option>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('head_type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group fn_instruction display">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="instructions" style="padding: 5px; margin:20px 0px 20px 0px;"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> 
                                            <ol>
                                                <li><?php echo $this->lang->line('fee_type_instruction_hostel_1'); ?></li>
                                                <li><?php echo $this->lang->line('fee_type_instruction_hostel_2'); ?></li>
                                                <li><?php echo $this->lang->line('fee_type_instruction_transport_1'); ?></li>
                                                <li><?php echo $this->lang->line('fee_type_instruction_transport_2'); ?></li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                                            
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('title'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($post['title']) ?  $post['title'] : ''; ?>" placeholder="<?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>                                
                                
                                <div class="item form-group fn_amount_head display">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""><?php echo $this->lang->line('class'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="padding-top: 6px;">                                       
                                        <strong>: <?php echo $this->lang->line('amount'); ?></strong>
                                    </div>
                                </div> 
                                
                                <div class="fn_add_classes_block display">
                                <?php if(isset($classes) && !empty($classes)){ ?>
                                    <?php foreach($classes as $obj){ ?>
                                        <div class="item form-group">
                                           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?php $obj->name; ?>"><?php echo $obj->name; ?> <span class="required">*</span></label>
                                           <div class="col-md-6 col-sm-6 col-xs-12">                                      
                                               <input type="hidden" name="class_id[<?php echo $obj->id; ?>]" id="<?php echo $obj->id; ?>" value="<?php echo $obj->id; ?>" />
                                               <input type="text" class="form-control col-md-7 col-xs-12" name="fee_amount[<?php echo $obj->id; ?>]" id="<?php echo $obj->id; ?>" value="" required="required" />
                                               <div class="help-block"><?php echo form_error($obj->name); ?></div>
                                           </div>
                                       </div>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('accounting/feetype/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                                                                
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_feetype">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('accounting/feetype/edit/'.$feetype->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="head_type"><?php echo $this->lang->line('fee_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="head_type" id="fee_type" onchange="show_class_amount(this.value, true);">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="fee" <?php if(isset($feetype->head_type) && $feetype->head_type == 'fee'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('general_fee'); ?></option>                                           
                                            <option value="hostel" <?php if(isset($feetype->head_type) && $feetype->head_type == 'hostel'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('hostel'); ?> </option>                                           
                                            <option value="transport" <?php if(isset($feetype->head_type) && $feetype->head_type == 'transport'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('transport'); ?> </option>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('head_type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($feetype->title) ?  $feetype->title : ''; ?>" placeholder="<?php echo $this->lang->line('fee'); ?> <?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>
                                
                               
                                
                                <div class="item form-group fn_amount_head <?php if(isset($feetype) && $feetype->head_type != 'fee'){ echo 'display'; } ?>">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""><?php echo $this->lang->line('name'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="padding-top: 6px;">                                       
                                        <strong>: <?php echo $this->lang->line('amount'); ?></strong>
                                    </div>
                                </div> 
                               
                                <div class="fn_edit_classes_block <?php if(isset($feetype) && $feetype->head_type != 'fee'){ echo 'display'; } ?>">
                                    <?php if(isset($classes) && !empty($classes)){ ?>
                                    <?php foreach($classes as $obj){ ?>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?php $obj->name; ?>"><?php echo $obj->name; ?> </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                <?php $fee_amount = get_fee_amount($feetype->id, $obj->id); ?>
                                                <input type="hidden" name="amount_id[<?php echo $obj->id; ?>]" value="<?php echo @$fee_amount->id; ?>" />
                                                <input type="hidden" name="class_id[<?php echo $obj->id; ?>]" value="<?php echo $obj->id; ?>" />
                                                <input type="text" class="form-control col-md-7 col-xs-12" name="fee_amount[<?php echo $obj->id; ?>]" id="<?php echo $obj->id; ?>" value="<?php echo @$fee_amount->fee_amount; ?>" />
                                                <div class="help-block"><?php echo form_error($obj->name); ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                
                                
                                <div class="item form-group fn_instruction <?php if(isset($feetype) && $feetype->head_type != 'fee'){ echo 'display'; } ?>">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="instructions" style="padding: 5px; margin:20px 0px 20px 0px;"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> 
                                            <ol>
                                                <li><?php echo $this->lang->line('fee_type_instruction_hostel_1'); ?></li>
                                                <li><?php echo $this->lang->line('fee_type_instruction_hostel_2'); ?></li>
                                                <li><?php echo $this->lang->line('fee_type_instruction_transport_1'); ?></li>
                                                <li><?php echo $this->lang->line('fee_type_instruction_transport_2'); ?></li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($feetype->note) ?  $feetype->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($feetype) ? $feetype->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('accounting/feetype/index'); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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


<div class="modal fade bs-feetype-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_feetype_data">           
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_feetype_modal(feetype_id){
         
        $('.fn_feetype_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('accounting/feetype/get_single_feetype'); ?>",
          data   : {feetype_id : feetype_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_feetype_data').html(response);
             }
          }
       });
    }
</script>

<!-- Super admin JS -->
 <script type="text/javascript">
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>
             $("#edit_school_id").trigger('change');
         <?php } ?>
    });

    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var fee_type_id = '';
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            fee_type_id =  '<?php echo $feetype->id; ?>';
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }       
       
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/feetype/get_fee_head_by_school'); ?>",
            data   : { school_id:school_id, fee_type_id:fee_type_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(fee_type_id){
                       $('.fn_edit_classes_block').html(response);   
                   }else{
                       $('.fn_add_classes_block').html(response);   
                   }                                    
               }
            }
        });
    }); 
    
    
    function show_class_amount(fee_type, is_edit){
    
        if(fee_type == 'fee' && is_edit == true){
            
           $('.fn_amount_head').show();             
           $('.fn_edit_classes_block').show();
           $('.fn_instruction').hide(); 
           
        }else if(fee_type == 'fee' && is_edit == false){
            
           $('.fn_amount_head').show();             
           $('.fn_add_classes_block').show();  
           $('.fn_instruction').hide(); 
           
        }else if(fee_type != 'fee' || fee_type != ''){
             
             $('.fn_amount_head').hide(); 
             $('.fn_add_classes_block').hide(); 
             $('.fn_edit_classes_block').hide(); 
             $('.fn_instruction').show(); 
        }
    }
    
  
</script>



<!-- datatable with buttons -->
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
    
    function get_feetype_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }  
    
</script>