<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-comments-o"></i><small> <?php echo $this->lang->line('manage_message'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3 no-print">
                            <?php $this->load->view('message-nav'); ?>   
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo $this->lang->line('read_message'); ?></h3>              
                                </div>
                           <div class="box box-primary">
                            <?php echo form_open_multipart(site_url('message/reply/'.$message->message_id), array('name' => 'compose', 'id' => 'compose', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                  <div class="mailbox-read-info">
                                      
                                    <h4><?php echo $this->lang->line('school'); ?>: <?php echo $message->school_name; ?></h4>
                                    <div class="ln_solid"></div> 
                                    
                                    <h4><?php echo $message->subject; ?></h4>
                                    <h5>
                                        <?php if($message->receiver_id == $message->owner_id){ ?>
                                            <?php $user = get_user_by_id( $message->sender_id); ?>
                                            <span><?php echo $this->lang->line('sender'); ?>: <?php echo $user->name; ?></span>
                                        <?php }else{ ?>
                                            <?php $user = get_user_by_id($message->receiver_id); ?>
                                            <span><?php echo $this->lang->line('receiver'); ?>: <?php echo $user->name; ?></span>
                                        <?php } ?>
                                      <span class="mailbox-read-time pull-right"><?php echo date($this->global_setting->date_format . ' H:i:s a', strtotime($message->created_at)); ?></span>
                                    </h5>
                                  </div>
                                  <div class="ln_solid"></div>  
                                  <div class="mailbox-read-message">
                                    <?php echo nl2br($message->body); ?>
                                     <br/>  
                                  </div>
                                  
                                  <?php if(isset($replies) && !empty($replies)){ ?>
                                    <?php foreach($replies as $obj){ ?>
                                    <div class="ln_solid"></div>
                                    <h5>                                      
                                        <?php $user = get_user_by_id( $obj->sender_id); ?>
                                        <span> <?php echo $this->lang->line('reply'); ?>: <?php echo $user->name; ?></span>
                                        <span class="mailbox-read-time pull-right"><?php echo date($this->global_setting->date_format . ' H:i:s a', strtotime($obj->created_at)); ?></span>
                                    </h5>     
                                      <div class="mailbox-read-message">
                                        <?php echo nl2br($obj->body); ?>
                                          <br/>
                                      </div>

                                    <?php } ?>
                                  <?php } ?> <!-- Reply End -->
                                  
                                   <?php if(!$message->is_trash || !$message->is_draft){ ?>
                                   <div class="form-group"></div>
                                    <div class="form-group">
                                        <textarea  class="form-control" name="body" id="body" required="required" placeholder="<?php echo $this->lang->line('reply'); ?> *"></textarea>
                                        <div class="help-block"><?php echo form_error('body'); ?></div>
                                        <input type="hidden" name="message_id" id="message_id" value="<?php echo $message->message_id; ?>" />
                                       
                                        <?php if($message->receiver_id == $message->owner_id){ ?> 
                                            <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $message->sender_id; ?>" />
                                        <?php }else{ ?> 
                                            <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $message->receiver_id; ?>" />
                                         <?php } ?>
                                    </div>
                                   <?php } ?>
                                   
                                </div>
                               
                                <!-- /.box-footer -->
                                <div class="ln_solid no-print"></div>
                                <div class="box-footer no-print">
                                  <div class="pull-right">
                                    <?php if(!$message->is_trash || !$message->is_draft){ ?> 
                                        <button type="submit" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $this->lang->line('reply'); ?></button>
                                        <!--<button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>-->
                                    <?php } ?>
                                  </div>
                                    <a href="<?php echo site_url('message/delete/'.$message->message_id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');"><button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?></button></a>
                                  <button type="button" class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                                </div>
                                 <?php echo form_close(); ?>
                              </div>
                            <!-- /. box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

<!-- datatable with buttons -->
 <script type="text/javascript">
        
    $("#compose").validate();    
</script> 