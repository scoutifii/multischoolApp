<div class="modal fade bs-invoice-modal-lg no-print_" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header  no-print">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
          <div class="col-md-12 col-sm-12 col-xs-12 text-center" style="font-weight: bold;margin-top: 01px;">
            <p class="red"><?php echo $this->session->userdata('error'); ?></p>
            <p class="green"><?php echo $this->session->userdata('success'); ?></p>
        </div>
          <div class="modal-body fn_invoice_data" style="padding-top: 30px;"></div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_invoice_modal(invoice_id){
       
        $('.fn_news_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('accounting/invoice/get_single_invoice'); ?>",
          data   : {invoice_id:invoice_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_invoice_data').html(response);
             }
          }
       });
    }
    
    <?php if(isset($invoice_id)){ ?>
        $(document).ready(function() {
            $('.bs-invoice-modal-lg').modal('show'); 
            get_invoice_modal(<?php echo $invoice_id; ?>);
        });
    <?php } ?>
    
</script>
<style>
    @media print {
    body.modalprinter * {
        visibility: hidden;
    }

    body.modalprinter .modal-dialog.focused {
        position: absolute;
        padding: 0;
        margin: 0;
        left: 0;
        top: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content {
        border-width: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body * {
        visibility: visible;
        width: 100%;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body {
        padding: 0;
        width: 100%;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title {
        margin-bottom: 20px;
    }
}
</style>
<script>
  $().ready(function () {
    $('.modal.printable').on('shown.bs.modal', function () {
        $('.modal-dialog', this).addClass('focused');
        $('body').addClass('modalprinter');

    }).on('hidden.bs.modal', function () {
        $('.modal-dialog', this).removeClass('focused');
        $('body').removeClass('modalprinter');
    });
  });
</script>
