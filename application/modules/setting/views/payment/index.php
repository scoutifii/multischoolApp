<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-dollar"></i><small> <?php echo $this->lang->line('payment_setting'); ?></small></h3>
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
                      <li  class="<?php echo isset($mtnmomo) ? 'active':''; ?>"><a href="#tab_mtnmomo_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mtn_momo'); ?></a> </li>
                        
                        <li  class="<?php echo isset($airtelmoney) ? 'active':''; ?>"><a href="#tab_airtelmoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('airtel_money'); ?></a> </li> 

                        <li  class="<?php echo isset($paypal) ? 'active':''; ?>"><a href="#tab_paypal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?></a> </li>                          
                        <!--<li  class="<?php echo isset($stripe) ? 'active':''; ?>"><a href="#tab_stripe_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?></a> </li>-->                          
                        <li  class="<?php echo isset($payumoney) ? 'active':''; ?>"><a href="#tab_pumoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?></a> </li>                          
                        <!--<li  class="<?php echo isset($ccavenue) ? 'active':''; ?>"><a href="#tab_ccavenue_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?></a> </li> -->                          
                        <li  class="<?php echo isset($paytm) ? 'active':''; ?>"><a href="#tab_paytm_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?></a> </li>                          
                        <li  class="<?php echo isset($paystack) ? 'active':''; ?>"><a href="#tab_paystack_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?></a> </li>                 
                    </ul>
                    <br/>
                    <div class="tab-content">
               
                        <div class="tab-pane fade in <?php echo isset($paypal) ? 'active':''; ?>" id="tab_paypal_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/paypal'), array('name' => 'paypal', 'id' => 'paypal', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paypal" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <!--<div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_api_username">paypal_api_username <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_api_username" value="<?php echo isset($setting) ? $setting->paypal_api_username : ''; ?>"  placeholder="paypal_api_username" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('paypal_api_username'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_api_password">paypal_api_password <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_api_password" value="<?php echo isset($setting) ? $setting->paypal_api_password : ''; ?>"  placeholder="paypal_api_password" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('paypal_api_password'); ?></div>
                                    </div>
                                </div>                  
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_api_signature">paypal_api_signature <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_api_signature" value="<?php echo isset($setting) ? $setting->paypal_api_signature : ''; ?>"  placeholder="paypal_api_signature" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('paypal_api_signature'); ?></div>
                                    </div>
                                </div> -->                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_email"><?php echo $this->lang->line('paypal_email'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_email" value="<?php echo isset($setting) ? $setting->paypal_email : ''; ?>"  placeholder="<?php echo $this->lang->line('paypal_email'); ?>" required="required" type="email"  autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paypal_email'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paypal_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paypal_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paypal_demo'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_extra_charge" value="<?php echo isset($setting) ? $setting->paypal_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paypal_extra_charge'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paypal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paypal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paypal_status'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.paypal.com" target="_blank"><img src="<?php echo IMG_URL; ?>paypal-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                        
                        <div class="tab-pane fade in <?php echo isset($stripe) ? 'active':''; ?> display" id="tab_stripe_setting">
                           <div class="x_content"> 
                              <?php echo form_open_multipart(site_url('setting/payment/stripe'), array('name' => 'stripe', 'id' => 'stripe', 'class'=>'form-horizontal form-label-left'), ''); ?>
                              <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                              <input type="hidden" value="1" name="stripe" />
                              <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                              
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_secret"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_secret" value="<?php echo isset($setting) ? $setting->stripe_secret : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                      <div class="help-block"><?php echo form_error('stripe_secret'); ?></div>
                                  </div>
                              </div>                                               

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_demo" required="required">
                                          <option value="1" <?php if(isset($setting) && $setting->stripe_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                          <option value="0" <?php if(isset($setting) && $setting->stripe_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                      </select>
                                      <div class="help-block"><?php echo form_error('stripe_demo'); ?></div>
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_extra_charge"> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_extra_charge" value="<?php echo isset($setting) ? $setting->stripe_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                      <div class="help-block"><?php echo form_error('stripe_extra_charge'); ?></div>
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_status" required="required">
                                          <option value="1" <?php if(isset($setting) && $setting->stripe_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                          <option value="0" <?php if(isset($setting) && $setting->stripe_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                      </select>
                                      <div class="help-block"><?php echo form_error('stripe_status'); ?></div>
                                  </div>
                              </div>

                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <a href="https://stripe.com/" target="_blank"><img src="<?php echo IMG_URL; ?>stripe-setting.png" alt="" /></a> 
                                  </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-3">
                                      <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                      <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit') ?></button>
                                  </div>
                              </div>
                              <?php echo form_close(); ?>
                          </div>
                       </div> 

                        <div class="tab-pane fade in <?php echo isset($payumoney) ? 'active':''; ?>" id="tab_pumoney_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/payumoney'), array('name' => 'payumoney', 'id' => 'payumoney', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="payumoney" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_key"><?php echo $this->lang->line('payumoney_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_key" value="<?php echo isset($setting) ? $setting->payumoney_key : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payumoney_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_salt" value="<?php echo isset($setting) ? $setting->payumoney_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payumoney_salt'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->payumoney_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->payumoney_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('payumoney_demo'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payu_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="payu_extra_charge" value="<?php echo isset($setting) ? $setting->payu_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('payu_extra_charge'); ?></div>
                                    </div>
                                </div> 
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->payumoney_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->payumoney_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('payumoney_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.payumoney.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paym-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                        
                        <div class="tab-pane fade in <?php echo isset($ccavenue) ? 'active':''; ?> display" id="tab_ccavenue_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/ccavenue'), array('name' => 'ccavenue', 'id' => 'ccavenue', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="ccavenue" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" /> 
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_key"><?php echo $this->lang->line('ccavenue_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_key" value="<?php echo isset($setting) ? $setting->ccavenue_key : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ccavenue_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_salt"><?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_salt" value="<?php echo isset($setting) ? $setting->ccavenue_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ccavenue_salt'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ccavenue_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->ccavenue_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->ccavenue_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('ccavenue_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_extra_charge" value="<?php echo isset($setting) ? $setting->ccavenue_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('ccavenue_extra_charge'); ?></div>
                                    </div>
                                </div>
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="ccavenue_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->ccavenue_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->ccavenue_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('ccavenue_status'); ?></div>
                                    </div>
                                </div>
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://www.ccavenue.com/" target="_blank"><img src="<?php echo IMG_URL; ?>ccavenue-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                         
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                                                
                        <div class="tab-pane fade in <?php echo isset($paytm) ? 'active':''; ?>" id="tab_paytm_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/paytm'), array('name' => 'paytm', 'id' => 'paytm', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paytm" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_key"><?php echo $this->lang->line('merchant_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_key" value="<?php echo isset($setting) ? $setting->paytm_merchant_key : ''; ?>"  placeholder="<?php echo $this->lang->line('merchant_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_merchant_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_mid"><?php echo $this->lang->line('merchant_mid'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_mid" value="<?php echo isset($setting) ? $setting->paytm_merchant_mid : ''; ?>"  placeholder="<?php echo $this->lang->line('merchant_mid'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_merchant_mid'); ?></div>
                                    </div>
                                </div> 
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_website"><?php echo $this->lang->line('website'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_website" value="<?php echo isset($setting) ? $setting->paytm_merchant_website : ''; ?>"  placeholder="<?php echo $this->lang->line('website'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_merchant_website'); ?></div>
                                    </div>
                                </div>                  
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_industry_type"><?php echo $this->lang->line('industry_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_industry_type" value="<?php echo isset($setting) ? $setting->paytm_industry_type : ''; ?>"  placeholder="<?php echo $this->lang->line('industry_type'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_industry_type'); ?></div>
                                    </div>
                                </div>                  
                        
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paytm_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paytm_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paytm_demo'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_extra_charge" value="<?php echo isset($setting) ? $setting->paytm_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('paytm_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->paytm_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->paytm_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('paytm_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://paytm.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paytm-setting.png" alt="" /></a> 
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                                                 
                        <div class="tab-pane fade in <?php echo isset($paystack) ? 'active':''; ?>" id="tab_paystack_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/paystack'), array('name' => 'paystack', 'id' => 'paystack', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paystack" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_secret_key" value="<?php echo isset($setting) ? $setting->stack_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_public_key" value="<?php echo isset($setting) ? $setting->stack_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_demo" id="stack_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_extra_charge" id="stack_extra_charge" value="<?php echo isset($setting) ? $setting->stack_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://paystack.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paystack-setting.png" alt="" /></a> 
                                        <div class="instructions">Uganda Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 


                         <div class="tab-pane fade in <?php echo isset($mtnmomo) ? 'active':''; ?>" id="tab_mtnmomo_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/mtnmomo'), array('name' => 'paystack', 'id' => 'paystack', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paystack" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_secret_key" value="<?php echo isset($setting) ? $setting->stack_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_public_key" value="<?php echo isset($setting) ? $setting->stack_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_demo" id="stack_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_extra_charge" id="stack_extra_charge" value="<?php echo isset($setting) ? $setting->stack_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://paystack.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paystack-setting.png" alt="" /></a> 
                                        <div class="instructions">Uganda Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>



                        <div class="tab-pane fade in <?php echo isset($airtelmoney) ? 'active':''; ?>" id="tab_airtelmoney_setting">
                            <div class="x_content"> 
                                <?php echo form_open_multipart(site_url('setting/payment/airtelmoney'), array('name' => 'paystack', 'id' => 'paystack', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />
                                <input type="hidden" value="1" name="paystack" />
                                <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_secret_key" value="<?php echo isset($setting) ? $setting->stack_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_public_key" value="<?php echo isset($setting) ? $setting->stack_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_demo" id="stack_demo" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_extra_charge" id="stack_extra_charge" value="<?php echo isset($setting) ? $setting->stack_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                    </div>
                                </div>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_status" required="required">
                                            <option value="1" <?php if(isset($setting) && $setting->stack_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                            <option value="0" <?php if(isset($setting) && $setting->stack_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                        </select>
                                        <div class="help-block"><?php echo form_error('stack_status'); ?></div>
                                    </div>
                                </div>
                          
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="https://paystack.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paystack-setting.png" alt="" /></a> 
                                        <div class="instructions">Uganda Payment Gateway</div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo isset($setting) ? $this->lang->line('update') : $this->lang->line('submit'); ?></button>
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
<script type="text/javascript">
    $("#paypal").validate();  
    $("#stripe").validate();  
    $("#payumoney").validate();  
    $("#ccavenue").validate();  
    $("#paytm").validate();  
    $("#paystack").validate();
    $("#mtnmomo").validate();
    $("#airtelmoney").validate();  
</script>