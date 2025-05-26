<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school'); ?></th>
            <td><?php echo $application->school_name; ?></td>       
            <th><?php echo $this->lang->line('session_year'); ?></th>
            <td><?php echo $application->session_year; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('applicant_type'); ?></th>
            <td><?php echo $application->role_name; ?></td>       
            <th><?php echo $this->lang->line('applicant'); ?></th>
            <td>
                <?php
                    $user = get_user_by_role($application->role_id, $application->user_id);
                    echo $user->name;
                    if($application->role_id == STUDENT){
                        echo ' [ '.$this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.', '.$this->lang->line('roll_no').': '.$user->roll_no .' ]';
                    }
                 ?>
            </td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('leave_type'); ?></th>
            <td><?php echo $application->type; ?></td>        
            <th><?php echo $this->lang->line('date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($application->leave_date)); ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('leave_from'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($application->leave_from)); ?></td>       
            <th><?php echo $this->lang->line('leave_to'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($application->leave_to)); ?></td>
        </tr>         
       
        <tr>
            <th><?php echo $this->lang->line('reason'); ?></th>
            <td><?php echo $application->leave_reason; ?></td>       
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $application->leave_note; ?></td>
        </tr> 
                    
        <tr>
            <th><?php echo $this->lang->line('total_leave'); ?></th>
            <td><?php echo $application->total_leave; ?> <?php echo $this->lang->line('day'); ?></td>        
            <th><?php echo $this->lang->line('apply_leave'); ?></th>
            <td><?php echo $application->leave_day; ?> <?php echo $this->lang->line('day'); ?></td>
        </tr>  
        
        <tr>
            <th><?php echo $this->lang->line('leave_used'); ?></th>
            <td>
                <?php 
                   $used = get_total_used_leave($this->session->userdata('academic_year_id'), $application->role_id, $application->type_id, $application->user_id);
                   echo $used > 0 ? $used : 0;
                ?>
                <?php echo $this->lang->line('day'); ?>
            </td>        
            <th><?php echo $this->lang->line('leave_remain'); ?></th>
            <td><?php echo $application->total_leave - $used; ?> <?php echo $this->lang->line('day'); ?></td>
        </tr>  
        
        <tr>
            <th><?php echo $this->lang->line('status'); ?></th>
            <td>
                <?php  if($application->leave_status == 0){ ?>
                    <a href="javascript:void(0);" class="btn btn-default red btn-xs"> <?php echo $this->lang->line('new'); ?> </a>
                <?php  }elseif($application->leave_status == 1){ ?>
                    <a href="javascript:void(0);" class="btn btn-info btn-xs"><?php echo $this->lang->line('waiting'); ?> </a>  
                <?php  }elseif($application->leave_status == 2){ ?>
                    <a href="javascript:void(0);" class="btn btn-danger btn-xs"><?php echo $this->lang->line('approved'); ?> </a>  
                <?php  }elseif($application->leave_status == 3){ ?>
                    <a href="javascript:void(0);" class="btn btn-danger btn-xs"><?php echo $this->lang->line('declined'); ?> </a>  
                <?php  } ?>
            </td>       
            <th><?php echo $this->lang->line('attachment'); ?></th>
            <td>
                <?php if($application->attachment){ ?>
                <a href="<?php echo UPLOAD_PATH; ?>/leave/<?php echo $application->attachment; ?>" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/><br/>
                <?php } ?>
            </td>
        </tr>    
    </tbody>
</table>
