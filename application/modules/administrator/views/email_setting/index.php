<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-envelope-o"></i><small> <?php echo $this->lang->line('manage_email_setting'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_setting_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'administrator', 'emailsetting')){ ?>
                            <?php if(isset($edit)){ ?>
                        <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('administrator/emailsetting/add'); ?>" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                            <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                            <?php } ?>     
                        <?php } ?>     
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>  
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_setting_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                         <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('email_protocol'); ?></th>
                                        <th><?php echo $this->lang->line('email_type'); ?></th>
                                        <th><?php echo $this->lang->line('char_set'); ?></th>
                                        <th><?php echo $this->lang->line('from_name'); ?></th>
                                        <th><?php echo $this->lang->line('from_email'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($email_settings) && !empty($email_settings)){ ?>
                                        <?php foreach($email_settings as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->mail_protocol; ?></td>
                                            <td><?php echo $obj->mail_type; ?></td>                                           
                                            <td><?php echo $obj->char_set; ?></td>                                           
                                            <td><?php echo $obj->from_name; ?></td>                                           
                                            <td><?php echo $obj->from_address; ?></td>                                           
                                            <td>
                                                <?php if(has_permission(VIEW, 'administrator', 'emailsetting')){ ?>
                                                    <a  onclick="get_email_setting_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-email-setting-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(EDIT, 'administrator', 'emailsetting')){ ?>
                                                    <a href="<?php echo site_url('administrator/emailsetting/edit/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'administrator', 'emailsetting')){ ?>
                                                    <a href="<?php echo site_url('administrator/emailsetting/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_setting">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('administrator/emailsetting/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail_protocol"><?php echo $this->lang->line('email_protocol'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $protocols = get_mail_protocol(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="mail_protocol"  id="mail_protocol" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($protocols as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('mail_protocol'); ?></div>
                                    </div>
                                </div>                                
                                
                                <div class="fn_add_smtp display"> 
                                   
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_host"><?php echo $this->lang->line('smtp_host'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_host"  id="smtp_host" value="" placeholder="<?php echo $this->lang->line('smtp_host'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_host'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_port"><?php echo $this->lang->line('smtp_port'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_port"  id="smtp_port" value="" placeholder="<?php echo $this->lang->line('smtp_port'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_port'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user"><?php echo $this->lang->line('smtp_username'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_user"  id="smtp_user" value="" placeholder="<?php echo $this->lang->line('smtp_username'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_user'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_pass"><?php echo $this->lang->line('smtp_password'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_pass"  id="smtp_pass" value="" placeholder="<?php echo $this->lang->line('smtp_password'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_pass'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_crypto"><?php echo $this->lang->line('smtp_security'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $cryptos = get_smtp_crypto(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="smtp_crypto"  id="smtp_crypto" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($cryptos as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('smtp_crypto'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_timeout"><?php echo $this->lang->line('smtp_timeout'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_timeout"  id="smtp_timeout" value="" placeholder="<?php echo $this->lang->line('smtp_timeout'); ?>" type="text" autocomplete="off">
                                        <div class="text-info">SMTP Timeout (in seconds) [ 5 - 10 ].</div>
                                        <div class="help-block"><?php echo form_error('smtp_timeout'); ?></div>
                                    </div>
                                </div>
                                    
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail_type"><?php echo $this->lang->line('email_type'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $mail_types = get_mail_type(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="mail_type"  id="mail_type" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($mail_types as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('mail_type'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="char_set"><?php echo $this->lang->line('char_set'); ?>  </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $char_sets = get_char_set(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="char_set"  id="char_set" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($char_sets as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('char_set'); ?></div>
                                    </div>
                                </div>
                                  
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="priority"><?php echo $this->lang->line('priority'); ?>  </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $email_priority = get_email_priority(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="priority"  id="priority" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($email_priority as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('priority'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="from_name"><?php echo $this->lang->line('from_name'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="from_name"  id="from_name" value="" placeholder="<?php echo $this->lang->line('from_name'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('from_name'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="from_address"><?php echo $this->lang->line('from_email'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="from_address"  id="from_address" value="" placeholder="<?php echo $this->lang->line('from_email'); ?>" type="email" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('from_address'); ?></div>
                                    </div>
                                </div>
                                  
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('administrator/emailsetting/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        
                        <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_setting">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('administrator/emailsetting/edit/'.$email_setting->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                <div class="item form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail_protocol"><?php echo $this->lang->line('email_protocol'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $protocols = get_mail_protocol(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="mail_protocol"  id="edit_mail_protocol" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($protocols as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" <?php if(isset($email_setting) && $email_setting->mail_protocol == $key ){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('mail_protocol'); ?></div>
                                    </div>
                                </div>                                
                                
                                <div class="fn_edit_smtp <?php if(isset($email_setting) && $email_setting->mail_protocol != 'smtp'){ echo 'display'; } ?>"> 
                                   
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_host"><?php echo $this->lang->line('smtp_host'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_host"  id="edit_smtp_host" value="<?php if(isset($email_setting)){ echo $email_setting->smtp_host;} ?>" placeholder="<?php echo $this->lang->line('smtp_host'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_host'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_port"><?php echo $this->lang->line('smtp_port'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_port"  id="edit_smtp_port" value="<?php if(isset($email_setting)){ echo $email_setting->smtp_port;} ?>" placeholder="<?php echo $this->lang->line('smtp_port'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_port'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user"><?php echo $this->lang->line('smtp_username'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_user"  id="edit_smtp_user" value="<?php if(isset($email_setting)){ echo $email_setting->smtp_user;} ?>" placeholder="<?php echo $this->lang->line('smtp_username'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_user'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_pass"><?php echo $this->lang->line('smtp_password'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_pass"  id="edit_smtp_pass" value="<?php if(isset($email_setting)){ echo $email_setting->smtp_pass;} ?>" placeholder="<?php echo $this->lang->line('smtp_password'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('smtp_pass'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_crypto"><?php echo $this->lang->line('smtp_security'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $cryptos = get_smtp_crypto(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="smtp_crypto"  id="smtp_crypto" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($cryptos as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" <?php if(isset($email_setting) && $email_setting->smtp_crypto == $key ){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('smtp_crypto'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_timeout"><?php echo $this->lang->line('smtp_timeout'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="smtp_timeout"  id="smtp_timeout" value="<?php if(isset($email_setting)){ echo $email_setting->smtp_timeout;} ?>" placeholder="<?php echo $this->lang->line('smtp_timeout'); ?>" type="text" autocomplete="off">
                                        <div class="text-info">SMTP Timeout (in seconds).</div>
                                        <div class="help-block"><?php echo form_error('smtp_timeout'); ?></div>
                                    </div>
                                </div>
                                    
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail_type"><?php echo $this->lang->line('email_type'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $mail_types = get_mail_type(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="mail_type"  id="mail_type" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($mail_types as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" <?php if(isset($email_setting) && $email_setting->mail_type == $key ){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('mail_type'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="char_set"><?php echo $this->lang->line('char_set'); ?>  </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $char_sets = get_char_set(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="char_set"  id="char_set" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($char_sets as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" <?php if(isset($email_setting) && $email_setting->char_set == $key ){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('char_set'); ?></div>
                                    </div>
                                </div>
                                  
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="priority"><?php echo $this->lang->line('priority'); ?>  </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php $email_priority = get_email_priority(); ?>
                                        <select  class="form-control col-md-12 col-xs-12"  name="priority"  id="priority" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($email_priority as $key=>$value ){ ?>
                                                <option value="<?php echo $key; ?>" <?php if(isset($email_setting) && $email_setting->priority == $key ){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('priority'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="from_name"><?php echo $this->lang->line('from_name'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="from_name"  id="from_name" value="<?php if(isset($email_setting)){ echo $email_setting->from_name;} ?>" placeholder="<?php echo $this->lang->line('from_name'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('from_name'); ?></div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="from_address"><?php echo $this->lang->line('from_email'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="from_address"  id="from_address" value="<?php if(isset($email_setting)){ echo $email_setting->from_address;} ?>" placeholder="<?php echo $this->lang->line('from_email'); ?>" type="email" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('from_address'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" id="id" name="id" value="<?php if(isset($email_setting)){ echo $email_setting->id;} ?>"/>
                                        <a href="<?php echo site_url('administrator/emailsetting/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-email-setting-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_email_setting_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_email_setting_modal(setting_id){
         
        $('.fn_email_setting_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('administrator/emailsetting/get_single_email_setting'); ?>",
          data   : {setting_id : setting_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_email_setting_data').html(response);
             }
          }
       });
    }
</script>



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
    
    $('#mail_protocol').on('change', function(){
        if($(this).val() == 'smtp'){
            $('.fn_add_smtp').show();
            $('#smtp_host').prop('required', true); 
            $('#smtp_port').prop('required', true); 
            $('#smtp_user').prop('required', true); 
            $('#smtp_pass').prop('required', true); 
        }else{
           $('.fn_add_smtp').hide(); 
           $('#smtp_host').prop('required', false); 
            $('#smtp_port').prop('required', false); 
            $('#smtp_user').prop('required', false); 
            $('#smtp_pass').prop('required', false); 
        }
    });
    $('#edit_mail_protocol').on('change', function(){
        if($(this).val() == 'smtp'){
            $('.fn_edit_smtp').show();
            $('#edit_smtp_host').prop('required', true); 
            $('#edit_smtp_port').prop('required', true); 
            $('#edit_smtp_user').prop('required', true); 
            $('#edit_smtp_pass').prop('required', true); 
        }else{
           $('.fn_edit_smtp').hide(); 
           $('#edit_smtp_host').prop('required', false); 
            $('#edit_smtp_port').prop('required', false); 
            $('#edit_smtp_user').prop('required', false); 
            $('#edit_smtp_pass').prop('required', false); 
        }
    });
    
    
</script> 
