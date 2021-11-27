 <?php
 	

include $_SERVER['DOCUMENT_ROOT'].'/admin/components/adm_head.php' ;
echo '<body class="wysihtml5-supported">

    <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="hidden-lg pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                        <span class="sr-only">Р РЋР Р†Р ВµРЎР‚Р Р…РЎС“РЎвЂљРЎРЉ</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                        <span class="sr-only">Toggle sidebar</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-left-custom">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="'.$_SESSION['avatarfull'].'" alt="">
                            <span> '.$_SESSION['personaname'].'</span>
                        
                        </a>
                        
                    </li>
                  
                </ul>




				</div>
				
			
				
           

          
        </div>
    </div>
    <!-- /navbar -->




    <!-- Page header -->
    <div class="container-fluid">
	
        <div class="page-header">
           
			<div class="panel-body" style=" width: 400px; left: 285px; top: 36px; position: absolute; ">

                            
                            
                            
                            
                            
                            
                            
                        </div>
            <ul class="middle-nav">
	
            
            </ul>
        </div>
    </div>
    <!-- /page header -->


    <!-- Page container -->
    <div class="page-container container-fluid">
    	
    	<!-- Sidebar -->
        <div class="sidebar collapse">
        	<ul class="navigation">
            	<li><a href="/admin/"><i class="fa fa-home "></i>Главная</a></li>
				<li><a href="/sys/profile.php?UPDATE=game"><i class="fa fa-cloud-upload"></i>Update DB</a></li>
				<li><a href="/admin/spot/"><i class="fa fa-pencil-square-o"></i>SPOTs sittings</a></li>
					<li><a href="/"><i class="fa fa-gamepad"></i>Сайт</a></li>
               
            
             
                <li><a href="#" class="expand level-closed"><i class="fa fa-user"></i>Пользователи</a>
                	<ul style="display: none;">
					 <li><a href="/admin/users">Пользователи</a></li>
				
                    </ul>
                </li>
                
            </ul>
			
			
			<div class="col-md-6" style=" width: 260px; right: 15px; top: 10px; ">



                </div>
			
			
			
        </div>
        <!-- /sidebar -->
		
		

    
        <!-- Page content -->
        <div class="page-content">

            <!-- Page title -->
        	<div class="page-title">
                <h5><i class="fa fa-bars"></i>  '.$_SESSION['personaname'].' <small>, Добро пожаловать ! </small></h5>
                
            </div>
            <!-- /page title -->';
			
?>