<h3>Installation Instructions</h3>
 <section>
            <div class="container">
                <div class="row">               
                    <div class="col-md-12 col-sm-12">
                        <hr />
                        <ol>
                            <li>Please follow each steps very well and accurately.</li>
                            <li><strong style="color: red;">Special Note:</strong> if you have ssl certificate for your domain, then please edit the following file application/config/config.php at 26th line with https instead of http</li>
                            
                            <li><strong>File For Localhost:</strong> Place the downloaded zip file to your local server <strong>xampp htdocs ( or your own folder inside htdocs)</strong> directory and  extract the uploaded zip file</li>
                            <li><strong>File For Live:</strong> Upload the downloaded zip file to your hosting server <strong>/public_html/</strong> directory. After complete upload then extract the uploaded zip file</li>
                            <li>Each requirements should be 100%, not try to skip any server requirements. Otherwise software will not run smoothly</li>
                            <li>Please input valid purchase code. Otherwise software will not run properly.</li>
                            <li><strong>Database For Localhost:</strong> Manually create a database from your localhost <strong>phpMyAdmin and Import database.sql file from documentation/database</strong></li>
                            <li><strong>Database For Live:</strong> Manually create a database from your server cpanel using <strong>MySql Database Wizard</strong>
                             and Create a user for the database and link that user to the created database with all necessary permissions and  Import database.sql file from documentation/database</li>
                            <li>Fill up	the information	like <strong>"hostname", "username", "password" and "database"</strong> with your created database information</li>
                            <li>Fill up	Super Admin information with valid email and phone</li>
                        </ol>
                    </div>
                </div>
            </div>
 </section>
<hr />
<?php echo form_open($this->uri->uri_string(), array('name' => 'instructions', 'id' => 'instructions', 'class'=>'form-horizontal form-label-left'), ''); ?>
<input type="hidden" name="instructions" id="instructions" value="instructions" />
<div class="text-right">
<button type="submit" class="btn btn-primary">Go Next!</button>
</div>
<?php  form_close(); ?>
