<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> <?php echo $this->lang->line('manage_invoice'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
           
            <div class="x_content quick-link no-print">
                <?php $this->load->view('quick-link'); ?>  
            </div>
            
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered no-print">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_invoice_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        
                        <li  class="<?php if(isset($single)){ echo 'active'; }?>"><a href="<?php echo site_url('accounting/invoice/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('create_invoice'); ?></a> </li>                          
                        <li  class="<?php if(isset($bulk)){ echo 'active'; }?>"><a href="<?php echo site_url('accounting/invoice/bulk'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('create_bulk_invoice'); ?></a> </li>                          
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_invoice"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>   
                            
                        <li class="li-class-list">
                        <?php echo form_open(site_url('accounting/invoice/index'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>     
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                 <select  class="form-control col-md-7 col-xs-12" name="school_id" onchange="this.form.submit();">
                                         <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                     <?php foreach($schools as $obj ){ ?>
                                         <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                     <?php } ?>   
                                 </select>
                             <?php } ?> 
                        <?php echo form_close(); ?>     
                        </li>      
                            
                    </ul>
                    <br/>                    
                    
                    <div class="tab-content  no-print">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>  no-print" id="tab_invoice_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('invoice_number'); ?></th>
                                        <th><?php echo $this->lang->line('student'); ?>/<?php echo $this->lang->line('sale_to'); ?></th>
                                        <th><?php echo $this->lang->line('gross_amount'); ?></th>
                                        <th><?php echo $this->lang->line('discount'); ?></th>
                                        <th><?php echo $this->lang->line('net_amount'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($invoices) && !empty($invoices)){ ?>
                                        <?php foreach($invoices as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->custom_invoice_id; ?></td>
                                            <td>
                                                <?php $user = get_user_by_role($obj->role_id, $obj->user_id); ?>
                                                <?php
                
                                                if(!empty($user)){    
                                                ?>
                                                    <?php echo  $user->name; ?> [<?php echo  $user->role; ?>]<br>                
                                                    <?php
                                                    if($obj->role_id == STUDENT){
                                                        echo $this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.', '. $this->lang->line('roll_no'). ':'. $user->roll_no;
                                                    }
                                                    ?>
                                                <?php } ?> 
                                            </td>
                                            <td><?php echo $obj->gross_amount; ?></td>
                                            <td><?php echo $obj->discount; ?></td>
                                            <td><?php echo $obj->net_amount; ?></td>
                                            <td><?php echo get_paid_status($obj->paid_status); ?></td>
                                            <td>
                                                <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>                                                
                                                   
                                                    <a  onclick="get_invoice_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-invoice-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                        <?php if($obj->paid_status != 'paid'){ ?>
                                                        <a href="<?php echo site_url('accounting/payment/index/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('pay_now'); ?></a>
                                                    <?php } ?> 
                                                        
                                                <?php } ?> 
                                         
                                                <?php if(has_permission(DELETE, 'accounting', 'invoice') && $obj->paid_status == 'unpaid'){ ?>                                                    
                                                      <a href="<?php echo site_url('accounting/invoice/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>        
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        
                        <?php if(isset($single)){ ?>
                        <div  class="tab-pane fade in <?php if(isset($single)){ echo 'active'; }?>" id="tab_single_invoice">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('accounting/invoice/add'), array('name' => 'single', 'id' => 'single', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id"  id="class_id" required="required" onchange="get_student_by_class(this.value, '');" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($classes) && !empty($classes)){ ?>
                                                <?php foreach($classes as $obj ){ ?>
                                                    <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="student_id"><?php echo $this->lang->line('student'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="student_id"  id="student_id" required="required" onchange="reset_form_data()">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                      
                                        </select>
                                        <div class="help-block"><?php echo form_error('student_id'); ?></div>
                                    </div>
                                </div>
                                    
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="income_head_id"><?php echo $this->lang->line('fee_type'); ?><span class="required"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 fn_single_fee_item">
                                         <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                        
                                         <?php }else{ ?>
                                            
                                            <?php if(isset($income_heads) && !empty($income_heads)){ ?>
                                                <?php foreach($income_heads as $obj ){ ?>
                                                    <input onclick="get_single_fee_amount(<?php echo $obj->id; ?>)" type="checkbox" name="income_head_id[<?php echo $obj->id; ?>]" id="income_head_id_<?php echo $obj->id; ?>" class="fn_income_head_id" value="<?php echo $obj->head_type; ?>" > <?php echo $obj->title; ?>
                                                    <br/>
                                                <?php } ?> 
                                            <?php } ?> 
                                         <?php } ?>
                                        
                                        
                                        <div class="help-block"><?php echo form_error('income_head_id'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount"><?php echo $this->lang->line('fee_amount'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12" readonly="readonly"  name="amount"  id="amount" value="<?php echo isset($post['amount']) ?  $post['amount'] : '0.00'; ?>" placeholder="<?php echo $this->lang->line('fee_amount'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('amount'); ?></div>
                                    </div>
                                </div>                                
                                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_month"><?php echo $this->lang->line('month'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="month"  id="month" value="<?php echo isset($post['month']) ?  $post['month'] : ''; ?>" placeholder="<?php echo $this->lang->line('month'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('month'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_applicable_discount"><?php echo $this->lang->line('is_applicable_discount'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="is_applicable_discount" id="is_applicable_discount" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="1"><?php echo $this->lang->line('yes'); ?></option>                                           
                                            <option value="0"><?php echo $this->lang->line('no'); ?></option>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('is_applicable_discount'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paid_status"><?php echo $this->lang->line('paid_status'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="paid_status" id="paid_status" required="required"  onchange="check_paid_status(this.value);">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="paid"><?php echo $this->lang->line('paid'); ?></option>                                           
                                            <option value="unpaid"><?php echo $this->lang->line('unpaid'); ?></option>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('paid_status'); ?></div>
                                    </div>
                                </div>
                                
                                <!-- For cheque Start-->
                                <div class="display fn_paid_status" style="<?php if(isset($post) && $post['paid_status'] == 'paid'){ echo 'display:block;';} ?>">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_method"><?php echo $this->lang->line('payment_method'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-7 col-xs-12"  name="payment_method"  id="payment_method" onchange="check_payment_method(this.value);">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                <?php $payments = get_payment_methods(); ?>
                                                <?php foreach($payments as $key=>$value ){ ?>                                              
                                                    <?php if(!in_array($key, array('paypal', 'payumoney', 'ccavenue', 'paytm','stripe','paystack'))){ ?>
                                                        <option value="<?php echo $key; ?>" <?php if(isset($post) && $post['payment_method'] == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                    <?php } ?>  
                                                <?php } ?>                                            
                                            </select>
                                        <div class="help-block"><?php echo form_error('payment_method'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- For cheque Start-->
                                <div class="display fn_cheque" style="<?php if(isset($post) && $post['payment_method'] == 'cheque'){ echo 'display:block;';} ?>">
                                    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_name"><?php echo $this->lang->line('bank_name'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="bank_name"  id="single_bank_name" value="" placeholder="<?php echo $this->lang->line('bank_name'); ?> "  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('bank_name'); ?></div>
                                        </div>
                                    </div> 
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cheque_no"><?php echo $this->lang->line('cheque_number'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="cheque_no"  id="single_cheque_no" value="" placeholder="<?php echo $this->lang->line('cheque_number'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('cheque_no'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- For cheque End-->
                                
                                <!-- For bank_receipt Start-->
                                <div class="display fn_receipt" style="<?php if(isset($post) && $post['payment_method'] == 'receipt'){ echo 'display:block;';} ?>">
                                    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_receipt"><?php echo $this->lang->line('bank_receipt'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="bank_receipt"  id="single_bank_receipt" value="" placeholder="<?php echo $this->lang->line('bank_receipt'); ?> "  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('bank_receipt'); ?></div>
                                        </div>
                                    </div>                                     
                                </div>
                                <!-- For bank_receipt End-->
                                
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
                                        <input type="hidden" value="single" name="type" />
                                        <a href="<?php echo site_url('accounting/invoice/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                        
                       <?php if(isset($bulk)){ ?> 
                        <div  class="tab-pane fade in <?php if(isset($bulk)){ echo 'active'; }?>" id="tab_bulk_invoice">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('accounting/invoice/bulk'), array('name' => 'bulk', 'id' => 'bulk', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id"  id="class_id" required="required" onchange="reset_form_data()">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($classes) && !empty($classes)){ ?>
                                                <?php foreach($classes as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="income_head_id?"><?php echo $this->lang->line('fee_type'); ?>  <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 fn_bulk_fee_item">
                                         <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                        
                                         <?php }else{ ?>
                                            
                                            <?php if(isset($income_heads) && !empty($income_heads)){ ?>
                                                <?php foreach($income_heads as $obj ){ ?>
                                                    <input onclick="get_bulk_fee_amount(<?php echo $obj->id; ?>)"  type="checkbox" itemid="<?php echo $obj->id; ?>" name="income_head_id[<?php echo $obj->id; ?>]" id="income_head_id_<?php echo $obj->id; ?>" class="fn_income_head_id" value="<?php echo $obj->id; ?>" > <?php echo $obj->title; ?>
                                                    <!--<input type="hidden" name="income_head_id[<?php echo $obj->id; ?>]" value="<?php echo $obj->id; ?>" />-->
                                                    <br/>
                                                <?php } ?> 
                                            <?php } ?> 
                                         <?php } ?>
                                                                                
                                        <div class="help-block"><?php echo form_error('income_head_id'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="student_id"><?php echo $this->lang->line('student'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div id="fn_student_container">                                            
                                        </div>
                                        <div class="help-block fn_check_button display">
                                            <button id="check_all" type="button" class="btn btn-success btn-xs"><?php echo $this->lang->line('check_all'); ?></button>
                                            <button id="uncheck_all" type="button" class="btn btn-success btn-xs"><?php echo $this->lang->line('uncheck_all'); ?></button>
                                        </div>
                                    </div>
                                </div>
                                                                                         
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_applicable_discount?"><?php echo $this->lang->line('is_applicable_discount'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="is_applicable_discount" id="is_applicable_discount" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="1"><?php echo $this->lang->line('yes'); ?></option>                                           
                                            <option value="0"><?php echo $this->lang->line('no'); ?></option>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('is_applicable_discount'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_month"><?php echo $this->lang->line('month'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="month"  id="month" value="<?php echo isset($post['month']) ?  $post['month'] : ''; ?>" placeholder="<?php echo $this->lang->line('month'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('month'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paid_status"><?php echo $this->lang->line('paid_status'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="paid_status" id="paid_status" required="required"  onchange="check_paid_status(this.value);">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="paid"><?php echo $this->lang->line('paid'); ?></option>                                           
                                            <option value="unpaid"><?php echo $this->lang->line('unpaid'); ?></option>                                           
                                        </select>
                                        <div class="help-block"><?php echo form_error('paid_status'); ?></div>
                                    </div>
                                </div>
                                
                                <!-- For cheque Start-->
                                <div class="display fn_paid_status" style="<?php if(isset($post) && $post['paid_status'] == 'paid'){ echo 'display:block;';} ?>">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_method"><?php echo $this->lang->line('payment_method'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-7 col-xs-12"  name="payment_method"  id="payment_method" onchange="check_payment_method(this.value);">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                <?php $payments = get_payment_methods(); ?>
                                                <?php foreach($payments as $key=>$value ){ ?>                                              
                                                    <?php if(in_array($key, array('cash'))){ ?>
                                                        <option value="<?php echo $key; ?>" <?php if(isset($post) && $post['payment_method'] == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                    <?php } ?>  
                                                <?php } ?>                                            
                                            </select>
                                        <div class="help-block"><?php echo form_error('payment_method'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <!-- For cheque Start-->
                                <div class="display fn_cheque" style="<?php if(isset($post) && $post['payment_method'] == 'cheque'){ echo 'display:block;';} ?>">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_name"><?php echo $this->lang->line('bank_name'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="bank_name"  id="bank_name" value="" placeholder="<?php echo $this->lang->line('bank_name'); ?> "  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('bank_name'); ?></div>
                                        </div>
                                    </div> 
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cheque_no"><?php echo $this->lang->line('cheque_number'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="cheque_no"  id="cheque_no" value="" placeholder="<?php echo $this->lang->line('cheque_number'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('cheque_no'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- For cheque End-->
                                
                                <!-- For bank_receipt Start-->
                                <div class="display fn_receipt" style="<?php if(isset($post) && $post['payment_method'] == 'receipt'){ echo 'display:block;';} ?>">
                                    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_receipt"><?php echo $this->lang->line('bank_receipt'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="bank_receipt"  id="single_bank_receipt" value="" placeholder="<?php echo $this->lang->line('bank_receipt'); ?> "  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('bank_receipt'); ?></div>
                                        </div>
                                    </div>                                     
                                </div>
                                <!-- For bank_receipt End-->
                              
                                                               
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
                                        <input type="hidden" value="bulk" name="type" />
                                        <a href="<?php echo site_url('accounting/invoice/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
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


<?php $this->load->view('invoice-modal'); ?> 


<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 
<script type="text/javascript"> 
    
    $("#month").datepicker( {
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });

    
    function check_paid_status(paid_status) {

        if (paid_status == "paid") {   
            
            $('.fn_paid_status').show(); 
            $('#payment_method').prop('required', true);                

        } else{
            
            $('.fn_cheque').hide();           
            $('.fn_receipt').hide();           
            $('.fn_paid_status').hide();  
            $('#payment_method').prop('required', false);               
        }
        
        $("select#payment_method").prop('selectedIndex', 0);
    }
              
    function check_payment_method(payment_method) {

        if (payment_method == "cheque") {
            
            $('.fn_cheque').show();                
            $('.fn_receipt').hide();                
            $('#bank_name').prop('required', true);
            $('#cheque_no').prop('required', true);  
            $('#bank_receipt').prop('required', false);  
            
        }else if (payment_method == "receipt") {
            
            $('.fn_receipt').show();                
            $('.fn_cheque').hide();     
            $('#bank_receipt').prop('required', true);
            $('#bank_name').prop('required', false);
            $('#cheque_no').prop('required', false);                

        } else{
            
            $('.fn_cheque').hide();  
            $('.fn_receipt').hide();  
            $('#bank_name').prop('required', false);
            $('#cheque_no').prop('required', false); 
            $('#bank_receipt').prop('required', false); 
        } 
    }
          
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var class_id = '';       
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                     
                   $('#class_id').html(response); 
               }
               
               get_single_fee_type_by_school(school_id);
               get_bulk_fee_type_by_school(school_id);
            }
        });
    }); 
     

    // single
    function get_student_by_class(class_id, student_id){       
        
        var school_id = $('.fn_school_id').val();
               
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
                
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_student_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , student_id : student_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {     
                    $('#student_id').html(response); 
               }
            }
        });                 
        
   }
   
   
  // single  
   function get_single_fee_type_by_school(school_id){
   
    $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_single_fee_type_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                    $('.fn_single_fee_item').html(response);
               }
            }
        });   
   }
   
    // single
    function get_single_fee_amount(income_head_id){
            
        var student_id = $('#student_id').val(); 
        var class_id = $('#class_id').val(); 
        var school_id = $('.fn_school_id').val();
        var amount = $('#amount').val();
        var check_status = '';
        
        if(!student_id){            
            toastr.error('<?php echo $this->lang->line('select_student'); ?>');
            $('#income_head_id_'+income_head_id).prop('checked', false);
            return false;
        }
        
        if($('#income_head_id_'+income_head_id).is(":checked")){
            check_status = true;           
        }else{
            check_status = false;
        }         
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_single_fee_amount'); ?>",
            data   : { school_id : school_id, income_head_id : income_head_id, class_id : class_id,  student_id:student_id, amount:amount, check_status:check_status},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   $('#amount').val(response);                     
               }
            }
        });  
   }
   
   
   
   //common
   function reset_form_data(){
      $('.fn_income_head_id').prop('checked', false);
      $('#amount').val('0.00');
      $('#month').val('');
      $('#is_applicable_discount').prop('selectedIndex', 0);
      $('#paid_status').prop('selectedIndex', 0);
      $('#payment_method').prop('selectedIndex', 0);
      $('#fn_student_container').html('');
      $('.fn_check_button').hide();
   }
   
   
   
 /* Bulk invoice */ 
    function get_bulk_fee_type_by_school(school_id){
   
    $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_bulk_fee_type_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                    $('.fn_bulk_fee_item').html(response);
               }
            }
        });   
   }
   
    function get_bulk_fee_amount(income_head_id){
            
        var school_id = $('.fn_school_id').val();
        var class_id = $('#class_id').val(); 
        var check_status = '';
        
        if(!class_id){            
            toastr.error('<?php echo $this->lang->line('select_class'); ?>');
            $('#income_head_id_'+income_head_id).prop('checked', false);
            return false;
        }
        
        if($('#income_head_id_'+income_head_id).is(":checked")){
            check_status = true;           
        }else{
            check_status = false;
        }  
        
        var head_ids = [];     
        $("input[name^='income_head_id']").each(function() {  
            if($(this).is(':checked')){
                head_ids += $(this).attr('itemid')+',';
             }
        });
       
                
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_bulk_fee_amount'); ?>",
            data   : { school_id:school_id, class_id:class_id, head_ids:head_ids},               
            async  : false,
            success: function(response){                                                   
               if(response == 'ay')
               {  
                    toastr.error('<?php echo $this->lang->line('set_academic_year_for_school'); ?>');
                    reset_form_data();                    
               }else{
                   $('#fn_student_container').html(response);
                   $('.fn_check_button').show(); 
               }
            }
        });  
    }

   // bulk
   $('#check_all').on('click', function(){
        $('#fn_student_container').children().find('input[type="checkbox"]').prop('checked', true);;
   });
   $('#uncheck_all').on('click', function(){
        $('#fn_student_container').children().find('input[type="checkbox"]').prop('checked', false);;
   });
  
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
        
    $("#single").validate();     
    $("#edit").validate(); 
    $("#bulk").validate();      
    
     function get_invoice_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }  
    
</script>