<?
$result = mysqli_query($link, "SELECT * FROM `office`");
$office = array();
while($row = mysqli_fetch_assoc($result))
$office[] = $row;

$result = mysqli_query($link, "SELECT `c`.`name`, `o`.`name` as `office` FROM `cabinet` `c`, `office` `o` WHERE `c`.`office` = `o`.`id`");
$cabinet = array();
while($row = mysqli_fetch_assoc($result))
$cabinet[] = $row;
?>
<div class="linkaddelement">
<div class="block-btn"><span class='plus'>+</span><span class='btn-title'>Новый офис</span></div>
<div class="block-btn"><span class='plus'>+</span><span class='btn-title'>Новый кабинет</span></div>
</div>
<div class="grid--50">
    <div class="block">
        <div class="header__block">
            <div class="block-title">Офисы</div>
           
        </div>
        <table class="fullwidth edit_table">
            <tr>
                <th class='td-center'></th>
                <th class='td-center'>№ п.п</th>
                <th>Название</th>
                <th>Адрес</th>
            </tr>
            <?
                $n = 1;
                for ($i=0; $i < count($office); $i++) { 
                echo "<tr>
                <td class='td-center'><input type='checkbox' class='table-input'></td>
                <td class='td-center'>$n</td>
                <td class='td-bold'>".$office[$i]['name']."</td>
                <td>".$office[$i]['address']."</td></tr>"; 
                $n++;
                }
            ?>
        </table>
    </div>
    <div class="block">
        <div class="header__block">
            <div class="block-title">Офисы</div>
            
        </div>
        <table class="fullwidth edit_table">
            <tr>
                <th class='td-center'></th>
                <th class='td-center'>№ п.п</th>
                <th>Название</th>
                <th>Офис</th>
            </tr>
            <?
                $n = 1;
                for ($i=0; $i < count($cabinet); $i++) { 
                echo "<tr>
                <td class='td-center'><input type='checkbox' class='table-input'></td>
                <td class='td-center'>$n</td>
                <td class='td-bold'>".$cabinet[$i]['name']."</td>
                <td>".$cabinet[$i]['office']."</td></tr>"; 
                $n++;
                }
            ?>
        </table>
    </div>  
</div>