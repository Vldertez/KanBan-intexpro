
Date.prototype.daysInMonth = function(y, m) {
	return	Date.getDaysInMonth(y, m)
};
let lessons=[];
// gen_evens()
let teacher=[]
function generate_date(date){
	name_mounths=["января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря"];
	name_days=["Пн","Вт","Ср","Чт","Пт","Сб","Вс"];
	today_day=date.getDate()
	today_mounth=date.getMonth()
	today_year=date.getFullYear()
	num_today = (date.getDay()-1) < 0 ? 6 : date.getDay()-1;
	count_day_mounth=date.daysInMonth(today_year, today_mounth);
	nums_date_weeek=[];
	k=0;
	for (i=num_today; i <= 6; i++) { 
		nums_date_weeek[i]={}
		nums_date_weeek[i]['day']=today_day+k;
		
		nums_date_weeek[i]['mounth']=name_mounths[today_mounth];
		nums_date_weeek[i]['num_mounth']=today_mounth+1
		if (nums_date_weeek[i]['num_mounth']<10) {
			nums_date_weeek[i]['num_mounth']='0'+nums_date_weeek[i]['num_mounth']
		}
		nums_date_weeek[i]['year']=today_year
		if (nums_date_weeek[i]['day']>count_day_mounth) {
			today_mounth_tmp=today_date.getMonth()+1
			today_year_tmp=today_year
			if (today_mounth_tmp>11) {
				today_mounth_tmp=0
				today_year_tmp=today_year+1;
			}
			today_date_tmp=new Date(today_year_tmp,today_mounth_tmp,1)
			// count_day_mounth_tmp=today_date.daysInMonth(today_year_tmp, today_mounth_tmp);
			// console.log(nums_date_weeek[i]['day']+" - "+count_day_mounth)
			nums_date_weeek[i]['day']=nums_date_weeek[i]['day']-count_day_mounth
			
			nums_date_weeek[i]['mounth']=name_mounths[today_mounth_tmp]
			nums_date_weeek[i]['num_mounth']=today_mounth_tmp+1
			if (nums_date_weeek[i]['num_mounth']<10) {
				nums_date_weeek[i]['num_mounth']='0'+nums_date_weeek[i]['num_mounth']
			}
			nums_date_weeek[i]['year']=today_year_tmp;
		}
		k++;
	}
 	k=1;
	today_mounth_tmp=0;
	today_year_tmp=0
	today_date_tmp=0;
	for (i=num_today-1; i >= 0; i--) { 
		nums_date_weeek[i]={}
		nums_date_weeek[i]['day']=today_day-k;
		nums_date_weeek[i]['mounth']=name_mounths[today_mounth];
		nums_date_weeek[i]['num_mounth']=today_mounth+1
		if (nums_date_weeek[i]['num_mounth']<10) {
			nums_date_weeek[i]['num_mounth']='0'+nums_date_weeek[i]['num_mounth']
		}
		nums_date_weeek[i]['year']=today_year
		if (nums_date_weeek[i]['day']<=0) {
			today_mounth_tmp=today_date.getMonth()-1
			today_year_tmp=today_year
			if (today_mounth_tmp<0) {
				today_mounth_tmp=11
				today_year_tmp=today_year-1;
			}
			today_date_tmp=new Date(today_year_tmp,today_mounth_tmp,1)
			count_day_mounth_tmp=today_date.daysInMonth(today_year_tmp, today_mounth_tmp);
			nums_date_weeek[i]['day']=count_day_mounth_tmp+nums_date_weeek[i]['day']
			nums_date_weeek[i]['mounth']=name_mounths[today_mounth_tmp]
			nums_date_weeek[i]['num_mounth']=today_mounth_tmp+1
			if (nums_date_weeek[i]['num_mounth']<10) {
				nums_date_weeek[i]['num_mounth']='0'+nums_date_weeek[i]['num_mounth']
			} 		
			nums_date_weeek[i]['year']=today_year_tmp;
		}
		k++;
	}
	str_time='<div class="column-time"><div class="nav"><div class="move-left"><i class="fa fa-chevron-left fa-lg"></i> </div><div class="move-right"><i class="fa fa-chevron-right fa-lg"></i> </div></div>'
	str_ceil='';
	for (i = 8; i<= 20; i++) {
		if (i<10){
		time='0'+i;
		} else {
			time=i;
		}
		str_time+='<div class="time">'+time+':00</div>';
		str_ceil+='<div class="ceil-top"></div><div class="ceil-bottom"></div>';
	}
	str_time+="</div>"
	str_columns='';
	$.ajax({
		url: 'addlesson.php',
		type: 'POST',
		data: {get_cabinet:1},
		success: function(data){
			data=JSON.parse(data)
			let str = ''
			let cabinets = "<div class='column-cabinet'>"
			for (j=0; j<data.length; j++){
				cabinets += "<div class='cabinet' id='"+data[j]['id']+"'><span class='cabinet_title'>"+data[j]['name']+"</span>"+str_ceil+"</div>";
			}
			cabinets += "</div>"
			
			for (i=0; i < 7; i++) {
				if (nums_date_weeek[i]['day']<10){
					dayprint='0'+nums_date_weeek[i]['day']
				} else {
					dayprint=nums_date_weeek[i]['day']
				}
				str_columns+="<div class='plan-column' id='"+nums_date_weeek[i]['year']+'-'+nums_date_weeek[i]['num_mounth']+'-'+dayprint+"'><div class='day'>"+name_days[i]+", <span class='date'>"+nums_date_weeek[i]['day']+" "+nums_date_weeek[i]['mounth']
				str_columns+="</span></div>"+cabinets+"</div>"
			}
			str=str_time+str_columns;
			$('.plan').html(str);
		}
		
	})
	 gen_evens(nums_date_weeek)
}
/*------------------------*/
	/*генерация событий*/
	function gen_evens(nums_date_weeek){
	masdate=$('.plan-column')
	office=$('#filter-office').val()
	let cabinets = ""
	$.ajax({
		url: 'addlesson.php',
		type: 'POST',
		data: {get_cabinet:office[0]},
		success: function(data){
			data=JSON.parse(data)
			for (j=0; j<data.length; j++){
				cabinets += "<div class='cabinet' id='"+data[j]['id']+"'><span class='cabinet_title'>"+data[j]['name']+"</span>"+str_ceil+"</div>";
			}
			$('.column-cabinet').html(cabinets)
		}
	})
	

	$.ajax({
		url: 'addlesson.php',
		type: 'POST',
		data: {teachers:'teacher'},
		success: function(data){
			teachers=JSON.parse(data);
		}
	})
	setTimeout(function(){
	$.ajax({
		url: 'addlesson.php',
		type: 'POST',
		data: {
			office:office[0],
			date: JSON.stringify(nums_date_weeek)
		},
		success: function(data){
			// console.log(data)
			lessons=JSON.parse(data)
			$(".plan-column").each(function() {
			thisdate=$(this).attr('id')
			for (i in lessons){
				if(lessons[i]['datelesson'] ==thisdate){
					time_begin=lessons[i]['time_begin'].split(':');
					time_end=lessons[i]['time_end'].split(':');
					date=lessons[i]['datelesson'].split('-');
					fulldate_begin=new Date(date[2],date[1]-1,date[0],time_begin[0],time_begin[1])
					fulldate_end=new Date(date[2],date[1]-1,date[0],time_end[0],time_end[1])
					fulldate_start=new Date(date[2],date[1]-1,date[0],8,0)
					// h=time_end[0]-time_begin[0]
					// m=Math.abs(time_end[1]-time_begin[1])
					height=(fulldate_end-fulldate_begin)/(1000*60)
					htop=(fulldate_begin-fulldate_start)/(1000*60)+18
					if(lessons[i]['type']=='kov'){
						colorbg='#660099'
						colorfont='#fff'
					} else{
						colorbg=lessons[i]['teacher-color']
						colorfont='#000'
					}
					block='<div class="event" style="height:'+height+'px;top:'+htop+'px;background: '+colorbg+';color:'+colorfont+'" id="'+lessons[i]['id']+'">'+lessons[i]['name-title']+'</div>'
					$('#'+lessons[i]['datelesson']).find('#'+lessons[i]['id_cabinet']).append(block)
				}
			}
		})
	}

});

}, 1000)
}

$(document).ready(function() {
$('head').append('<link rel="stylesheet" type="text/css" href="assets/calendar.css?'+Date .now ()+'">')
$('head').append('<link rel="stylesheet" type="text/css" href="assets/modalless.css?'+Date .now ()+'">')
today_date=new Date()
today_day=today_date.getDate()
today_mounth=today_date.getMonth()
today_year=today_date.getFullYear()
num_today=today_date.getDay()
count_day_mounth=today_date.daysInMonth();
generate_date(today_date)	 

$('html').on('click', '.move-left', function(){
	today_day=today_day-7;
	
	if(today_day<=0) {
		today_mounth=today_date.getMonth()-1
		if (today_mounth<0) {
			today_mounth=11
			today_year-=1;
		}
		today_date=new Date(today_year,today_mounth,1)
		console.log(today_day)
		count_day_mounth=today_date.daysInMonth(today_year, today_mounth);
		today_day=count_day_mounth+today_day	
	}	
	today_date=new Date(today_year,today_mounth,today_day)
	today_year=today_date.getFullYear()
	generate_date(today_date)
	// gen_evens(today_date)
	})
	 $('html').on('click', '.move-right', function(){
		today_day=today_day+7;
	if(today_day>today_date.daysInMonth(today_year, today_mounth)) {
		today_mounth=today_date.getMonth()+1
		if (today_mounth>11) {
			today_mounth=0
			today_year+=1;
		}
		today_date=new Date(today_year,today_mounth,1)
		count_day_mounth=today_date.daysInMonth(today_year, (today_mounth-1));
		today_day=today_day-count_day_mounth	
	}	
	today_date=new Date(today_year,today_mounth,today_day)
	today_year=today_date.getFullYear()
	generate_date(today_date)
	
	})	

	
/*Добавление Занятия*/



$(document).on('click', '.event', function(){
	mastype={'group':'Групповое', 'ind':'Индивидуальное','kov':'Коворкинг'}
	id=$(this).attr('id')
	thisless=lessons[id]
	// $(this).closest('.cabinet').append('<div class="description-less"><div class="content-less"><div class="close-less">x</div><div class="title-less"></div><div class="time-less"></div><div class="topic-less"></div><div class="teacher-less"></div><div class="cabinet-less"></div><div class="btns"></div></div></div>')
		$('.modal-less').css('display', 'flex')
	$('.time-less').text(thisless['datelesson']+', '+thisless['time_begin']+' - '+thisless['time_end'])
	if(thisless['name-title']){
		$('.title-less').text(thisless['name-title'])
	} else {
		$('.title-less').text(thisless['name'])
	}
	$('.teacher-less').text('Преподаватель: '+thisless['teacher-title'])
	$('.topic-less').text('Тема занятия: '+thisless['namelesson'])
	$('.cabinet-less').text('Кабинет: '+thisless['cabinet'])
	$('.hw-less').text('Домашнее задание: '+thisless['homework'])
	$('.btns').html('<div class="btn btn-edit" id="edit-'+thisless['id']+'">Редактировать</div><div class="btn btn-del" id="del-'+thisless['id']+'">Удалить</div>')
	// $('.description-less').css('top', $(this).css('top'))
	// $('.description-less').css('right', $(this).closest('.cabinet').width()+5)
	$(this).css('pointer-events', 'none')
	thisevent=$(this)
	$(document).on('click','.close-less', function(){
		thisevent.css('pointer-events', 'auto')
		$(this).closest('.modal-less').css('display', 'none')
	} )
	})
 
$('#filter-office').change(function(){
	$('.event').remove()
	gen_evens(nums_date_weeek)
})
})
