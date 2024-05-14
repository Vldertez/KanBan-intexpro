
<section class='controls'>
<h2 class="main-title">Расписание</h2>
<div class="filter" id="ktplan">
	    <div class="filter-teacher">
              <div class="multiselect_block">
                <label for="select-1" class="field_multiselect">Преподаватели</label>
                <input id="checkbox-1" class="multiselect_checkbox" type="checkbox">
                <label for="checkbox-1" class="multiselect_label"></label>
                <select id="select-1" class="field_select filter_calendar" name="teacher" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">
				<?
                 $result = mysqli_query($link, "SELECT * FROM `admins` WHERE `status`=0 ORDER BY `initials`");
				 $teachers = array();
				 while($row = mysqli_fetch_assoc($result))
				 $teachers[] = $row;
				 	foreach ($teachers as $td) { 
						echo "<option value='".$td['id']."'>".$td['initials']."</option>";
					}
					?>
                </select>
                <span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
              </div>
              <span class="error_text"></span>
		 </div>
		 <div class="filter-office">
			<div class="multiselect_block">
                <label for="select-2" class="field_multiselect">Офис</label>
                <input id="checkbox-2" class="multiselect_checkbox" type="checkbox">
                <label for="checkbox-2" class="multiselect_label"></label>
                <select id="filter-office" class="field_select filter_calendar" name="place" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">
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
                <span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
            </div>
            <span class="error_text"></span>
			</div>
		<div class="filter-cabitet">
			<div class="multiselect_block">
                <label for="select-3" class="field_multiselect">Кабинет</label>
                <input id="checkbox-3" class="multiselect_checkbox" type="checkbox">
                <label for="checkbox-3" class="multiselect_label"></label>
                <select id="filter-office" class="field_select filter_calendar" name="cabinet" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">
				<?
                 $result = mysqli_query($link, "SELECT * FROM `cabinet` WHERE `office`= 1 ORDER BY `name`");
				 $cabinet = array();
				 while($row = mysqli_fetch_assoc($result))
				 $cabinet[] = $row;
				 	foreach ($cabinet as $td) { 
						echo "<option value='".$td['id']."'>".$td['name']."</option>";
					}
					?>
                </select>
                <span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
            </div>
            <span class="error_text"></span>
		 </div>
		 <div class="filter-type-lesson">
		 <div class="multiselect_block">
                <label for="select-4" class="field_multiselect">Кабинет</label>
                <input id="checkbox-4" class="multiselect_checkbox" type="checkbox">
                <label for="checkbox-4" class="multiselect_label"></label>
                <select id="filter-office" class="field_select filter_calendar" name="technology" multiple style="@media (min-width: 768px) { height: calc(4 * 38px)}">
						<option value='group'>Групповые</option>
						<option value='ind'>Индивиддуальные</option>
						<option value='kov'>Коворкинг</option>
                </select>
                <span class="field_multiselect_help">Вы можете выбрать несколько элементов, нажав <b>Ctrl(or Command)+Element</b></span>
            </div>
            <span class="error_text"></span>
		 </div>
	</div>
	<div class="addclass"> <span class='plus'>+</span> Добавить занятие </div>
</section>

<section class="plan">


</section>
</div>
</div>
<div class="modal-less modal">
<div class="description-less">
	<div class="content-less">
		<div class="close-less">x</div>
		<div class="title-less"></div>
		<div class="time-less"></div>
		<div class="namecourse-less"></div>
		<div class="topic-less"></div>
		<div class="hw-less"></div>
		<div class="teacher-less"></div>
		<div class="cabinet-less"></div>
		<div class="btns"></div>
	</div>
</div>
</div>