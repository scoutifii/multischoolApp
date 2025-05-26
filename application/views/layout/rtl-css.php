<style type="text/css">
    <?php if($this->global_setting->enable_rtl){ ?>
    
        *, *:before, *:after {
            box-sizing: border-box;
            direction: rtl;
        }
        
        .header-top {   
            text-align: left;
            padding-left: 25px;
        }
        .rtl,
        .event-for span,
        .event-place span,
        .event-date span,
        .event-info span,
        .list-unstyled .left-part,
        .right-pane ul li strong,
        .footer-contact-info .icon{
            float:right;
        }
        
        .more-link,
        .main-menu ul {
            direction: rtl;
            text-align:left !important;
        }        
        
        .detail-notice,
        .right-pane h3,
        .news-content h2,
        .event-for,
        .event-place, 
        .event-date, 
        .event-info {
            text-align: right;
        }
        
        .field-title{
            float: none;
        }
        .row{
            direction:rtl;
        }
        
        .page-title,
        .widget-title,
        .right-pane ul li,
        .contact-form form{
            direction:rtl;
            text-align: right;
        }
    
        .main-menu ul li.manutoggle a{
            margin-right: 70px;
        }
          
        <?php if($this->session->userdata('theme') == 'lime-green'){ ?>
    
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #9eff8b;
            }
            .nav-md ul.nav.child_menu li:after {
                 border-right: 1px solid #9eff8b;
             }             

        <?php }elseif($this->session->userdata('theme') == 'black'){ ?>
                
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #000000;
            }               
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
                
        <?php }elseif($this->session->userdata('theme') == 'dark-orange'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #f3dec6;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'deep-pink'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #e292bd;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'dodger-blue'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #006eda;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'light-sea-green'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #35fff4;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
                
        <?php }elseif($this->session->userdata('theme') == 'maroon'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #f79c9c;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'medium-purple'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #d6d2de;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'orchid'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #ff00f5;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'rebecca-purple'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #c081ff;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'red'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #fb8888;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'slate-gray'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #c3c3c3;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'dark-khaki'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #c3b091;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
        <?php }?>
         
        
    <?php }else{ ?>
                
        <?php if($this->session->userdata('theme') == 'lime-green'){ ?>
                
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #9eff8b;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #fdfdfd;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'black'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #000000;
            }               
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
        
        <?php }elseif($this->session->userdata('theme') == 'dark-orange'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #f3dec6;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'deep-pink'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #e292bd;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'dodger-blue'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #006eda;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'light-sea-green'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #35fff4;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'maroon'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #f79c9c;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'medium-purple'){ ?>
            
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #d6d2de;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'orchid'){ ?>
            
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #ff00f5;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'rebecca-purple'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #c081ff;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'red'){ ?>
            
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #fb8888;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }
            
        <?php }elseif($this->session->userdata('theme') == 'slate-gray'){ ?>
            
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-right: 5px solid #c3c3c3;
            }
            .nav-md ul.nav.child_menu li:after {
                border-left: 1px solid #ffffff;
            }

        <?php }elseif($this->session->userdata('theme') == 'dark-khaki'){ ?>
            
            .nav.side-menu>li.current-page, 
            .nav.side-menu>li.active,
            .nav-sm .nav.side-menu li.active-sm {
                border-left: 5px solid #c3b091;
            }
            .nav-md ul.nav.child_menu li:after {
                border-right: 1px solid #ffffff;
            }
            <?php } ?>

    <?php } ?>


</style>
