<? 
if (isset($_POST['parent'])) {
    $parent = $_POST['parent'];
    $kid = $_POST['kid'];
    $tel = $_POST['tel'];
    $age = $_POST['age'];
    $type = $_POST['type'];
    $call_type = $_POST['call'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];
    $office = implode(";",$_POST['office']);
    $camp_change = implode(";",$_POST['camp_change']);
    $date = strtotime(date("d.m.Y H:i"));
    $utm_source = $POST['utm_source'];
    
    $request="INSERT INTO `summer`(`parent`, `kid`, `tel`,`call_type`, `age`, `type`, `office`, `camp_change`, `date_time`, `status`, `comment`, `date_change`,`utm_source`) 
    VALUES ('".$parent."','".$kid."','".$tel."','".$call_type."','".$age."','".$type."','".$office."','".$camp_change."',$date,'".$status."','".$comment."', $date, '$utm_source')";
    mysqli_query($link,$request) or die(mysqli_error($link));
    echo "<script>window.location = 'index.php?p=summer'</script>";	
  }

$result = mysqli_query($link, "SELECT * FROM `statuses_summer`");
$statuses = array();
while($row = mysqli_fetch_assoc($result))
$statuses[$row['id']] = $row;
$req = "SELECT * FROM `office`";
$result = mysqli_query($link, $req);
$office = array();
while($row = mysqli_fetch_assoc($result))
$office[] = $row;


echo '<link rel="stylesheet" type="text/css" href="assets/summer.css">
 <main>
<section class="form">
    <div class="border_gradient">
        ';
           echo  '<form method="POST"><div class="column">
                <label for="parent">ФИО родителя</label>
                <input type="text" name="parent" required="1">
            </div>
            <div class="column">
                <label for="kid">ФИО ребенка</label>
                <input type="text" name="kid" required="1">
            </div>
            <div class="column tel">
                <label for="tel">Телефон</label>
                <input type="tel" name="tel" required="1" id="tel" placeholder="+7 (999) 123 - 45 - 67">
            </div> 
            <div class="column date">
                <label for="age">Возраст</label>
                <input type="date" name="age" required="1" placeholder="24.10.2007">
            </div>
            
            <div class="column call_radio">
                <label>Тип связи</label>
                <div class="checkbox">
                    <div class="line-input">
                        <input type="radio" value="Звонок" name="call" id="call" required="1"><label for="call"> Звонок</label>
                    </div>
                    <div class="line-input">
                        <input type="radio" value="What`s App" name="call" id="whatsup" required="1"><label for="whatsup"> What`s App</label>
                    </div>
                    <div class="line-input">
                        <input type="radio" value="Telegram" name="call" id="telegram" required="1"><label for="telegram"> Telegram</label>
                    </div>
                    <div class="line-input">
                        <input type="radio" value="ВКонтакте" name="call" id="vk" required="1"><label for="vk"> ВКонтакте</label>
                    </div>
                </div>
            </div>
            <div class="age"><img src="src/images/robot.png" alt=""><span></span></div>
            <div class="column camp_change">
                <label>Смены</label>
                <div class="checkbox">
                    
                <div class="line-input">
                <input type="checkbox" value="1 смена 6.06 - 10.06" name="camp_change[]" id="camp_change1"><label for="camp_change1"><span> 1 смена </span><br> 6.06 - 10.06</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="2 смена 13.06 - 17.06" name="camp_change[]" id="camp_change2"><label for="camp_change2"> <span> 2 смена </span> <br>13.06 - 17.06</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="3 смена 20.06 - 24.06" name="camp_change[]" id="camp_change3"><label for="camp_change3">  <span> 3 смена </span><br>20.06 - 24.06</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="4 смена 27.06 - 01.07" name="camp_change[]" id="camp_change4"><label for="camp_change4"><span> 4 смена </span><br> 27.06 - 01.07</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="5 смена 04.07 - 08.07" name="camp_change[]" id="camp_change5"><label for="camp_change5"><span> 5 смена </span><br>04.07 - 08.07</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="6 смена 11.07 - 15.07" name="camp_change[]" id="camp_change6"><label for="camp_change6"><span> 6 смена </span><br>11.07 - 15.07</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="7 смена  18.07 - 22.07" name="camp_change[]" id="camp_change7"><label for="camp_change7"><span> 7 смена </span><br> 18.07 - 22.07</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="8 смена 25.07 - 29.07" name="camp_change[]" id="camp_change8"><label for="camp_change8"><span> 8 смена </span><br>25.07 - 29.07</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="9 смена  01.08 - 05.08" name="camp_change[]" id="camp_change9"><label for="camp_change9"><span> 9 смена </span><br> 01.08 - 05.08</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="10 смена 08.08 - 12.08" name="camp_change[]" id="camp_change10"><label for="camp_change10"><span> 10 смена </span><br>08.08 - 12.08</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="11 смена 15.08 - 19.08" name="camp_change[]" id="camp_change11"><label for="camp_change11"><span> 11 смена </span><br>15.08 - 19.08</label>
            </div>
            <div class="line-input">
                <input type="checkbox" value="12 смена 22.08 - 26.08" name="camp_change[]" id="camp_change12"><label for="camp_change12"><span> 12 смена </span><br>22.08 - 26.08</label>
            </div>
                </div>
            </div>
            <div class="column office">
            <label>На каком филиале Вам будет<br>удобно обитать?</label>
            <div class="checkbox">';
	for ($i = 0; $i < count($office); $i++) {
		echo "<div class='line-input'>
				<input type='checkbox' value='".$office[$i]['id']."' name='office[]' id='of".$office[$i]['id']."'><label for='of".$office[$i]['id']."'>". $office[$i]['full_name']."</label>
			</div>";
	}
		
	echo '</div>
        </div>
            <div class="column type">
                <label>В лагерь или на интенсивы?</label>
                <div class="checkbox">
                    <div class="line-input">
                        <input type="radio" value="Лагерь" name="type" id="camp"><label for="camp"></label>
                    </div>
                    <div class="line-input">
                        <input type="radio" value="Интенсив" name="type" id="intensive"><label for="intensive"></label>
                    </div>
                </div>
            </div>
            <div class="column">
                <label>Статус</label>
                <select name="status">';
                for ($i=0; $i<count($statuses); $i++){
                    echo "<option value=".$statuses[$i]['id'].">".$statuses[$i]['name']."</option>";
                }
               echo '</select>
                </div>
                <div class="column">
                <label>Комментарий: </label>
                <textarea name="comment"></textarea>
                </div>
                <div class="column">
                <label>Источник заявки: </label>
                <input type="text" name="utm_source">
                </div>
            <button type="submit" name="ok" class="btn_summer">Всё! Отправляем! <img src="assets/img/btn.png"></button>
                </div>
            </div></form>';
        echo '
    </div>
</section>
</main>';
   
    ?>
<script src="jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src='js.js'></script>
</body>
  <script type="text/javascript" src='imask.js'></script>
</body>
</html>

<?

?>