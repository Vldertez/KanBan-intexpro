<?
include('nav.php');
	if(!isset($_GET['p'])){
		include 'calendar.php';
	} else {
	echo '<div class="main">
		<div class="content">';
		}
			//Добавление ученика
				if(isset($_GET['p']) && $_GET['p']=='addusers'){
					include "logic.php";
					echo "<h2>Добавление нового ученика</h2>";
					echo "<form method='POST' action='index.php?p=users'>";
					echo "<div class='container'>";
					echo "<div class='label'>";
					echo "<p>ФИО Родителя 1</p>";
					echo "<p>Телефон родителя 1</p>";
					echo "<p>Пароль</p>";
					echo "<p>ФИО ученика</p>";
					echo "<p>Телефон ученика</p>";
					echo "<p>Дата рождения ученика</p>";
					
					echo "</div>";
					echo "<div class='input'>";
					
					echo "<input type='text' name='nameParent1' required>";
					echo "<input type='text' name='phone1'>";
					echo "<input type='text' name='pass' value='".generPassword()."' placeholder='Пароль' required>";
					echo "<input type='text' name='fio' required>";
					echo "<input type='text' name='telStudent'>";
					echo "<input type='date' name='dateOfBirth'>";
					
					// echo "<input type='date' name='datepay' required>";
					
					// echo "</div></div>";
					// echo "<h3 class='subtitle'>Данные договора</h3>";
					// echo "<div class='container'>";
					// echo "<div class='label'>";
					
					// echo "<p>№ договора</p>";
					// echo "<p>Дата договора</p>";
					// echo "<p>ФИО представителя</p>";
					// echo "<p>Дата рождения представителя</p>";
					// echo "<p>ФИО ученика</p>";
					// echo "<p>Паспорт</p>";
					// echo "<p>Выдан</p>";
					// echo "<p>Место жительства</p>";
					// echo "<p>Зачислить в группу(ы)</p>";
					// echo "</div>";
					// echo "<div class='input'>";
					// echo "<input type='text' name='number' required>";
					// echo "<input type='date' name='date'>";
					// echo "<input type='text' name='name'>";
					// echo "<input type='date' name='date_birth_parent'>";
					// echo "<input type='text' name='child'>";
					// echo "<input type='text' name='passport'>";
					// echo "<input type='text' name='issued'>";
					// echo "<input type='text' name='residency'>";
					$year=nowYear();
				   $req="SELECT * FROM `groupuser` WHERE `year`=".$year." ORDER BY `name`";
				   $result = mysqli_query($link, $req);
				   $groups = array();
				   while($row = mysqli_fetch_assoc($result))
				   $groups[] = $row;
					echo "<ul class='ks-cboxtags'>";
					foreach ($groups as $td) {
					echo '<li><input type="checkbox" id="checkbox'.$td['id'].'" value="'.$td['id'].'" name="groups[]"><label for="checkbox'.$td['id'].'">'.$td['name'].'</label></li>';
					}
					echo "</ul>";
					echo "</div></div><input type='submit' value='Добавить' class='btn' name='okadduser'></form>";
				}
				if(isset($_POST['okadduser'])){
					include "logic.php";
					$nameParent1 = $_POST["nameParent1"];
					$login = createLogin($nameParent1, $link);
					
					// $nameParent2 = $_POST["nameParent2"];
					$passHash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
					$phone1 = $_POST["phone1"];
					// $phone2 = $_POST["phone2"];
					// $email = $_POST["email"];
					$sql = "INSERT INTO `parents` (name1, phone1, login, password)
						VALUES ('" . $nameParent1 . "', '" . $phone1 . "','" . $login . "', '" . $passHash . "')";
						mysqli_query($link,$sql) or die(mysqli_error($link));
				$result = mysqli_fetch_row(mysqli_query($link, "SELECT MAX(`id`) FROM `parents`"));
				$parentid = $result[0];
				echo $parentid;
				$file = fopen("out.txt", "a");
				fwrite($file, "\n" . $_POST['fio'] . "\nЛогин: " . $login . "\nПароль: " . $_POST['pass'] . "\n");
				echo "Логин: " . $login . "<br>" . "Пароль: " . $_POST['pass'];
				
					$request="INSERT INTO `users`(`contract`,`datacontract`, `fio`, `groupuser`, `telStudent`, `dateBirth`, `parent`) 
						VALUES (null,null,'".$_POST['fio']."',null,'".$_POST['telStudent']."','".$_POST['dateOfBirth']."','".$parentid."')";
					mysqli_query($link,$request) or die(mysqli_error($link));
					$result =mysqli_fetch_row( mysqli_query($link, "SELECT max(`id`) FROM `users`"));
					$thisid = $result[0];
					if (isset($_POST['groups'])) {
						$thisgroup=$_POST['groups'];
						for ($i=0; $i < count($thisgroup); $i++) { 
							$request="INSERT INTO `group_members`(`groupid`, `userid`) VALUES (".$thisgroup[$i].",".$thisid.")";
							mysqli_query($link,$request) or die(mysqli_error($link));
						}
				}
					
					echo "<script>window.location = 'index.php?p=users'</script>";	
				}
				//Добавление группы
				if(isset($_GET['p']) && $_GET['p']=='addgroup'){
					$result = mysqli_query($link, "SELECT * FROM `courses`");
					$courses = array();
					while($row = mysqli_fetch_assoc($result))
					$courses[] = $row;

					$result = mysqli_query($link, "SELECT * FROM `admins` WHERE `status`=0 ORDER BY `initials`");
					$teachers = array();
					while($row = mysqli_fetch_assoc($result))
					$teachers[] = $row;

					$result = mysqli_query($link, "SELECT * FROM `office`");
					$office = array();
					while($row = mysqli_fetch_assoc($result))
					$office[] = $row;

					$result = mysqli_query($link, "SELECT * FROM `days-week`");
					$days_week = array();
					while($row = mysqli_fetch_assoc($result))
					$days_week[] = $row;

					echo "<h2>Добавление новой группы</h3>";
					echo "<form method='POST' action='#openconfirm'>";
					echo "<div class='container'>";
					echo "<div class='label'>";
					echo "<p>Название группы</p>";
					echo "<p>Название курса</p>";
					echo "<p>Адрес</p>";
					echo "<p>Кабинет</p>";
					echo "<p>Преподаватель</p>";
					echo "<p>Первый день</p>";
					echo "<p>Время первого дня</p>";
					echo "<p>Второй день</p>";
					echo "<p>Время второго дня</p>";
					echo "<p>Учебный год</p>";
					echo "</div>";
					echo "<div class='input'>";
					echo "<input type='text' name='name'>";

					echo "<select name='course'>
					<option></option>";
					foreach ($courses as $td) {
					echo "<option value=".$td['id'].">".$td['namecourse']."</option>";
					}
					echo "</select>";

					echo "<select name='address' class='group-address'>
					<option></option>";
					foreach ($office as $td) {
					echo "<option value=".$td['id'].">".$td['name']."</option>";
					}
					echo "</select>";

					echo "<select name='cabinet'>
					<option></option>";
					
					echo "</select>";

					echo "<select name='teachers'>
					<option></option>";
					foreach ($teachers as $td) {
					echo "<option value=".$td['id'].">".$td['initials']."</option>";
					}
					echo "</select>";

					echo "<select name='first-day'>
					<option></option>";
					foreach ($days_week as $td) {
					echo "<option value=".$td['id'].">".$td['name']."</option>";
					}
					echo "</select>
					<div class='time-input'>
						<input type='time' name='first-time-start'> - 
						<input type='time' name='first-time-end'>
					</div>
					<select name='second-day'>
						<option></option>";
						foreach ($days_week as $td) {
						echo "<option value=".$td['id'].">".$td['name']."</option>";
						}
					echo "</select>
					<div class='time-input'>
						<input type='time' name='second-time-start'> - 
						<input type='time' name='second-time-end'>
					</div>";
						$year=nowYear();
					   echo "<input type='text' name='year' value=$year>";
					   echo "<input type='hidden' name='days' value=null>";
					   echo "<input type='hidden' name='times' value=null>";
					echo "</div></div><input type='submit' value='Добавить' class='btn' name='okadd'></form>";
				}
				if(isset($_POST['okadd'])){
					mysqli_query($link,addRecord('groupuser',$_POST,false)) or die(mysqli_error($link));
					echo "<script>window.location = 'index.php?p=group'</script>";	
				}
				//Список учеников
				if(isset($_GET['p']) && $_GET['p']=='users'){
					
					echo "<h2>Список учеников</h2>";
					$req="SELECT distinct `year` FROM `groupuser` GROUP BY `year`";
					$result = mysqli_query($link, $req);
					$years = array();
					while($row = mysqli_fetch_assoc($result))
						$years[] = $row;
					echo "<div class='filters'> ";
					echo "<div class='inputs'><input type='text' class='input-filter' name='filter_group-year' placeholder='Учебный год' value='".nowYear()."'>
						<div class='listfind find_filter'><ul>";
					for ($i=0; $i < count($years); $i++) { 
						echo "<li id=".$years[$i]['year']."><a href='".$_SERVER['REQUEST_URI']."&year=".$years[$i]['year']."'>".$years[$i]['year']."</a></li>";
					}
					echo "</ul></div></div>";

					$req="SELECT `id`, `name` FROM `groupuser` WHERE `year`=".nowYear();
					$result = mysqli_query($link, $req);
					$names_group = array();
					while($row = mysqli_fetch_assoc($result))
						$names_group[] = $row;
					?>
					<div class='inputs'><input type='text' class='input-filter' name='filter_group-name' placeholder='Группа' value='<? echo isset($_GET['group']) ? $_GET['group'] : ""?>'>
					<?
						echo "<div class='listfind find_filter'><ul>";
					echo "<li id='no_group'><a href='".$_SERVER['REQUEST_URI']."&group=nogroup'>Без группы</a></li>";
					for ($i=0; $i < count($names_group); $i++) { 
						echo "<li id=".$names_group[$i]['id']."><a href='".$_SERVER['REQUEST_URI']."&group=".$names_group[$i]['id']."'>".$names_group[$i]['name']."</a></li>";
					}
					echo "</ul></div></div>";

					
					echo "</div>";
					echo "<div class='linkaddelement'>";
					echo "<a href='index.php?p=addusers' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить ученика</a>";
					echo "<a href='index.php?p=users#openimport' class='addelement'><i class='icon fa fa-file-excel-o fa-fw'></i> Импорт из Excel</a>";
					echo "</div>";
					echo "<div class='scroll scrolly'>";
					echo "<table class='fullwidth students'>";
					echo "<tr><th>Договор</th><th>Дата договора</th><th>ФИО</th><th>Группы</th><th>Номер телефона ученика</th><th>Дата рождения</th><th>Родитель 1</th><th>Номер телефона родителя 1</th><th>Действие</th></tr>";
					$year=nowYear();
					if (isset($_GET['group'])){
						if ($_GET['group'] !=='nogroup') 
							$in = "IN";
						 else $in = "NOT IN";
					}  else $in = "IN";
					$query="SELECT `u`.`id`,
					(SELECT `number` FROM `contracts` WHERE `id_user`=`u`.`id` AND `date`>'".$year."-08-01' AND `date`<'".($year+1)."-08-01' ORDER BY `u`.`id` DESC LIMIT 1) As `contracts`,
					(SELECT `date` FROM `contracts` WHERE `id_user`=`u`.`id` AND `date`>'".$year."-08-01' AND `date`<'".($year+1)."-08-01' ORDER BY `u`.`id` DESC LIMIT 1) As `date_contracts`,
					
					`u`.`fio`,`u`.`datepay`,`u`.`telStudent`,`u`.`dateBirth`,
					(SELECT `name1` FROM `parents` WHERE `id`=`u`.`parent`) As `parent`, 
					
					(SELECT `phone1` FROM `parents` WHERE `id`=`u`.`parent`) As `tel-parent`, 
					
					(SELECT GROUP_CONCAT(`name` separator ', ') FROM `groupuser` WHERE `id` IN (SELECT `groupid` FROM `group_members` WHERE  `userid`=`u`.`id`) AND `year`=".$year.") AS groups
					
					FROM `users` `u`
					WHERE `u`.`id` $in (SELECT `userid` 
					 FROM `group_members` 
					 WHERE `groupid` IN (
						 SELECT `id`
						 FROM `groupuser` 
						 WHERE `year`=".$year.")
					) ORDER BY `u`.`id` DESC";
					$result = mysqli_query($link, $query) or die(mysqli_error($link));
					$users = [];
						while($tr = mysqli_fetch_assoc($result))
						$users[] = $tr;
					foreach ($users as $row) {
						
					echo "<tr>";
					echo "<td class='leftp'>".$row['contracts']."</td><td class='leftp'>".$row['date_contracts']."</td><td class='leftp'>".$row['fio']."</td><td style='white-space:normal;'>".$row['groups']."</td><td>".$row['telStudent']."</td><td>".$row['dateBirth']."</td><td class='leftp'>".$row['parent']."</td><td>".$row['tel-parent']."</td>
					<td>
					<a href='index.php?p=contract&id=".$row['id']."'><i class='fa fa-file-text' aria-hidden='true'></i></a>
					<a href='index.php?p=users&ideditus=".$row['id']."#openedituser'><i class='fa fa-pencil' aria-hidden='true'></i></a>
					<i class='fa fa-trash fa-lg delete' id=users-".$row['id']."></i>
					</td>";
					echo "</tr>";
					}
					
				echo "</table>";
					echo "</div>";

					
					if(isset($_GET['ideditus'])){ //Редактирование ученика
						echo "<div id='openedituser' class='modalform'>
				  <div class='modal-dialogform'>
				    <div class='modal-contentform'>
				        <a href='#closeform' title='Close' class='closeform'>×</a>
				      <div class='modal-bodyform'>";
				      	$idus=$_GET['ideditus'];
						  $req ="SELECT * FROM `users` WHERE `id`=".$idus;
						  $user = mysqli_fetch_assoc(mysqli_query($link, $req) );
						  $idparent=$user['parent'];
						  $req ="SELECT * FROM `parents` WHERE `id`=".$idparent;
							$parent = mysqli_fetch_assoc(mysqli_query($link, $req) );
				 		echo "<h2>Редактирование ученика</h3>";
						echo "<form method='POST' action='index.php?p=users'>";
						echo "<div class='container'>";
						echo "<div class='label'>";
						echo "<p>Ученик</p>";
						echo "<p>Номер телефона ученика</p>";
						echo "<p>Дата рождения</p>";
						echo "<p>Родитель 1</p>";
						echo "<p>Номер телефона родителя 1</p>";
						echo "<p>Родитель 2</p>";
						echo "<p>Номер телефона родителя 2</p>";
						echo "<p>Email родителя</p>";
						echo "<p>Пароль</p>";
						echo "<p>Дата начала оплаты</p>";
						echo "</div>";
						echo "<div class='input'>";
						echo "<input type='text' name='fio' value='".$user['fio']."'>";
						echo "<input type='text' name='telStudent' value='".$user['telStudent']."'>";
						echo "<input type='date' name='dateOfBirth' value='".$user['dateBirth']."'>";
						
						echo "<input type='text' name='nameParent1' value='".$parent['name1']."'>";
						echo "<input type='text' name='phone1' value='".$parent['phone1']."'>";
						echo "<input type='text' name='nameParent2' value='".$user['name2']."'>";
						echo "<input type='text' name='phone2' value='".$parent['phone2']."'>";
						echo "<input type='text' name='email' value='".$parent['email']."'>";
						echo "<input type='text' name='pass' placeholder='Пароль'>";

						echo "<input type='date' name='datepay' value='".$user['datepay']."'>";
						echo "<input type='hidden' name='idchild' value='$idus'>";
						echo "<input type='hidden' name='idparent' value='$idparent'>";
						echo "</div></div><input type='submit' value='Сохранить' class='btn' name='okedituser'></form>";
				      echo"</div>
				    </div>
				  </div>
				</div>";
			}
			
				if(isset($_POST['okedituser'])){
		$request="UPDATE `users` SET `fio`='".$_POST['fio']."',`datepay`='".$_POST['datepay']."',`telStudent`='".$_POST['telStudent']."',`dateBirth`='".$_POST['dateOfBirth']."' WHERE id=".$_POST['idchild'];
		mysqli_query($link,$request) or die(mysqli_error($link));
		
		$request="UPDATE `parents` SET `name1`='".$_POST['nameParent1']."',`phone1`='".$_POST['phone1']."',`name2`='".$_POST['nameParent2']."',`phone2`='".$_POST['phone2']."',`email`='".$_POST['email']."'";
		if ($_POST['pass']) {
			$passHash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
			$request.=",`password`='".$passHash."'";
		}
		$idparent=$_POST['idparent'];
		$req ="SELECT `name1` FROM `parents` WHERE `id`=".$idparent;
		  $parent = mysqli_fetch_assoc(mysqli_query($link, $req) );
		  if ($parent['name1']!=$_POST['nameParent1']){
			include "logic.php";
			$login = createLogin($_POST['nameParent1'], $link);
			$request.=",`login`='".$login."'";
		  }
		$request.=" WHERE id=".$_POST['idparent'];
		mysqli_query($link,$request) or die(mysqli_error($link));
		echo "<script>window.location = 'index.php?p=users'</script>";	
	}
			}

			// список договоров
			if (isset($_GET['p']) && $_GET['p']=='contract'){
				
				$id = $_GET['id'];
				$req ="SELECT * FROM `contracts` WHERE `id_user`=".$id;
				$result = mysqli_query($link, $req)or die(mysqli_error($link));
				$contracts = array();
				while($tr = mysqli_fetch_assoc($result))
				$contracts[] = $tr;
				$req ="SELECT `fio` FROM `users` WHERE `id`=".$id;
				$result = mysqli_query($link, $req) or die(mysqli_error($link));
				$user = array();
				while($tr = mysqli_fetch_assoc($result))
				$user[] = $tr;
				$user=$user[0]['fio'];
				echo "<h2>Список договоров ученика $user</h2>";
				echo "<div class='linkaddelement'>";
				echo "<a href='index.php?p=addcontract&id=".$id."' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить договор</a>";
				// echo "<a href='index.php?p=users#openimport' class='addelement'><i class='icon fa fa-file-excel-o fa-fw'></i> Импорт из Excel</a>";
				echo "</div>";
				echo "<div class='scroll scrolly'>";
				echo "<table class='defaultwidth students'>";
				echo "<tr><th>Номер</th><th>Дата договора</th><th>ФИО представителя</th><th>Дата рождения представителя</th><th>ФИО ученика</th><th>Дата рождения</th><th>Паспорт</th><th>Выдан</th><th>Телефон</th><th>Место жительства</th><th>Действие</th></tr>";
				foreach ($contracts as $row) {	
					echo "<tr>";
					echo "<td>".$row['number']."</td><td>".$row['date']."</td><td class='leftp'>".$row['name']."</td><td class='leftp'>".$row['date_birth_parent']."</td><td>".$row['child']."</td><td>".$row['date_birth']."</td><td>".$row['passport']."</td><td>".$row['issued']."</td><td>".$row['phone']."</td><td>".$row['residency']."</td>
					<td><a href='index.php?p=ideditcontract&id=".$row['id']."'><i class='fa fa-pencil fa-lg'></i></a>
					<i class='fa fa-trash fa-lg delete' id=contracts-".$row['id']."></i></td>";
					echo "</tr>";
					
				}
				echo "</table>";
					echo "</div>";
					
			}
				//Добавление договора
			if(isset($_GET['p']) && $_GET['p']=='addcontract'){
				$id = $_GET['id'];
				$req ="SELECT * FROM `users` WHERE `id`=".$id;
				$result = mysqli_query($link, $req) or die(mysqli_error($link));
				$user = array();
				while($tr = mysqli_fetch_assoc($result))
				$user[] = $tr;
				$user_name=$user[0]['fio'];
				$req ="SELECT * FROM `parents` WHERE `id`=".$user[0]['parent'];
				$result = mysqli_query($link, $req) or die(mysqli_error($link));
				$parent = array();
				while($tr = mysqli_fetch_assoc($result))
				$parent[] = $tr;
				echo "<h2>Добавление нового договора ученику $user_name</h2>";
				echo "<form method='POST' action='index.php?p=contract&id=".$user[0]['id']."'>"; //
				echo "<div class='container'>";
				echo "<div class='label'>";
				echo "<p>№ договора</p>";
				echo "<p>Дата договора</p>";
				echo "<p>ФИО представителя</p>";
				echo "<p>Дата рождения представителя</p>";
				echo "<p>ФИО ученика</p>";
				echo "<p>Дата рождения</p>";
				echo "<p>Паспорт</p>";
				echo "<p>Выдан</p>";
				echo "<p>Телефон</p>";
				echo "<p>Место жительства</p>";
				echo "</div>";
				echo "<div class='input'>";
								
				echo "<input type='text' name='number' required>";
				echo "<input type='date' name='date'>";
				echo "<input type='text' name='name' value='".$parent[0]['name1']."'>";
				echo "<input type='date' name='date_birth_parent'>";
				echo "<input type='text' name='child' value='".$user[0]['fio']."'>";
				echo "<input type='date' name='date_birth' value='".$user[0]['dateBirth']."'>";
				echo "<input type='text' name='passport'>";
				echo "<input type='text' name='issued'>";
				echo "<input type='text' name='phone' value='".$parent[0]['phone1']."'>";
				echo "<input type='text' name='residency'>";
				echo "<input type='hidden' name='id' value='".$id."'>";
				echo "</div></div><input type='submit' value='Добавить' class='btn' name='okaddcontract'></form>";
			}
			if(isset($_POST['okaddcontract'])){
				$number = $_POST["number"];
				$date = $_POST["date"];
				$name = $_POST['name'];
				$date_birth_parent = $_POST['date_birth_parent'];
				$child = $_POST["child"];
				$date_birth = $_POST["date_birth"];
				$passport = $_POST["passport"];
				$issued = $_POST["issued"];
				$phone = $_POST["phone"];
				$residency = $_POST["residency"];
				$id = $_POST["id"];
				$sql = "INSERT INTO `contracts`(`number`, `date`, `name`, `date_birth_parent`, `child`, `date_birth`, `passport`, `issued`, `phone`, `residency`, `id_user`) VALUES ('" . $number . "', '" . $date . "', '" . $name . "', '" . $date_birth_parent . "', '" . $child . "','" . $date_birth . "', '" . $passport . "', '" . $issued . "', '" . $phone . "', '" . $residency . "', " . $id . ")";
					mysqli_query($link,$sql) or die(mysqli_error($link));
					echo "<script>window.location = 'index.php?p=contract&id=".$id."'</script>";	
			}

			if(isset($_GET['p']) && $_GET['p']=='ideditcontract'){ //Редактирование договора
				  $idcontract=$_GET['id'];
				  $req ="SELECT * FROM `contracts` WHERE `id`=".$idcontract;
				  $contract = mysqli_fetch_assoc(mysqli_query($link, $req) );
				  
				$req ="SELECT * FROM `users` WHERE `id`=".$contract['id_user'];
				$user = mysqli_fetch_assoc(mysqli_query($link, $req) );
				$iduser=$user['fio'];
				 echo "<h2>Редактирование договора ученика ".$iduser."</h3>";
				echo "<form method='POST' action='index.php?p=contract&id=".$user['id']."'>";
				echo "<div class='container'>";
				echo "<div class='label'>";
				echo "<p>№ договора</p>";
				echo "<p>Дата договора</p>";
				echo "<p>ФИО представителя</p>";
				echo "<p>Дата рождения представителя</p>";
				echo "<p>ФИО ученика</p>";
				echo "<p>Дата рождения</p>";
				echo "<p>Паспорт</p>";
				echo "<p>Выдан</p>";
				echo "<p>Телефон</p>";
				echo "<p>Место жительства</p>";
				echo "</div>";
				echo "<div class='input'>";
				echo "<input type='text' name='number' value='".$contract['number']."'>";
				echo "<input type='date' name='date' value='".$contract['date']."'>";
				echo "<input type='text' name='name' value='".$contract['name']."'>";
				echo "<input type='text' name='date_birth_parent' value='".$contract['date_birth_parent']."'>";
				echo "<input type='text' name='child' value='".$contract['child']."'>";
				echo "<input type='date' name='date_birth' value='".$contract['date_birth']."'>";
				
				echo "<input type='text' name='passport' value='".$contract['passport']."'>";
				echo "<input type='text' name='issued' value='".$contract['issued']."'>";
				echo "<input type='text' name='phone' value='".$contract['phone']."'>";
				echo "<input type='text' name='residency' value='".$contract['residency']."'>";
				echo "<input type='hidden' name='id' value='$idcontract'>";
				echo "</div></div><input type='submit' value='Сохранить' class='btn' name='okeditcontract'></form>";
			  echo"</div>
		</div>";
	}
	if(isset($_POST['okeditcontract'])){
		$request="UPDATE `contracts` SET `number`='".$_POST['number']."',`date`='".$_POST['date']."',`name`='".$_POST['name']."',`date_birth_parent`='".$date_birth_parent."',`child`='".$_POST['child']."',`date_birth`='".$_POST['date_birth']."',`passport`='".$_POST['passport']."',`issued`='".$_POST['issued']."',`phone`='".$_POST['phone']."' WHERE id=".$_POST['id'];
		mysqli_query($link,$request) or die(mysqli_error($link));
		echo "<script>window.location = 'index.php?p=contract&id=".$id."'</script>";
	}
			//Список групп
			if(isset($_GET['p']) && $_GET['p']=='group'){
					echo "<h2>Список групп</h3>";
					$req="SELECT distinct `year` FROM `groupuser` GROUP BY `year`";
					$result = mysqli_query($link, $req);
					$years = array();
					while($row = mysqli_fetch_assoc($result))
						$years[] = $row;
					echo "<div class='filters'> ";
					echo "<div class='inputs'><input type='text' class='input-filter' name='filter_group-year' placeholder='Учебный год' value='".nowYear()."'>
						<div class='listfind find_filter'><ul>";
					for ($i=0; $i < count($years); $i++) { 
						echo "<li id=".$years[$i]['year']."><a href='".$_SERVER['REQUEST_URI']."&year=".$years[$i]['year']."'>".$years[$i]['year']."</a></li>";
					}
					echo "</ul></div></div></div>";
					echo "<div class='linkaddelement'>";
					echo "<a href='index.php?p=addgroup' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить группу</a>";
					echo "<a href='index.php?p=group#openimport' class='addelement'><i class='icon fa fa-file-excel-o fa-fw'></i> Импорт из Excel</a>";
					echo "</div>";
					$year=nowYear();
					echo "<table  class='fullwidth'>";
					if ($year>2021) {
						$req="SELECT `id`, `name`, (SELECT `namecourse` FROM `courses` WHERE `id`=`g`.`course`) as `course`, (SELECT `name` FROM `office` WHERE `id`=`g`.`address`) as `address`, (SELECT `initials` FROM `admins` WHERE `id`=`g`.`teachers`) as `teacher`, CONCAT((SELECT `name` FROM `days-week` WHERE `id`=`g`.`first-day`), ' ', `first-time-start`, '-', `first-time-end`) as `first-day`, CONCAT((SELECT `name` FROM `days-week` WHERE `id`=`g`.`second-day`), ' ', `second-time-start`, '-', `second-time-end`) as `second-day`, (SELECT `name` FROM `cabinet` WHERE `id`=`g`.`cabinet`) as `cabinet` FROM `groupuser` `g` WHERE `year`=$year ORDER BY `name`";
					$result = mysqli_query($link, $req);
					$groups = array();
					while($row = mysqli_fetch_assoc($result))
					$groups[] = $row;
					echo "<tr><th>Группа</th><th>Курс</th><th>Адрес</th><th>Преподаватель</th><th>Дни и время занятий</th><th>Кабинет</th><th>Действие</th></tr>";
					foreach ($groups as $row) {
						$day = $row['first-day']."<br>";
						$day.= ($row['second-day']) ? $row['second-day'] : '';
					echo "<tr>";
					echo "<td>".$row['name']."</td><td class='left'>".$row['course']."</td><td>".$row['address']."</td><td class='leftp'>".$row['teacher']."</td><td class='p'>".$day."</td><td class='p'>".$row['cabinet']."</td><td><i class='fa fa-user fa-lg addusertogroup' id=".$row['id']."></i><a href='index.php?p=group&ideditgroup=".$row['id']."#openeditgroup'><i class='fa fa-pencil fa-lg'></i></a><i class='fa fa-trash fa-lg delete' id=groupuser-".$row['id']."></i></td>";
					echo "</tr>";
					}
					} else {
						$req="SELECT `id`, `name`, (SELECT `namecourse` FROM `courses` WHERE `id`=`g`.`course`) as `course`, `address`, (SELECT `initials` FROM `teachers` WHERE `id`=`g`.`teachers`) as `teacher`, `days`, `times`, `year`  FROM `groupuser` `g` WHERE `year`=$year ORDER BY `name`";
					$result = mysqli_query($link, $req);
					$groups = array();
					while($row = mysqli_fetch_assoc($result))
					$groups[] = $row;
					echo "<tr><th>Группа</th><th>Курс</th><th>Адрес</th><th>Преподаватель</th><th>Дни занятий</th><th>Время занятий</th><th>Действие</th></tr>";
					foreach ($groups as $row) {
					echo "<tr>";
					echo "<td>".$row['name']."</td><td class='left'>".$row['course']."</td><td>".$row['address']."</td><td class='leftp'>".$row['teacher']."</td><td class='leftp'>".$row['days']."</td><td class='p'>".$row['times']."</td><td><i class='fa fa-user fa-lg addusertogroup' id=".$row['id']."></i><a href='index.php?p=group&ideditgroup=".$row['id']."#openeditgroup'><i class='fa fa-pencil fa-lg'></i></a><i class='fa fa-trash fa-lg delete' id=groupuser-".$row['id']."></i></td>";
					echo "</tr>";
				}
					
				}
				echo "</table>";
				if(count($groups)==0) {
					echo "Групп за выбранный год нет";
				}
					if(isset($_GET['ideditgroup'])){ //Редактирование группы
						echo "<div id='openeditgroup' class='modalform'>
				  <div class='modal-dialogform'>
				    <div class='modal-contentform'>
				        <a href='#closeform' title='Close' class='closeform'>×</a>
				      <div class='modal-bodyform'>";
				      	$idgroup=$_GET['ideditgroup'];
						  $req="SELECT * FROM `groupuser` WHERE `id`=".$idgroup;
							$result = mysqli_query($link, $req);
							$groups = mysqli_fetch_assoc($result);
				 		echo "<h2>Редактирование ученика</h3>
						<form method='POST' action='index.php?p=group'>
						<div class='container'>
						<div class='label'>
							<p>Название группы</p>
							<p>Название курса</p>
							<p>Адрес</p>
							<p>Преподаватель</p>
							<p>Первый день</p>
							<p>Время первого дня</p>
							<p>Второй день</p>
							<p>Время второго дня</p>
							<p>Учебный год</p>
						</div>
						<div class='input'>
						<input type='hidden' name='id' value='$idgroup'>
						<input type='text' name='name' value='".$groups['name']."'>";
						echo "<select name='course'>";
						var_dump(printselect_id('courses', 'namecourse', array('id' => 'ASC'), array('id', $groups['course'])));
						echo "</select>
						<select name='address'>";
						echo printselect_id('office', 'name', array('id' => 'ASC'),  array('id', $groups['address']));
						echo "</select>";
						echo "<select name='teachers'>";
						echo printselect_id('admins', 'initials', array('initials' => 'ASC'),  array('id', $groups['teachers']));
						echo "</select>";
						echo "<select name='first-day'>";
						echo printselect_id('days-week', 'name', array('id' => 'ASC'),  array('id', $groups['first-day']));
						echo "</select>
							<div class='time-input'>
							<input type='time' name='first-time-start' value='".$groups['first-time-start']."'> - 
							<input type='time' name='first-time-end' value='".$groups['first-time-end']."'>
						</div>
						<select name='second-day'>";
						echo printselect_id('days-week', 'name', array('id' => 'ASC'),  array('id', $groups['second-day']));
						echo "</select>
						<div class='time-input'>
							<input type='time' name='second-time-start' value='".$groups['second-time-start']."'> - 
							<input type='time' name='second-time-end' value='".$groups['second-time-end']."'>
						</div>";
						echo "<input type='text' name='year' value='".$groups['year']."'>";
						echo "</div></div><input type='submit' value='Сохранить' class='btn' name='okedit'></form>";
				      echo"</div>
				    </div>
				  </div>
				</div>";
			}
				if(isset($_POST['okedit'])){
					echo $request = setRecords('groupuser',$_POST,array('id'=> array('=', $_POST['id'])),NULL);
		// $request="UPDATE `groupuser` SET `name`='".$_POST['namegroup']."',`course`='".$_POST['namecourse']."',`address`='".$_POST['address']."',`teachers`='".$_POST['teachers']."',`days`='".$_POST['days']."',`times`='".$_POST['times']."',`year`=".$_POST['year']." WHERE id=".$_POST['id'];
		mysqli_query($link,$request) or die(mysqli_error($link));
		echo "<script>window.location = 'index.php?p=group'</script>";	
	}
			}
			//Список КТП
			if(isset($_GET['p']) && $_GET['p']=='ktplan'){
				
				$year=nowYear();
				$req="SELECT distinct `year` FROM `groupuser` GROUP BY `year`";
					$result = mysqli_query($link, $req);
					$years = array();
					while($row = mysqli_fetch_assoc($result))
						$years[] = $row;
					echo "<div class='filters'> ";
					echo "<div class='inputs'><input type='text' class='input-filter' name='filter_group-year' placeholder='Учебный год' value='".nowYear()."'>
						<div class='listfind find_filter'><ul>";
					for ($i=0; $i < count($years); $i++) { 
						echo "<li id=".$years[$i]['year']."><a href='".$_SERVER['REQUEST_URI']."&year=".$years[$i]['year']."'>".$years[$i]['year']."</a></li>";
					}
					echo "</ul></div></div></div>";
					echo "<div class='linegroup'>";
					$result = mysqli_query($link, "SELECT * FROM `groupuser` WHERE `year`=$year ORDER BY `name`");
					$groups = array();
					while($row = mysqli_fetch_assoc($result))
					$groups[$row['id']] = $row;

					foreach ($groups as $td) {
					echo "<a href='index.php?p=ktplan&idg=".$td['id']."'><div class='groupteg'>".$td['name']."</div></a>";
					}
					echo "</div>";
					if (isset($_GET['idg'])){
						$idgroup=$_GET['idg'];
						$result = mysqli_query($link, "SELECT * FROM `ktplan` WHERE idgroup=$idgroup");
						$epms = array();
						while($row = mysqli_fetch_assoc($result))
						$epms[] = $row;
						echo "<h2>Список занятий для группы ".$groups[$idgroup]['name']." </h3>
						<div class='linkaddelement'>
						<a href='index.php?p=ktplan&gid=$idgroup#openimport' class='addelement'><i class='icon fa fa-file-excel-o fa-fw'></i> Импорт из Excel</a>
						<a href='export_simple.php?table=ktplan&idgroup=group=$idgroup' class='addelement'><i class='icon fa fa-table fa-fw'></i> Экспорт в Excel</a>
						<div class='dellelement' data=".$idgroup." id='ktplan'><i class='icon fa fa-times-circle-o fa-fw'></i> Удалить все записи</div>";
						echo "</div>
						<table class='fullwidth ktptable'>
						<tr><th>Дата</th><th>Тема</th><th>Домашнее задание</th><th>Действие</th></tr>";
						foreach ($epms as $row) {
						echo "<tr><td no-wrap>".$row['datelesson']."</td><td class='left ktpname'>".$row['namelesson']."</td><td class='left ktpname'>".$row['homework']."</td><td><i class='btn-edit fa fa-pencil fa-lg' id='edit-".$row['id']."'></i><i class='fa fa-trash fa-lg delete' id=ktplan-".$row['id']."></i></td></tr>";
						}
						
					}
					echo "</table>";
					echo '<script  charset="utf-8" type="text/javascript" src="assets/eventless.js"></script>';
			}
				//посещаемость
				if(isset($_GET['p']) && $_GET['p']=='attendance'){
					$req="SELECT distinct `year` FROM `groupuser` GROUP BY `year`";
					$result = mysqli_query($link, $req);
					$years = array();
					while($row = mysqli_fetch_assoc($result))
						$years[] = $row;
					echo '<section class="controls">
					<div class="filter" id="groupuser"> 
						<div class="filter-teacher">
							<div class="multiselect_block">
								<label for="select-1" class="field_multiselect">Преподаватели</label>
								<input id="checkbox-1" class="multiselect_checkbox" type="checkbox">
								<label for="checkbox-1" class="multiselect_label"></label>
								<select id="select-1" class="field_select" name="teachers" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">';
								$result = mysqli_query($link, "SELECT * FROM `admins` WHERE `status`=0 ORDER BY `initials`");
								$teachers = array();
								while($row = mysqli_fetch_assoc($result))
								$teachers[] = $row;
									foreach ($teachers as $td) { 
										echo "<option value='".$td['id']."'>".$td['initials']."</option>";
									}
									
								echo '</select>
								<span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
							</div>
							<span class="error_text"></span>
						</div>
						<div class="filter-office">
							<div class="multiselect_block">
								<label for="select-2" class="field_multiselect">Офис</label>
								<input id="checkbox-2" class="multiselect_checkbox" type="checkbox">
								<label for="checkbox-2" class="multiselect_label"></label>
								<select id="filter-office" class="field_select" name="address" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">';
								$result = mysqli_query($link, "SELECT * FROM `office`");
								$office = array();
								while($row = mysqli_fetch_assoc($result))
								$office[] = $row;
									foreach ($office as $td) { 
											echo "<option value='".$td['id']."'>".$td['name']."</option>";
									}
								echo '</select>
								<span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
							</div>
							<span class="error_text"></span>
							</div>
						<div class="filter-year">
							<div class="multiselect_block">
								<label for="select-3" class="field_multiselect">Учебный год</label>
								<input id="checkbox-3" class="multiselect_checkbox" type="checkbox">
								<label for="checkbox-3" class="multiselect_label"></label>
								<select id="filter-office" class="field_select" name="year" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">';
								$result = mysqli_query($link, "SELECT DISTINCT `year` FROM `groupuser`");
								$year = array();
								while($row = mysqli_fetch_assoc($result))
								$year[] = $row;
									foreach ($year as $td) { 
										if ($td['year']==nowYear()){
											echo "<option value='".nowYear()."' selected>".nowYear()."</option>";
										} else{
											echo "<option value='".$td['year']."' >".$td['year']."</option>";
										}
										
									}
								echo '</select>
								<span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
							</div>
							<span class="error_text"></span>
							</div></div></section>';
					// 	<div class="listfind find_filter"><ul>
					// for ($i=0; $i < count($years); $i++) { 
					// 	echo "<li id=".$years[$i]['year']."><a href='".$_SERVER['REQUEST_URI']."&year=".$years[$i]['year']."'>".$years[$i]['year']."</a></li>";
					// }
					// echo "</ul></div></div></div>";
					echo "<div class='linegroup'>";
					$year=nowYear();
					$result = mysqli_query($link, "SELECT * FROM `groupuser` WHERE `year`=$year ORDER BY `name`");
					$groups = array();
					while($row = mysqli_fetch_assoc($result))
					$groups[$row['id']] = $row;
					foreach ($groups as $td) {
					echo "<a href='index.php?p=attendance&idgr=".$td['id']."'><div class='groupteg'>".$td['name']."</div></a>";
					}
					echo "</div>";
					require_once('attendance.php');
					
			}
			//Добавление оплаты
			if(isset($_GET['p']) && $_GET['p']=='addpay'){
				require_once "addpay.php";
			}
				//Список оплат
				if(isset($_GET['p']) && $_GET['p']=='pay'){
					require_once('pay.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='payold'){
					require_once('attendance.php');
					if ($_POST['oksearch']){
						$tmp_req = "SELECT `id` FROM `users` WHERE `fio` LIKE '%".$_POST['fio']."%'";
						$req = "SELECT * FROM `pay-old` WHERE `iduser` IN($tmp_req) ORDER by `id` DESC";
					} else {
						$req = "SELECT * FROM `pay-old` ORDER by `id` DESC";
					}
					$result = mysqli_query($link, $req);
					$epms = array();
					while($row = mysqli_fetch_assoc($result))
					 $epms[] = $row;
					echo "<h2>Список оплат</h2>";
					echo "<div class='filters'>
					<form method='POST'>
							<input type='text' name='fio' placeholder='ФИО'>
							<input type='submit' value='Искать' name='oksearch'>
						</form>
						</div>";

					echo "<div class='linkaddelement'>";
					echo "<a href='index.php?p=addpay' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить оплату</a>";
					echo "<a href='#selectdate' class='addelement'><i class='icon fa fa-table fa-fw exportpay'></i> Экспорт в Excel</a>";
					echo "</div>";
					echo "<table class='fullwidth'>";
					echo "<tr><th>Дата</th><th>ФИО</th><th>Группа</th><th>Сумма</th><th>Стоимость занятия</th><th>Количество занятий</th><th>Тип оплаты</th><th>Способ оплаты</th><th>Начало периода оплаты</p><th>Действие</th></tr>";
					foreach ($epms as $row) {
						switch ($row['way']) {
							case 'B':
								$type='Безнал';
								break;
							case 'Q':
								$type='QR';
								break;
							case 'N':
								$type='Наличные';
								break;
							default:
							$type='Не указано';
							break;		
						}
						switch ($row['type']) {
							case 'A':
								$way='Абонемент';
								break;
							case 'R':
								$way='Разовое';
								break;
								default:
							$way='Не указано';
							break;
						}
					echo "<tr>";
						echo "<td>".$row['datepay']."</td><td class='leftp'>".$users[$row['iduser']]['fio']."</td><td>".$groups[$row['namegroup']]['name']."</td><td>".$row['sumpay']."</td><td>".$row['sumpayone']."</td><td>".$row['countless']."</td><td>".$type."</td><td>".$way."</td><td>".$row['datebegin']."</td><td><a href='index.php?p=pay&ideditpay=".$row['id']."#openeditpay'><i class='fa fa-pencil fa-lg'></i></a><i class='fa fa-trash fa-lg delete' id=pay-".$row['id']."></i></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
				 //Список курсов
				 if(isset($_GET['p']) && $_GET['p']=='course'){
					echo "<h2>Список курсов</h2>";
					echo "<div class='linkaddelement'>";
					echo "<a href='index.php?p=addcourse' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить курс</a>";
					echo "</div>";
					echo "<table class='fullwidth'>";
					echo "<tr><th>№ п/п</th><th>Название курса</th><th>Категория</th><th>Аббревиатура</th><th>Описание</th><th>Теги</th><th>Действие</th></tr>";
					$n = 1;
					foreach ($courses as $row) {
						$req = "SELECT `t`.`name_tags` FROM `id_tags` `i`, `tags` `t` WHERE `t`.`id` = `i`.`id_tags` AND `i`.`id_courses` = ".$row['id'];
						$result = mysqli_query($link, $req);
						$tags = array();
						while($row_tag = mysqli_fetch_assoc($result))
							$tags[] = $row_tag;
							// var_dump($tags);
						$str_tags = "<ul class='ks-cboxtags tags' data-course = ".$row['id'].">";
						foreach ($tags as $td) {
							$str_tags.='<li><input type="checkbox" id="checkbox'.$td['id'].'" value="'.$td['id'].'" name="tags"><label for="checkbox'.$td['id'].'">'.$td['name_tags'].'</label></li>';
						 }
						 $str_tags .=  "</ul>";
						//  echo $str_tags;
						$description = str_replace("\n", "<br>", $row['description']);
					echo "<tr>";
						echo "<td class='left'>$n</td>
						<td class='left'>".$row['namecourse']."</td>
						<td class='left'>".$row['category']."</td>
						<td class='left'>".$row['abbreviation']."</td>
						<td class='left' style='white-space:normal'>".$description."</td>
						<td class='left' style='white-space:normal'>".$str_tags."</td>
						<td>
						<a href='index.php?p=addtagcourse&id=".$row['id']."' class='link_add_tags'><i class='fa fa-hashtag fa-lg'></i></a>
						<a href='index.php?p=course&ideditcourse=".$row['id']."#openeditcourse'><i class='fa fa-pencil fa-lg'></i></a>
						<i class='fa fa-trash fa-lg delete' id=courses-".$row['id']."></i></td>";
					echo "</tr>";
					$n++;
				}
				if(isset($_GET['ideditcourse'])){ //Редактирование курса
					$id=$_GET['ideditcourse'];
					$result = mysqli_query($link, "SELECT * FROM `courses` WHERE id=$id");
					$epms = array();
					while($row = mysqli_fetch_assoc($result))
					$epms[] = $row;
					echo "<div id='openeditcourse' class='modalform'>
					  <div class='modal-dialogform'>
						<div class='modal-contentform'>
							<a href='#closeform' title='Close' class='closeform'>×</a>
						  <div class='modal-bodyform'>";
							 echo "<h2>Редактирование курса</h3>";
							echo "<form method='POST' action='index.php?p=course'>";
							echo "<div class='container'>";
							echo "<div class='label'>";
							echo "<p>Название курса</p>";
							echo "<p>Аббревиатура</p>";
							echo "<p>Описание</p>";
							echo "</div>";
							echo "<div class='input'>";
							echo "<input type='hidden' name='id' value='$id'>";
							echo "<input type='text' name='namecourse' value='".$epms[0]['namecourse']."'>";
							echo "<input type='text' name='abbreviation' value='".$epms[0]['abbreviation']."'>";
							echo "<textarea name='description'>".$epms[0]['description']."</textarea> ";
							echo "</div></div><input type='submit' value='Сохранить' class='btn' name='okeditcourse'></form>";
						  echo"</div>
						</div>
					  </div>
					</div>";
				}
					if(isset($_POST['okeditcourse'])){
					$request="UPDATE `courses` SET `namecourse`='".$_POST['namecourse']."',`description`='".$_POST['description']."',`abbreviation`='".$_POST['abbreviation']."' WHERE id=".$_POST['id'];
					echo $request;
					mysqli_query($link,$request) or die(mysqli_error($link));
					echo "<script>window.location = 'index.php?p=course'</script>";	
		}
			}
			if(isset($_GET['p']) && $_GET['p']=='addcourse'){
					echo "<h2>Добавить курс</h3>";
					echo "<form method='POST' action='#openconfirm'>";
					echo "<div class='container'>";
					echo "<div class='label'>";
					echo "<p>Название курса</p>";
					echo "<p>Аббревиатура</p>";
					echo "<p>Описание</p>";
					echo "</div>";
					echo "<div class='input'>";
					echo "<input type='text' name='namecourse'>";
					echo "<input type='text' name='abbreviation'>";
					echo "<textarea name='description'></textarea>";
					echo "</div></div><input type='submit' value='Добавить' class='btn' name='okaddcourse'></form>";
				}
				if(isset($_POST['okaddcourse'])){
					$content=$_POST['description'];
					$str=str_replace(array("\r\n", "\r", "\n"), "</p><p class=\"p\">", $content);
					$str="<p class=\"p\">".$str;
					$request="INSERT INTO `courses`(`namecourse`, `abbreviation`, `description`) 
					VALUES ('".$_POST['namecourse']."','".$_POST['abbreviation']."','$str')";
					mysqli_query($link,$request) or die(mysqli_error($link));
					echo "<script>window.location = 'index.php?p=course'</script>";	
				 }
				 if (isset($_POST['okimportktp'])){
					require_once "PHPExcel/Classes/PHPExcel.php";
					$office = $_POST['place'];
					$cabinet = $_POST['cabinet'];
					$data = [
						'office' => $office,
						'cabinet' => $cabinet
					];
					$path =$_FILES['xlsx']['name'];
					copy($_FILES['xlsx']['tmp_name'],$path);
					$fname=$_FILES['xlsx']['name'];
					$file = PHPExcel_IOFactory::load($fname);
					exceltomysql($_POST, $file, $data);
				}
				if(isset($_GET['p']) && $_GET['p']=='summary'){ //Сводная таблица оплат
					require_once("summary.php");
				}
				if(isset($_GET['p']) && $_GET['p']=='admins'){ //Таблица пользователей 
					echo "<h2>Сотрудники</h2>";
					echo "<div class='linkaddelement'>";
					echo "<a href='index.php?p=addadmins' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить пользователей</a>";
					echo "</div>";
					echo "<table class='fullwidth'>";
					echo "<tr><th>Фото</th><th>Инициалы</th><th>ФИО</th><th>Логин</th><th>Роль</th><th>Действие</th></tr>";
					foreach ($admins as $row) {
						echo "<tr><td><img class='mentors' src='assets/img/avatars/".$row['avatar']."'></td><td>".$row['initials']."</td><td class='left'>".$row['fio']."</td><td class='leftp'>".$row['login']."</td><td class='leftp'>".$row['role']."</td><td><a href='index.php?p=admins&ideditadmin=".$row['id']."#openeditadmin'><i class='fa fa-pencil fa-lg'></i></a><i class='fa fa-trash fa-lg delete' id=admins-".$row['id']."></i></td></tr>";
						
					}
					echo "</table>";
					if(isset($_GET['ideditadmin'])){ //Редактирование пользователя
						$idadmin=$_GET['ideditadmin'];
						$result = mysqli_query($link, "SELECT * FROM `admins` WHERE id=$idadmin");
						$admin = mysqli_fetch_assoc($result);
						echo "<div id='openeditadmin' class='modalform'>
						  <div class='modal-dialogform'>
							<div class='modal-contentform'>
								<a href='#closeform' title='Close' class='closeform'>×</a>
							  <div class='modal-bodyform'>";
								 echo "<h2>Редактирование сотрудника</h3>";
								echo "<form method='POST' action='index.php?p=admins'>";
								echo "<div class='container'>";
								echo "<div class='label'>";
								echo "<p>ФИО полностью</p>";
								echo "<p>ФИО с инициалами</p>";
								echo "<p>Фото</p>";
								echo "<p>Цвет</p>";
								echo "<p>Логин</p>";
								echo "<p>Пароль</p>";
								echo "<p>Роль в CRM</p>";
								echo "</div>";
								echo "<div class='input'>";
								echo "<input type='hidden' name='id' value='$idadmin'>";
								echo "<input type='text' name='fio' value='".$admin['fio']."'>";
								echo "<input type='text' name='initials' value='".$teacher['initials']."'>";
								echo "<input type='file' name='avatar' value='".$teacher['avatar']."'>";
								echo "<input type='color' name='color' value='".$teacher['color']."'>";
								echo "<input type='text' name='login' value='".$admin['login']."'>";
								echo "<input type='text' name='password'>";
								echo "<input type='text' name='role' value='".$admin['role']."'>";
								echo "</div></div><input type='submit' value='Сохранить' class='btn' name='okeditadmin'></form>";
							  echo"</div>
							</div>
						  </div>
						</div>";
					}
					if(isset($_POST['okeditadmin'])){
						$request="UPDATE `admins` SET `login`='".$_POST['login']."',`fio`='".$_POST['fio']."',`role`='".$_POST['role']."',`initials`='".$_POST['initials']."',`avatar`='".$_POST['avatar']."',`color`='".$_POST['color']."'";
						if ($_POST['password']) {
							$passHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
							$request.=",`password`='".$passHash."'";
						}
						if (isset($_FILES['avatar']['name'])) {
							$path = "assets/img/avatars/".$_FILES['avatar']['name'];
							if(copy($_FILES['avatar']['tmp_name'],$path)) {
							$fname=$_FILES['avatar']['name'];
								$request.=",`avatar`='".$fname."'";
							}
							}
						$request.=" WHERE id=".$_POST['id'];
						mysqli_query($link,$request) or die(mysqli_error($link));
						echo "<script>window.location = 'index.php?p=admins'</script>";	
				}
				}
				$errors=0;
				if(isset($_GET['p']) && $_GET['p']=='addadmins'){
					echo "<h2>Добавить пользователей</h3>";
					echo "<form method='POST' action='#openconfirm'>";
					if($errors){
					echo '<div class="attention">Пароли не совпадают</div>';
					}
					echo "<div class='container'>";
					echo "<div class='label'>";
					echo "<p>ФИО полностью</p>";
					echo "<p>ФИО с инициалами</p>";
					echo "<p>Фото</p>";
					echo "<p>Цвет</p>";
					echo "<p>Логин</p>";
					echo "<p>Пароль</p>";
					echo "<p>Повторите пароль</p>";
					echo "<p>Роль в CRM</p>";
					echo "</div>";
					echo "<div class='input'>";
					echo "<input type='text' name='fio'>";
					echo "<input type='text' name='initials'>";
					echo "<input type='file' name='avatars'>";
					echo "<input type='color' name='color'>";
					echo "<input type='text' name='login'>";
					echo "<input type='password' name='pass'>";
					echo "<input type='password' name='pass1'>";
					echo "<input type='text' name='role'>";
					echo "</div></div><input type='submit' value='Добавить' class='btn' name='okaddadmins'></form>";
				}
				if(isset($_POST['okaddadmins'])){
					$fio=$_POST['fio'];
					$login=$_POST['login'];
					$pass=$_POST['pass'];
					$pass1=$_POST['pass1'];
					$role=$_POST['role'];
					$path = "assets/img/avatars/".$_FILES['avatars']['name'];
					if(copy($_FILES['avatars']['tmp_name'],$path)) {}
					$fname=$_FILES['avatars']['name'];
					$request="INSERT INTO `admins`(`login`, `password`, `fio`, `role`, `initials`, `avatar`, `color`, `status`) 
					VALUES ('".$login."','".password_hash($pass, PASSWORD_BCRYPT)."','".$fio."','".$role."','".$_POST['initials']."','$fname','".$_POST['color']."',0)";
					mysqli_query($link,$request) or die(mysqli_error($link));
					
				 }
				 if(isset($_GET['p']) && $_GET['p']=='ads'){
				 	include('ads.php');
				 }
				 if(isset($_GET['p']) && $_GET['p']=='addads'){
					include('addads.php');
				}
				 if(isset($_GET['p']) && $_GET['p']=='openday'){
				 	include('openday.php');
				 }
				 if(isset($_GET['p']) && $_GET['p']=='dept'){
					include('dept.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='summer'){
					include('summer.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='addsummer'){
					include('addsummer.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='pay_tmp'){
					include('pay_tmp.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='application_training'){
					include('application_training.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='add_application_traning'){
					include('add_application_traning.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='management'){
					include('management.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='teachers_summary'){
					include('teachers_summary.php');
				}
				if(isset($_GET['p']) && $_GET['p']=='addtagcourse'){
					include('addtagcourse.php');
				}
			?>
		</div>
	</div>
<div id="openimport" class="modalform">
  <div class="modal-dialogform">
    <div class="modal-contentform">
      <div class="modal-headerform">
        <h3 class="modal-titleform">Импорт из Excel</h3>
        <a href="#closeform" title="Close" class="closeform">×</a>
      </div>
      <div class="modal-bodyform">
        <form method='POST' action="index.php?p=ktplan&idg=<?=$_GET['gid']?>#openconfirm" enctype='multipart/form-data'>
		<div class='container'>
		<?
			echo "<input type='hidden' name='p' value='".$_GET['p']."'>";
			echo "<input type='hidden' name='gid' value='".$_GET['gid']."'>";
			?>	
		<div class='label'>
		<p>Выберите файл</p>
		<p>Выберите филиал</p>
		<p>Выберите кабинет</p>
		</div>
		<div class='input'>
		<input type='file' name='xlsx'>
		<select name='place' required="true" class='group-address'>
			<option></option>
			<?
				$result = mysqli_query($link, "SELECT * FROM `office`");
				$office = array();
				while($row = mysqli_fetch_assoc($result))
				$office[] = $row;
					foreach ($office as $td) { 
						if ($td['id']==1){
							echo "<option value='".$td['id']."' selected>".$td['name']."</option>";
						} else{
							echo "<option value='".$td['id']."' >".$td['name']."</option>";
						}
						
					}
			?>
		</select>
		<select name="cabinet" required="true">
			<option></option>
			<?
				$result = mysqli_query($link, "SELECT * FROM `cabinet` WHERE `office`=1");
				$cabinet = array();
				while($row = mysqli_fetch_assoc($result))
				$cabinet[] = $row;
					foreach ($cabinet as $td) { 
						if ($td['id']==1){
							echo "<option value='".$td['id']."' selected>".$td['name']."</option>";
						} else{
							echo "<option value='".$td['id']."' >".$td['name']."</option>";
						}
					}
				?>
			</select>
		</div></div>
		<div class="accordion">
	    <section class="accordion_item">
	        <h3 class="title_block">Как должен выглядеть файл Excel!</h3>
	        <div class="info">
	        	<?
	        	if(isset($_GET['p']) && $_GET['p']=='users'){
	        		echo "<p class='info_item'>* Последовательность данных: номер договора, дата договора, фио, группа, дата начала оплаты, ФИО родителя, номер телефона родителя, номер телефона ученика, дата рождения.</p>
	        	<p class='info_item'>* Заголовков ячеек не должно быть!</p>
	        	<p class='info_item'>* Объединенных ячеек не должно быть!</p>
	            <img src='assets/img/Excel users.PNG'>";
	            }
	            if(isset($_GET['p']) && $_GET['p']=='ktplan'){
	        		echo "<p class='info_item'>* Последовательность данных: дата занятия, тема, время начала, время окончания, домашнее задание, баллы за ДЗ.</p>
	        	<p class='info_item'>* Заголовков ячеек не должно быть!</p>
	        	<p class='info_item'>* Объединенных ячеек не должно быть!</p>
	        	<p class='info_item'>* Ячейки с датами формата Дата.</p>
	        	<p class='info_item'>* Ячейки с временем формата Текст.</p>
	            <img src='assets/img/Excel ktp.png'>";
	            }
	            if(isset($_GET['p']) && $_GET['p']=='group'){
	        	echo "<p class='info_item'>* Последовательность данных: сокращенное имя группы, курс, адрес, преподаватель, дни занятий, время занятий.</p>
	        	<p class='info_item'>* Заголовков ячеек не должно быть!</p>
	        	<p class='info_item'>* Объединенных ячеек не должно быть!</p>
	            <img src='assets/img/Excel groups.PNG'>";
	            }
	             if(isset($_GET['p']) && $_GET['p']=='individual'){
	        	echo "<p class='info_item'>* Последовательность данных: номер договора, дата договора, фио, курс, дата начала оплаты, номер телефона, дата рождения.</p>
	        	<p class='info_item'>* Заголовков ячеек не должно быть!</p>
	        	<p class='info_item'>* Объединенных ячеек не должно быть!</p>
	            <img src='assets/img/individuals.JPG'>";
	            }
	            
	            ?>
	        </div>
	    </section>
	</div>
		<input type='submit' value='Добавить' class='btn' name='okimportktp'></form>
          
      </div>
    </div>
  </div>
</div>
<div id="selectdate" class="modalform">
  <div class="modal-dialogform">
    <div class="modal-contentform">
        <a href="#closeform" title="Close" class="closeform">×</a>
      <div class="modal-bodyform">
      	<form method='POST' action="export.php">
      	<div class="input">
      	<h3>Экспорт в Excel</h3>
      	<p>С какой даты: <input type="date" name="datebig" id='datebig'></p>
      	<p>До какой даты: <input type="date" name="dateend" id='dateend'></p>
      </div>
      <input type="submit" name="okexportpay" class='btn' value='OK' id='okexportpay'>
      </div>
  </form>
    </div>
  </div>
</div>
<div id="calendar-add-lesson"  class="modalform">
	<div class="modal-dialogform">
		<div class="modal-contentform">
			<div class="modal-header">
			<h3>Добавить новое занятие в расписание</h3>
			<div title="Close" class="close-less">×</div>
			</div>
			<div class="modal-bodyform">
				<?
				$url='addlesson.php';
				if(isset($_GET['p'])){
					$url.='?p='.$_GET['p'];
				}?>
				<form method='POST' action=<? echo '"'.$url.'"'?> >
				<div class='container'>	
					<div class='grid_form'>
						<p>Тип события</p>
						<select name="type-lesson" required="true">
						<option selected="selected"></option>
						<?
							$result = mysqli_query($link, "SELECT * FROM `type_lesson`");
							$type_lesson = array();
							while($row = mysqli_fetch_assoc($result))
								$type_lesson[] = $row;
							foreach ($type_lesson as $td) { 
								echo "<option value='".$td['id']."' >".$td['name']."</option>";
							}
						?>
						</select>
						<p class="name-title"></p>
						<div class="name-event"></div>
						<p class="repeat_title">Повторяющееся</p>
						<div class="repeat">
							<label class="checkbox-ios">
								<input type='checkbox' id='input_repeat' name="repeat" value="repeat">
								<span class="checkbox-ios-switch"></span>
							</label>  
						</div>
						<div class="grid_form grid_form_internal form_repeat">
							<p>Дата начала:</p>
							<input type="date" name="date-start">
							<p>Дата окончания:</p>
							<input type="date" name="date-end">
							<p>Дни занятий:</p>
							<div class="weekday">
							<label for="day"><input type="checkbox" value="1" name="day[]"  > Понедельник</label>
							<label for="day"><input type="checkbox"  name="day[]"  value="2"> Вторник</label>
							<label for="day"><input type="checkbox"  name="day[]"  value="3"> Среда</label>
							<label for="day"><input type="checkbox"  name="day[]" value="4"> Четверг</label>
							<label for="day"><input type="checkbox"  name="day[]" value="5"> Пятница</label>
							<label for="day"><input type="checkbox"  name="day[]" value="6"> Суббота</label>
							<label for="day"><input type="checkbox"  name="day[]" value="7"> Воскресенье</label>
							</div>
						</div>
						<p class="data_title">Дата:</p>
						<input type="date" name="date-lesson" required="true">
						<p class="time_title">Время:</p>
						<div class="time-input"><input type="time" class="input-time" name="time-begin" required="true"> - <input type="time" class="input-time" name="time-end" required="true"></div>
						<p>Место:</p>
						<select name='place' required="true" id="place">
						<option></option>
						<?
							$result = mysqli_query($link, "SELECT * FROM `office`");
							$office = array();
							while($row = mysqli_fetch_assoc($result))
							$office[] = $row;
								foreach ($office as $td) { 
									echo "<option value='".$td['id']."' >".$td['name']."</option>";
								}
						?>
						</select>
						<p>Кабинет:</p>
						<select name="cabinet" required="true">
						<option></option>
						<?
						$result = mysqli_query($link, "SELECT * FROM `cabinet` WHERE `office`=1");
							$cabinet = array();
							while($row = mysqli_fetch_assoc($result))
							$cabinet[] = $row;
								foreach ($cabinet as $td) { 
									echo "<option value='".$td['id']."' >".$td['name']."</option>";
								}
								?>
						</select>
						<p class='textarea topic_lesson'>Тема занятия:</p>
						<textarea name="topic" class="topic_lesson"></textarea>
						<p class='textarea homework_lesson'>Домашнее задание:</p>
						<textarea name="hw" class="homework_lesson"></textarea>
						<p class='homework_points_lesson'>Количество баллов за ДЗ:</p>	
						<input type="number" name="max-points" class="homework_points_lesson">	
						<p class='teacher_lesson'>Преподаватель:</p>	
						<select name="teacher" class="teacher_lesson">
						<option></option>
						<?
						$result = mysqli_query($link, "SELECT * FROM `admins` WHERE `status`=0 ORDER BY `initials` ASC");
						$teachers = array();
						while($row = mysqli_fetch_assoc($result))
						$teachers[] = $row;
							foreach ($teachers as $td) { 
								echo "<option value='".$td['id']."' >".$td['initials']."</option>";
							}
							?>
						</select>	
						<p class='course_lesson'>Курс:</p>
						<select name="course" class="course_lesson">
						<option></option>
						<?
						$result = mysqli_query($link, "SELECT * FROM `courses` ORDER BY `namecourse` ASC");
						$courses = array();
						while($row = mysqli_fetch_assoc($result))
						$courses[] = $row;
							foreach ($courses as $td) { 
								echo "<option value='".$td['id']."' >".$td['namecourse']."</option>";
							}
							?>
						</select>		
					</div>
				</div>
				<input type="submit" name="addles" value="Добавить" class="btn">
				</form>
			</div>
			<div class="wait"><p class="wait-p">Подождите...</p></div>
		</div>
	</div>
</div>
<div id="addusertogroup"  class="modalform">
	<div class="modal-dialogform">
		<div class="modal-contentform">
			<div class="modal-headerform">
        <h3 class="modal-titleform">Добавить учеников в группу</h3>
			<div title="Close" class="closeform">×</div>
			</div>
			<div class="modal-bodyform">
				<div class='container'>	
				<div class='label'>
				<p>Введите ФИО:</p></div>
				<div class="input"><input type="text" name="user" placeholder="ФИО">
				<div class="listfind"></div>
			</div></div>
				<div class="listadd"><ul></ul></div>
				<div class="btn btn-addtogroup">Сохранить</div>
			</div>
			
		</div>
	</div>
</div>
<div id="openconfirm" class="modalform">
  <div class="modal-dialogform">
    <div class="modal-contentform">
        <a href="#closeform" title="Close" class="closeform">×</a>
      <div class="modal-bodyform">
      	<i class="fa fa-check fa-5x"></i>
        <h1>Успешно!</h1>
      </div>
    </div>
  </div>
</div>
<div id="openerror" class="modalform">
  <div class="modal-dialogform">
    <div class="modal-contentform">
        <div title="Close" class="closeform">×</div>
      <div class="modal-bodyform">
      	<i class="fa fa-times-circle-o fa-5x"></i>
        <h1>Произошла ошибка!</h1>
      </div>
    </div>
  </div>
</div>
	<?
if(!isset($_GET['p'])){
		echo '<script  charset="utf-8" type="text/javascript" src="assets/calendar.js?'. time().'"></script>';
		echo '<script  charset="utf-8" type="text/javascript" src="assets/eventless.js?'.time().'"></script>';
	} 
?>
	<script  charset="utf-8" type="text/javascript" src="assets/date.js?<?php echo time(); ?>"></script>
	<script  charset="utf-8" type="text/javascript" src="assets/js.js?<?php echo time(); ?>"></script>

</body>
</html>