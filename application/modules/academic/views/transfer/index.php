<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mail-forward"></i><small> <?php echo $this->lang->line('manage_teacher_transfer'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <!-- Loading Indicator -->
            <div id="loading-indicator" class="alert alert-info" style="display:none;">
                <i class="fa fa-spinner fa-spin"></i> <?php echo $this->lang->line('loading'); ?>...
            </div>
            
            <div class="x_content quick-link">
              <div class="well">
                 <?php $this->load->view('quick-link'); ?>
              </div>
            </div>
           
            <div class="x_content">                 
                <?php echo form_open_multipart(site_url('academic/transfer/add'), array('name' => 'transfer', 'id' => 'transfer', 'class' => 'form-horizontal form-label-left'), ''); ?>
                
                <div class="row">                    
                    <?php $this->load->view('layout/school_filter'); ?>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('teacher'); ?> <span class="required">*</span></div>
                            <select class="form-control col-md-7 col-xs-12" name="teacher_id" id="teacher_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($teachers) && !empty($teachers)) { ?>
                                    <?php foreach ($teachers as $obj) { ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($teacher_id) && $teacher_id == $obj->id){ echo 'selected="selected"';} ?>>
                                            <?php echo ucfirst($obj->name); ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block text-danger"><?php echo form_error('teacher_id'); ?></div>
                        </div>
                    </div>
                    
                    <?php $this->load->view('layout/school_list_filter'); ?> 
                    
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <?php if(has_permission(ADD, 'academic', 'transfer')) { ?>
                                <button id="transfer-btn" type="submit" class="btn btn-success">
                                    <i class="fa fa-mail-forward"></i> <?php echo $this->lang->line('teacher_transfer'); ?>
                                </button>
                            <?php } ?>
                            <!-- <button id="search-btn" type="submit" class="btn btn-success">
                                <i class="fa fa-mail-forward"></i> <?php echo $this->lang->line('transfer'); ?>
                            </button> -->
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('name'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>
                            <th><?php echo $this->lang->line('phone'); ?></th>                         
                            <th><?php echo $this->lang->line('original_school'); ?></th>
                            <th><?php echo $this->lang->line('current_school'); ?></th>
                            <!-- <th><?php echo $this->lang->line('school_option'); ?></th> -->
                        </tr>
                    </thead>
                    <tbody>   
                        <?php $count = 1; if (isset($transfers) && !empty($transfers)) { ?>
                            <?php foreach($transfers as $obj){ ?>
                            <tr>
                                <td><?php echo $count++;  ?></td>
                                <td><?php echo ucfirst($obj->teacher); ?></td>
                                <td>
                                    <?php if ($obj->photo != '') { ?>
                                        <img src="<?php echo UPLOAD_PATH; ?>/teacher-photo/<?php echo $obj->photo; ?>" alt="" width="50" /> 
                                    <?php } else { ?>
                                        <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="50" /> 
                                    <?php } ?>
                                    <input type="hidden" value="<?php echo $obj->id; ?>"  name="transfers[]" />
                                </td>
                                <td><?php echo $obj->phone; ?></td>                                
                                <td><?php echo $obj->original_school; ?></td>
                                <td><?php echo $obj->current_school; ?></td>
                                
                            </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="12" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>             
            </div> 
             
        </div>
    </div>
</div>

<script type="text/javascript">
    /**
     * Teacher Transfer Module - Improved JavaScript
     * Features: Better error handling, modern async/await, validation, and user feedback
     */
    
    // Wait for document ready
    $(document).ready(function() {
        initializeTransferModule();
    });

    /**
     * Initialize module on page load
     */
    function initializeTransferModule() {
        // Trigger school change if school_id exists
        <?php if(isset($school_id) && !empty($school_id)) { ?>
            $('#school_id').trigger('change');
        <?php } ?>
        
        // Initialize form validation
        $('#transfer').validate();
        $('#add').validate();
        
        // Hide error labels initially
        $('#datatable-responsive').on('init.dt', function() {
            hideValidationErrors();
        });
    }

    /**
     * Handle school change event
     */
    $('#school_id').on('change', function() {
        const schoolId = $(this).val();
        
        if (!schoolId) {
            toastr.error('<?php echo addslashes($this->lang->line("select_school")); ?>');
            return false;
        }
        
        // Get stored values if editing existing transfer
        const currentClassId = '<?php if(isset($current_class_id)) echo $current_class_id; ?>';
        const nextClassId = '<?php if(isset($next_class_id)) echo $next_class_id; ?>';
        const currentSessionId = '<?php if(isset($current_session_id)) echo $current_session_id; ?>';
        const nextSessionId = '<?php if(isset($next_session_id)) echo $next_session_id; ?>';
        const teacherId = '<?php if(isset($teacher_id)) echo $teacher_id; ?>';
        
        // Show loading indicator
        showLoadingIndicator(true);
        
        // Load data in parallel using Promise.all for better performance
        Promise.all([
            getDataBySchool('<?php echo site_url("ajax/get_class_by_school"); ?>', schoolId, currentClassId, 'current'),
            getDataBySchool('<?php echo site_url("ajax/get_class_by_school"); ?>', schoolId, nextClassId, 'next'),
            getDataBySchool('<?php echo site_url("ajax/get_current_session_by_school"); ?>', schoolId, currentSessionId, 'current_session'),
            getDataBySchool('<?php echo site_url("ajax/get_next_session_by_school"); ?>', schoolId, nextSessionId, 'next_session'),
            getTeacherBySchool(schoolId, teacherId)
        ])
        .then(() => {
            showLoadingIndicator(false);
            toastr.success('<?php echo addslashes($this->lang->line("data_loaded_successfully")); ?>');
        })
        .catch(error => {
            showLoadingIndicator(false);
            console.error('Error loading data:', error);
            toastr.error('<?php echo addslashes($this->lang->line("error_loading_data")); ?>');
        });
    });

    /**
     * Get data for class/session by school using AJAX
     * @param {string} url - API endpoint
     * @param {string} schoolId - School ID
     * @param {string} selectedId - Selected item ID
     * @param {string} type - Type of data (current, next, current_session, next_session)
     * @returns {Promise}
     */
    function getDataBySchool(url, schoolId, selectedId, type) {
        return new Promise((resolve, reject) => {
            let data = { school_id: schoolId };
            let targetSelector = '';
            
            // Prepare data based on type
            switch(type) {
                case 'current':
                    data.class_id = selectedId;
                    targetSelector = '#current_class_id';
                    break;
                case 'next':
                    data.class_id = selectedId;
                    targetSelector = '#next_class_id';
                    break;
                case 'current_session':
                    data.current_session_id = selectedId;
                    targetSelector = '#current_session_id';
                    break;
                case 'next_session':
                    data.academic_year_id = selectedId;
                    targetSelector = '#next_session_id';
                    break;
            }
            
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'html',
                timeout: 10000,
                success: function(response) {
                    if (response && targetSelector) {
                        $(targetSelector).html(response);
                        resolve();
                    } else {
                        reject(new Error('Empty response for ' + type));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error (' + type + '):', status, error);
                    reject(new Error('AJAX Error: ' + error));
                }
            });
        });
    }

    /**
     * Get teachers for selected school
     * @param {string} schoolId - School ID
     * @param {string} teacherId - Pre-selected teacher ID
     * @returns {Promise}
     */
    function getTeacherBySchool(schoolId, teacherId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("ajax/get_teacher_by_school"); ?>',
                data: { 
                    school_id: schoolId, 
                    teacher_id: teacherId 
                },
                dataType: 'html',
                timeout: 10000,
                success: function(response) {
                    if (response) {
                        $('#teacher_id').html(response);
                        resolve();
                    } else {
                        reject(new Error('Empty teacher response'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error (Teacher):', status, error);
                    reject(new Error('AJAX Error: ' + error));
                }
            });
        });
    }

    /**
     * Show/hide loading indicator
     * @param {boolean} show - Whether to show indicator
     */
    function showLoadingIndicator(show) {
        const indicator = $('#loading-indicator');
        if (show) {
            indicator.slideDown(200);
        } else {
            indicator.slideUp(200);
        }
    }

    /**
     * Hide validation error messages
     */
    function hideValidationErrors() {
        $('#datatable-responsive label.error').hide();
    }

    /**
     * Validate form submission
     */
    $('#add').on('submit', function(e) {
        const $form = $(this);
        
        // Disable submit button to prevent double submission
        const $submitBtn = $form.find('#transfer-btn');
        const originalText = $submitBtn.html();
        $submitBtn.prop('disabled', true)
                  .html('<i class="fa fa-spinner fa-spin"></i> <?php echo addslashes($this->lang->line("processing")); ?>...');
        
        // Re-enable button after 3 seconds (safety timeout)
        setTimeout(function() {
            $submitBtn.prop('disabled', false)
                      .html(originalText);
        }, 3000);
    });

</script>

<style>
    /* Hide validation error labels for better UX */
    #datatable-responsive label.error {
        display: none !important;
    }
    
    /* Style for loading indicator */
    #loading-indicator {
        margin: 15px;
        padding: 12px 15px;
        border-radius: 4px;
    }
    
    /* Improve image thumbnails */
    .img-thumbnail {
        padding: 4px;
        background-color: #f5f5f5;
    }
    
    /* Button hover effects */
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
</style>

