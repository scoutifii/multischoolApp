<h3>Database Connection</h3>

<section>
    <div class="container">
        <div class="row">               
            <div class="col-md-12 col-sm-12">
                <ol>
                    <li><strong>For Localhost:</strong> Manually create a database from your localhost <strong>phpMyAdmin </strong>  and  Import database.sql file from documentation/database</li>
                    <li><strong>For Live:</strong> Manually create a database from your server cpanel using <strong>MySql Database Wizard</strong>
                     and Create a user for the database and link that user to the created database with all necessary permissions  and  Import database.sql file from documentation/database</li>
                    <li>Fill up	the information	like <strong>"hostname", "username", "password" and "database"</strong> with your created database information</li>
                </ol>
            </div>
        </div>
        <div class="row">               
            <div class="col-md-12 col-sm-12">
                <hr />
                <?php echo form_open($this->uri->uri_string(), array('name' => 'dbform', 'id' => 'dbform', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="form-group">
                    <label for="hostname">MySQL Hostname</label>
                    <input type="text" class="form-control required" name="hostname" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label for="database">Database Name</label>
                    <input type="text" class="form-control required" name="dbname" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="username">Database Username</label>
                    <input type="text" class="form-control required" name="username" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Database Password</label>
                    <input type="text" class="form-control" name="password" autocomplete="off">
                </div>
                <div class="text-right">
                    <input type="hidden" name="purchase_code" id="purchase_code" value="<?php echo $purchase_code; ?>" />
                    <input type="hidden" name="superadmin" id="superadmin" value="superadmin" />
                    <button type="submit" class="btn btn-primary">Go Next</button>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>


