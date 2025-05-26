<div class="" data-example-id="togglable-tabs">
    <ul  class="nav nav-tabs bordered">
        <li  class="active"><a href="#tab_pop_twilio_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('twilio'); ?></a> </li>                          
        <li  class=""><a href="#tab_pop_clickatell_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('clicktell'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_bulk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bulk'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_msg91_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('msg91'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_plivo_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('plivo'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_textlocal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('text_local'); ?> </a> </li>                          
        
        <li  class=""><a href="#tab_pop_smscountry_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('sms_country'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_betasms_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('beta_sms'); ?> </a> </li>                          
        <li  class=""  style="float: left;clear: both;"><a href="#tab_pop_bulkpk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bulk_pk'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_cluster_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('sms_custer'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_alpha_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('alpha_net'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_bdbulk_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('bd_bulk'); ?> </a> </li>                          
        <li  class=""><a href="#tab_pop_mimsms_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('mim_sms'); ?> </a> </li>                          
    </ul>
    <br/>
    
     <div class="tab-content">   
        <div  class="tab-pane fade in active" id="tab_pop_twilio_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('account_sid'); ?></th>
                    <td><?php echo $sms_setting->twilio_account_sid; ?></td> 
                </tr>                    
                <tr>
                    <th><?php echo $this->lang->line('auth_token'); ?></th>
                    <td><?php echo $sms_setting->twilio_auth_token; ?></td>
                </tr>                
                <tr>
                    <th><?php echo $this->lang->line('from_number'); ?></th>
                    <td><?php echo $sms_setting->twilio_from_number; ?></td>
                </tr>                
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->twilio_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr>               
               
            </tbody>
        </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_clickatell_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->clickatell_username; ?></td> 
                </tr>                    
                <tr>
                    <th><?php echo $this->lang->line('password'); ?></th>
                    <td><?php echo $sms_setting->clickatell_password; ?></td> 
                </tr>                    
                <tr>
                    <th><?php echo $this->lang->line('api_key'); ?></th>
                    <td><?php echo $sms_setting->clickatell_api_key; ?></td> 
                </tr>                    
                <tr>
                    <th><?php echo $this->lang->line('from_number'); ?></th>
                    <td><?php echo $sms_setting->clickatell_from_number; ?></td> 
                </tr>         
                <tr>
                    <th><?php echo $this->lang->line('clickatell_mo_no'); ?></th>
                    <td><?php echo $sms_setting->clickatell_mo_no; ?></td> 
                </tr>         
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->clickatell_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr>               
               
            </tbody>
        </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_bulk_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->bulk_username; ?></td> 
                </tr>         
                <tr>
                    <th><?php echo $this->lang->line('password'); ?></th>
                    <td><?php echo $sms_setting->bulk_password; ?></td> 
                </tr>         
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->bulk_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_msg91_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('auth_key'); ?></th>
                    <td><?php echo $sms_setting->msg91_auth_key; ?></td> 
                </tr>         
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->msg91_sender_id; ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->msg91_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_plivo_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('auth_id'); ?></th>
                    <td><?php echo $sms_setting->plivo_auth_id; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('auth_token'); ?></th>
                    <td><?php echo $sms_setting->plivo_auth_token; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('from_number'); ?></th>
                    <td><?php echo $sms_setting->plivo_from_number; ?></td> 
                </tr> 
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->plivo_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_textlocal_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->textlocal_username; ?></td> 
                </tr>                  
                <tr>
                    <th><?php echo $this->lang->line('hash_key'); ?></th>
                    <td><?php echo $sms_setting->textlocal_hash_key; ?></td> 
                </tr>                  
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->textlocal_sender_id; ?></td> 
                </tr>                  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->textlocal_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>         
         
        <div  class="tab-pane fade in" id="tab_pop_smscountry_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->smscountry_username; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('password'); ?></th>
                    <td><?php echo $sms_setting->smscountry_password; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->smscountry_sender_id; ?></td> 
                </tr>           
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->smscountry_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
                           
        <div  class="tab-pane fade in" id="tab_pop_betasms_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->betasms_username; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('password'); ?></th>
                    <td><?php echo $sms_setting->betasms_password; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->betasms_sender_id; ?></td> 
                </tr>           
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->betasms_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
                                    
        <div  class="tab-pane fade in" id="tab_pop_bulkpk_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->bulk_pk_username; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('password'); ?></th>
                    <td><?php echo $sms_setting->bulk_pk_password; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->bulk_pk_sender_id; ?></td> 
                </tr>           
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->bulk_pk_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>         
                                    
        <div  class="tab-pane fade in" id="tab_pop_cluster_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('auth_key'); ?></th>
                    <td><?php echo $sms_setting->cluster_auth_key; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('router'); ?></th>
                    <td><?php echo $sms_setting->cluster_router; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->cluster_sender_id; ?></td> 
                </tr>           
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->cluster_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>         
                                    
        <div  class="tab-pane fade in" id="tab_pop_alpha_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th width="50%"><?php echo $this->lang->line('username'); ?></th>
                    <td><?php echo $sms_setting->alpha_username; ?></td> 
                </tr>                 
                <tr>
                    <th><?php echo $this->lang->line('hash_key'); ?></th>
                    <td><?php echo $sms_setting->alpha_hash; ?></td> 
                </tr>   
                <tr>
                    <th><?php echo $this->lang->line('sms_type'); ?></th>
                    <td><?php echo  $this->lang->line($sms_setting->alpha_type); ?></td> 
                </tr>   
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->alpha_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_bdbulk_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th><?php echo $this->lang->line('hash_key'); ?></th>
                    <td><?php echo $sms_setting->bdbulk_hash; ?></td> 
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('sms_type'); ?></th>
                    <td><?php echo  $this->lang->line($sms_setting->bdbulk_type); ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->bdbulk_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
        <div  class="tab-pane fade in" id="tab_pop_mimsms_setting" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th><?php echo $this->lang->line('api_key'); ?></th>
                    <td><?php echo $sms_setting->mim_api_key; ?></td> 
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('sender_id'); ?></th>
                    <td><?php echo $sms_setting->mim_sender_id; ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('sms_type'); ?></th>
                    <td><?php echo $this->lang->line($sms_setting->mim_type); ?></td> 
                </tr>  
                <tr>
                    <th><?php echo $this->lang->line('is_active'); ?></th>
                    <td><?php echo $sms_setting->mim_status ? $this->lang->line('yes'): $this->lang->line('no'); ?></td>
                </tr> 
            </tbody>
            </table>
        </div>
         
         
    </div>
</div>
