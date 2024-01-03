<?php

function timestamp_to_date_italian($month_number)
    {       
        $months_italian = array(
                '01' => 'Gennaio', 
                '02' => 'Febbraio', 
                '03' => 'Marzo', 
                '04' => 'Aprile',
                '05' => 'Maggio', 
                '06' => 'Giugno', 
                '07' => 'Luglio', 
                '08' => 'Agosto',
                '09' => 'Settembre', 
                '10' => 'Ottobre', 
                '11' => 'Novembre',
                '12' => 'Dicembre');

              
        return $months_italian[$month_number];

    }

/* function timestamp_to_day_name_italia($name_day_today){
    $name_day_italian = array(
        'Mon' => 'Lunedì',
        'Tue' => 'Martedì',
        'Wed' => 'Mercoledì', 
        'Thu' => 'Giovedì',
        'Fri' => 'Venerdì',
        'Sat' => 'Sabato',
        'Sun' => 'Domenica'
    );
    return $name_day_italian[$name_day_today];
} */
    $day_today = date('d');
    $months_today = timestamp_to_date_italian(date("m"));
    $years_today = date('Y');
    /* $name_day_today = date("D");
    $name_today_for_opening_hours = timestamp_to_day_name_italia($name_day_today); */
?>
<div class="site-header_top-bar">
    <div class="container">
        <div class="row">
            <div class="text-centered">
            Oggi <span class="day"><?php echo $day_today; ?></span> <span class="month"><?php echo $months_today; ?></span> <span class="year"><?php echo $years_today; ?></span> siamo aperti 9.30 - 19.30

            </div>
            <?php @include('social-network.php');?>
        </div>
    </div>
</div>
<!-- /.site-header_top-bar -->