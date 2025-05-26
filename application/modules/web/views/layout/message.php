<style type="text/css">
    .remove{ 
        font-weight: bold;
        font-size: 12px;
        cursor: pointer;
        float: right;
    }
    #message_div{ 
        padding: 6px 10px 6px 10px;
        margin-bottom: 10px;
        margin-top: 20px;
        background: #01b5ef;
        font-weight: bold;
        text-align: left;
        border-radius: 5px;
        color: #fff;
    }
</style>

<?php
$message = '';
$alert_class = 'success';
if ($this->session->userdata('success')):
    $message = $this->session->userdata('success');
    $this->session->unset_userdata('success');
    $class = 'success';
elseif ($this->session->userdata('error')):
    $message = $this->session->userdata('error');
    $this->session->unset_userdata('error');
    $class = 'error';
elseif ($this->session->userdata('warning')):
    $message = $this->session->userdata('warning');
    $this->session->unset_userdata('warning');
    $class = 'warning';
elseif ($this->session->userdata('info')):
    $message = $this->session->userdata('info');
    $this->session->unset_userdata('alert_info');
    $class = 'info';
endif;
?>

<?php if ($message):  ?>
<div class="row"> 
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div id="message_div" class="alert alert-<?php echo $class; ?>"> 
                <?php echo $message; ?>  
            <span class="remove">X</span>
        </div>
    </div>
</div>
<?php endif; ?>
<script type="text/javascript">
    $(function () {
        $('#message_div').delay(10000).fadeOut();
        $('.remove').click(function () {
           $('#message_div').hide();
        });
    });
</script>