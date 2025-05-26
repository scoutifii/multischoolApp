<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-envelope"></i><small> <?php echo $this->lang->line('manage_feedback'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_feedback_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                           
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_feedback"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>  
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_feedback_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>                                        
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>                                       
                                        <th width="60%"><?php echo $this->lang->line('feedback'); ?></th>                                        
                                        <th><?php echo $this->lang->line('is_publish'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($feedbacks) && !empty($feedbacks)){ ?>
                                        <?php foreach($feedbacks as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>                                            
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->feedback; ?></td>
                                            <td>
                                                <?php echo $obj->is_publish ? $this->lang->line('yes') : $this->lang->line('no'); ?>
                                            </td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->created_at)); ?></td>
                                            <td>
                                                <?php if($obj->is_publish){ ?>
                                                    <a href="<?php echo site_url('administrator/feedback/deactivate/'.$obj->id); ?>"><button class="btn btn-success btn-xs"> <i class="fa fa-check"></i> <?php echo  $this->lang->line('unpublish_now'); ?></button></a>
                                                <?php }else{ ?>    
                                                    <a href="<?php echo site_url('administrator/feedback/activate/'.$obj->id); ?>"><button class="btn btn-info btn-xs"> <i class="fa fa-close"></i> <?php echo  $this->lang->line('publish_now'); ?></button></a>
                                                <?php } ?>  
                                                <?php if(has_permission(EDIT, 'administrator', 'feedback')){ ?>
                                                    <a href="<?php echo site_url('administrator/feedback/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>                                                
                                                <?php if(has_permission(DELETE, 'administrator', 'feedback')){ ?>
                                                    <a href="<?php echo site_url('administrator/feedback/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_feedback">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('administrator/feedback/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                            
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="feedback"><?php echo $this->lang->line('feedback'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="feedback"  id="feedback" required="required" placeholder="<?php echo $this->lang->line('feedback'); ?>"><?php echo isset($post['feedback']) ?  $post['feedback'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('feedback'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('administrator/feedback/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_feedback">
                            <div class="x_content">
                               
                               <?php echo form_open(site_url('administrator/feedback/edit/'.$feedback->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                                         
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="feedback"><?php echo $this->lang->line('feedback'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="feedback"  id="feedback" required="required" placeholder="<?php echo $this->lang->line('feedback'); ?>"><?php echo isset($feedback->feedback) ?  $feedback->feedback : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('feedback'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($feedback) ? $feedback->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('guardian/feedback/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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