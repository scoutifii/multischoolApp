 <table id="datatable-responsive" class="table table-striped table-condensed table-hover" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('region_name'); ?></th>
            <td><?php echo $village->region_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subregion'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $village->sub_region_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('district_name'); ?></th>
            <td><?php echo $village->district_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subcounty'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $village->sub_county_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $village->village_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('code'); ?></th>
            <td><?php echo $village->village_code; ?></td>
        </tr>
      
    </tbody>
</table>
