<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('admission_form'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('admission_form'); ?></a></li>
        </ul>
    </div>
</section>

<section class="page-contact-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="admission-form">
                    <div class="row"> 
                        <div class="col-md-10 col-sm-10 col-xs-12 ">
                            <div class="admission-address">
                                <div><h3><?php echo $school->school_name; ?></h3></div>                                
                                <div><?php echo $school->address; ?></div>
                                <div><?php echo $school->phone; ?></div>
                                <div><?php echo $school->email; ?></div>
                                <div><h4><?php echo $this->lang->line('admission_form'); ?></h4></div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <span class="student-picture"><?php echo $this->lang->line('photo'); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><hr></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('basic_information'); ?>:</strong></p> </div>
                    </div>  
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('name'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('birth_date'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>                                              
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('gender'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>                    
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('blood_group'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">                                           
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('religion'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('caste'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">                                           
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('email'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>   
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('phone'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>   
                    </div>
                    <div class="row">                                           
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('national_id'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>   
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('health_condition'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>   
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('address_information'); ?>:</strong></p> </div>
                    </div>                      
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('present_address'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('permanent_address'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('academic_information'); ?>:</strong></p> </div>
                    </div>                     
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('student_type'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('class'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('group'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('second_language'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                                     
                                        
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('father_information'); ?>:</strong></p> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('father_name'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('father_phone'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('father_education'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('father_profession'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('father_designation'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>                        
                    </div>
                    
                        
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('mother_information'); ?>:</strong></p> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('mother_name'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('mother_phone'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('mother_education'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('mother_profession'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('mother_designation'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('other_information'); ?>:</strong></p> </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('email'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('health_condition'); ?> :</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('previous_school'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('previous_class'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('other_info'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                                     
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('guardian_information'); ?>:</strong></p> </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('guardian_name'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('relation_with_guardian'); ?> :</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('guardian_phone'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('email'); ?> :</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('religion'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('profession'); ?> :</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('national_id'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('present_address'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('permanent_address'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('other_info'); ?>:</div> 
                                <div class="field-value"></div> 
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>         
        </div>
        <div class="row no-print">
            <div class="col-md-12 col-sm-12 text-center margin-top">
                <button class="btn btn-info glbscl-link-btn hvr-bs" onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                <a  class="btn btn-info glbscl-link-btn hvr-bs"  href="<?php echo site_url('admission-online'); ?>"><?php echo $this->lang->line('online_admission'); ?></a>
            </div>
        </div>
    </div>
</section>
