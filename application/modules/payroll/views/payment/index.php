<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-dollar"></i><small> <?php echo $this->lang->line('manage_payment'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
           <div class="x_content quick-link">
                <?php $this->load->view('quick-link'); ?> 
            </div>
            
            <div class="x_content"> 
                <?php echo form_open_multipart(site_url('payroll/payment/index'), array('name' => 'payment', 'id' => 'payment', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                  
                    <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('user_type'); ?> <span class="required"> *</span></div>
                            <select  class="form-control col-md-7 col-xs-12"  name="payment_to"  id="payment_to" required="required" onchange="get_user_list(this.value);">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                <option value="employee" <?php if(isset($payment_to) && $payment_to == 'employee'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('employee'); ?></option>
                                <option value="teacher" <?php if(isset($payment_to) && $payment_to == 'teacher'){ echo 'selected="selected"'; } ?>><?php echo $this->lang->line('teacher'); ?></option>
                            </select>
                            <div class="help-block"><?php echo form_error('type'); ?></div>
                        </div>
                    </div>  
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('payment_to'); ?> <span class="required"> *</span></div>
                            <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="user_id"  required="required" >
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                            </select>
                            <div class="help-block"><?php echo form_error('user_id'); ?></div>
                        </div>
                    </div> 
                
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_payment_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(isset($payment)){ ?>
                            <?php if(has_permission(ADD, 'payroll', 'payment')){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_payment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                            <?php } ?> 
                        <?php } ?> 
                       <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_payment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>                           
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_payment_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('photo'); ?></th>                                                                    
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('month'); ?></th>
                                        <th><?php echo $this->lang->line('grade_name'); ?></th>
                                        <th><?php echo $this->lang->line('salary_type'); ?></th>
                                        <th><?php echo $this->lang->line('total_allowance'); ?></th>
                                        <th><?php echo $this->lang->line('total_deduction'); ?></th>
                                        <th><?php echo $this->lang->line('gross_salary'); ?></th>
                                        <th><?php echo $this->lang->line('net_salary'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($payments) && !empty($payments)){ ?>
                                        <?php foreach($payments as $obj){ ?>
                                        <?php
                                        $path = '';
                                        if($payment_to == 'teacher'){ $path = 'teacher'; }                                           
                                        else{ $path = 'employee'; }
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td>
                                                  <?php if ($obj->photo != '') { ?>                                        
                                                      <img src="<?php echo UPLOAD_PATH; ?>/<?php echo $path; ?>-photo/<?php echo $obj->photo; ?>" alt="" width="60" /> 
                                                  <?php } else { ?>
                                                      <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="60" /> 
                                                  <?php } ?>
                                            </td>
                                            <td><?php echo ucfirst($obj->name); ?></td>
                                            <td><?php echo date('M, Y', strtotime('1-'.$obj->salary_month)); ?></td>
                                            <td><?php echo $obj->grade_name; ?></td>
                                            <td><?php echo $obj->salary_type; ?></td>
                                            <td><?php echo $obj->total_allowance; ?></td>
                                            <td><?php echo $obj->total_deduction; ?></td>
                                            <td><?php echo $obj->gross_salary; ?></td>
                                            <td><?php echo $obj->net_salary; ?></td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'payroll', 'payment')){ ?>
                                                    <a href="<?php echo site_url('payroll/payment/edit/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(VIEW, 'payroll', 'payment')){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-success btn-xs" onclick="getPaymentModal(<?php echo $obj->id; ?>,'<?php echo $payment_to; ?>');"  data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'payroll', 'payment')){ ?>
                                                    <a href="<?php echo site_url('payroll/payment/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        
                        <?php if(isset($payment)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_payment">
                                <div class="x_content"> 
                                   <?php echo form_open(site_url('payroll/payment/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                    
                                          
                                    <div class="row">                                        
                                        
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="grade_name"><?php echo $this->lang->line('grade_name'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="grade_name"  id="add_grade_name" value="<?php echo $payment->grade_name; ?>" placeholder="<?php echo $this->lang->line('grade_name'); ?>" required="required" readonly="readonly" type="text" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('grade_name'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="salary_type"><?php echo $this->lang->line('salary_type'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="salary_type"  id="add_salary_type" value="<?php echo $this->lang->line($payment->salary_type); ?>" placeholder="<?php echo $this->lang->line('salary_type'); ?>" required="required" readonly="readonly" type="text" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('salary_type'); ?></div>
                                            </div>
                                        </div>
                                        <?php if($payment->salary_type == 'monthly'){ ?>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="basic_salary"><?php echo $this->lang->line('basic_salary'); ?> <span class="required">*</span></label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="basic_salary"  id="add_basic_salary" value="<?php echo $payment->basic_salary; ?>" placeholder="<?php echo $this->lang->line('basic_salary'); ?>" required="required" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('basic_salary'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="house_rent"><?php echo $this->lang->line('house_rent'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="house_rent"  id="add_house_rent" value="<?php echo $payment->house_rent; ?>" placeholder="<?php echo $this->lang->line('house_rent'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('house_rent'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="transport"><?php echo $this->lang->line('transport_allowance'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="transport"  id="add_transport" value="<?php echo $payment->transport; ?>" placeholder="<?php echo $this->lang->line('transport_allowance'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('transport'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="medical"><?php echo $this->lang->line('medical_allowance'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="medical"  id="add_medical" value="<?php echo $payment->medical; ?>" placeholder="<?php echo $this->lang->line('medical_allowance'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('medical'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="over_time_hourly_rate"><?php echo $this->lang->line('over_time_hourly_rate'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="over_time_hourly_rate"  id="add_over_time_hourly_rate" value="<?php echo $payment->over_time_hourly_rate; ?>" placeholder="<?php echo $this->lang->line('over_time_hourly_rate'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('over_time_hourly_rate'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="over_time_total_hour"><?php echo $this->lang->line('over_time_total_hour'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="over_time_total_hour"  id="add_over_time_total_hour" value="" placeholder="<?php echo $this->lang->line('over_time_total_hour'); ?>" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('over_time_total_hour'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="over_time_amount"><?php echo $this->lang->line('over_time_amount'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="over_time_amount"  id="add_over_time_amount" value="" placeholder="<?php echo $this->lang->line('over_time_amount'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('over_time_amount'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="provident_fund"><?php echo $this->lang->line('provident_fund'); ?> </label>
                                                    <input  class="form-control col-md-7 col-xs-12 "  name="provident_fund"  id="add_provident_fund" value="<?php echo $payment->provident_fund; ?>" placeholder="<?php echo $this->lang->line('provident_fund'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('provident_fund'); ?></div>
                                                </div>
                                            </div>
                                        <?php }else{ ?> 
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="hourly_rate"><?php echo $this->lang->line('hourly_rate'); ?> <span class="required">*</span></label>
                                                    <input  class="form-control col-md-7 col-xs-12"  name="hourly_rate"  id="add_hourly_rate" value="<?php echo $payment->hourly_rate; ?>" placeholder="<?php echo $this->lang->line('hourly_rate'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('hourly_rate'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="item form-group">
                                                    <label for="total_hour"><?php echo $this->lang->line('total_hour'); ?> <span class="required">*</span></label>
                                                    <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="total_hour"  id="add_total_hour" value="" placeholder="<?php echo $this->lang->line('total_hour'); ?>" required="required" type="number" autocomplete="off">
                                                    <div class="help-block"><?php echo form_error('total_hour'); ?></div>
                                                </div>
                                            </div>
                                        <?php } ?> 
                                        
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="bonus"><?php echo $this->lang->line('bonus'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="bonus"  id="add_bonus" value="" placeholder="<?php echo $this->lang->line('bonus'); ?>"  type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('bonus'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="penalty"><?php echo $this->lang->line('penalty'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="penalty"  id="add_penalty" value="" placeholder="<?php echo $this->lang->line('penalty'); ?>" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('penalty'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="total_allowance"><?php echo $this->lang->line('total_allowance'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12 "  name="total_allowance"  id="add_total_allowance" value="<?php echo $payment->salary_type == 'monthly' ? $payment->total_allowance : ''; ?>" placeholder="<?php echo $this->lang->line('total_allowance'); ?>" type="number" readonly="readonly" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('total_allowance'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="total_deduction"><?php echo $this->lang->line('total_deduction'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12 "  name="total_deduction"  id="add_total_deduction" value="<?php echo $payment->salary_type == 'monthly' ? $payment->total_deduction : ''; ?>" placeholder="<?php echo $this->lang->line('total_deduction'); ?>" type="number" readonly="readonly" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('total_deduction'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gross_salary"><?php echo $this->lang->line('gross_salary'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12 "  name="gross_salary"  id="add_gross_salary" value="<?php echo $payment->salary_type == 'monthly' ? $payment->gross_salary : ''; ?>" placeholder="<?php echo $this->lang->line('gross_salary'); ?>" type="number" readonly="readonly" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('gross_salary'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="net_salary"><?php echo $this->lang->line('net_salary'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12 "  name="net_salary"  id="add_net_salary" value="<?php echo $payment->salary_type == 'monthly' ? $payment->net_salary : ''; ?>" placeholder="<?php echo $this->lang->line('net_salary'); ?>" type="number" readonly="readonly" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('net_salary'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="salary_month"><?php echo $this->lang->line('month'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12 "  name="salary_month"  id="add_salary_month" value="" placeholder="<?php echo $this->lang->line('month'); ?>" required="required" type="text" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('salary_month'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="payment_method"><?php echo $this->lang->line('payment_method'); ?> <span class="required">*</span></label>
                                                <select  class="form-control col-md-7 col-xs-12" name="payment_method"  id="payment_method" required="required" onchange="check_payment_method(this.value);" >
                                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                    <?php $payments = get_payment_methods(); ?>
                                                    <?php foreach($payments as $key=>$value ){ ?>                                           
                                                        <?php if(in_array($key, array('cash', 'cheque'))){ ?>
                                                            <option value="<?php echo $key; ?>" <?php if(isset($post) && $post['payment_method'] == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                        <?php } ?>                                           
                                                    <?php } ?>                                            
                                                </select>
                                                <div class="help-block"><?php echo form_error('payment_method'); ?></div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row display fn_cheque">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="bank_name"><?php echo $this->lang->line('bank_name'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="bank_name"  id="bank_name" value="" placeholder="<?php echo $this->lang->line('bank_name'); ?>"  type="text" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('bank_name'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="cheque_no"><?php echo $this->lang->line('cheque_number'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="cheque_no"  id="cheque_no" value="" placeholder="<?php echo $this->lang->line('cheque_number'); ?>"  type="text" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('cheque_no'); ?></div>
                                            </div>
                                        </div>
                                    </div>                                    
                                   
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="expenditure_head_id"><?php echo $this->lang->line('expenditure_head'); ?> <span class="required">*</span></label>
                                                <select  class="form-control col-md-7 col-xs-12" name="expenditure_head_id"  id="expenditure_head_id" required="required" >
                                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                    <?php foreach($exp_heads as $obj ){ ?>                                           
                                                         <option value="<?php echo $obj->id; ?>" <?php if(isset($post) && $post['expenditure_head_id'] == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                                    <?php } ?>                                            
                                                </select>
                                                <div class="help-block"><?php echo form_error('expenditure_head_id'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item form-group">
                                                <label for="note"><?php echo $this->lang->line('note'); ?></label>
                                                <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"></textarea>
                                                <div class="help-block"><?php echo form_error('note'); ?></div>
                                            </div>
                                        </div>
                                    </div>   
                                    
                                    
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" id="add_school_id" name="school_id" value="<?php echo $school_id; ?>" />
                                            <input type="hidden" id="add_payment_to" name="payment_to" value="<?php echo $payment_to; ?>" />
                                            <input type="hidden" id="add_user_id" name="user_id" value="<?php echo $user_id; ?>" />
                                            <input type="hidden" id="add_salary_grade_id" name="salary_grade_id" value="<?php echo $payment->salary_grade_id; ?>" />
                                            <input type="hidden" id="add_hidden_salary_type" value="<?php echo strtolower($payment->salary_type); ?>" />
                                            <a href="<?php echo site_url('payroll/payment/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>  
                        <?php } ?>
                        
                        <?php if(isset($edit)){ ?>
                        
                        <div class="tab-pane fade in active" id="tab_edit_payment">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('payroll/payment/edit/'.$edit_payment->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                 
                                     <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="grade_name"><?php echo $this->lang->line('grade_name'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="grade_name"  id="edit_grade_name" value="<?php echo $edit_payment->grade_name; ?>" placeholder="<?php echo $this->lang->line('grade_name'); ?>" required="required" readonly="readonly" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('grade_name'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="salary_type"><?php echo $this->lang->line('salary_type'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="salary_type"  id="edit_salary_type" value="<?php echo $this->lang->line(strtolower($edit_payment->salary_type)); ?>" placeholder="<?php echo $this->lang->line('salary_type'); ?>" required="required" readonly="readonly" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('salary_type'); ?></div>
                                        </div>
                                    </div>
                                    <?php if($payment->salary_type == 'monthly'){ ?>
                                        
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="basic_salary"><?php echo $this->lang->line('basic_salary'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="basic_salary"  id="edit_basic_salary" value="<?php echo $edit_payment->basic_salary; ?>" placeholder="<?php echo $this->lang->line('basic_salary'); ?>" required="required" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('basic_salary'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="house_rent"><?php echo $this->lang->line('house_rent'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="house_rent"  id="edit_house_rent" value="<?php echo $edit_payment->house_rent; ?>" placeholder="<?php echo $this->lang->line('house_rent'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('house_rent'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="transport"><?php echo $this->lang->line('transport_allowance'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="transport"  id="edit_transport" value="<?php echo $edit_payment->transport; ?>" placeholder="<?php echo $this->lang->line('transport_allowance'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('transport'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="medical"><?php echo $this->lang->line('medical_allowance'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="medical"  id="edit_medical" value="<?php echo $edit_payment->medical; ?>" placeholder="<?php echo $this->lang->line('medical_allowance'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('medical'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="over_time_hourly_rate"><?php echo $this->lang->line('over_time_hourly_rate'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="over_time_hourly_rate"  id="edit_over_time_hourly_rate" value="<?php echo $edit_payment->over_time_hourly_rate; ?>" placeholder="<?php echo $this->lang->line('over_time_hourly_rate'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('over_time_hourly_rate'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="over_time_total_hour"><?php echo $this->lang->line('over_time_total_hour'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="over_time_total_hour"  id="edit_over_time_total_hour" value="<?php echo $edit_payment->over_time_total_hour; ?>" placeholder="<?php echo $this->lang->line('over_time_total_hour'); ?>" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('over_time_total_hour'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="over_time_amount"><?php echo $this->lang->line('over_time_amount'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="over_time_amount"  id="edit_over_time_amount" value="<?php echo $edit_payment->over_time_amount; ?>" placeholder="<?php echo $this->lang->line('over_time_amount'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('over_time_amount'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="provident_fund"><?php echo $this->lang->line('provident_fund'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12 "  name="provident_fund"  id="edit_provident_fund" value="<?php echo $edit_payment->provident_fund; ?>" placeholder="<?php echo $this->lang->line('provident_fund'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('provident_fund'); ?></div>
                                            </div>
                                        </div>
                                    
                                    <?php }else{ ?>  
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="hourly_rate"><?php echo $this->lang->line('hourly_rate'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="hourly_rate"  id="edit_hourly_rate" value="<?php echo $edit_payment->hourly_rate; ?>" placeholder="<?php echo $this->lang->line('hourly_rate'); ?>" readonly="readonly" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('hourly_rate'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="total_hour"><?php echo $this->lang->line('total_hour'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="total_hour"  id="edit_total_hour" value="<?php echo $edit_payment->total_hour; ?>" placeholder="<?php echo $this->lang->line('total_hour'); ?>" required="required" type="number" autocomplete="off">
                                                <div class="help-block"><?php echo form_error('total_hour'); ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>  
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="bonus"><?php echo $this->lang->line('bonus'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="bonus"  id="edit_bonus" value="<?php echo $edit_payment->bonus; ?>" placeholder="<?php echo $this->lang->line('bonus'); ?>"  type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('bonus'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="penalty"><?php echo $this->lang->line('penalty'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="penalty"  id="edit_penalty" value="<?php echo $edit_payment->penalty; ?>" placeholder="<?php echo $this->lang->line('penalty'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('penalty'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="total_allowance"><?php echo $this->lang->line('total_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 "  name="total_allowance"  id="edit_total_allowance" value="<?php echo $edit_payment->total_allowance; ?>" placeholder="<?php echo $this->lang->line('total_allowance'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('total_allowance'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="total_deduction"><?php echo $this->lang->line('total_deduction'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 "  name="total_deduction"  id="edit_total_deduction" value="<?php echo $edit_payment->total_deduction; ?>" placeholder="<?php echo $this->lang->line('total_deduction'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('total_deduction'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="gross_salary"><?php echo $this->lang->line('gross_salary'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 "  name="gross_salary"  id="edit_gross_salary" value="<?php echo $edit_payment->gross_salary; ?>" placeholder="<?php echo $this->lang->line('gross_salary'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('gross_salary'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="net_salary"><?php echo $this->lang->line('net_salary'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 "  name="net_salary"  id="edit_net_salary" value="<?php echo $edit_payment->net_salary; ?>" placeholder="<?php echo $this->lang->line('net_salary'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('net_salary'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="salary_month"><?php echo $this->lang->line('month'); ?> <span class="required">*</span> </label>
                                            <input  class="form-control col-md-7 col-xs-12 "  name="salary_month"  id="edit_salary_month" value="<?php echo $edit_payment->salary_month; ?>" placeholder="<?php echo $this->lang->line('month'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('salary_month'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="payment_method"><?php echo $this->lang->line('payment_method'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12" name="payment_method"  id="edit_payment_method" required="required" onchange="check_payment_method(this.value);">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php $payments = get_payment_methods(); ?>
                                            <?php foreach($payments as $key=>$value ){ ?>                                           
                                                <?php if(in_array($key, array('cash', 'cheque'))){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if(isset($edit_payment) && $edit_payment->payment_method == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>                                           
                                            <?php } ?>                                            
                                            </select>
                                            <div class="help-block"><?php echo form_error('payment_method'); ?></div>
                                        </div>
                                    </div>
                                </div>
                 
                                <div class="row fn_cheque <?php if(isset($edit_payment) && $edit_payment->payment_method == 'cash'){ echo 'display'; } ?>">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="bank_name"><?php echo $this->lang->line('bank_name'); ?> <span class="required">*</span> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="bank_name"  id="edit_bank_name" value="<?php echo $edit_payment->bank_name; ?>" placeholder="<?php echo $this->lang->line('bank_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('bank_name'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="cheque_no"><?php echo $this->lang->line('cheque_number'); ?> <span class="required">*</span> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="cheque_no"  id="edit_cheque_no" value="<?php echo $edit_payment->cheque_no; ?>" placeholder="<?php echo $this->lang->line('cheque_number'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('cheque_no'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                 
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="expenditure_head_id"><?php echo $this->lang->line('expenditure_head'); ?> <span class="required">*</span> </label>
                                            <select  class="form-control col-md-7 col-xs-12" name="expenditure_head_id"  id="edit_expenditure_head_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                <?php foreach($exp_heads as $obj ){ ?>                                           
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($expenditure) && $expenditure->expenditure_head_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                                <?php } ?>                                            
                                            </select>
                                            <div class="help-block"><?php echo form_error('expenditure_head_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                            <label for="note"><?php echo $this->lang->line('note'); ?> </label>
                                            <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="edit_note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo $edit_payment->note ?></textarea>
                                            <div class="help-block"><?php echo form_error('note'); ?></div>
                                        </div>
                                    </div>
                                </div> 

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" id="edit_school_id" name="school_id" value="<?php echo $school_id; ?>" />
                                            <input type="hidden" id="edit_payment_to" name="payment_to" value="<?php echo $payment_to; ?>" />
                                            <input type="hidden" id="edit_user_id" name="user_id" value="<?php echo $user_id; ?>" />
                                            <input type="hidden" id="edit_salary_grade_id" name="salary_grade_id" value="<?php echo $edit_payment->salary_grade_id; ?>" />
                                            <input type="hidden" id="edit_id" name="id" value="<?php echo $edit_payment->id; ?>" />
                                            <input type="hidden" id="edit_expenditure_id" name="expenditure_id" value="<?php echo $edit_payment->expenditure_id; ?>" />
                                            <input type="hidden" id="edit_hidden_salary_type" value="<?php echo strtolower($edit_payment->salary_type); ?>" />
                                            <a href="<?php echo site_url('payroll/payment/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('detail_payment'); ?></h4>
        </div>
        <div class="modal-body">
            
        </div>       
      </div>
    </div>
</div>

  <!-- bootstrap-datetimepicker -->
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
     
     
    function getPaymentModal(payment_id, payment_to){
         
         $('.modal-body').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
          $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('payroll/payment/get_single_payment'); ?>",
            data   : {payment_id : payment_id, payment_to :payment_to},  
            success: function(response){                                                   
               if(response)
               {
                  $('.modal-body').html(response);
               }
            }
         });
    }
</script>
 
<!-- datatable with buttons -->
 <script type="text/javascript">
    
       
    $("#add_salary_month").datepicker( {
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });
    $("#edit_salary_month").datepicker( {
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });
     
       
    
    $("#add").validate();     
    $("#edit").validate();   
    $('#payment').validate();
    
    
    $('.fn_add_claculate').on('keyup', function(){
        
        var type = $('#add_hidden_salary_type').val();
       
        if(type === 'monthly'){
           
            var basic_salary = $('#add_basic_salary').val() ? parseFloat($('#add_basic_salary').val()) : 0;
            var house_rent = $('#add_house_rent').val() ? parseFloat($('#add_house_rent').val()) : 0;
            var transport = $('#add_transport').val() ? parseFloat($('#add_transport').val()): 0;
            var medical = $('#add_medical').val() ? parseFloat($('#add_medical').val()) : 0;
            var bonus = $('#add_bonus').val() ? parseFloat($('#add_bonus').val()) : 0;
            
            var ot_hourly_rate = $('#add_over_time_hourly_rate').val() ? parseFloat($('#add_over_time_hourly_rate').val()) : 0;
            var ot_total_hour = $('#add_over_time_total_hour').val() ? parseFloat($('#add_over_time_total_hour').val()) : 0;
            $('#add_over_time_amount').val(ot_hourly_rate*ot_total_hour);       
            var ot_total_amount = $('#add_over_time_amount').val() ? parseFloat($('#add_over_time_amount').val()) : 0;
            
            
            var provident_fund = $('#add_provident_fund').val() ? parseFloat($('#add_provident_fund').val()) : 0;
            var penalty = $('#add_penalty').val() ? parseFloat($('#add_penalty').val()) : 0;

           $('#add_total_allowance').val(house_rent+transport+medical+bonus+ot_total_amount);       
            var total_allowance = $('#add_total_allowance').val() ? parseFloat($('#add_total_allowance').val()) : 0;

            $('#add_total_deduction').val(provident_fund+penalty);
            var total_deduction = $('#add_total_deduction').val() ? parseFloat($('#add_total_deduction').val()) : 0;

            $('#add_gross_salary').val(basic_salary+total_allowance);
            $('#add_net_salary').val((basic_salary+total_allowance)-total_deduction);
            
       }else{
           
            var hourly_rate = $('#add_hourly_rate').val() ? parseFloat($('#add_hourly_rate').val()) : 0;
            var total_hour = $('#add_total_hour').val() ? parseFloat($('#add_total_hour').val()) : 0;
          
            var bonus = $('#add_bonus').val() ? parseFloat($('#add_bonus').val()) : 0;
            var penalty = $('#add_penalty').val() ? parseFloat($('#add_penalty').val()) : 0;
            
            $('#add_total_allowance').val(bonus);       
            var total_allowance = $('#add_total_allowance').val() ? parseFloat($('#add_total_allowance').val()) : 0;

            $('#add_total_deduction').val(penalty);
            var total_deduction = $('#add_total_deduction').val() ? parseFloat($('#add_total_deduction').val()) : 0;

            $('#add_gross_salary').val((hourly_rate*total_hour)+total_allowance);
            $('#add_net_salary').val((hourly_rate*total_hour)+total_allowance-total_deduction);
       }
        
    });
    
    $('.fn_edit_claculate').on('keyup', function(){
        
        var type = $('#edit_hidden_salary_type').val();
       
        if(type === 'monthly'){
           
            var basic_salary = $('#edit_basic_salary').val() ? parseFloat($('#edit_basic_salary').val()) : 0;
            var house_rent = $('#edit_house_rent').val() ? parseFloat($('#edit_house_rent').val()) : 0;
            var transport = $('#edit_transport').val() ? parseFloat($('#edit_transport').val()): 0;
            var medical = $('#edit_medical').val() ? parseFloat($('#edit_medical').val()) : 0;
            var bonus = $('#edit_bonus').val() ? parseFloat($('#edit_bonus').val()) : 0;
            
            var ot_hourly_rate = $('#edit_over_time_hourly_rate').val() ? parseFloat($('#edit_over_time_hourly_rate').val()) : 0;
            var ot_total_hour = $('#edit_over_time_total_hour').val() ? parseFloat($('#edit_over_time_total_hour').val()) : 0;
            $('#edit_over_time_amount').val(ot_hourly_rate*ot_total_hour);       
            var ot_total_amount = $('#edit_over_time_amount').val() ? parseFloat($('#edit_over_time_amount').val()) : 0;
            
            
            var provident_fund = $('#edit_provident_fund').val() ? parseFloat($('#edit_provident_fund').val()) : 0;
            var penalty = $('#edit_penalty').val() ? parseFloat($('#edit_penalty').val()) : 0;

           $('#edit_total_allowance').val(house_rent+transport+medical+bonus+ot_total_amount);       
            var total_allowance = $('#edit_total_allowance').val() ? parseFloat($('#edit_total_allowance').val()) : 0;

            $('#edit_total_deduction').val(provident_fund+penalty);
            var total_deduction = $('#edit_total_deduction').val() ? parseFloat($('#edit_total_deduction').val()) : 0;

            $('#edit_gross_salary').val(basic_salary+total_allowance);
            $('#edit_net_salary').val((basic_salary+total_allowance)-total_deduction);
            
       }else{
           
            var hourly_rate = $('#edit_hourly_rate').val() ? parseFloat($('#edit_hourly_rate').val()) : 0;
            var total_hour = $('#edit_total_hour').val() ? parseFloat($('#edit_total_hour').val()) : 0;
          
            var bonus = $('#edit_bonus').val() ? parseFloat($('#edit_bonus').val()) : 0;
            var penalty = $('#edit_penalty').val() ? parseFloat($('#edit_penalty').val()) : 0;
            
            $('#edit_total_allowance').val(bonus);       
            var total_allowance = $('#edit_total_allowance').val() ? parseFloat($('#edit_total_allowance').val()) : 0;

            $('#edit_total_deduction').val(penalty);
            var total_deduction = $('#edit_total_deduction').val() ? parseFloat($('#edit_total_deduction').val()) : 0;

            $('#edit_gross_salary').val((hourly_rate*total_hour)+total_allowance);
            $('#edit_net_salary').val((hourly_rate*total_hour)+total_allowance-total_deduction);
       }
        
    });
    
    function check_payment_method(payment_method) {

    if (payment_method == "cheque") {

           $('.fn_cheque').show();                
           $('#bank_name').prop('required', true);
           $('#cheque_no').prop('required', true);                

       }else{         

           $('.fn_cheque').hide();  
           $('#bank_name').prop('required', false);
           $('#cheque_no').prop('required', false);                
       } 
    }
    
    <?php if(isset($payment_to) && isset($user_id)){ ?>
        get_user_list('<?php echo $payment_to; ?>', <?php echo $user_id; ?>)
    <?php } ?>
    function get_user_list(payment_to, user_id){
        
        
       var school_id = $('#school_id').val(); 
       if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           $('#payment_to').prop('selectedIndex',0);
           return false;
        }
        
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_user_list_by_type'); ?>",
            data   : {school_id:school_id, payment_to : payment_to, user_id : user_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#user_id').html(response); 
               }
            }
        }); 
   }   
</script>