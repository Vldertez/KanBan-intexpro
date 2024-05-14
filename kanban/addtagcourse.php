<?php
$id_course = $_GET['id'];
$req="SELECT * FROM `courses` WHERE `id` = $id_course";
$result = mysqli_query($link, $req);
$course = mysqli_fetch_assoc($result);

$req="SELECT * FROM `tags`";
$result = mysqli_query($link, $req);
$tags = array();
while($row = mysqli_fetch_assoc($result))
$tags[] = $row;
$req="SELECT `id_tags` FROM `id_tags` WHERE `id_courses` = $id_course";
$result = mysqli_query($link, $req);
$id_tags = array();
while($row = mysqli_fetch_assoc($result))
$id_tags[] = (int)$row['id_tags'];
?>
<h2>Добавление тегов курсу <? echo $course['namecourse']?></h2>
<div class="header_tag">
    <div class="new_tag">
        <div class="new_tag_line">
            <input type="text" name="addtag" id="addtag" placeholder="Новый тег">  
            <div class="btn" id='okaddtag'>Добавить</div>
        </div>
    </div>
    <div class="btns">
        <div class="btn btn--green" id="save_tag">Сохранить</div>
    </div>
</div>



<?php

 echo "<ul class='ks-cboxtags tags' data-course = $id_course>";
 foreach ($tags as $td) {
    if (in_array($td['id'], $id_tags)){
        echo '<li><input type="checkbox" id="checkbox'.$td['id'].'" value="'.$td['id'].'" name="tags" checked><label for="checkbox'.$td['id'].'">'.$td['name_tags'].'</label></li>';
    } else {
         echo '<li><input type="checkbox" id="checkbox'.$td['id'].'" value="'.$td['id'].'" name="tags"><label for="checkbox'.$td['id'].'">'.$td['name_tags'].'</label></li>';
    }

 }
 echo "</ul>";

?>