<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Date Helper Example</h1>               
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-md-12">
        <?php
        // Show server side messages
        if (isset($alert_message)) {
            $html_alert_ui = '';
            $html_alert_ui.='<div class="alert-container">';
            $html_alert_ui.='<div class="auto-closable-alert alert ' . $alert_message_css . ' alert-dismissable">';
            $html_alert_ui.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html_alert_ui.=$alert_message;
            $html_alert_ui.='</div>';
            $html_alert_ui.='</div>';
            echo $html_alert_ui;
        }
        ?>              
    </div>
</div><!--/.row-->


<div class="row">
    <div class="col-md-12">                
            <h4>Now</h4>
            <?php echo now(); ?>
    </div>    

    <div class="col-md-12">
        <h4>Time Zone Menu</h4>
        <?php echo timezone_menu(); ?>
    </div>


    <div class="col-md-12">
        <h4>unix_to_human</h4>
        <?php
        $now = time();
        echo unix_to_human($now); // U.S. time, no seconds
        echo '<br>';
        echo unix_to_human($now, TRUE, 'us'); // U.S. time with seconds
        echo '<br>';
        echo unix_to_human($now, TRUE, 'eu'); // Euro time with seconds
        ?>
    </div>

</div>
