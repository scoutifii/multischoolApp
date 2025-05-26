
<div class="" data-example-id="togglable-tabs">
    <ul  class="nav nav-tabs bordered">
        <li class="active"><a href="#tab_guardian"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-info-circle"></i> <?php echo $this->lang->line('profile'); ?></a> </li>
        <li class=""><a href="#tab_student_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-male"></i> <?php echo $this->lang->line('student_list'); ?></a> </li>
        <li class=""><a href="#tab_invoice_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-dollar"></i> <?php echo $this->lang->line('invoice'); ?></a> </li>
    </ul>
    <br/>

    <div class="tab-content">
        <div  class="tab-pane fade in active" id="tab_guardian" >    
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width=""><?php echo $this->lang->line('school_name'); ?></th>
                        <td colspan="3"><?php echo $guardian->school_name; ?></td>                       
                    </tr>
                    <tr>                       
                        <th width="20%"><?php echo $this->lang->line('name'); ?> </th>
                        <td width="30%"><?php echo $guardian->name; ?></td>
                        <th width="20%"><?php echo $this->lang->line('username'); ?> </th>
                        <td width="30%"><?php echo $guardian->username; ?></td>
                    </tr>
                    
                    <tr>
                        <th><?php echo $this->lang->line('national_id'); ?></th>
                        <td><?php echo $guardian->national_id; ?></td>                    
                        <th><?php echo $this->lang->line('phone'); ?></th>
                        <td><?php echo $guardian->phone; ?></td>
                    </tr>
                    
                    <tr>
                        <th><?php echo $this->lang->line('profession'); ?></th>
                        <td><?php echo $guardian->profession; ?></td>                    
                        <th><?php echo $this->lang->line('religion'); ?></th>
                        <td><?php echo $guardian->religion; ?></td>
                    </tr>
                    
                    <tr>
                        <th><?php echo $this->lang->line('present_address'); ?></th>
                        <td><?php echo $guardian->present_address; ?></td>
                        <th><?php echo $this->lang->line('permanent_address'); ?></th>
                        <td><?php echo $guardian->permanent_address; ?></td>
                    </tr>
                   
                    <tr>
                        <th><?php echo $this->lang->line('role'); ?></th>
                        <td><?php echo $guardian->role; ?></td>                   
                        <th><?php echo $this->lang->line('email'); ?></th>
                        <td><?php echo $guardian->email; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('photo'); ?></th>
                        <td>
                            <?php if($guardian->photo){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>/guardian-photo/<?php echo $guardian->photo; ?>" alt="" width="70" /><br/><br/>
                            <?php } ?>  
                        </td>                    
                        <th><?php echo $this->lang->line('other_info'); ?></th>
                        <td><?php echo $guardian->other_info; ?>   </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
         <div  class="tab-pane fade in " id="tab_student_list" >
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                   <tr>
                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                        <th><?php echo $this->lang->line('name'); ?></th>
                        <th><?php echo $this->lang->line('class'); ?></th>
                        <th><?php echo $this->lang->line('section'); ?></th>
                        <th><?php echo $this->lang->line('group'); ?></th>
                        <th><?php echo $this->lang->line('gender'); ?></th>
                        <th><?php echo $this->lang->line('blood_group'); ?></th>
                        <th><?php echo $this->lang->line('photo'); ?></th>
                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                    </tr>
                </thead>
                 <tbody>   
                    <?php  $count = 1; if(isset($students) && !empty($students)){ ?>
                        <?php foreach($students as $obj){ ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo ucfirst($obj->name); ?></td>
                            <td><?php echo $obj->class_name; ?></td>
                            <td><?php echo $obj->section; ?></td>
                            <td><?php echo $this->lang->line($obj->group); ?></td>
                            <td><?php echo $this->lang->line($obj->gender); ?></td>
                            <td><?php echo $this->lang->line($obj->blood_group); ?></td>
                            <td>
                                <?php  if($obj->photo != ''){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="70" /> 
                                <?php }else{ ?>
                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="70" /> 
                                <?php } ?>
                            </td>
                            <td>
                                <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                                    <a onclick="get_student_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-student-modal-lg" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>                   
            </table>  
        </div> 
        
          <div  class="tab-pane fade in " id="tab_invoice_list" >
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                        <th><?php echo $this->lang->line('invoice_number'); ?></th>
                        <th><?php echo $this->lang->line('student'); ?></th>
                        <th><?php echo $this->lang->line('class'); ?></th>
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
                            <td><?php echo $obj->custom_invoice_id; ?></td>
                            <td><?php echo $obj->student_name; ?></td>
                            <td><?php echo $obj->class_name; ?></td>
                            <td><?php echo $obj->gross_amount; ?></td>
                            <td><?php echo $obj->discount; ?></td>
                            <td><?php echo $obj->net_amount; ?></td>
                            <td><?php echo get_paid_status($obj->paid_status); ?></td>
                            <td>
                                <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>
                                    <a target="_blank" href="<?php echo site_url('accounting/invoice/view/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                               <?php } ?>
                                <?php if(has_permission(DELETE, 'accounting', 'invoice')){ ?>
                                    <?php if($obj->paid_status == 'unpaid'){ ?>
                                        <a target="_blank" href="<?php echo site_url('accounting/invoice/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>                   
            </table>  
        </div>  
    </div>
</div>
    
    
