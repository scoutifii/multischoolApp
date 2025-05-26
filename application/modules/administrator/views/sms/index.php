<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-gears"></i><small> <?php echo $this->lang->line('manage_sms_setting'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_sms_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'administrator', 'sms')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('administrator/sms/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('sms'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_sms"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('sms'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>                              
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_sms"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('sms'); ?></a> </li>                          
                        <?php } ?>                         
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_sms_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('school'); ?></th>
                                        <th><?php echo $this->lang->line('clicktell'); ?></th>
                                        <th><?php echo $this->lang->line('twilio'); ?></th>
                                        <th><?php echo $this->lang->line('bulk'); ?></th>
                                        <th><?php echo $this->lang->line('msg91'); ?></th>
                                        <th><?php echo $this->lang->line('plivo'); ?></th>
                                        <th><?php echo $this->lang->line('text_local'); ?></th>
                                        <th><?php echo $this->lang->line('sms_country'); ?></th>
                                        <th><?php echo $this->lang->line('beta_sms'); ?></th>
                                        <th><?php echo $this->lang->line('bulk_pk'); ?></th>
                                        <th><?php echo $this->lang->line('sms_custer'); ?></th>
                                        <th><?php echo $this->lang->line('alpha_net'); ?></th>
                                        <th><?php echo $this->lang->line('bd_bulk'); ?></th>
                                        <th><?php echo $this->lang->line('mim_sms'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($sms_settings) && !empty($sms_settings)){ ?>
                                        <?php foreach($sms_settings as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $obj->school_name; ?></td>
                                            <td><?php echo $obj->clickatell_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>
                                            <td><?php echo $obj->twilio_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>
                                            <td><?php echo $obj->bulk_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>
                                            <td><?php echo $obj->msg91_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->plivo_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->textlocal_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->smscountry_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->betasms_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->bulk_pk_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->cluster_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->alpha_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->bdbulk_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td><?php echo $obj->mim_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>                                            
                                            <td>                                                
                                                <?php if(has_permission(VIEW, 'administrator', 'sms')){ ?>
                                                    <a  onclick="get_sms_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-sms-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a><br/>
                                                <?php } ?>  
                                                <?php if(has_permission(EDIT, 'administrator', 'sms')){ ?>
                                                    <a href="<?php echo site_url('administrator/sms/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'administrator', 'sms')){ ?>
                                                    <a href="<?php echo site_url('administrator/sms/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>                                
                            </div>
                        </div>
                        

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_sms">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('administrator/sms/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <?php $this->load->view('layout/school_list_form'); ?> 
                                    </div>                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-3">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li  class="active"><a href="#tab_twilio_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('twilio'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_clickatell_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('clicktell'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_bulk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bulk'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_msg91_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('msg91'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_plivo_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('plivo'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_textlocal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('text_local'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_smscountry_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('sms_country'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_betasms_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('beta_sms'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_bulkpk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bulk_pk'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_cluster_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('sms_custer'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_alpha_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('alpha_net'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_bdbulk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bd_bulk'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_mimsms_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mim_sms'); ?></a> </li>                          
                                        </ul>
                                      </div> 
                                    <div class="col-xs-9">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="tab_twilio_setting">                           
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_account_sid"><?php echo $this->lang->line('account_sid'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="twilio_account_sid" value="<?php echo isset($sms_setting) ? $sms_setting->twilio_account_sid : ''; ?>"  placeholder="<?php echo $this->lang->line('account_sid'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('twilio_account_sid'); ?></div>
                                                    </div>
                                                </div>                                               
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_auth_token"><?php echo $this->lang->line('auth_token'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="twilio_auth_token" value="<?php echo isset($sms_setting) ? $sms_setting->twilio_auth_token : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_token'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('twilio_auth_token'); ?></div>
                                                    </div>
                                                </div>                                               
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_from_number"><?php echo $this->lang->line('from_number'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="twilio_from_number" value="<?php echo isset($sms_setting) ? $sms_setting->twilio_from_number : ''; ?>"  placeholder="<?php echo $this->lang->line('from_number'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('twilio_from_number'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="twilio_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->twilio_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->twilio_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('twilio_status'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.twilio.com" target="_blank"><img src="<?php echo IMG_URL; ?>twilio-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class="tab-pane fade in " id="tab_clickatell_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_username" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_username'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_password" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_password'); ?></div>
                                                    </div>
                                                </div>                  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_api_key" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_api_key : ''; ?>"  placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_api_key'); ?></div>
                                                    </div>
                                                </div>       
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_from_number"><?php echo $this->lang->line('from_number'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_from_number" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_from_number : ''; ?>"  placeholder="<?php echo $this->lang->line('from_number'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_from_number'); ?></div>
                                                    </div>
                                                </div>       
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_mo_no"><?php echo $this->lang->line('clickatell_mo_no'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_mo_no" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_mo_no : ''; ?>"  placeholder="<?php echo $this->lang->line('clickatell_mo_no'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_mo_no'); ?></div>
                                                    </div>
                                                </div>  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="clickatell_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->clickatell_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->clickatell_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('clickatell_status'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.clickatell.com/" target="_blank"><img src="<?php echo IMG_URL; ?>clickatell-sms.png" alt="" /></a> 
                                                        </div>
                                                </div>
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_bulk_setting">                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_username" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_password" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_password'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bulk_status">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bulk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bulk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bulk_status'); ?></div>
                                                    </div>
                                                </div>                                 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.bulksms.com/" target="_blank"><img src="<?php echo IMG_URL; ?>bulk-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                           
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_msg91_setting">                        
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="msg91_auth_key"><?php echo $this->lang->line('auth_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="msg91_auth_key" value="<?php echo isset($sms_setting) ? $sms_setting->msg91_auth_key : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('msg91_auth_key'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="msg91_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="msg91_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->msg91_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('msg91_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="msg91_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="msg91_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->msg91_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->msg91_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('msg91_status'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://msg91.com/" target="_blank"><img src="<?php echo IMG_URL; ?>msg91-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                                
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_plivo_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_auth_id"><?php echo $this->lang->line('auth_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="plivo_auth_id" value="<?php echo isset($sms_setting) ? $sms_setting->plivo_auth_id : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('plivo_auth_id'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_auth_token"><?php echo $this->lang->line('auth_token'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="plivo_auth_token" value="<?php echo isset($sms_setting) ? $sms_setting->plivo_auth_token : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_token'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('plivo_auth_token'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_from_number"><?php echo $this->lang->line('from_number'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="plivo_from_number" value="<?php echo isset($sms_setting) ? $sms_setting->plivo_from_number : ''; ?>"  placeholder="<?php echo $this->lang->line('from_number'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('plivo_from_number'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="plivo_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->plivo_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->plivo_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('plivo_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.plivo.com/" target="_blank"><img src="<?php echo IMG_URL; ?>plivo-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                         
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_textlocal_setting">                         
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="textlocal_username" value="<?php echo isset($sms_setting) ? $sms_setting->textlocal_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('textlocal_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_hash_key"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="textlocal_hash_key" value="<?php echo isset($sms_setting) ? $sms_setting->textlocal_hash_key : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('textlocal_hash_key'); ?></div>
                                                    </div>
                                                </div>                                   
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="textlocal_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->textlocal_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('textlocal_sender_id'); ?></div>
                                                    </div>
                                                </div>  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="textlocal_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->textlocal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->textlocal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('textlocal_status'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.textlocal.com/" target="_blank"><img src="<?php echo IMG_URL; ?>textlocal-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                                
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_smscountry_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="smscountry_username" value="<?php echo isset($sms_setting) ? $sms_setting->smscountry_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('smscountry_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="smscountry_password" value="<?php echo isset($sms_setting) ? $sms_setting->smscountry_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('smscountry_password'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="smscountry_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->smscountry_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('smscountry_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="smscountry_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->smscountry_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->smscountry_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('smscountry_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.smscountry.com/" target="_blank"><img src="<?php echo IMG_URL; ?>country-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                                                                  
                                            <div class="tab-pane fade in " id="tab_betasms_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="betasms_username" value="<?php echo isset($sms_setting) ? $sms_setting->betasms_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('betasms_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="betasms_password" value="<?php echo isset($sms_setting) ? $sms_setting->betasms_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('betasms_password'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="betasms_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->betasms_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('betasms_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="betasms_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->betasms_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->betasms_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('smscountry_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://betasms.com/betasms-api/" target="_blank"><img src="<?php echo IMG_URL; ?>beta-sms.png" alt="" /></a> 
                                                         <div class="instructions">Nigeria & West African SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                                                                  
                                            <div class="tab-pane fade in " id="tab_bulkpk_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_pk_username" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_pk_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_pk_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_pk_password" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_pk_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_pk_password'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_pk_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_pk_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_pk_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bulk_pk_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bulk_pk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bulk_pk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bulk_pk_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="http://bulksms.com.pk" target="_blank"><img src="<?php echo IMG_URL; ?>bulk-pk-sms.png" alt="" /></a> 
                                                        <div class="instructions">Pakistani SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                                                                                                              
                                            <div class="tab-pane fade in " id="tab_cluster_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_auth_key"><?php echo $this->lang->line('auth_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="cluster_auth_key" value="<?php echo isset($sms_setting) ? $sms_setting->cluster_auth_key : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('cluster_auth_key'); ?></div>
                                                    </div>
                                                </div>  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="cluster_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->cluster_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('cluster_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_router"><?php echo $this->lang->line('router'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="cluster_router" value="<?php echo isset($sms_setting) ? $sms_setting->cluster_router : ''; ?>"  placeholder="<?php echo $this->lang->line('router'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('cluster_router'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="cluster_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->cluster_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->cluster_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('cluster_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="http://www.smscluster.com/" target="_blank"><img src="<?php echo IMG_URL; ?>cluster-sms.png" alt="" /></a> 
                                                         <div class="instructions">Pakistani SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                            
                                            <div class="tab-pane fade in " id="tab_alpha_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="alpha_username" value="<?php echo isset($sms_setting) ? $sms_setting->alpha_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('alpha_username'); ?></div>
                                                    </div>
                                                </div>  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_hash"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="alpha_hash" value="<?php echo isset($sms_setting) ? $sms_setting->alpha_hash : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('alpha_hash'); ?></div>
                                                    </div>
                                                </div> 
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_type"><?php echo $this->lang->line('sms_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="alpha_type" required="required">
                                                            <option value="text" <?php if(isset($sms_setting) && $sms_setting->alpha_type == 'text'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('text'); ?></option>
                                                            <option value="unicode" <?php if(isset($sms_setting) && $sms_setting->alpha_type == 'unicode'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('unicode'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('alpha_type'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="alpha_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->alpha_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->alpha_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('alpha_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://alpha.net.bd/" target="_blank"><img src="<?php echo IMG_URL; ?>alpha-sms.png" alt="" /></a> 
                                                         <div class="instructions">Bangladeshi SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                        
                                            <div class="tab-pane fade in " id="tab_bdbulk_setting">                            
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_hash"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bdbulk_hash" value="<?php echo isset($sms_setting) ? $sms_setting->bdbulk_hash : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bdbulk_hash'); ?></div>
                                                    </div>
                                                </div>                                                 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_type"><?php echo $this->lang->line('sms_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bdbulk_type" required="required">
                                                            <option value="text" <?php if(isset($sms_setting) && $sms_setting->bdbulk_type == 'text'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('text'); ?></option>
                                                            <option value="unicode" <?php if(isset($sms_setting) && $sms_setting->bdbulk_type == 'unicode'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('unicode'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bdbulk_type'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bdbulk_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bdbulk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bdbulk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bdbulk_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://bdbulksms.net/" target="_blank"><img src="<?php echo IMG_URL; ?>bdbulk-sms.gif" alt="" /></a> 
                                                         <div class="instructions">Bangladeshi SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                            
                                            <div class="tab-pane fade in " id="tab_mimsms_setting">                            
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="mim_api_key" value="<?php echo isset($sms_setting) ? $sms_setting->mim_api_key : ''; ?>"  placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('mim_api_key'); ?></div>
                                                    </div>
                                                </div>    
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="mim_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->mim_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('mim_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_type"><?php echo $this->lang->line('sms_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="mim_type" required="required">
                                                            <option value="text" <?php if(isset($sms_setting) && $sms_setting->mim_type == 'text'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('text'); ?></option>
                                                            <option value="unicode" <?php if(isset($sms_setting) && $sms_setting->mim_type == 'unicode'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('unicode'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('mim_type'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bdbulk_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bdbulk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bdbulk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bdbulk_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.mimsms.com/" target="_blank"><img src="<?php echo IMG_URL; ?>mim-sms.png" alt="" /></a> 
                                                         <div class="instructions">Bangladeshi SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                            
                                        </div>                                    
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a href="<?php echo site_url('administrator/sms/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                <button id="send" type="submit" class="btn btn-success"><?php  echo $this->lang->line('submit'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_sms">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('administrator/sms/edit/'.$sms_setting->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                    </div>                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-3">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li  class="active"><a href="#tab_edit_twilio_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('twilio'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_clickatell_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('clicktell'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_bulk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bulk'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_msg91_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('msg91'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_plivo_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('plivo'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_textlocal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('text_local'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_smscountry_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('sms_country'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_betasms_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('beta_sms'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_bulkpk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bulk_pk'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_cluster_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('sms_custer'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_alpha_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('alpha_net'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_bdbulk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bd_bulk'); ?></a> </li>                          
                                            <li  class=""><a href="#tab_edit_mimsms_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mim_sms'); ?></a> </li>                          
                                        </ul>
                                      </div> 
                                    <div class="col-xs-9">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="tab_edit_twilio_setting">                           
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_account_sid"><?php echo $this->lang->line('account_sid'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="twilio_account_sid" value="<?php echo isset($sms_setting) ? $sms_setting->twilio_account_sid : ''; ?>"  placeholder="<?php echo $this->lang->line('account_sid'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('twilio_account_sid'); ?></div>
                                                    </div>
                                                </div>                                               
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_auth_token"><?php echo $this->lang->line('auth_token'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="twilio_auth_token" value="<?php echo isset($sms_setting) ? $sms_setting->twilio_auth_token : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_token'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('twilio_auth_token'); ?></div>
                                                    </div>
                                                </div>                                               
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_from_number"><?php echo $this->lang->line('from_number'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="twilio_from_number" value="<?php echo isset($sms_setting) ? $sms_setting->twilio_from_number : ''; ?>"  placeholder="<?php echo $this->lang->line('from_number'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('twilio_from_number'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twilio_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="twilio_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->twilio_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->twilio_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('twilio_status'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.twilio.com" target="_blank"><img src="<?php echo IMG_URL; ?>twilio-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class="tab-pane fade in " id="tab_edit_clickatell_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_username" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_username'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_password" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_password'); ?></div>
                                                    </div>
                                                </div>                  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_api_key" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_api_key : ''; ?>"  placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_api_key'); ?></div>
                                                    </div>
                                                </div>       
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_from_number"><?php echo $this->lang->line('from_number'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_from_number" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_from_number : ''; ?>"  placeholder="<?php echo $this->lang->line('from_number'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_from_number'); ?></div>
                                                    </div>
                                                </div>       
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_mo_no"><?php echo $this->lang->line('clickatell_mo_no'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="clickatell_mo_no" value="<?php echo isset($sms_setting) ? $sms_setting->clickatell_mo_no : ''; ?>"  placeholder="<?php echo $this->lang->line('clickatell_mo_no'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('clickatell_mo_no'); ?></div>
                                                    </div>
                                                </div>  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="clickatell_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="clickatell_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->clickatell_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->clickatell_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('clickatell_status'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="https://www.clickatell.com/" target="_blank"><img src="<?php echo IMG_URL; ?>clickatell-sms.png" alt="" /></a> 
                                                        </div>
                                                </div>
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_edit_bulk_setting">                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_username" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_password" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_password'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bulk_status">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bulk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bulk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bulk_status'); ?></div>
                                                    </div>
                                                </div>                                 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.bulksms.com/" target="_blank"><img src="<?php echo IMG_URL; ?>bulk-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                           
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_edit_msg91_setting">                        
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="msg91_auth_key"><?php echo $this->lang->line('auth_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="msg91_auth_key" value="<?php echo isset($sms_setting) ? $sms_setting->msg91_auth_key : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('msg91_auth_key'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="msg91_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="msg91_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->msg91_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('msg91_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="msg91_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="msg91_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->msg91_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->msg91_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('msg91_status'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://msg91.com/" target="_blank"><img src="<?php echo IMG_URL; ?>msg91-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                                
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_edit_plivo_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_auth_id"><?php echo $this->lang->line('auth_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="plivo_auth_id" value="<?php echo isset($sms_setting) ? $sms_setting->plivo_auth_id : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('plivo_auth_id'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_auth_token"><?php echo $this->lang->line('auth_token'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="plivo_auth_token" value="<?php echo isset($sms_setting) ? $sms_setting->plivo_auth_token : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_token'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('plivo_auth_token'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_from_number"><?php echo $this->lang->line('from_number'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="plivo_from_number" value="<?php echo isset($sms_setting) ? $sms_setting->plivo_from_number : ''; ?>"  placeholder="<?php echo $this->lang->line('from_number'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('plivo_from_number'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plivo_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="plivo_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->plivo_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->plivo_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('plivo_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.plivo.com/" target="_blank"><img src="<?php echo IMG_URL; ?>plivo-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                         
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_edit_textlocal_setting">                         
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="textlocal_username" value="<?php echo isset($sms_setting) ? $sms_setting->textlocal_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('textlocal_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_hash_key"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="textlocal_hash_key" value="<?php echo isset($sms_setting) ? $sms_setting->textlocal_hash_key : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('textlocal_hash_key'); ?></div>
                                                    </div>
                                                </div>                                   
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="textlocal_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->textlocal_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('textlocal_sender_id'); ?></div>
                                                    </div>
                                                </div>  
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textlocal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="textlocal_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->textlocal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->textlocal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('textlocal_status'); ?></div>
                                                    </div>
                                                </div>                          
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.textlocal.com/" target="_blank"><img src="<?php echo IMG_URL; ?>textlocal-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                                
                                            </div> 

                                            <div class="tab-pane fade in " id="tab_edit_smscountry_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="smscountry_username" value="<?php echo isset($sms_setting) ? $sms_setting->smscountry_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('smscountry_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="smscountry_password" value="<?php echo isset($sms_setting) ? $sms_setting->smscountry_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('smscountry_password'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="smscountry_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->smscountry_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('smscountry_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smscountry_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="smscountry_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->smscountry_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->smscountry_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('smscountry_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.smscountry.com/" target="_blank"><img src="<?php echo IMG_URL; ?>country-sms.png" alt="" /></a> 
                                                    </div>
                                                </div>                                
                                            </div>                                             
                                            
                                            <div class="tab-pane fade in " id="tab_edit_betasms_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="betasms_username" value="<?php echo isset($sms_setting) ? $sms_setting->betasms_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('betasms_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="betasms_password" value="<?php echo isset($sms_setting) ? $sms_setting->betasms_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('betasms_password'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="betasms_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->betasms_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('betasms_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="betasms_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="betasms_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->betasms_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->betasms_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('betasms_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://betasms.com/betasms-api/" target="_blank"><img src="<?php echo IMG_URL; ?>beta-sms.png" alt="" /></a> 
                                                        <div class="instructions">Nigeria & West African SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                            
                                            <div class="tab-pane fade in " id="tab_edit_bulkpk_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_pk_username" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_pk_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_pk_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_pk_password" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_pk_password : ''; ?>"  placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_pk_password'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bulk_pk_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->bulk_pk_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bulk_pk_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulk_pk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bulk_pk_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bulk_pk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bulk_pk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bulk_pk_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="http://bulksms.com.pk" target="_blank"><img src="<?php echo IMG_URL; ?>bulk-pk-sms.png" alt="" /></a> 
                                                        <div class="instructions">Pakistani SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                        
                                            <div class="tab-pane fade in " id="tab_edit_cluster_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_auth_key"><?php echo $this->lang->line('auth_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="cluster_auth_key" value="<?php echo isset($sms_setting) ? $sms_setting->cluster_auth_key : ''; ?>"  placeholder="<?php echo $this->lang->line('auth_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('cluster_auth_key'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_router"><?php echo $this->lang->line('router'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="cluster_router" value="<?php echo isset($sms_setting) ? $sms_setting->cluster_router : ''; ?>"  placeholder="<?php echo $this->lang->line('router'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('cluster_router'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="cluster_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->cluster_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('cluster_sender_id'); ?></div>
                                                    </div>
                                                </div> 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cluster_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="cluster_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->cluster_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->cluster_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('cluster_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="http://www.smscluster.com" target="_blank"><img src="<?php echo IMG_URL; ?>cluster-sms.png" alt="" /></a> 
                                                        <div class="instructions">Pakistani SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                        
                                            <div class="tab-pane fade in " id="tab_edit_alpha_setting">    
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="alpha_username" value="<?php echo isset($sms_setting) ? $sms_setting->alpha_username : ''; ?>"  placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('alpha_username'); ?></div>
                                                    </div>
                                                </div>                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_hash"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="alpha_hash" value="<?php echo isset($sms_setting) ? $sms_setting->alpha_hash : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('alpha_hash'); ?></div>
                                                    </div>
                                                </div>                                
                                                                                                 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_type"><?php echo $this->lang->line('sms_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="alpha_type" required="required">
                                                            <option value="text" <?php if(isset($sms_setting) && $sms_setting->alpha_type == 'text'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('text'); ?></option>
                                                            <option value="unicode" <?php if(isset($sms_setting) && $sms_setting->alpha_type == 'unicode'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('unicode'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('alpha_type'); ?></div>
                                                    </div>
                                                </div>   
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alpha_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="alpha_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->alpha_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->alpha_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('alpha_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://alpha.net.bd/" target="_blank"><img src="<?php echo IMG_URL; ?>alpha-sms.png" alt="" /></a> 
                                                        <div class="instructions">Bangladeshi SMS Gateway</div>
                                                    </div>
                                                </div>            
                                            </div>
                                                                                        
                                            <div class="tab-pane fade in " id="tab_edit_bdbulk_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_hash"><?php echo $this->lang->line('hash_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="bdbulk_hash" value="<?php echo isset($sms_setting) ? $sms_setting->bdbulk_hash : ''; ?>"  placeholder="<?php echo $this->lang->line('hash_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('bdbulk_hash'); ?></div>
                                                    </div>
                                                </div>                                
                                                                                                 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_type"><?php echo $this->lang->line('sms_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bdbulk_type" required="required">
                                                            <option value="text" <?php if(isset($sms_setting) && $sms_setting->bdbulk_type == 'text'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('text'); ?></option>
                                                            <option value="unicode" <?php if(isset($sms_setting) && $sms_setting->bdbulk_type == 'unicode'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('unicode'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bdbulk_type'); ?></div>
                                                    </div>
                                                </div>   
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bdbulk_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="bdbulk_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->bdbulk_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->bdbulk_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('bdbulk_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://bdbulksms.net" target="_blank"><img src="<?php echo IMG_URL; ?>bdbulk-sms.gif" alt="" /></a> 
                                                        <div class="instructions">Bangladeshi SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                                                                        
                                            <div class="tab-pane fade in " id="tab_edit_mimsms_setting">                            
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_api_key"><?php echo $this->lang->line('api_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="mim_api_key" value="<?php echo isset($sms_setting) ? $sms_setting->mim_api_key : ''; ?>"  placeholder="<?php echo $this->lang->line('api_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('mim_api_key'); ?></div>
                                                    </div>
                                                </div>  
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_sender_id"><?php echo $this->lang->line('sender_id'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="mim_sender_id" value="<?php echo isset($sms_setting) ? $sms_setting->mim_sender_id : ''; ?>"  placeholder="<?php echo $this->lang->line('sender_id'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('mim_sender_id'); ?></div>
                                                    </div>
                                                </div>                                
                                                                                                 
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_type"><?php echo $this->lang->line('sms_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="mim_type" required="required">
                                                            <option value="text" <?php if(isset($sms_setting) && $sms_setting->mim_type == 'text'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('text'); ?></option>
                                                            <option value="unicode" <?php if(isset($sms_setting) && $sms_setting->mim_type == 'unicode'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('unicode'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('mim_type'); ?></div>
                                                    </div>
                                                </div>   
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mim_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="mim_status" required="required">
                                                            <option value="0" <?php if(isset($sms_setting) && $sms_setting->mim_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($sms_setting) && $sms_setting->mim_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('mim_status'); ?></div>
                                                    </div>
                                                </div>                          
                                               <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.mimsms.com/" target="_blank"><img src="<?php echo IMG_URL; ?>mim-sms.png" alt="" /></a> 
                                                        <div class="instructions">Bangladeshi SMS Gateway</div>
                                                    </div>
                                                </div>                                
                                            </div> 
                                            
                                        </div>                                    
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                
                                 <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <input type="hidden" value="<?php echo isset($sms_setting) ? $sms_setting->id : '' ?>" name="id" />
                                                <a href="<?php echo site_url('administrator/sms/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                <button id="send" type="submit" class="btn btn-success"><?php  echo $this->lang->line('update'); ?></button>
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


<div class="modal fade bs-sms-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('sms_setting'); ?></h4>
        </div>
        <div class="modal-body fn_sms_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_sms_modal(sms_id){
         
        $('.fn_sms_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loader.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('administrator/sms/get_single_sms'); ?>",
          data   : {sms_id : sms_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_sms_data').html(response);
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