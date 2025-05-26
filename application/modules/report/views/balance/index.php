<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('accounting_balance_report'); ?></small></h3>                
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <?php $this->load->view('quick_report'); ?>   
            
             <div class="x_content filter-box no-print"> 
                <?php echo form_open_multipart(site_url('report/balance'), array('name' => 'balance', 'id' => 'balance', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">                    
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        
                        <?php $this->load->view('layout/school_list_filter'); ?>
                        
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group"> 
                                <?php echo $this->lang->line('academic_year'); ?>
                                <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach ($academic_years as $obj) { ?>
                                    <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group"> 
                                <?php echo $this->lang->line('group_by_data'); ?> <span class="required">*</span>
                                <select  class="form-control col-md-7 col-xs-12" name="group_by" id="group_by"  required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $groups = get_group_by_type(); ?>
                                    <?php foreach ($groups as $key=>$value) { ?>
                                    <option value="<?php echo $key; ?>" <?php if(isset($group_by) && $group_by == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group"> 
                                <?php echo $this->lang->line('from_date'); ?>
                                <input  class="form-control col-md-7 col-xs-12"  name="date_from"  id="date_from" value="<?php echo isset($date_from) && $date_from != '' ?  date('d-m-Y', strtotime($date_from)) : ''; ?>" placeholder="<?php echo $this->lang->line('from_date'); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group"> 
                               <?php echo $this->lang->line('to_date'); ?>
                                <input  class="form-control col-md-7 col-xs-12"  name="date_to"  id="date_to" value="<?php echo isset($date_to) && $date_to != '' ?  date('d-m-Y', strtotime($date_to)) : ''; ?>" placeholder="<?php echo $this->lang->line('to_date'); ?>" type="text">
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">

                    <?php if(isset($school) && !empty($school)){ ?>
                    <div class="x_content">             
                       <div class="row">
                           <div class="col-sm-3  col-xs-3">&nbsp;</div>
                           <div class="col-sm-6  col-xs-6 layout-box">
                               <div>
                                   
                                 <?php if($school->logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                                 <?php }else if($school->frontend_logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                                 <?php }else{ ?>                                                        
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                                 <?php } ?>
                                   
                                   <h4><?php echo $school->school_name; ?></h4>
                                   <p><?php echo $school->address; ?></p>
                                   <h3 class="head-title ptint-title" style="width: 100%;"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('accounting_balance_report'); ?></small></h3>                
                                   <div class="clearfix">&nbsp;</div>
                               </div>
                           </div>
                            <div class="col-sm-3  col-xs-3">&nbsp;</div>
                       </div>            
                    </div>
                    <?php } ?>
                    
                    <ul  class="nav nav-tabs bordered no-print">
                        <li class=""><a href="#tab_tabular"   role="tab" data-toggle="tab"   aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('tabular_report'); ?></a> </li>
                        <li  class="active"><a href="#tab_graphical"   role="tab" data-toggle="tab"  aria-expanded="false"><i class="fa fa-line-chart"></i> <?php echo $this->lang->line('graphical_report'); ?></a> </li>                          
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in" id="tab_tabular" >
                            <div class="x_content">
                            <table id="datatable-keytable" class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('group_by_data'); ?></th>
                                        <th><?php echo $this->lang->line('income'); ?></th>
                                        <th><?php echo $this->lang->line('expenditure'); ?></th>
                                        <th><?php echo $this->lang->line('balance'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php 
                                    $total_income = 0;
                                    $total_expenditure = 0;
                                    $total_balance = 0;
                                    
                                    $income_arr = array();
                                    $expenditure_arr = array();
                                    $balance_arr = array();
                                    
                                    $count = 1; if(isset($balance) && !empty($balance)){ ?>
                                        <?php foreach($balance as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>  
                                            <td><?php echo $obj['group_by_field']; ?></td>
                                            <td><?php echo $obj['income']; $total_income += $obj['income'];  $income_arr[] = $obj['income']; ?></td>                                           
                                            <td><?php echo $obj['expenditure']; $total_expenditure += $obj['expenditure'];  $expenditure_arr[] = $obj['expenditure'] ? $obj['expenditure'] : 0;  ?></td>                                           
                                            <td><?php echo $total_balance = $total_income - $total_expenditure; $balance_arr[] = ($total_balance);  ?></td>                                           
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="2"><strong><?php echo $this->lang->line('total_amount'); ?></strong></td>
                                            <td><strong><?php echo number_format($total_income,2); ?></strong></td>                                           
                                            <td><strong><?php echo number_format($total_expenditure,2); ?></strong></td>                                           
                                            <td><strong><?php echo number_format(($total_income - $total_expenditure),2); ?></strong></td>                                           
                                        </tr>
                                    <?php }else{ ?>
                                        <tr><td colspan="5" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div  class="tab-pane fade in active" id="tab_graphical" >
                            <div class="x_content">
                                <?php if(isset($balance) && !empty($balance)){ ?>
                                 <script type="text/javascript">
                                     
                                      $(function () {
                                        $('#invoice-report').highcharts({
                                                chart: {
                                                type: 'column'
                                                },
                                                title: {
                                                    text: '<?php echo $this->lang->line('accounting_balance_report'); ?>'
                                                },
                                                xAxis: {
                                                    categories: [
                                                        <?php foreach($balance as $obj){ ?> 
                                                         '<?php echo $obj['group_by_field']; ?>',
                                                         <?php } ?>         
                                                     ]
                                                },
                                                credits: {
                                                    enabled: false
                                                },
                                                series: [{
                                                    name: '<?php echo $this->lang->line('income'); ?>',
                                                    data: [<?php echo implode(',', $income_arr); ?>]
                                                }, {
                                                    name: '<?php echo $this->lang->line('expenditure'); ?>',
                                                    data: [<?php echo implode(',', $expenditure_arr); ?>]
                                                }, {
                                                    name: '<?php echo $this->lang->line('balance'); ?>',
                                                    data: [<?php echo implode(',', $balance_arr); ?>]
                                                }],
                                            credits: {
                                            enabled: false
                                            }
                                        });
                                     });
                                     
                                </script>
                                
                                <div id="invoice-report" style="width: 99%; height:<?php echo count($balance)*30+250 ?>px !important; margin: 0 auto"></div>
                                 <?php }else{ ?>
                                <p class="text-center"><?php echo $this->lang->line('no_data_found'); ?></p>
                                 <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            
        </div>
    </div>
</div>
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">
     
    $('#date_from').datepicker();
    $('#date_to').datepicker();
    $("#balance").validate();  
       
    
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){

        var school_id = $(this).val();
        var academic_year_id = '';

        <?php if(isset($school_id) && !empty($school_id)){ ?>
          academic_year_id =  '<?php echo $academic_year_id; ?>';           
        <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
        
        get_academic_year_by_school(school_id, academic_year_id);
          
    });
     
    function get_academic_year_by_school(school_id, academic_year_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id :academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response); 
               }
            }
        });
   }  
    
</script>
