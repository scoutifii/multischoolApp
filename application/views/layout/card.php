<?php if(isset($setting) && !empty($setting)){ ?>
<style type="text/css">
    @media print {
        
    .card-block{       
        border: 1px dashed <?php echo isset($setting->border_color) && $setting->border_color != '' ? $setting->border_color : 'lightgray'; ?> !important;        
    }
    
    .card-top{       
        background-color: <?php echo isset($setting->top_bg) && $setting->top_bg != '' ? $setting->top_bg : '#F1F1F1'; ?> !important; 
        background-size: 100% 100% !important;
        -webkit-print-color-adjust: exact !important; 
        color-adjust: exact !important; 
    } 
    
    .card-school h2{
        color: <?php echo isset($setting->school_name_color) && $setting->school_name_color != '' ? $setting->school_name_color : '#FFFFFF'; ?> !important;                  
        font-size: <?php echo isset($setting->school_name_font_size) && $setting->school_name_font_size != '' ? $setting->school_name_font_size : '24'; ?>px !important;                  
    }
    .card-school p{
        color: <?php echo isset($setting->school_address_color) && $setting->school_address_color != '' ? $setting->school_address_color : '#FFFFFF'; ?> !important;                  
    }

    /* id no start*/
    .std-id{
        width: 100%;
        text-align: center;
    }
    .std-id span{
        color: <?php echo isset($setting->id_no_color) && $setting->id_no_color != '' ? $setting->id_no_color : '#303030'; ?> !important;                  
        background-color: <?php echo isset($setting->id_no_bg) && $setting->id_no_bg != '' ? $setting->id_no_bg : '#343434'; ?> !important;                   
    }

    
    /* card body part  */    
    .card-info p .card-title{       
        color: <?php echo isset($setting->title_color) && $setting->title_color != '' ? $setting->title_color : '#303030'; ?> !important;                  
    }
    .card-info p .card-value{      
         color: <?php echo isset($setting->value_color) && $setting->value_color != '' ? $setting->value_color : '#303030'; ?> !important;       
    }

    /* bottom part */
    .card-bottom{       
        background-color: <?php echo isset($setting->bottom_bg) && $setting->bottom_bg != '' ? $setting->bottom_bg : '#f1f1f1'; ?> !important;       
        background-size: 100% 100% !important;
        -webkit-print-color-adjust: exact !important; 
        color-adjust: exact !important; 
    }  

    .card-bottom p{
        text-align: <?php echo isset($setting->bottom_text_align) && $setting->bottom_text_align != '' ? $setting->bottom_text_align : 'center'; ?>;       
        color: <?php echo isset($setting->bottom_text_color) && $setting->bottom_text_color != '' ? $setting->bottom_text_color : '#ffffff'; ?> !important;       
    }
}

@media all { 
    .card-block{       
        border: 1px dashed <?php echo isset($setting->border_color) && $setting->border_color != '' ? $setting->border_color : 'lightgray'; ?>;        
    }

    .card-top{ 
        background-color: <?php echo isset($setting->top_bg) && $setting->top_bg != '' ? $setting->top_bg : '#F1F1F1'; ?>;                  
    }
    
    .card-school h2{
        font-size: <?php echo isset($setting->school_name_font_size) && $setting->school_name_font_size != '' ? $setting->school_name_font_size : '20'; ?>px;       
        color: <?php echo isset($setting->school_name_color) && $setting->school_name_color != '' ? $setting->school_name_color : '#FFFFFF'; ?>;                  
    }
    .card-school p{
        color: <?php echo isset($setting->school_address_color) && $setting->school_address_color != '' ? $setting->school_address_color : '#FFFFFF'; ?>;                  
    }

    /* id no start*/
    .std-id{
        width: 100%;
        text-align: center;
    }
     .std-id h3{
        padding: 0;
        margin: 0px;
    }
    .std-id span{
        font-size: <?php echo isset($setting->id_no_font_size) && $setting->id_no_font_size != '' ? $setting->id_no_font_size : '14'; ?>px;       
        color: <?php echo isset($setting->id_no_color) && $setting->id_no_color != '' ? $setting->id_no_color : '#303030'; ?>;                  
        background-color: <?php echo isset($setting->id_no_bg) && $setting->id_no_bg != '' ? $setting->id_no_bg : '#id_no_bg'; ?>;                  
    }

    
    /* card body part  */    
    .card-info p .card-title{       
        font-size: <?php echo isset($setting->title_font_size) && $setting->title_font_size != '' ? $setting->title_font_size : '11'; ?>px;       
        color: <?php echo isset($setting->title_color) && $setting->title_color != '' ? $setting->title_color : '#303030'; ?>;                  
    }
    .card-info p .card-value{      
         font-size: <?php echo isset($setting->value_font_size) && $setting->value_font_size != '' ? $setting->value_font_size : '11'; ?>px;       
         color: <?php echo isset($setting->value_color) && $setting->value_color != '' ? $setting->value_color : '#303030'; ?>;       
    }

    /* bottom part */
    .card-bottom{      
        background-color: <?php echo isset($setting->bottom_bg) && $setting->bottom_bg != '' ? $setting->bottom_bg : '#f1f1f1'; ?>;
    }

    .card-bottom p{
        text-align: <?php echo isset($setting->bottom_text_align) && $setting->bottom_text_align != '' ? $setting->bottom_text_align : 'center'; ?>;       
        color: <?php echo isset($setting->bottom_text_color) && $setting->bottom_text_color != '' ? $setting->bottom_text_color : '#ffffff'; ?>;       
    }
}

</style>
<?php } ?>



<?php if(isset($admit_setting) && !empty($admit_setting)){ ?>
<style type="text/css">
    @media print {
        
    .admit-card-block{       
        border: 3px dashed <?php echo isset($admit_setting->border_color) && $admit_setting->border_color != '' ? $admit_setting->border_color : 'lightgray'; ?> !important;        
    }
    
    .admit-card-top{       
        background-color: <?php echo isset($admit_setting->top_bg) && $admit_setting->top_bg != '' ? $admit_setting->top_bg : '#F1F1F1'; ?> !important; 
        background-size: 100% 100% !important;
        -webkit-print-color-adjust: exact !important; 
        color-adjust: exact !important; 
    } 
    
    .admit-card-school h2{
        color: <?php echo isset($admit_setting->school_name_color) && $admit_setting->school_name_color != '' ? $admit_setting->school_name_color : '#FFFFFF'; ?> !important;                  
        font-size: <?php echo isset($admit_setting->school_name_font_size) && $admit_setting->school_name_font_size != '' ? $admit_setting->school_name_font_size : '30'; ?>px !important;                  
    }
    .admit-card-school p{
        color: <?php echo isset($admit_setting->school_address_color) && $admit_setting->school_address_color != '' ? $admit_setting->school_address_color : '#FFFFFF'; ?> !important;                  
    }

    /* admit start*/
    .admit-card{
        width: 100%;
        text-align: center;
    }
    .admit-card span{
        font-size: <?php echo isset($admit_setting->admit_font_size) && $admit_setting->admit_font_size != '' ? $admit_setting->admit_font_size : '20'; ?>px !important;                  
        color: <?php echo isset($admit_setting->admit_color) && $admit_setting->admit_color != '' ? $admit_setting->admit_color : '#303030'; ?> !important;                  
        background-color: <?php echo isset($admit_setting->admit_bg) && $admit_setting->admit_bg != '' ? $admit_setting->admit_bg : '#343434'; ?> !important;                   
    }

    
    /* card body part  */    
    .admit-card-info p .admit-card-title{       
        font-size: <?php echo isset($admit_setting->title_font_size) && $admit_setting->title_font_size != '' ? $admit_setting->title_font_size : '11'; ?>px !important;                  
        color: <?php echo isset($admit_setting->title_color) && $admit_setting->title_color != '' ? $admit_setting->title_color : '#303030'; ?> !important;                  
    }
    .admit-card-info p .admit-card-value{  
        font-size: <?php echo isset($admit_setting->value_font_size) && $admit_setting->value_font_size != '' ? $admit_setting->value_font_size : '11'; ?>px !important;                  
        color: <?php echo isset($admit_setting->value_color) && $admit_setting->value_color != '' ? $admit_setting->value_color : '#303030'; ?> !important;       
    }
    
    .admit-exam{  
        font-size: <?php echo isset($admit_setting->exam_font_size) && $admit_setting->exam_font_size != '' ? $admit_setting->exam_font_size : '16'; ?>px !important;                  
        color: <?php echo isset($admit_setting->exam_color) && $admit_setting->exam_color != '' ? $admit_setting->exam_color : '#303030'; ?> !important;       
    }
    .exam-subjects ol li{  
        font-size: <?php echo isset($admit_setting->subject_font_size) && $admit_setting->subject_font_size != '' ? $admit_setting->subject_font_size : '12'; ?>px !important;                  
        color: <?php echo isset($admit_setting->subject_color) && $admit_setting->subject_color != '' ? $admit_setting->subject_color : '#3943cc'; ?> !important;       
    }

    /* bottom part */
    .admit-card-bottom{       
        background-color: <?php echo isset($admit_setting->bottom_bg) && $admit_setting->bottom_bg != '' ? $admit_setting->bottom_bg : '#cacaca'; ?> !important;       
        background-size: 100% 100% !important;
        -webkit-print-color-adjust: exact !important; 
        color-adjust: exact !important; 
    }  

    .admit-card-bottom p{
        text-align: <?php echo isset($setting->bottom_text_align) && $setting->bottom_text_align != '' ? $setting->bottom_text_align : 'center'; ?>;       
        color: <?php echo isset($setting->bottom_text_color) && $setting->bottom_text_color != '' ? $setting->bottom_text_color : '#ffffff'; ?> !important;       
    }
}


@media all { 
        .admit-card-block{       
        border: 3px dashed <?php echo isset($admit_setting->border_color) && $admit_setting->border_color != '' ? $admit_setting->border_color : 'lightgray'; ?> !important;        
    }
    
    .admit-card-top{       
        background-color: <?php echo isset($admit_setting->top_bg) && $admit_setting->top_bg != '' ? $admit_setting->top_bg : '#F1F1F1'; ?> !important; 
        background-size: 100% 100% !important;
        -webkit-print-color-adjust: exact !important; 
        color-adjust: exact !important; 
    } 
    
    .admit-card-school h2{
        color: <?php echo isset($admit_setting->school_name_color) && $admit_setting->school_name_color != '' ? $admit_setting->school_name_color : '#FFFFFF'; ?> !important;                  
        font-size: <?php echo isset($admit_setting->school_name_font_size) && $admit_setting->school_name_font_size != '' ? $admit_setting->school_name_font_size : '30'; ?>px !important;                  
    }
    .admit-card-school p{
        color: <?php echo isset($admit_setting->school_address_color) && $admit_setting->school_address_color != '' ? $admit_setting->school_address_color : '#FFFFFF'; ?> !important;                  
    }

    /* admit start*/
    .admit-card{
        width: 100%;
        text-align: center;
    }
    .admit-card span{
        font-size: <?php echo isset($admit_setting->admit_font_size) && $admit_setting->admit_font_size != '' ? $admit_setting->admit_font_size : '20'; ?>px !important;                  
        color: <?php echo isset($admit_setting->admit_color) && $admit_setting->admit_color != '' ? $admit_setting->admit_color : '#303030'; ?> !important;                  
        background-color: <?php echo isset($admit_setting->admit_bg) && $admit_setting->admit_bg != '' ? $admit_setting->admit_bg : '#343434'; ?> !important;                   
    }

    
    /* card body part  */    
    .admit-card-info p .admit-card-title{       
        font-size: <?php echo isset($admit_setting->title_font_size) && $admit_setting->title_font_size != '' ? $admit_setting->title_font_size : '11'; ?>px !important;                  
        color: <?php echo isset($admit_setting->title_color) && $admit_setting->title_color != '' ? $admit_setting->title_color : '#303030'; ?> !important;                  
    }
    .admit-card-info p .admit-card-value{  
        font-size: <?php echo isset($admit_setting->value_font_size) && $admit_setting->value_font_size != '' ? $admit_setting->value_font_size : '11'; ?>px !important;                  
        color: <?php echo isset($admit_setting->value_color) && $admit_setting->value_color != '' ? $admit_setting->value_color : '#303030'; ?> !important;       
    }
    
    .admit-exam{  
        font-size: <?php echo isset($admit_setting->exam_font_size) && $admit_setting->exam_font_size != '' ? $admit_setting->exam_font_size : '16'; ?>px !important;                  
        color: <?php echo isset($admit_setting->exam_color) && $admit_setting->exam_color != '' ? $admit_setting->exam_color : '#303030'; ?> !important;       
    }
    .exam-subjects ol li{  
        font-size: <?php echo isset($admit_setting->subject_font_size) && $admit_setting->subject_font_size != '' ? $admit_setting->subject_font_size : '12'; ?>px !important;                  
        color: <?php echo isset($admit_setting->subject_color) && $admit_setting->subject_color != '' ? $admit_setting->subject_color : '#3943cc'; ?> !important;       
    }

    /* bottom part */
    .admit-card-bottom{       
        background-color: <?php echo isset($admit_setting->bottom_bg) && $admit_setting->bottom_bg != '' ? $admit_setting->bottom_bg : '#cacaca'; ?> !important;       
        background-size: 100% 100% !important;
        -webkit-print-color-adjust: exact !important; 
        color-adjust: exact !important; 
    }  

    .admit-card-bottom p{
        text-align: <?php echo isset($setting->bottom_text_align) && $setting->bottom_text_align != '' ? $setting->bottom_text_align : 'center'; ?>;       
        color: <?php echo isset($setting->bottom_text_color) && $setting->bottom_text_color != '' ? $setting->bottom_text_color : '#ffffff'; ?> !important;       
    }
}

</style>
<?php } ?>