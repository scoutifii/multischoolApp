 <table id="datatable-responsive" class="table table-striped table-condensed table-hover" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('region'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $district->region_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subregion'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $district->sub_region_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $district->district_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('code'); ?></th>
            <td><?php echo $district->district_code; ?></td>
        </tr>
      
    </tbody>
</table>
