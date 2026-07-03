<ul class="sessionul fixedmenu">
    <?php
    if ($this->rbac->hasPrivilege('quick_session_change', 'can_view')): ?>
        <li class="removehover">
            <a data-toggle="modal" data-target="#sessionModal"><?= lang('App.current_session') . ": " . $this->setting_model->getCurrentSessionName(); ?><i class="fa fa-pencil pull-right"></i></a>
        </li>
    <?php endif; ?>
    <li class="dropdown">
        <a class="dropdown-toggle drop5" data-toggle="dropdown" href="#" aria-expanded="false">
            <?= lang('App.quick_links'); ?> <span class="glyphicon glyphicon-th pull-right"></span>
        </a>
        <ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">
            <?php if ($this->rbac->hasPrivilege('student', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>student/search"><i class="fa fa-user-plus"></i><?= lang('App.student_details'); ?></a></li>

            <?php endif; ?> 
            <?php if ($this->rbac->hasPrivilege('collect_fees', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>studentfee"><i class="fa fa-money"></i><?= lang('App.collect_fees'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('income', 'can_add')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/income"> &nbsp;<i class="fa fa-usd"></i> <?= lang('App.add_income'); ?></a></li>
            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('expense', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/expense"><i class="fa fa-credit-card"></i><?= lang('App.add_expense'); ?></a></li>

            <?php endif; ?> 
            <?php if ($this->rbac->hasPrivilege('student_attendance', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/stuattendence"><i class="fa fa-calendar-check-o"></i><?= lang('App.student_attendance'); ?></a></li>

                <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('staff_attendance', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/staffattendance"><i class="fa fa-calendar-check-o"></i><?= lang('App.staff_attendance'); ?></a></li>

            <?php endif; ?> 
            <?php if ($this->rbac->hasPrivilege('staff', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/staff"><i class="fa fa-calendar-check-o"></i><?= lang('App.staff_directory'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('exam', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/exam"><i class="fa fa-map-o"></i><?= lang('App.exam_list'); ?></a></li>

                <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('exam_schedule', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/examschedule"><i class="fa fa-columns"></i><?= lang('App.exam_schedule'); ?></a></li>

                <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('class_timetable', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/timetable"><i class="fa fa-calendar-times-o"></i><?= lang('App.class_timetable'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_view')): ?>           
                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/enquiry"><i class="fa fa-calendar-check-o"></i><?= lang('App.admission_enquiry'); ?></a></li>
                <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('complaint', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/complaint"><i class="fa fa-calendar-check-o"></i><?= lang('App.complain'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('upload_content', 'can_view')): ?>
                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/content"><i class="fa fa-download"></i><?= lang('App.upload_content'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('item_stock', 'can_add')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/itemstock"><i class="fa fa-object-group"></i><?= lang('App.add_item_stock'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('notice_board', 'can_view')): ?>

                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/notification"><i class="fa fa-bullhorn"></i><?= lang('App.notice_board'); ?></a></li>

            <?php endif; ?>
            <?php if ($this->rbac->hasPrivilege('email_sms', 'can_view')): ?>
                <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="<?= esc(base_url()) ?>admin/mailsms/compose"><i class="fa fa-envelope-o"></i><?= lang('App.send_email_/_sms'); ?></a></li>
            <?php endif; ?>
        </ul>
    </li>
</ul>  
