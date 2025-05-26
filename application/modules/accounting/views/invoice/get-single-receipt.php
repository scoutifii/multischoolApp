<div class="x_content_ fn-print-area">
<section class="content invoice profile_img">
         <!-- title row -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_ text-center" style="text-align: center !important;">
                 <?php if($school->logo){ ?>
                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                 <?php }else if($school->frontend_logo){ ?>
                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                 <?php }else{ ?>                                                        
                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                 <?php } ?> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_" style="text-align: center !important;">
                <address>
                    <h3><?php echo $school->school_name; ?></h3>
                     <?php echo $school->address; ?>
                    <br><?php echo $this->lang->line('phone'); ?>: <?php echo $school->phone; ?>,
                    <?php echo $this->lang->line('email'); ?>: <?php echo $school->email; ?>
                </address>
            </div>            
        </div>

        <!-- info row -->
        <div class="row invoice-info">          
            <div class="col-md-6 col-sm-6 col-xs-6 invoice-col_">                
                <address>
                    <strong><?php echo $this->lang->line('student'); ?>:</strong>: <?php echo $receipt->student_name; ?>
                    <br><strong><?php echo $this->lang->line('class'); ?>:</strong> <?php echo $receipt->class_name; ?>
                    <br><strong><?php echo $this->lang->line('phone'); ?>:</strong> <?php echo $receipt->phone; ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-6 invoice-col">
                <strong><?php echo $this->lang->line('invoice'); ?>: </strong> #<?php echo $receipt->custom_invoice_id; ?>                                                     
                <br>
                <strong><?php echo $this->lang->line('status'); ?>:</strong> <?php echo get_paid_status($receipt->paid_status); ?>
                <br>
                <strong><?php echo $this->lang->line('date'); ?>:</strong> <?php echo date($this->global_setting->date_format, strtotime($receipt->date)); ?>
            </div>
            <!-- /.col -->
        </div> 
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 invoice-header_" style="text-align: center !important;">
                <address>
                    <h4><?php echo $this->lang->line('student_copy'); ?></h4>                    
                </address>
            </div>            
        </div>
</section>
<section class="content invoice">
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                        <th><?php echo $this->lang->line('fee_type'); ?></th>
                        <th><?php echo $this->lang->line('gross_amount'); ?></th>
                        <th><?php echo $this->lang->line('discount'); ?></th>
                        <th><?php echo $this->lang->line('net_amount'); ?></th>
                    </tr>
                </thead>
                <tbody> 
                    <?php if(isset($invoice_items) && !empty($invoice_items)){ ?>
                        <?php $counter = 1; foreach($invoice_items as $item){ ?>
                        <tr>
                            <td  style="width:10%"><?php echo $counter++; ?></td>
                            <td  style="width:25%"> <?php echo $item->title; ?></td>
                            <td> <?php echo $school->currency_symbol; ?><?php echo $item->gross_amount; ?></td>
                            <td><?php echo $school->currency_symbol; ?><?php echo round($item->discount,2); ?></td>
                            <td><?php echo $school->currency_symbol; ?><?php echo round($item->net_amount, 2); ?></td>
                        </tr> 
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
     <div class="row">
         <div class="col-xs-12"></div>
     </div>
    <!-- /.row -->
    <div class="row">       
        <p class="white text-center">
             <?php if(isset($this->school_setting->footer) && $this->school_setting->footer != ''){ ?>
                <?php echo $this->school_setting->footer; ?>
             <?php }else{ ?>
                <?php echo $this->global_setting->brand_footer ? $this->global_setting->brand_footer : 'Copyright © '. date('Y').' <a target="_blank" href="https://codecanyon.net/user/codetroopers">Codetroopers Team.</a> All rights reserved.'; ?> 
             <?php } ?>
        </p> 
    </div>

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
        </div>
    </div>
</section>
</div>