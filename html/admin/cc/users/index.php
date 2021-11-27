<?php

@include_once $_SERVER['DOCUMENT_ROOT'].('/sys/api.php');
		if(!isset($_SESSION["steamid"])) {
					steamlogin();
}
else
{
@include_once $_SERVER['DOCUMENT_ROOT'].('/sys/api.php');
$login = $_SESSION["steamid"];
$sql = "SELECT *
FROM `account` WHERE `steamid` LIKE '$login'";
$result = mysql_query($sql);
$row = mysql_fetch_object($result);
if ($row->admin !== '1') {

echo 'Ты посмел зайти в админ панель без админки ? ДикиЙ выезжает за тобой !' ;	

}
else{
	
	
include $_SERVER['DOCUMENT_ROOT'].'/admin/components/head.php';
echo '

			
		
 <!-- Bordered datatable inside panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Пользователи</h6></div>
                <div class="datatable">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                 <th>id</th>
								  <th>Steam id</th>
                                <th>Ник</th>
                                <th>Трейд ссылка</th>
                                <th>Выиграл</th>
								 <th>Админ</th>
								  <th>Аватар</th>
								   <th>Игр</th>
                            </tr>
                        </thead>
                        <tbody>
                           ';
                          

$rs = mysql_query("SELECT * FROM `account` ORDER BY `id` ");
while($row = mysql_fetch_array($rs)) {


if (empty($row["id"]))
{
	

}	
else
{						 
	echo '<tr>';
	 echo '   <td>'.$row["id"].'</td>';
                             echo '   <td>'.$row["steamid"].'</td>';
                             echo '   <td>'.$row["name"].'</td>';
                               echo ' <td>'.$row["tlink"].'</td>';
                               echo ' <td>'.$row["won"].'$</td>';
							   
					echo ' <td>'.$row["admin"].'</td>';
					
	

									 echo ' <td> <img src="'.$row["avatar"].'" style="
    width: 30px;
    align-content: center;
" alt ></td>';
									     echo ' <td>'.$row["games"].'</td>';
                          echo '  </tr>';
							echo '</tr>';


}

}
                           
                     	echo ' 
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /bordered datatable inside panel -->
		
            
         
			
	
             
			
			
			
   

        </div>
    </div>



</body></html>

';



}

}
?>