<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $ebook->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $ebook->name; ?></td>
        </tr>
             
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $ebook->class_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('edition'); ?></th>
            <td><?php echo $ebook->edition; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('author'); ?></th>
            <td><?php echo $ebook->author; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('language'); ?></th>
            <td><?php echo $ebook->language; ?></td>
        </tr>    
        <tr>
            <th><?php echo $this->lang->line('book_cover'); ?></th>
            <td>
                <?php if($ebook->cover_image){ ?>
                <img src="<?php echo UPLOAD_PATH; ?>/ebook/<?php echo $ebook->cover_image; ?>" alt="" width="100" /><br/><br/>
                <?php } ?>
            </td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('e_book'); ?></th>
            <td>
                <?php if($ebook->file_name){ ?>
                <a  target="_blank" href="<?php echo UPLOAD_PATH; ?>/ebook/<?php echo $ebook->file_name; ?>" class="btn btn-success btn-xs"> <i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/>
                <?php } ?>
            </td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('upload'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($ebook->created_at)); ?></td>
        </tr>       
    </tbody>
</table>