<div class="" data-example-id="togglable-tabs">
    <ul  class="nav nav-tabs bordered">
        <li  class="active"><a href="#tab_pop_paypal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?></a> </li>                          
        <!--<li  class=""><a href="#tab_pop_stripe_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?></a> </li>-->                          
        <li  class=""><a href="#tab_pop_pumoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?></a> </li>                          
        <!--<li  class=""><a href="#tab_pop_ccavenue_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?></a> </li>-->                        
        <li  class=""><a href="#tab_pop_paytm_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?></a> </li>                          
        <li  class=""><a href="#tab_pop_paystack_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?></a> </li>                          
    </ul>
    <br/>
    
     <div class="tab-content">   
         
        <div  class="tab-pane fade in active" id="tab_pop_paypal_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="40%"><?php echo $this->lang->line('paypal_email'); ?></th>
                    <td><?php echo $payment_setting->paypal_email; ?></td> 
                </tr>
                                
                <tr>
                    <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                    <td><?php echo $payment_setting->paypal_extra_charge; ?></td>
                </tr> 
                 <tr>
                    <th><?php echo $this->lang->line('is_demo'); ?></th>
                    <td><?php  echo $payment_setting->paypal_demo ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $payment_setting->paypal_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr>               
               
            </tbody>
        </table>
        </div>         
         
        <div  class="tab-pane fade in display" id="tab_pop_stripe_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="40%"><?php echo $this->lang->line('secret_key'); ?></th>
                    <td><?php echo $payment_setting->stripe_secret; ?></td> 
                </tr>         
                      
                <tr>
                    <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                    <td><?php echo $payment_setting->stripe_extra_charge; ?></td>
                </tr> 
                 <tr>
                    <th> <?php echo $this->lang->line('is_demo'); ?></th>
                    <td><?php echo $payment_setting->stripe_demo ? $this->lang->line('yes') : $this->lang->line('no') ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $payment_setting->stripe_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_pumoney_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="40%"><?php echo $this->lang->line('payumoney_key'); ?></th>
                    <td><?php echo $payment_setting->payumoney_key; ?></td> 
                </tr>                    
                <tr>
                    <th><?php echo $this->lang->line('key_salt'); ?></th>
                    <td><?php echo $payment_setting->payumoney_salt; ?></td> 
                </tr>                    
                                 
                <tr>
                    <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                    <td><?php echo $payment_setting->payu_extra_charge; ?></td> 
                </tr> 
                 <tr>
                    <th><?php echo $this->lang->line('is_demo'); ?></th>
                    <td><?php echo $payment_setting->payumoney_demo ? $this->lang->line('yes'): $this->lang->line('no'); ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $payment_setting->payumoney_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr>               
               
            </tbody>
        </table>
        </div>
                
         
        <div  class="tab-pane fade in display" id="tab_pop_ccavenue_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="40%"><?php echo $this->lang->line('ccavenue_key'); ?></th>
                    <td><?php echo $payment_setting->ccavenue_key; ?></td> 
                </tr>         
                <tr>
                    <th><?php echo $this->lang->line('key_salt'); ?></th>
                    <td><?php echo $payment_setting->ccavenue_salt; ?></td> 
                </tr>  
                
                <tr>
                    <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                    <td><?php echo $payment_setting->ccavenue_extra_charge; ?></td> 
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('is_demo'); ?></th>
                    <td><?php echo $payment_setting->ccavenue_demo  ? $this->lang->line('yes'): $this->lang->line('no'); ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $payment_setting->ccavenue_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_paytm_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="40%"><?php echo $this->lang->line('merchant_key'); ?></th>
                    <td><?php echo $payment_setting->paytm_merchant_key; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('merchant_mid'); ?></th>
                    <td><?php echo $payment_setting->paytm_merchant_mid; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('website'); ?></th>
                    <td><?php echo $payment_setting->paytm_merchant_website; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('industry_type'); ?></th>
                    <td><?php echo $payment_setting->paytm_industry_type; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                    <td><?php echo $payment_setting->paytm_extra_charge; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('is_demo'); ?></th>
                    <td><?php echo $payment_setting->paytm_demo ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $payment_setting->paytm_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>  
         
            
        <div  class="tab-pane fade in" id="tab_pop_paystack_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="40%"><?php echo $this->lang->line('secret_key'); ?></th>
                    <td><?php echo $payment_setting->stack_secret_key; ?></td> 
                </tr>             
                <tr>
                    <th width="40%"><?php echo $this->lang->line('public_key'); ?></th>
                    <td><?php echo $payment_setting->stack_public_key; ?></td> 
                </tr>             
            
                <tr>
                    <th><?php echo $this->lang->line('extra_charge'); ?> (%)</th>
                    <td><?php echo $payment_setting->stack_extra_charge; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('is_demo'); ?></th>
                    <td><?php echo $payment_setting->stack_demo ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $payment_setting->stack_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>     
         
    </div>
</div>
