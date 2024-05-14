$(document).ready(function() {
	// $('head').append('<link rel="stylesheet" type="text/css" href="assets/modalless.css">')
	function reqgroup(type, resolve = () => null){
		$('.wait').css('display','flex')
	if (type==3 || type==4) {
		$('.name-title').css('display','block')
		$('.name-event').css('display','block')
		$('.name-title').text('ФИО или название: ')
		$('.name-event').html('<input  type="text" name="name">')
		$('.wait').css('display','none')
		$('.topic_lesson, .homework_lesson, .homework_points_lesson, .teacher_lesson, .course_lesson').css('display','none')
		resolve() 
		return
	} else {
		if (type==2 || type == 5){
			data = {cont:'ind'}
			key = 'fio'
			$('.name-title').text('ФИО ученика: ')
			$('.topic_lesson, .homework_lesson, .homework_points_lesson, .teacher_lesson, .course_lesson').css('display','block')
			attr_id = 'group'
			type == 2 ? $('.repeat_title, .repeat').css('display','block') : null;
			$('.wait').css('display','flex')
			let data_teacher = {
				teacher_id: 'curent', 
			}
			$.ajax({
				url: 'addlesson.php', 
				method: 'POST', 
				data: data_teacher,
				success: function(data){
					data=JSON.parse(data)
					
					
					$(".teacher_lesson").val(data.id);
					$('.wait').css('display','none')
				}
			})
			$('#input_repeat').change(function(){
				console.log($(this).is(':checked'))
				if ($(this).is(':checked')) {
					$('.form_repeat').css('display','grid')
					$('input[name="date-lesson"]').css('display','none')
					$('input[name="date-lesson"]').removeAttr('required')
					$('input[name="date-start"]').attr('required', 'required')
					$('input[name="date-end"]').attr('required', 'required')
					$('.data_title').css('display','none')
					$('.topic_lesson, .homework_lesson, .homework_points_lesson').css('display','none')
				}
				else {
					$('.form_repeat').css('display','none')
					$('input[name="date-lesson"]').css('display','block')
					$('.data_title').css('display','block')
					$('input[name="date-lesson"]').attr('required',"true")
					$('.topic_lesson, .homework_lesson, .homework_points_lesson').css('display','block')
					$('input[name="date-start"]').removeAttr('required')
					$('input[name="date-end"]').removeAttr('required')
			  }
			})
			let checked = [];
			$('input[name="day[]"]').change(function(){
				if ($(this).is(':checked')) {
				checked.push($(this).val())
				html = ''
				for (let i = 0; i < checked.length; i++) {
					html += "<div class='item_time'>"+(i+1)+"-й день <input type='time' class='input-time' name='time-begin[]' required='true'> - <input type='time' class='input-time' name='time-end[]' required='true'></div>"
				}
				$('.time-input').html(html)
				console.log(checked)
			} else {
				checked.pop()
				$('.item_time:last-child').remove()
			}
			})
		} else if (type==1){
			data = {cont:'group'}
			key = 'name'
			$('.name-title').text('Группа: ')
			$('.topic_lesson, .homework_lesson, .homework_points_lesson, .teacher_lesson').css('display','block')
			$('.course_lesson').css('display','none')
			attr_id='group'
			$(document).on('change', '#group', function(){
				$('.wait').css('display','flex')
				id = $(this).val()
				let data = {
					teacher_id: id, 
				}
				console.log(data)
				$.ajax({
					url: 'addlesson.php', 
					method: 'POST', 
					data: data,
					success: function(data){
						data=JSON.parse(data)
						
						$(".teacher_lesson").val(data.id);
						$('.wait').css('display','none')
					}
				})
			})
		}
		$.ajax({
			url: 'addlesson.php',
			type: 'POST',
			data: data,
			success: function(data){
				data=JSON.parse(data)
				string='<select name="name" id='+attr_id+' required="required"><option></option>'
				for (var i in data ) {
					if(data[i]){
					string+='<option value="'+data[i]['id']+'">'+data[i][key]+'</option>'
					}
				}
				string+='</select>'
				$('.name-title').css('display','block')
				$('.name-event').css('display','block')
				$('.name-event').html(string)
				$('.wait').css('display','none')
				
				resolve() 
				return
			}	
		});
	}

}


$('.addclass').click(function(){
	$('#calendar-add-lesson').css('opacity','1');
	$('#calendar-add-lesson').css('pointer-events', 'auto');
	$("#calendar-add-lesson *").removeAttr("style");
	$("#calendar-add-lesson input").not('input[name="day[]"], #input_repeat').val('');
	$("#calendar-add-lesson option").removeAttr("selected");
	$('#calendar-add-lesson h3').text('Добавить новое занятие в расписание');
	$('input[type=submit]').attr('value', 'Добавить');
})
$('.close-less').click(function(){
		$('#calendar-add-lesson').css('opacity','0');
	$('.modalform').css('pointer-events', 'none');
})
$('select[name=type-lesson]').change(function(){
	type=$('select[name=type-lesson]').val()
	console.log(type)
	reqgroup(type)
})


$(document).on('click', '.btn-edit', function(){
	$('.wait').css('display','flex')
 	$('#calendar-add-lesson').css('opacity','1');
	$('#calendar-add-lesson').css('pointer-events', 'auto');
	id=$(this).attr('id').split('-')[1]
	thisless=[]
	$.ajax({
		url: 'addlesson.php',
		type: 'POST',
		data: {cont:'less', id:id},
		success: async function(data){
			
			thisless=JSON.parse(data);
			$('#calendar-add-lesson h3').text('Изменить занятие')
			$('input[name=date-lesson]').attr('value', thisless[id]['datelesson'])
			thisless[id]['time_begin'] = thisless[id]['time_begin'].split(':')[0] <10 ? '0' + thisless[id]['time_begin'] : thisless[id]['time_begin'];
			$('input[name=time-begin]').attr('value', thisless[id]['time_begin'])
			$('input[name=time-end]').attr('value', thisless[id]['time_end'])
			$('input[type=submit]').attr('value', 'Изменить')
			$('input[type=submit]').attr('name', 'editless')
			$('select[name="type-lesson"]').val(thisless[id]['type']);
			$('select[name=place]').val(thisless[id]['place']);
			$('select[name=cabinet]').html(cabisoffice(thisless[id]['place'], thisless[id]['cabinet']))
			$('.wait').css('display','flex')
			$('textarea[name=topic]').html(thisless[id]['namelesson'])
			$('textarea[name=hw]').text(thisless[id]['homework'])
			$('input[name=max-points]').val(thisless[id]['max-points'])
			$('select[name=teacher]').val(thisless[id]['teacher']);
			$('select[name=course]').val(thisless[id]['course']);
			
			await new Promise((resolve, reject) => {reqgroup(thisless[id]['type'], resolve)})		
			
				if (thisless[id]['type']==1 || thisless[id]['type']==2 || thisless[id]['type']==5 ) {
					$("#group").val(thisless[id]['idgroup']);
				} else {
					
					$('input[name=name]').val(thisless[id]['idgroup'])
				}
				$('.grid_form').append('<input type=hidden name="id" value='+thisless[id]['id']+'>')
				
		}
	})
 })

$(document).on('click', '.btn-del', function(){
	id=$(this).attr('id').split('-')[1]
	wind='<div class="window"><div class="content-window"><img src="assets/img/error.png"><p>Вы действительно хотите удалить занятие?</p><div class="btns"><div class="btn btn-ok">Да</div><div class="btn btn-no">Нет</div></div></div></div>'
	$('body').append(wind)
	$('.window').css('display', 'flex')
	$(document).on('click', '.btn-ok', function(){

	$.ajax({
		url: 'addlesson.php',
		type: 'POST',
		data: {delid:id},
		success: function(data){
			if (data=='ok'){
				$('.event#'+id).remove()
				$('.window').remove()
				$('.description-less').remove()

			}
		}
	});
})
	$(document).on('click', '.btn-no', function(){
		$('.window').remove()
	})
	})

async function cabisoffice(office, cabinet = null) {

	data = {
		"get_cabinet" : office
	}
	$.ajax({
	url: 'addlesson.php',
	type: 'POST',
	data: data,
	success: function(data){
	data=JSON.parse(data)
	
	cabinets = '<option></option>'
	for (j=0; j<data.length; j++){
		cabinets += "<option value='"+data[j]['id']+"'>"+data[j]['name']+"</option>";
	}
    $('select[name=cabinet]').html(cabinets)
	cabinet ? $('select[name=cabinet] option[value='+cabinet+']').attr('selected', 'selected') : null
	$('.wait').css('display', 'none')
}
  });

}
$('#place').change(function(){
$('.wait').css('display', 'flex')
cabisoffice($(this).val())
})

})