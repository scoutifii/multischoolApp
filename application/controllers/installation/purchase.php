<h3>Enter Purchase Code</h3>
<p>Please input valid purchase code. Otherwise software will not run properly.</p>
<section>
    <div class="container">
        <div class="row">               
            <div class="col-md-12 col-sm-12">
                <hr />
                <?php echo form_open($this->uri->uri_string(), array('name' => 'purchase', 'id' => 'purchase', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="form-group">
                    <label for="purchase_code">Purchase Code</label>
                    <input type="text" class="form-control required" name="purchase_code" id="purchase_code" autocomplete="off" />
                </div>
                <div class="text-right">
                    <input type="hidden" name="database" id="database" value="database" />
                    <button type="submit" class="btn btn-primary">Go Next</button>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>


