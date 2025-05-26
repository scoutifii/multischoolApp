<div class="" data-example-id="togglable-tabs">
    <ul  class="nav nav-tabs bordered">
        <li class="active"><a href="#tab_basic_info"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-info-circle"></i> <?php echo $this->lang->line('basic'); ?> <?php echo $this->lang->line('information'); ?></a> </li>
        <li class=""><a href="#tab_social_info"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-share"></i> <?php echo $this->lang->line('social'); ?> <?php echo $this->lang->line('information'); ?></a> </li>
    </ul>
    <br/>
    
     <div class="tab-content">
        <div  class="tab-pane fade in active" id="tab_basic_info" > 
            <table id="datatable-responsive" class="table table-striped table-condensed table-hover" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('name'); ?></th>
                        <td colspan="3"><?php echo $employee->school_name; ?></td>  
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('name'); ?></th>
                        <td><?php echo $employee->name; ?></td>        
                        <th><?php echo $this->lang->line('national_id'); ?></th>
                        <td><?php echo $employee->national_id; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('designation'); ?></th>
                        <td><?php echo $employee->designation; ?></td>        
                        <th><?php echo $this->lang->line('phone'); ?></th>
                        <td><?php echo $employee->phone; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?></th>
                        <td><?php echo $employee->present_address; ?></td>        
                        <th><?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?></th>
                        <td><?php echo $employee->permanent_address; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('gender'); ?></th>
                        <td><?php echo $this->lang->line($employee->gender); ?></td>       
                        <th><?php echo $this->lang->line('blood_group'); ?></th>
                        <td><?php echo $this->lang->line($employee->blood_group); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('religion'); ?></th>
                        <td><?php echo $employee->religion; ?></td>       
                        <th><?php echo $this->lang->line('birth_date'); ?></th>
                        <td><?php echo date($this->global_setting->date_format, strtotime($employee->dob)); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('join_date'); ?></th>
                        <td><?php echo date($this->global_setting->date_format, strtotime($employee->joining_date)); ?></td>        
                        <th><?php echo $this->lang->line('role'); ?></th>
                        <td><?php echo $employee->role; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('salary_grade'); ?></th>
                        <td><?php echo $employee->grade_name; ?></td>        
                        <th><?php echo $this->lang->line('salary_type'); ?></th>
                        <td><?php echo $this->lang->line($employee->salary_type); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('email'); ?></th>
                        <td><?php echo $employee->email; ?></td>        
                        <th><?php echo $this->lang->line('other_info'); ?></th>
                        <td><?php echo $employee->other_info; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('photo'); ?></th>
                        <td>
                            <?php if($employee->photo){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>/employee-photo/<?php echo $employee->photo; ?>" alt="" width="70" />
                            <?php } ?>        
                        </td>
                        <th><?php echo $this->lang->line('resume'); ?></th>
                        <td>
                            <?php if($employee->resume){ ?>
                                <a href="<?php echo UPLOAD_PATH; ?>/employee-resume/<?php echo $employee->resume; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a>
                            <?php } ?>
                        </td>
                    </tr>                    

                </tbody>
            </table>
        </div>
        <div  class="tab-pane fade in" id="tab_social_info" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>           
                <tr>
                    <th><?php echo $this->lang->line('facebook_url'); ?></th>
                    <td><?php echo $employee->facebook_url; ?></td>       
                    <th><?php echo $this->lang->line('linkedin_url'); ?></th>
                    <td><?php echo $employee->linkedin_url; ?></td>
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('twitter_url'); ?></th>
                    <td><?php echo $employee->twitter_url; ?></td>        
                    <th><?php echo $this->lang->line('google_plus_url'); ?></th>
                    <td><?php echo $employee->google_plus_url; ?></td>
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('instagram_url'); ?></th>
                    <td><?php echo $employee->instagram_url; ?></td>        
                    <th><?php echo $this->lang->line('pinterest_url'); ?></th>
                    <td><?php echo $employee->pinterest_url; ?></td>
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('youtube_url'); ?></th>
                    <td><?php echo $employee->youtube_url; ?></td>        
                    <th><?php echo $this->lang->line('is_view_on_web'); ?></th>
                    <td><?php echo $employee->is_view_on_web ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                </tr>

            </tbody>
        </table>
        </div>
    </div>
</div>
