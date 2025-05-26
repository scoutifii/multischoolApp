<div class="row">
    <div class="col-sm-12">
        <div class="ebook">
            <div id="pdffile"></div>
        </div>
    </div> <!-- col-sm-12 -->
</div>

<script src="<?php echo VENDOR_URL; ?>pdfjs/pdfobject.min.js"></script> 
<script type="text/javascript">
    var options = {
        pdfOpenParams: { view: 'Fit', pagemode: 'none', scrollbar: '1', toolbar: '1', statusbar: '1', messages: '1', navpanes: '1' }
    };
    PDFObject.embed("<?php echo UPLOAD_PATH; ?>/ebook/<?php echo $ebook->file_name; ?>", "#pdffile");
</script>

<style>
    #pdffile embed {
        width: 100% !important;
        height: 600px !important;
    }
</style>