<div class="" data-example-id="togglable-tabs">
    <ul  class="nav nav-tabs bordered">
        <li class="active"><a href="#tab_basic_info"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-info-circle"></i> <?php echo $this->lang->line('profile'); ?></a> </li>
        <li class=""><a href="#tab_social_info"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-share"></i> <?php echo $this->lang->line('social_link'); ?></a> </li>
    </ul>
    <br/>
    
     <div class="tab-content">
        <div  class="tab-pane fade in active" id="tab_basic_info" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th width="20%"><?php echo $this->lang->line('school_name'); ?></th>
                        <td width="30%"><?php echo $teacher->school_name; ?></td>        
                        <th width="20%"><?php echo $this->lang->line('username'); ?></th>
                        <td width="30%"><?php echo $teacher->username; ?></td>        
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('name'); ?></th>
                        <td><?php echo $teacher->name; ?></td>        
                        <th><?php echo $this->lang->line('responsibility'); ?></th>
                        <td><?php echo $teacher->responsibility; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('national_id'); ?></th>
                        <td><?php echo $teacher->national_id; ?></td>        
                        <th><?php echo $this->lang->line('phone'); ?></th>
                        <td><?php echo $teacher->phone; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('present_address'); ?></th>
                        <td><?php echo $teacher->present_address; ?></td>        
                        <th><?php echo $this->lang->line('permanent_address'); ?></th>
                        <td><?php echo $teacher->permanent_address; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('gender'); ?></th>
                        <td><?php echo $this->lang->line($teacher->gender); ?></td>        
                        <th><?php echo $this->lang->line('blood_group'); ?></th>
                        <td><?php echo $this->lang->line($teacher->blood_group); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('religion'); ?></th>
                        <td><?php echo $teacher->religion; ?></td>        
                        <th><?php echo $this->lang->line('birth_date'); ?></th>
                        <td><?php echo date($this->global_setting->date_format, strtotime($teacher->dob)); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('join_date'); ?></th>
                        <td><?php echo date($this->global_setting->date_format, strtotime($teacher->joining_date)); ?></td>        
                        <th><?php echo $this->lang->line('role'); ?></th>
                        <td><?php echo $teacher->role; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('salary_grade'); ?></th>
                        <td><?php echo $teacher->grade_name; ?></td>        
                        <th><?php echo $this->lang->line('salary_type'); ?></th>
                        <td><?php echo $this->lang->line($teacher->salary_type); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('email'); ?></th>
                        <td><?php echo $teacher->email; ?></td>        
                        <th><?php echo $this->lang->line('other_info'); ?></th>
                        <td><?php echo $teacher->other_info; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('photo'); ?></th>
                        <td>
                        <?php if($teacher->photo){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>/teacher-photo/<?php echo $teacher->photo; ?>" alt="" width="70" />
                        <?php } ?>
                        </td>        
                        <th><?php echo $this->lang->line('resume'); ?></th>
                        <td>
                        <?php if($teacher->resume){ ?>
                            <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/teacher-resume/<?php echo $teacher->resume; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a>
                        <?php } ?>
                        </td>
                    </tr>                    
                </tbody>
            </table>

        </div>
        <div  class="tab-pane fade in " id="tab_social_info" > 
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tbody>
                    
                    <tr>
                        <th><?php echo $this->lang->line('facebook_url'); ?></th>
                        <td><?php echo $teacher->facebook_url; ?></td>        
                        <th><?php echo $this->lang->line('linkedin_url'); ?></th>
                        <td><?php echo $teacher->linkedin_url; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('twitter_url'); ?></th>
                        <td><?php echo $teacher->twitter_url; ?></td>        
                        <th><?php echo $this->lang->line('google_plus_url'); ?></th>
                        <td><?php echo $teacher->google_plus_url; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('instagram_url'); ?></th>
                        <td><?php echo $teacher->instagram_url; ?></td>        
                        <th><?php echo $this->lang->line('pinterest_url'); ?></th>
                        <td><?php echo $teacher->pinterest_url; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('youtube_url'); ?></th>
                        <td><?php echo $teacher->youtube_url; ?></td>        
                        <th><?php echo $this->lang->line('is_view_on_web'); ?></th>
                        <td><?php echo $teacher->is_view_on_web ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
     </div>
</div>