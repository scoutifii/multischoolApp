<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> <?php echo $this->lang->line('payment'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
           <?php if(logged_in_role_id() != GUARDIAN){ ?>             
             <div class="x_content quick-link">
                 <?php $this->load->view('quick-link'); ?>               
             </div>            
            <?php } ?>  
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                     <ul  class="nav nav-tabs bordered">
                        <li class="active"><a href="#tab_fee_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-dollar"></i> <?php echo $this->lang->line('payment'); ?></a> </li>
                     </ul>
                    <br/>
                    <div class="tab-content"> 
                         <div  class="tab-pane fade in active" id="tab_fee_list" >
                        <div class="x_content"> 
                           <?php echo form_open(site_url('accounting/payment/paid/'.$invoice_id), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                            
                            <?php $this->load->view('layout/school_list_form'); ?>
                            
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount"><?php echo $this->lang->line('amount'); ?> <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="amount"  id="amount" value="<?php echo $due_amount; ?>" placeholder="<?php echo $this->lang->line('amount'); ?>" required="required" type="number" step="any">
                                    <div class="help-block"><?php echo form_error('amount'); ?></div>
                                </div>
                            </div>                               
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_method"><?php echo $this->lang->line('payment_method'); ?> <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select  class="form-control col-md-7 col-xs-12"  name="payment_method"  id="payment_method" required="required" onchange="check_payment_method(this.value);">
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php $payments = get_payment_methods(); ?>
                                        <?php foreach($payments as $key=>$value ){ ?>
                                            <?php if($this->session->userdata('role_id') == GUARDIAN || $this->session->userdata('role_id') == STUDENT){ ?>
                                                <?php if(in_array($key, array('paypal', 'payumoney', 'ccavenue', 'paytm', 'paystack'))){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if(isset($post) && $post['payment_method'] == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            <?php }else{ ?>
                                                    <?php if(!in_array($key, array('paypal', 'payumoney', 'ccavenue', 'paytm', 'stripe', 'paystack'))){ ?>
                                                     <option value="<?php echo $key; ?>" <?php if(isset($post) && $post['payment_method'] == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>                                               
                                            <?php } ?>
                                        <?php } ?>    
                                       
                                    </select>
                                    <div class="help-block"><?php echo form_error('payment_method'); ?></div>
                                </div>
                            </div>

                            <!-- For cheque Start-->
                            <div class="display fn_cheque" style="<?php if(isset($post) && $post['payment_method'] == 'cheque'){ echo 'display:block;';} ?>">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_name"><?php echo $this->lang->line('bank_name'); ?> <span class="required">*</span> </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="bank_name"  id="bank_name" value="" placeholder="<?php echo $this->lang->line('bank_name'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('bank_name'); ?></div>
                                </div>
                            </div> 
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cheque_no"><?php echo $this->lang->line('cheque_number'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="cheque_no"  id="cheque_no" value="" placeholder="<?php echo $this->lang->line('cheque_number'); ?>"  type="text"  autocomplete="off">
                                    <div class="help-block"><?php echo form_error('cheque_no'); ?></div>
                                </div>
                            </div>
                            </div>
                            <!-- For cheque End-->

                            <!-- For Stripe Start-->
                            <div class="display fn_stripe"  style="<?php if(isset($post) && $post['payment_method'] == 'stripe'){ echo 'display:block;';} ?>">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_card_number"><?php echo $this->lang->line('card_number'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="stripe_card_number"  id="stripe_card_number" value="" placeholder="<?php echo $this->lang->line('card_number'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('stripe_card_number'); ?></div>
                                </div>
                            </div> 
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_cvv"><?php echo $this->lang->line('cvv'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="card_cvv"  id="card_cvv" value="" placeholder="<?php echo $this->lang->line('cvv'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('card_cvv'); ?></div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expire"><?php echo $this->lang->line('expire'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <input  class="form-control col-md-7 col-xs-12"  name="expire_month"  id="expire_month" value="" placeholder="<?php echo $this->lang->line('expire_month'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('expire_month'); ?></div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <input  class="form-control col-md-7 col-xs-12"  name="expire_year"  id="expire_year" value="" placeholder="<?php echo $this->lang->line('expire_year'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('expire_year'); ?></div>
                                </div>
                            </div>
                            </div>

                            <!-- For Stripe End-->

                            <!-- For PayuMoney Start-->
                            <div class="display fn_payumoney"  style="<?php if(isset($post) && $post['payment_method'] == 'payumoney'){ echo 'display:block;';} ?>">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pum_first_name"><?php echo $this->lang->line('first_name'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="pum_first_name"  id="pum_first_name" value="" placeholder="<?php echo $this->lang->line('first_name'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('pum_first_name'); ?></div>
                                </div>
                            </div> 
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pum_email"><?php echo $this->lang->line('email'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="pum_email"  id="pum_email" value="" placeholder="<?php echo $this->lang->line('email'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('pum_email'); ?></div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pum_phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input  class="form-control col-md-7 col-xs-12"  name="pum_phone"  id="pum_phone" value="" placeholder="<?php echo $this->lang->line('phone'); ?>"  type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('pum_phone'); ?></div>
                                </div>
                            </div>

                            </div>

                            <!-- For PayUMoney End-->
                            
                            
                           <!-- For PayStack Start-->
                            <div class="display fn_paystack"  style="<?php if(isset($post) && $post['payment_method'] == 'paystack'){ echo 'display:block;';} ?>">
                           
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_email"><?php echo $this->lang->line('email'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_email"  id="stack_email" value="" placeholder="<?php echo $this->lang->line('email'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('stack_email'); ?></div>
                                    </div>
                                </div>                            

                            </div>
                            <!-- For PayStack End-->
                            
                           <!-- For Receipt Start-->
                            <div class="display fn_receipt"  style="<?php if(isset($post) && $post['payment_method'] == 'receipt'){ echo 'display:block;';} ?>">
                           
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_receipt"><?php echo $this->lang->line('bank_receipt'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="bank_receipt"  id="bank_receipt" value="" placeholder="<?php echo $this->lang->line('bank_receipt'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('bank_receipt'); ?></div>
                                    </div>
                                </div>                           

                            </div>
                            <!-- For Receipt End-->

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"></textarea>
                                    <div class="help-block"><?php echo form_error('note'); ?></div>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
                                    <input type="hidden" name="due_amount" value="<?php echo $due_amount; ?>" />
                                    <a href="<?php echo site_url('accounting/invoice/due'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                    <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
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
<!-- datatable with buttons -->
 <link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">
    $(document).ready(function() {
        $("#expire_month").datepicker( {
            format: "mm",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#expire_year").datepicker( {
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
       });  
    function check_payment_method(payment_method) {

            if (payment_method == "stripe") {
                
                $('.fn_payumoney').hide();
                $('.fn_cheque').hide();
                $('.fn_paystack').hide();
                $('.fn_receipt').hide();
                $('.fn_stripe').show();
                
                $('#bank_name').prop('required', false);
                $('#cheque_no').prop('required', false);
                $('#pum_first_name').prop('required', false);
                $('#pum_email').prop('required', false);
                $('#pum_phone').prop('required', false);
                $('#stripe_card_number').prop('required', true);
                $('#stripe_cvv').prop('required', true);
                $('#expire_month').prop('required', true);
                $('#expire_year').prop('required', true);
                $('#stack_email').prop('required', false);
                $('#bank_receipt').prop('required', false);
                
            } else if (payment_method == "cheque") {
                
                $('.fn_payumoney').hide();
                $('.fn_stripe').hide();
                $('.fn_paystack').hide();
                $('.fn_receipt').hide();
                $('.fn_cheque').show();
                
                $('#bank_name').prop('required', true);
                $('#cheque_no').prop('required', true);
                $('#pum_first_name').prop('required', false);
                $('#pum_email').prop('required', false);
                $('#pum_phone').prop('required', false);
                $('#stripe_card_number').prop('required', false);
                $('#stripe_cvv').prop('required', false);
                $('#expire_month').prop('required', false);
                $('#expire_year').prop('required', false);
                $('#stack_email').prop('required', false);
                $('#bank_receipt').prop('required', false);
                
            } else if (payment_method == "payumoney") {
                
                $('.fn_stripe').hide();
                $('.fn_cheque').hide();
                $('.fn_paystack').hide();
                $('.fn_receipt').hide();
                $('.fn_payumoney').show();
                
                $('#bank_name').prop('required', false);
                $('#cheque_no').prop('required', false);
                $('#pum_first_name').prop('required', true);
                $('#pum_email').prop('required', true);
                $('#pum_phone').prop('required', true);
                $('#stripe_card_number').prop('required', false);
                $('#stripe_cvv').prop('required', false);
                $('#expire_month').prop('required', false);
                $('#expire_year').prop('required', false);
                $('#stack_email').prop('required', false);
                $('#bank_receipt').prop('required', false);
                
            } else if (payment_method == "paystack") {
                
                $('.fn_stripe').hide();
                $('.fn_cheque').hide();
                $('.fn_payumoney').hide();
                $('.fn_receipt').hide();
                $('.fn_paystack').show();
                
                $('#bank_name').prop('required', false);
                $('#cheque_no').prop('required', false);
                $('#pum_first_name').prop('required', false);
                $('#pum_email').prop('required', false);
                $('#pum_phone').prop('required', false);
                $('#stripe_card_number').prop('required', false);
                $('#stripe_cvv').prop('required', false);
                $('#expire_month').prop('required', false);
                $('#expire_year').prop('required', false);
                $('#stack_email').prop('required', true);
                $('#bank_receipt').prop('required', false);
                
            } else if (payment_method == "receipt") {
                
                $('.fn_stripe').hide();
                $('.fn_cheque').hide();
                $('.fn_payumoney').hide();
                $('.fn_paystack').hide();
                $('.fn_receipt').show();
                
                $('#bank_name').prop('required', false);
                $('#cheque_no').prop('required', false);
                $('#pum_first_name').prop('required', false);
                $('#pum_email').prop('required', false);
                $('#pum_phone').prop('required', false);
                $('#stripe_card_number').prop('required', false);
                $('#stripe_cvv').prop('required', false);
                $('#expire_month').prop('required', false);
                $('#expire_year').prop('required', false);
                $('#stack_email').prop('required', false);
                $('#bank_receipt').prop('required', true);
                
            }else{
                
                $('.fn_stripe').hide();
                $('.fn_cheque').hide();
                $('.fn_payumoney').hide();
                $('.fn_paystack').hide();
                $('.fn_receipt').hide();
                
                $('#bank_name').prop('required', false);
                $('#cheque_no').prop('required', false);
                $('#pum_first_name').prop('required', false);
                $('#pum_email').prop('required', false);
                $('#pum_phone').prop('required', false);
                $('#stripe_card_number').prop('required', false);
                $('#stripe_cvv').prop('required', false);
                $('#expire_month').prop('required', false);
                $('#expire_year').prop('required', false);
                $('#stack_email').prop('required', false);
                $('#bank_receipt').prop('required', false);
            } 
        }
        
        
    $("#add").validate();     
</script>