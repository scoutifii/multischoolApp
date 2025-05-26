<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-dollar"></i><small> <?php echo $this->lang->line('manage_salary_grade'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                <?php $this->load->view('quick-link'); ?>                 
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_grade_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'payroll', 'grade')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('payroll/grade/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_grade"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_grade"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>
                        
                        <li class="li-class-list">
                       <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                            <select  class="form-control col-md-7 col-xs-12" onchange="get_grade_by_school(this.value);">
                                    <option value="<?php echo site_url('payroll/grade/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                <?php foreach($schools as $obj ){ ?>
                                    <option value="<?php echo site_url('payroll/grade/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                <?php } ?>   
                            </select>
                        <?php } ?>  
                        </li>       
                            
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_grade_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('grade_name'); ?></th>
                                        <th><?php echo $this->lang->line('basic_salary'); ?></th>
                                        <th><?php echo $this->lang->line('hourly_rate'); ?></th>
                                        <th><?php echo $this->lang->line('gross_salary'); ?></th>
                                        <th><?php echo $this->lang->line('net_salary'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($grades) && !empty($grades)){ ?>
                                        <?php foreach($grades as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->grade_name; ?></td>
                                            <td><?php echo $obj->basic_salary; ?></td>
                                            <td><?php echo $obj->hourly_rate; ?></td>
                                            <td><?php echo $obj->gross_salary; ?></td>
                                            <td><?php echo $obj->net_salary; ?></td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'payroll', 'grade')){ ?>
                                                    <a href="<?php echo site_url('payroll/grade/edit/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(VIEW, 'payroll', 'grade')){ ?>
                                                    <a  onclick="get_grade_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-grade-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'payroll', 'grade')){ ?>
                                                    <a href="<?php echo site_url('payroll/grade/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_grade">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('payroll/grade/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                 
                                <div class="row">
                                    
                                    <?php $this->load->view('layout/school_list_filter'); ?> 
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="grade_name"><?php echo $this->lang->line('grade_name'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="grade_name"  id="add_grade_name" value="<?php echo isset($post['grade_name']) ?  $post['grade_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('grade_name'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('grade_name'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="basic_salary"><?php echo $this->lang->line('basic_salary'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="basic_salary"  id="add_basic_salary" value="<?php echo isset($post['basic_salary']) ?  $post['basic_salary'] : ''; ?>" placeholder="<?php echo $this->lang->line('basic_salary'); ?>" required="required" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('basic_salary'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="house_rent"><?php echo $this->lang->line('house_rent'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="house_rent"  id="add_house_rent" value="<?php echo isset($post['house_rent']) ?  $post['house_rent'] : ''; ?>" placeholder="<?php echo $this->lang->line('house_rent'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('house_rent'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="transport"><?php echo $this->lang->line('transport_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="transport"  id="add_transport" value="<?php echo isset($post['transport']) ?  $post['transport'] : ''; ?>" placeholder="<?php echo $this->lang->line('transport_allowance'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('transport'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="medical"><?php echo $this->lang->line('medical_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="medical"  id="add_medical" value="<?php echo isset($post['medical']) ?  $post['medical'] : ''; ?>" placeholder="<?php echo $this->lang->line('medical_allowance'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('medical'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="over_time_hourly_rate"><?php echo $this->lang->line('over_time_hourly_rate'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="over_time_hourly_rate"  id="add_over_time_hourly_rate" value="<?php echo isset($post['over_time_hourly_rate']) ?  $post['over_time_hourly_rate'] : ''; ?>" placeholder="<?php echo $this->lang->line('over_time_hourly_rate'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('over_time_hourly_rate'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="provident_fund"><?php echo $this->lang->line('provident_fund'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="provident_fund"  id="add_provident_fund" value="<?php echo isset($post['provident_fund']) ?  $post['provident_fund'] : ''; ?>" placeholder="<?php echo $this->lang->line('provident_fund'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('provident_fund'); ?></div>
                                        </div>
                                    </div>
                               </div>   
                               <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="hourly_rate"><?php echo $this->lang->line('hourly_rate'); ?> <span class=""></span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="hourly_rate"  id="add_hourly_rate" value="<?php echo isset($post['hourly_rate']) ?  $post['hourly_rate'] : ''; ?>" placeholder="<?php echo $this->lang->line('hourly_rate'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('hourly_rate'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="total_allowance"><?php echo $this->lang->line('total_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="total_allowance"  id="add_total_allowance" value="<?php echo isset($post['total_allowance']) ?  $post['total_allowance'] : ''; ?>" placeholder="<?php echo $this->lang->line('total_allowance'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('total_allowance'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="total_deduction"><?php echo $this->lang->line('total_deduction'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="total_deduction"  id="add_total_deduction" value="<?php echo isset($post['total_deduction']) ?  $post['total_deduction'] : ''; ?>" placeholder="<?php echo $this->lang->line('total_deduction'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('total_deduction'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="gross_salary"><?php echo $this->lang->line('gross_salary'); ?>  </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="gross_salary"  id="add_gross_salary" value="<?php echo isset($post['gross_salary']) ?  $post['gross_salary'] : ''; ?>" placeholder="<?php echo $this->lang->line('gross_salary'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('gross_salary'); ?></div>
                                        </div>
                                    </div>
                               </div>  
                                <div class="row">   
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="net_salary"><?php echo $this->lang->line('net_salary'); ?>  </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_add_claculate"  name="net_salary"  id="add_net_salary" value="<?php echo isset($post['net_salary']) ?  $post['net_salary'] : ''; ?>" placeholder="<?php echo $this->lang->line('net_salary'); ?>" type="number" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('net_salary'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                            <label for="note"><?php echo $this->lang->line('note'); ?>  </label>
                                            <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('note'); ?></div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('payroll/grade/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_grade">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('payroll/grade/edit/'.$grade->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                                                                                
                                <div class="row">
                                    
                                    <?php $this->load->view('layout/school_list_edit_form'); ?>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="grade_name"><?php echo $this->lang->line('grade_name'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="grade_name"  id="edit_grade_name" value="<?php echo isset($grade->grade_name) ?  $grade->grade_name : ''; ?>" placeholder="<?php echo $this->lang->line('grade_name'); ?>" required="required" type="text"  autocomplete="off">
                                            <div class="help-block"><?php echo form_error('grade_name'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="basic_salary"><?php echo $this->lang->line('basic_salary'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="basic_salary"  id="edit_basic_salary" value="<?php echo isset($grade->basic_salary) ?  $grade->basic_salary : ''; ?>" placeholder="<?php echo $this->lang->line('basic_salary'); ?>" required="required" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('basic_salary'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="house_rent"><?php echo $this->lang->line('house_rent'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="house_rent"  id="edit_house_rent" value="<?php echo isset($grade->house_rent) ?  $grade->house_rent : ''; ?>" placeholder="<?php echo $this->lang->line('house_rent'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('house_rent'); ?></div>
                                        </div>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="transport"><?php echo $this->lang->line('transport_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="transport"  id="edit_transport" value="<?php echo isset($grade->transport) ?  $grade->transport : ''; ?>" placeholder="<?php echo $this->lang->line('transport_allowance'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('transport'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="medical"><?php echo $this->lang->line('medical_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="medical"  id="edit_medical" value="<?php echo isset($grade->medical) ?  $grade->medical : ''; ?>" placeholder="<?php echo $this->lang->line('medical_allowance'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('medical'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="over_time_hourly_rate"><?php echo $this->lang->line('over_time_hourly_rate'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="over_time_hourly_rate"  id="edit_over_time_hourly_rate" value="<?php echo isset($grade->over_time_hourly_rate) ?  $grade->over_time_hourly_rate : ''; ?>" placeholder="<?php echo $this->lang->line('over_time_hourly_rate'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('over_time_hourly_rate'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="provident_fund"><?php echo $this->lang->line('provident_fund'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="provident_fund"  id="edit_provident_fund" value="<?php echo isset($grade->provident_fund) ?  $grade->provident_fund : ''; ?>" placeholder="<?php echo $this->lang->line('provident_fund'); ?>" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('provident_fund'); ?></div>
                                        </div>
                                    </div>
                                </div>    
                                    
                                <div class="row">    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="hourly_rate"><?php echo $this->lang->line('hourly_rate'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="hourly_rate"  id="edit_hourly_rate" value="<?php echo isset($grade->hourly_rate) ?  $grade->hourly_rate : ''; ?>" placeholder="<?php echo $this->lang->line('hourly_rate'); ?>" required="required" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('hourly_rate'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="total_allowance"><?php echo $this->lang->line('total_allowance'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="total_allowance"  id="edit_total_allowance" value="<?php echo isset($grade->total_allowance) ?  $grade->total_allowance : ''; ?>" placeholder="<?php echo $this->lang->line('total_allowance'); ?>"  readonly="readonly" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('total_allowance'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="total_deduction"><?php echo $this->lang->line('total_deduction'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="total_deduction"  id="edit_total_deduction" value="<?php echo isset($grade->total_deduction) ?  $grade->total_deduction : ''; ?>" placeholder="<?php echo $this->lang->line('total_deduction'); ?>"  readonly="readonly" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('total_deduction'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="gross_salary"><?php echo $this->lang->line('gross_salary'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="gross_salary"  id="edit_gross_salary" value="<?php echo isset($grade->gross_salary) ?  $grade->gross_salary : ''; ?>" placeholder="<?php echo $this->lang->line('gross_salary'); ?>" readonly="readonly" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('gross_salary'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="net_salary"><?php echo $this->lang->line('net_salary'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12 fn_edit_claculate"  name="net_salary"  id="edit_net_salary" value="<?php echo isset($grade->net_salary) ?  $grade->net_salary : ''; ?>" placeholder="<?php echo $this->lang->line('net_salary'); ?>"  readonly="readonly" type="number" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('net_salary'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                            <label for="note"><?php echo $this->lang->line('note'); ?></label>
                                            <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($grade->note) ?  $grade->note : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('note'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            
                                   
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($grade) ? $grade->id : $id; ?>" name="id" />
                                        <a  href="<?php echo site_url('payroll/grade/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>                    
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-grade-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_grade_data">
            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_grade_modal(grade_id){
         
        $('.fn_grade_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('payroll/grade/get_single_grade'); ?>",
          data   : {grade_id : grade_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_grade_data').html(response);
             }
          }
       });
    }
</script>


<!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
        
    $("#add").validate();     
    $("#edit").validate();   
    
    
    $('.fn_add_claculate').on('keyup', function(){
        
        var basic_salary = $('#add_basic_salary').val() ? parseFloat($('#add_basic_salary').val()) : 0;
        var house_rent = $('#add_house_rent').val() ? parseFloat($('#add_house_rent').val()) : 0;
        var transport = $('#add_transport').val() ? parseFloat($('#add_transport').val()): 0;
        var medical = $('#add_medical').val() ? parseFloat($('#add_medical').val()) : 0;
        var provident_fund = $('#add_provident_fund').val() ? parseFloat($('#add_provident_fund').val()) : 0;
        
       $('#add_total_allowance').val(house_rent+transport+medical);       
        var total_allowance = $('#add_total_allowance').val() ? parseFloat($('#add_total_allowance').val()) : 0;
        
        $('#add_total_deduction').val(provident_fund);
        var total_deduction = $('#add_total_deduction').val() ? parseFloat($('#add_total_deduction').val()) : 0;
        
        $('#add_gross_salary').val(basic_salary+total_allowance);
        $('#add_net_salary').val((basic_salary+total_allowance)-total_deduction);
        
    });
    
    $('.fn_edit_claculate').on('keyup', function(){
        
        var basic_salary = $('#edit_basic_salary').val() ? parseFloat($('#edit_basic_salary').val()) : 0;
        var house_rent = $('#edit_house_rent').val() ? parseFloat($('#edit_house_rent').val()) : 0;
        var transport = $('#edit_transport').val() ? parseFloat($('#edit_transport').val()): 0;
        var medical = $('#edit_medical').val() ? parseFloat($('#edit_medical').val()) : 0;
        var provident_fund = $('#edit_provident_fund').val() ? parseFloat($('#edit_provident_fund').val()) : 0;
        
       $('#edit_total_allowance').val(house_rent+transport+medical);       
        var total_allowance = $('#edit_total_allowance').val() ? parseFloat($('#edit_total_allowance').val()) : 0;
        
        $('#edit_total_deduction').val(provident_fund);
        var total_deduction = $('#edit_total_deduction').val() ? parseFloat($('#edit_total_deduction').val()) : 0;
        
        $('#edit_gross_salary').val(basic_salary+total_allowance);
        $('#edit_net_salary').val((basic_salary+total_allowance)-total_deduction);
        
    });
    
    function get_grade_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }  
    
</script>