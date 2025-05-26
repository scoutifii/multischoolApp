<a href="<?php echo site_url('message/compose'); ?>" class="btn btn-default btn-block margin-bottom text-left compose-msg">
    <i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('compose'); ?>
</a>
<div class="mail-menu-box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('folder'); ?></h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="<?php if(isset($inbox)){ echo 'nav-active';} ?>">
                <a href="<?php echo site_url('message/inbox'); ?>"><i class="fa fa-inbox"></i> <?php echo $this->lang->line('inbox'); ?>
                    <span class="label label-primary pull-right"><?php echo count($inboxs); ?>/<?php echo count($new); ?></span>
                </a>
            </li>
            <li class="<?php if(isset($sent)){ echo 'nav-active';} ?>">
                <a href="<?php echo site_url('message/sent'); ?>"><i class="fa fa-envelope-o"></i> <?php echo $this->lang->line('sent'); ?>
                    <span class="label label-default pull-right"><?php echo count($sents); ?></span>
                </a>
            </li>
            
            <li class="<?php if(isset($draft)){ echo 'nav-active';} ?>">
                <a href="<?php echo site_url('message/draft'); ?>"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('draft'); ?>
                    <span class="label label-info pull-right"><?php echo count($drafts); ?></span>
                </a>
            </li>           
            <li class="<?php if(isset($trash)){ echo 'nav-active';} ?>">
                <a href="<?php echo site_url('message/trash'); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('trash'); ?>
                    <span class="label label-danger pull-right"><?php echo count($trashs); ?></span>
                </a>
            </li>
        </ul>
    </div>
</div> 

<script type="text/javascript">
      $(function () {
          
       //Handle starring for glyphicon and font awesome   
       $(".mailbox-star").click(function (e) {
            e.preventDefault();
            //detect type
            var $this = $(this).find("a > i");
            var message_id = $(this).find("a").attr('id');
            var fa = $this.hasClass("fa");
            var star = $this.hasClass("fa-star-o");
            //Switch states   
            if (fa) {               
              $this.toggleClass("fa-star");
              $this.toggleClass("fa-star-o");
              $.ajax({       
                    type   : "POST",
                    url    : "<?php echo site_url('message/set_fvourite_status'); ?>",
                    data   : { star : star , message_id : message_id},               
                    async  : false,
                    success: function(response){                                                   
                       if(response)
                       {
                            toastr.success('<?php echo $this->lang->line('update_success'); ?>'); 
                       }
                    }
                });
            }
      });
      
      //Enable check and uncheck all functionality
        $(".fn_checkbox_toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
              //Uncheck all checkboxes
              $(".mailbox-messages input[type='checkbox']").prop('checked', false);
               $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
              //Check all checkboxes
              $(".mailbox-messages input[type='checkbox']").prop('checked', true);
              $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
        
        // refresh
        $('#fn_refresh').click(function(){
            location.reload();
        });
        
        // Move to trash
        $('#fn_trash').click(function() {
             var message_id = "";
             var message_ids = [];
             $('input:checkbox.fn_checkbox').each(function () {
                  if(this.checked){
                     message_id = $(this).attr('id'); 
                     message_ids.push(message_id); 
                  }
             });
             if (message_ids.lenth != 0 ) {
                $.ajax({
                   type   : "POST",
                   url    : "<?php echo site_url('message/set_trash_status'); ?>",
                   data   : { message_ids : message_ids},            
                   async  : false,
                   success: function(response) {
                       if(response)
                       {
                           toastr.success('<?php echo $this->lang->line('update_success'); ?>'); 
                           location.reload();
                       }
                   }
                });
             }else{
                toastr.error('<?php echo $this->lang->line('update_failed'); ?>'); 
             }
        });
        
        // Trash to delete
        $('#fn_delete').click(function() {
             var message_id = "";
             var message_ids = [];
             $('input:checkbox.fn_checkbox').each(function () {
                  if(this.checked){
                     message_id = $(this).attr('id'); 
                     message_ids.push(message_id); 
                  }
             });
             if (message_ids.lenth != 0 ) {
                $.ajax({
                   type   : "POST",
                   url    : "<?php echo site_url('message/set_delete_status'); ?>",
                   data   : { message_ids : message_ids},            
                   async  : false,
                   success: function(response) {
                       if(response)
                       {
                           toastr.success('<?php echo $this->lang->line('delete_success'); ?>'); 
                           location.reload();
                       }
                   }
                });
             }else{
                toastr.error('<?php echo $this->lang->line('delete_failed'); ?>'); 
             }
        });     
    });
</script>