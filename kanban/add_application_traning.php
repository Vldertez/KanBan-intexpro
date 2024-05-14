<?

    $result = mysqli_query($link, "SELECT * FROM `days-week`");
    $days_week = array();
    while($row = mysqli_fetch_assoc($result))
    $days_week[] = $row;

    echo "<h2>Добавление новой заявки</h3>";
    echo "<form method='POST' action='#openconfirm'>";
    echo "<div class='container'>";
    echo "<div class='label'>";
    echo "<p>Дата заявки</p>";
    echo "<p>Кто добавил</p>";
    echo "<p>Ребенок</p>";
    echo "<p>Возраст</p>";
    echo "<p>Родитель</p>";
    echo "<p>Телефон</p>";
    echo "<p>Курс(ы)</p>";
    echo "<p>Комментарий</p>";
    echo "<p>Откуда пришли</p>";
    echo "<p>Группа (пробное)</p>";
    echo "</div>";
    echo "<div class='input'>";
    $date=$date['year'].'-'.$date['mounth'].'-'.$date['mday'];
    $date =  date("Y-m-d\TH:i");
    echo " <input type='datetime-local' name='date' value='".$date."' required>";
    $result = mysqli_query($link, "SELECT `id`, `fio` FROM `admins` WHERE `role` ='manager' OR `role` ='admin'");
    $current_user = array();
    while($row = mysqli_fetch_assoc($result))
    $current_user[] = $row;
    echo "<select name='id_admin'>
    <option></option>";
    foreach ($current_user as $td) {
        if ($td['id'] == $_COOKIE['id']) {
            echo "<option value=".$td['id']." selected>".$td['fio']."</option>";
        } else {
            echo "<option value=".$td['id'].">".$td['fio']."</option>";
        }
    }
    echo "</select>";
    echo "<input type='text' name='name_child'>";
    echo "<input type='number' name='age_child'>";
    echo "<input type='text' name='name_parent'>";
    echo "<input type='tel' name='phone'>";
    echo "<textarea name='courses'></textarea>";
    echo "<textarea name='comment'></textarea>";
    $result = mysqli_query($link, "SELECT `id`, `ru` FROM `utm_source`");
    $utm_source = array(); 
    while($row = mysqli_fetch_assoc($result))
    $utm_source[] = $row;
    echo "<select name='address'>
    <option></option>";
    foreach ($utm_source as $td) {
    echo "<option value=".$td['id'].">".$td['ru']."</option>";
    }
    echo "</select>";
    $year=nowYear();
    $req="SELECT * FROM `groupuser` WHERE `year`=".$year;
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
    
    echo "</div></div><input type='submit' value='Добавить' class='btn' name='okadd'></form>";

if($_POST['okadd']){
    mysqli_query($link,addRecord('groupuser',$_POST,false)) or die(mysqli_error($link));
    echo "<script>window.location = 'index.php?p=group'</script>";	
}