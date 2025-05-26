<h3>Super Admin Information</h3>
<p>Fill up Super Admin information with valid email, phone and good username</p>
<section>
    <div class="container">
        <div class="row">               
            <div class="col-md-12 col-sm-12">            
                <?php echo form_open($this->uri->uri_string(), array('name' => 'superadmin', 'id' => 'superadmin', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                                                
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control required" name="name" id="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control required email" name="email" id="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control required" name="phone" id="phone" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control required" name="username" id="username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control required" name="password" id="password" autocomplete="off">
                    </div>                   
                    <div class="form-group">
                        <label for="conf_password">Confirm Password</label>
                        <input type="password" class="form-control required" name="conf_password" id="conf_password" autocomplete="off">
                    </div>
                    <div class="text-right">
                        <input type="hidden" name="purchase_code" id="purchase_code" value="<?php echo $purchase_code; ?>" />
                        <input type="hidden" name="installation" id="installation" value="installation">
                        <button type="submit" class="btn btn-primary">Go Next!</button>
                    </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>


