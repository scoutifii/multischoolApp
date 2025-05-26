<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-certificate"></i><small> <?php echo $this->lang->line('manage_certificate_type'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_type_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'certificate', 'type')){ ?>
                        
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('certificate/type/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_type"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_type"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>                            
                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_type_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('certificate_name'); ?></th>
                                        <th><?php echo $this->lang->line('school_name'); ?></th>
                                        <th><?php echo $this->lang->line('main_certificate_text'); ?></th>
                                        <th><?php echo $this->lang->line('background'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php  $count = 1; if(isset($certificates) && !empty($certificates)){ ?>
                                        <?php foreach($certificates as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo ucfirst($obj->name); ?></td>
                                            <td><?php echo $obj->top_title; ?></td>
                                            <td><?php echo $obj->main_text; ?></td>
                                            <td>
                                                <?php  if($obj->background != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/certificate/<?php echo $obj->background; ?>" alt="" width="150" /> 
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if(has_permission(VIEW, 'certificate', 'type')){ ?>
                                                    <a href="<?php echo site_url('certificate/type/view/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(EDIT, 'certificate', 'type')){ ?>
                                                    <a href="<?php echo site_url('certificate/type/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'certificate', 'type')){ ?>
                                                    <a href="<?php echo site_url('certificate/type/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_type">
                            <div class="x_content"> 
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo form_open_multipart(site_url('certificate/type/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                     
                                    <?php $this->load->view('layout/school_list_form'); ?> 
                                    
                                    <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $this->lang->line('certificate_name'); ?> <span class="required">*</span>
                                         </label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($name) ?  $name : ''; ?>" placeholder="<?php echo $this->lang->line('certificate_name'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('name'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="top_title"> <?php echo $this->lang->line('school_name'); ?> <span class="required">*</span></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="top_title"  id="top_title" value="<?php echo isset($top_title) ?  $top_title : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('top_title'); ?></div>
                                         </div>
                                     </div>
                              

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="main_text"> <?php echo $this->lang->line('main_certificate_text'); ?> <span class="required">*</span></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <textarea  class="form-control col-md-7 col-xs-12"  name="main_text"  id="main_text" required="required" placeholder="<?php echo $this->lang->line('main_certificate_text'); ?>"><?php echo isset($main_text) ?  $main_text : ''; ?></textarea>
                                             <div class="help-block"><?php echo form_error('main_text'); ?></div>
                                             <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="fn_add_tag"></div>
                                            </div>
                                         </div>
                                         
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer_left"> <?php echo $this->lang->line('footer_left'); ?></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="footer_left"  id="footer_left" value="<?php echo isset($footer_left) ?  $footer_left : ''; ?>" placeholder="<?php echo $this->lang->line('footer_left'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('footer_left'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer_middle"> <?php echo $this->lang->line('footer_middle'); ?></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="footer_middle"  id="footer_middle" value="<?php echo isset($footer_middle) ?  $footer_middle : ''; ?>" placeholder="<?php echo $this->lang->line('footer_middle'); ?>"  type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('footer_middle'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer_right"> <?php echo $this->lang->line('footer_right'); ?></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="footer_right"  id="footer_right" value="<?php echo isset($footer_right) ?  $footer_right : ''; ?>" placeholder="<?php echo $this->lang->line('footer_right'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('footer_right'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo $this->lang->line('background'); ?>
                                         </label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <div class="btn btn-default btn-file">
                                                 <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                 <input  class="form-control col-md-7 col-xs-12"  name="background"  id="background" type="file">
                                             </div>
                                             <div class="text-info">jpeg,jpg [1300x700]</div>
                                             <div class="help-block"><?php echo form_error('background'); ?></div>
                                         </div>
                                     </div>

                                     <div class="ln_solid"></div>
                                     <div class="form-group">
                                         <div class="col-md-6 col-md-offset-3">
                                             <a  href="<?php echo site_url('certificate/type/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                             <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                         </div>
                                     </div>
                                     <?php echo form_close(); ?>
                                </div>
                                
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_type">
                            <div class="x_content"> 
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo form_open_multipart(site_url('certificate/type/edit/'.$certificate->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                      
                                    <?php $this->load->view('layout/school_list_edit_form'); ?>
                                    
                                    <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $this->lang->line('certificate_name'); ?> <span class="required">*</span>
                                         </label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($certificate) ? $certificate->name : ''; ?>" placeholder="<?php echo $this->lang->line('certificate_name'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('name'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="top_title"><?php echo $this->lang->line('school_name'); ?> <span class="required">*</span></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="top_title"  id="top_title" value="<?php echo isset($certificate) ? $certificate->top_title : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('top_title'); ?></div>
                                         </div>
                                     </div>
                                                                     

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="main_text"> <?php echo $this->lang->line('main_certificate_text'); ?> <span class="required">*</span></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <textarea  class="form-control col-md-7 col-xs-12"  name="main_text"  id="edit_main_text" required="required" placeholder="<?php echo $this->lang->line('main_certificate_text'); ?>"><?php echo isset($certificate) ? $certificate->main_text : ''; ?></textarea>
                                             <div class="help-block"><?php echo form_error('main_text'); ?></div>
                                             <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="fn_add_tag"></div>
                                            </div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer_left"> <?php echo $this->lang->line('footer_left'); ?></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="footer_left"  id="footer_left" value="<?php echo isset($certificate) ? $certificate->footer_left : ''; ?>" placeholder="<?php echo $this->lang->line('footer_left'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('footer_left'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer_middle"> <?php echo $this->lang->line('footer_middle'); ?></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="footer_middle"  id="footer_middle" value="<?php echo isset($certificate) ? $certificate->footer_middle : ''; ?>" placeholder="<?php echo $this->lang->line('footer_middle'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('footer_middle'); ?></div>
                                         </div>
                                     </div>

                                     <div class="item form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="footer_right"> <?php echo $this->lang->line('footer_right'); ?></label>
                                         <div class="col-md-9 col-sm-9 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="footer_right"  id="footer_right" value="<?php echo isset($certificate) ? $certificate->footer_right : ''; ?>" placeholder="<?php echo $this->lang->line('footer_right'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('footer_right'); ?></div>
                                         </div>
                                     </div>
                                    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> <?php echo $this->lang->line('background'); ?>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="hidden" name="prev_background" id="prev_background" value="<?php echo $certificate->background; ?>" />
                                            <?php if($certificate->background){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/certificate/<?php echo $certificate->background; ?>" alt="" width="120" /><br/><br/>
                                            <?php } ?>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="background"  id="background" type="file">
                                            </div>
                                            <div class="text-info">jpeg,jpg [1300x700]</div>
                                            <div class="help-block"><?php echo form_error('background'); ?></div>
                                        </div>
                                    </div>

                                     <div class="ln_solid"></div>
                                     <div class="form-group">
                                         <div class="col-md-6 col-md-offset-3">
                                             <input type="hidden" value="<?php echo isset($certificate) ? $certificate->id : $id; ?>" name="id" />
                                             <a href="<?php echo site_url('certificate/type/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                             <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                         </div>
                                     </div>
                                     <?php echo form_close(); ?>
                                
                                </div>                                
                            </div>
                        </div>  
                        <?php } ?>
                        
                        <?php if(isset($detail)){ ?>
                             <div class="tab-pane fade in active" id="tab_view_type">
                                <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('certificate/type/view/'. $certificate->id), array('name' => '', 'id' => '', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                    
                                        <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet"> 
                                        <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet"> 
                                        <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed" rel="stylesheet">
                                        <link href="https://fonts.googleapis.com/css?family=Limelight" rel="stylesheet">  
                                        <link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet"> 
                                        <link href="https://fonts.googleapis.com/css?family=Prosto+One" rel="stylesheet"> 
                                        
                                         <div class="row">
                                             <div class="col-sm-12">
                                                <div class="certificate">
                                                    
                                                    <div class="certificate-top">
                                                        <h2 class="top-heading-title"><?php echo $certificate->top_title; ?></h2>
                                                       <div class="row">
                                                            <div class="sub-title-img col-sm-12">
                                                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="70" />
                                                            </div> 
                                                       </div>
                                                    </div>
                                                    
                                                    <div class="name-ection">
                                                        <div class="row" >
                                                            <div class="col-sm-12">
                                                                <div class="name-text"><?php echo $certificate->name; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="main-text-block">
                                                        <p class="main-text">
                                                            <?php echo $certificate->main_text; ?>
                                                        </p>
                                                    </div>
                                                    <div class="footer-section">
                                                        <div class="row" >
                                                            <div class="col-sm-4 <?php if($certificate->footer_left){ echo 'footer_text'; } ?>"><?php echo $certificate->footer_left; ?></div>
                                                            <div class="col-sm-4 <?php if($certificate->footer_middle){ echo 'footer_text'; } ?>"><?php echo $certificate->footer_middle; ?></div>
                                                            <div class="col-sm-4 <?php if($certificate->footer_right){ echo 'footer_text'; } ?>"><?php echo $certificate->footer_right; ?></div>
                                                        </div>
                                                    </div>
                                                </div>
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
     
  get_tag_by_role(<?php echo STUDENT; ?>);
  function get_tag_by_role(role_id){
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('/ajax/get_tag_by_role'); ?>",
            data   : { role_id : role_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('.fn_add_tag').html(response); 
               }
            }
        }); 
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
</script>
<style>
    .certificate {
        min-height: 550px;
        margin-left: auto;
        margin-right: auto;
        padding: 80px 120px;
        background: url("<?php echo UPLOAD_PATH; ?>/certificate/<?php echo $certificate->background; ?>") no-repeat ;
        background-size: 100% 100%;
    }    
</style>