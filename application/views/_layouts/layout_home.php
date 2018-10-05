<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $el_html_head; ?>
    <!-- Core Bootstrap CSS with customized (theme) style should be loaded first -->
    <link href="<?php echo base_url('assets/dist/css/styles.css');?>" rel="stylesheet">
	
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">    
    <!-- jQuery DataTables Core CSS -->    
    <link href="<?php //echo base_url('assets/vendors/datatables.net-dt/css/jquery.dataTables.css');?>" rel="stylesheet">
    <!-- Bootstrap 4 DataTables CSS -->    
    <link href="<?php echo base_url('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css');?>" rel="stylesheet">
	<!--Select 2 CSS-->
	<link href="<?php echo base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet" />
	<!--Date Picker-->
	<link href="<?php echo base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');?>" rel="stylesheet" />

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'); ?>"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'); ?>"></script>
    <![endif]-->
</head>

<body data-controller="<?php echo $this->router->class; ?>" data-method="<?php echo $this->router->method; ?>">
	
	
	<?php echo $el_navbar; ?>
    
    <main role="main">
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-3">Hello, world!</h1>
                <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
                <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>
            </div><!--/.container-->
        </div><!--/.jumbotron-->
        

        <div class="container">
            <div class="row my-2">
                <div class="col-12">
                    <div id="demo" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ul>
                    <div class="carousel-inner w-100 h-100">
                        <div class="carousel-item active">
                            <img src="<?php echo base_url('assets/src/img/carousel/1.jpg');?>">
                            <div class="carousel-caption">
                                <h3>Some title goes here...</h3>
                                <p>Some text, another text...</p>
                            </div>   
                        </div><!--/.carousel-item-->

                        <div class="carousel-item">
                            <img src="<?php echo base_url('assets/src/img/carousel/2.jpg');?>">
                            <div class="carousel-caption">
                                <h3>Darjeeling</h3>
                                <p>We miss you!</p>
                            </div>   
                        </div><!--/.carousel-item-->

                        <div class="carousel-item">
                            <img src="<?php echo base_url('assets/src/img/carousel/3.jpg');?>">
                            <div class="carousel-caption">
                                <h3>Some title goes here...</h3>
                                <p>Some text, another text...</p>
                            </div>   
                        </div><!--/.carousel-item-->

                    </div><!--/.carousel-inner-->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                    </div>
                </div><!--/.col-->
            </div><!--/.row-->

            <div class="row">
                <div class="col-12"><?php echo $maincontent; ?></div>
            </div><!--/.row-->			
        </div> <!-- /container -->
    </main>
	
	<footer class="footer">
        <?php echo $el_footer; ?>
    </footer>

	<button class="btn btn-primary scrollup"><i aria-hidden="true" class="fa fa-arrow-up"></i></button>
	<div class="ajax-loader-ui" id="ajax-loader" style="display:none;"><img src="<?php echo base_url('assets/src/img/ajax-loader.svg');?>" class="ajax-loader-img" alt="Loading..."></div>

    
	<!-- jQuery -->    
	<script type="text/javascript" src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js'); ?>"></script>	
    <!-- Bootstrap dependency popper.js -->
    <script src="<?php echo base_url('assets/vendors/popper.js/dist/umd/popper.min.js'); ?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
	
	
	<!-- jQuery DataTables Core JavaScript -->
    <script src="<?php echo base_url('assets/vendors/datatables.net/js/jquery.dataTables.js'); ?>"></script>    
    <!-- Bootstrap4 DataTables JavaScript -->
    <script src="<?php echo base_url('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.js'); ?>"></script>    
	<!--Select 2-->
    <script src="<?php echo base_url('assets/vendors/select2/dist/js/select2.min.js');?>"></script>	
	<!-- Datepicker JS -->
	<script src="<?php echo base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>	
	<!-- Pace JS for page load progress -->
	<script src="<?php echo base_url('assets/vendors/pace-js/pace.min.js'); ?>"></script>
	
	<!-- CKEditor -->
	<script src="<?php echo base_url('assets/vendors/ckeditor5-build-classic/build/ckeditor.js'); ?>"></script>
	
	<!--Application Specific JS Loading Through Controllers-->
    <?php echo isset($app_js) ? $app_js : ''; ?>
</body>
</html>