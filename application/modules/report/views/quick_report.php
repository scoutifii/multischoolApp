<div class="x_content quick-link no-print">
    <div class="row">                   
        <div class="col-md-12 col-sm-12 col-xs-12">
            <span style="padding-top: 8px;"><?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('report'); ?>:</span>
            <select  class="form-control" name="report" id="report" onchange="get_report_action(this.value);">
                    <?php 
                    $reports = array(); 
                    $reports[site_url('report/income')] = $this->lang->line('income_report'); 
                    $reports[site_url('report/expenditure')] = $this->lang->line('expenditure_report'); 
                    $reports[site_url('report/invoice')] = $this->lang->line('invoice_report'); 
                    $reports[site_url('report/duefee')] = $this->lang->line('due_fee_report'); 
                    $reports[site_url('report/feecollection')] = $this->lang->line('fee_collection_report'); 
                    $reports[site_url('report/balance')] = $this->lang->line('accounting_balance_report'); 
                    $reports[site_url('report/library')] = $this->lang->line('library_report'); 
                    $reports[site_url('report/sattendance')] = $this->lang->line('student_attendance_report'); 
                    $reports[site_url('report/syattendance')] = $this->lang->line('student_yearly_attendance_report'); 
                    $reports[site_url('report/tattendance')] = $this->lang->line('teacher_attendance_report');  
                    $reports[site_url('report/tyattendance')] = $this->lang->line('teacher_yearly_attendance_report'); 
                    $reports[site_url('report/eattendance')] = $this->lang->line('employee_attendance_report'); 
                    $reports[site_url('report/eyattendance')] = $this->lang->line('employee_yearly_attendance_report'); 
                    $reports[site_url('report/student')] = $this->lang->line('student_report'); 
                    $reports[site_url('report/sinvoice')] = $this->lang->line('student_invoice_report'); 
                    $reports[site_url('report/sactivity')] = $this->lang->line('student_activity_report'); 
                    $reports[site_url('report/payroll')] = $this->lang->line('payroll_report'); 
                    $reports[site_url('report/transaction')] = $this->lang->line('daily_transaction_report'); 
                    $reports[site_url('report/statement')] = $this->lang->line('daily_statement_report'); 
                    $reports[site_url('report/examresult')] = $this->lang->line('exam_result_report'); 
                    $reports[site_url('report/teachertransfer')] = $this->lang->line('teacher_transfer_report'); 
                    $reports[site_url('report/studenttransfer')] = $this->lang->line('student_transfer_report'); 
                    ?>
                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                    <?php foreach($reports as $key=>$value){ ?>
                    <option value="<?php echo $key; ?>" <?php if(isset($report_url) && $report_url == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                    <?php } ?>
                </select>
        </div>
    </div>             
</div>

<script src="<?php echo VENDOR_URL; ?>chart/js/highcharts.js"></script>
<script src="<?php echo VENDOR_URL; ?>chart/js/highcharts-3d.js"></script>
<script src="<?php echo VENDOR_URL; ?>chart/js/modules/exporting.js"></script>

<script type="text/javascript">
    function get_report_action(url){          
       if(url){
           window.location.href = url; 
       }
    }
</script>

 