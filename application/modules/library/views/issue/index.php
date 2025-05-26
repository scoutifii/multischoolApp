<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-book"></i><small> <?php echo $this->lang->line('manage_issue_and_return'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_issue_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'library', 'issue')){ ?>
                            <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_issue"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('new_issue'); ?></a> </li>                          
                        <?php } ?>
                       
                       <li class="li-class-list">
                           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_book_list_by_school(this.value);">
                                        <option value="<?php echo site_url('library/issue/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('library/issue/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>  
                        </li>      
                            
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_issue_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('photo'); ?></th>
                                        <th><?php echo $this->lang->line('student'); ?></th>
                                        <th><?php echo $this->lang->line('title'); ?></th>
                                        <th><?php echo $this->lang->line('book_id'); ?></th>
                                        <th><?php echo $this->lang->line('issue_date'); ?></th>
                                        <th><?php echo $this->lang->line('due_date'); ?></th>
                                        <th><?php echo $this->lang->line('return_date'); ?></th>
                                        <th><?php echo $this->lang->line('book_cover'); ?></th>
                                        <th><?php echo $this->lang->line('day'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                   
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($issue_books) && !empty($issue_books)){ ?>
                                        <?php foreach($issue_books as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td>
                                                <?php  if($obj->photo != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="70" /> 
                                                <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="70" /> 
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $obj->name; ?></td>
                                            <td><?php echo $obj->title; ?></td>
                                            <td><?php echo $obj->custom_id; ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->issue_date)); ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->due_date)); ?></td>
                                            <td><?php echo $obj->return_date && $obj->return_date != '0000-00-00' ? date($this->global_setting->date_format, strtotime($obj->return_date)) : ''; ?></td>
                                            <td>
                                                <?php  if($obj->cover != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/book-cover/<?php echo $obj->cover; ?>" alt="" width="70" /> 
                                                <?php } ?>
                                            </td>
                                            <td>
                                             <?php echo floor((strtotime($obj->due_date)-strtotime($obj->issue_date))/86400); ?>
                                            </td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'library', 'issue')){ ?>
                                                    <?php if($obj->is_returned){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-success btn-xs"><i class="fa fa-retweet"></i> <?php echo $this->lang->line('return'); ?> </a>
                                                    <?php }else{ ?>
                                                        <?php if(has_permission(EDIT, 'library', 'issue')){ ?>
                                                        <a href="javascript:void(0);" onclick="return_book_by_id('<?php echo $obj->issue_id; ?>', '<?php echo $obj->id; ?>');" class="btn btn-info btn-xs"><i class="fa fa-share"></i> <?php echo $this->lang->line('return_this'); ?></a>
                                                        <?php } ?>
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

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_issue">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('library/issue/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?> 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="book_id"><?php echo $this->lang->line('book'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 fn_get_book" name="book_id" id="book_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            <?php if(isset($books) && !empty($books)){ ?>
                                                <?php foreach($books as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>"><?php echo $obj->title; ?> [<?php echo $obj->custom_id; ?>]</option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('book_id'); ?></div>
                                    </div>
                                </div>               
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="isbn_no"><?php echo $this->lang->line('isbn_no'); ?>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="isbn_no"  id="isbn_no" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('isbn_no'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('isbn_no'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edition"><?php echo $this->lang->line('edition'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="edition"  id="edition" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('edition'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('edition'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="author"><?php echo $this->lang->line('author'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="author"  id="author" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('author'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('author'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="language"><?php echo $this->lang->line('language'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="language"  id="language" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('language'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('language'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"><?php echo $this->lang->line('price'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="price"  id="price" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('price'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('price'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty"><?php echo $this->lang->line('quantity'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="qty"  id="qty" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('quantity'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('qty'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rack_no"><?php echo $this->lang->line('almira_rack'); ?> 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="rack_no"  id="rack_no" value="" readonly="readonly" placeholder="<?php echo $this->lang->line('almira_rack'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('rack_no'); ?></div>
                                    </div>
                                </div>
                                
                               <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('book_cover'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="cover" >
                                        <img src=""  alt="" width="70" />
                                    </div>
                               </div>
                               
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date"><?php echo $this->lang->line('return_date'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="due_date"  id="due_date" value="" required="required"  placeholder="<?php echo $this->lang->line('return_date'); ?>"  type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('due_date'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="member_id"><?php echo $this->lang->line('library'); ?> <?php echo $this->lang->line('member'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="library_member_id" id="library_member_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                           <?php if(isset($members) && !empty($members)){ ?>
                                                <?php foreach($members as $obj){ ?>
                                                    <option value="<?php echo $obj->lm_id; ?>"><?php echo $obj->name; ?> [<?php echo $obj->custom_member_id; ?>]</option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('library_member_id'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('library/issue/index'); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="fn_send" type="submit" class="btn btn-success"><?php echo $this->lang->line('issue'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 
 <!-- Super admin js START  -->
 <script type="text/javascript">
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val(); 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('library/issue/get_book_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                     
                   $('#book_id').html(response);                                    
                   get_library_member_by_school(school_id);
               }
            }
        });
    }); 
    
    
    function get_library_member_by_school(school_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('library/issue/get_library_member_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   $('#library_member_id').html(response);                    
               }
            }
        });
    }
    
  </script>
<!-- Super admin js end -->

 
 <script type="text/javascript">
 
  $('#due_date').datepicker();
     
      $(document).ready(function(){
          
        $('.fn_get_book').change(function(){
           
          var book_id  = $(this).val();           
          
          $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('library/issue/get_book_by_id'); ?>",
            data   : { book_id : book_id},               
            async  : false,
            dataType: 'json',
            success: function(response){ 
                if(response){
                   
                    $('#isbn_no').val(response.isbn_no);
                    $('#edition').val(response.edition);
                    $('#author').val(response.author);
                    $('#language').val(response.language);
                    $('#price').val(response.price);
                    if(response.qty > 0){
                        $('#qty').val(response.qty);
                    }else{
                        $('#qty').val('Out of Stock');
                        $('#fn_send').hide('slow');
                    }                    
                    $('#rack_no').val(response.rack_no);                    
                    $('#cover img').attr('src', '<?php echo UPLOAD_PATH; ?>/book-cover/'+response.cover);                    
                   
                }else{
                    $("input[type=text]").val('');
                    $('#cover img').attr('src', '');
                    toastr.error('<?php echo $this->lang->line('unexpected_error'); ?>'); 
                }
            }
        }); 
                      
       });       
   });
   
   function return_book_by_id(issue_id, book_id){       
           
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('library/issue/return_book_by_id'); ?>",
            data   : { issue_id : issue_id, book_id : book_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  toastr.success('<?php echo $this->lang->line('return_success'); ?>'); 
                  location.reload();
               }
            }
        });  
   }
</script>

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
    
    function get_book_list_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    } 
    
</script>