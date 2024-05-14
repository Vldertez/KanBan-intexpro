  flag=0
$('.btn_nav').click(function(){

 if (!flag) {
  $('.panel').animate({left:'0'}, 500)
  $('.btn_nav .fa').removeClass('fa-angle-double-right')
  $('.btn_nav .fa').addClass('fa-angle-double-left')
  flag=1
 }  else {
  $('.panel').animate({left:'-300px'}, 500)
  $('.btn_nav .fa').removeClass('fa-angle-double-left')
  $('.btn_nav .fa').addClass('fa-angle-double-right')
  flag=0
 }
})
  $('.tdpos').change(function(){
    content=$(this).val();                           
    elementid=$(this).closest('.tddate').attr('id');
    data=$(this).closest('.item__points').attr('data')
    pun=parseFloat($(this).closest('.tddate').find('[data=pun] input').val())
    beh=parseFloat($(this).closest('.tddate').find('[data=beh] input').val())
    act=parseFloat($(this).closest('.tddate').find('[data=act] input').val())
    task=parseFloat($(this).closest('.tddate').find('[data=task] input').val())
    pun= (isNaN(pun)) ? 0 : pun
    beh= (isNaN(beh)) ? 0 : beh
    act= (isNaN(act)) ? 0 : act
    task= (isNaN(task)) ? 0 : task
    sum=pun+beh+act+task;
    $(this).closest('.tddate').find('[data=asses]').text(sum)
    // console.log(content)
    // console.log(elementid)
    // console.log(data)
        if(content=='') {
          content=' '
        }  
        idgr=$('h2').attr('id')         
          $.ajax({
          url: 'save.php',    
          type: 'GET',
          data: {
                content: content,    
                id:elementid,
                idgroup:idgr,
                data:data
                 },       
          success:function (data) { 
            // console.log(data)
          if (data == content)
            {                                                                      
               $('<div id="status">Данные успешно сохранены</div>')   
                        .insertAfter('.main')
                        .addClass("success")
                        .fadeIn('fast')
                        .delay(4000)
                        .fadeOut('slow', function() {this.remove();}); 
                }
                  else
                 {
                   $('<div id="status">Запрос завершился ошибкой</div>')
                       .insertAfter('.main')
                       .addClass("error")
                       .fadeIn('fast')
                       .delay(4000)
                       .fadeOut('slow', function() {this.remove();}); 
                        }
                    }
             });
  })
function postgroup(content){
  $.ajax({
    url: 'index.php?p=ktplan',
    method:'GET',
    type: 'GET',
    data: {
               text:content
           },       

    success:function (resp) {
    if (resp == 'ok') {                                                                      
        console.log('ok')
          } else {
        console.log('no')
           }
              }
         });
}
$(".groupteg").click(function() {
var idid=this.id; 
postgroup(idid);
})
var o, n;
  $(".title_block").click(function() {
    o = $(this).parents(".accordion_item"), n = o.find(".info"),
      o.hasClass("active_block") ? (o.removeClass("active_block"),
        n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
        o.siblings(".active_block").removeClass("active_block").children(
          ".info").stop(!0, !0).slideUp())
  })    
  var o, n;          
 $(".title-menu").click(function() {
    o = $(this).parents(".cat-menu"), 
    n = o.find(".submenu"),
      o.hasClass("active_block") ? (o.removeClass("active_block"),
        n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
        o.siblings(".active_block").removeClass("active_block").children(
          ".submenu").stop(!0, !0).slideUp())
  })   

 $(".delete").click(function() {
  el=$(this)
    delel(obreldel(this.id)[1], obreldel(this.id)[0], el) 
   })



   $(".dellelement").click(function() {
    id=$(this).attr('data');
    content=this.id;
    console.log(id)
    console.log(content)
    $.ajax({
      url: 'delete.php',    
      type: 'POST',
      data: {  
                  event: 'delall',
                  elid:id,
                  page:content,
             },       
      success:function (data) { 
          console.log(data)
      if (data == 'ok')
        {                                                                  
           $('<div id="status">Элемент успешно удален</div>')   
                    .insertAfter('.main')
                    .addClass("success")
                    .fadeIn('fast')
                    .delay(4000)
                    .fadeOut('slow', function() {this.remove();}); 

            }
              else
             {
               $('<div id="status">Запрос завершился ошибкой'+data+'</div>')
                   .insertAfter('.main')
                   .addClass("error")
                   .fadeIn('fast')
                   .delay(4000000)
                   .fadeOut('slow', function() {this.remove();}); 
                    }
                    $('.window').remove()
        }
           });

   })


    function obreldel(p){
    p=p.split('-')
    return p;
    }
    function delel(id, page, el) {
      wind='<div class="window"><div class="content-window"><img src="assets/img/error.png"><p>Вы действительно хотите удалить занятие?</p><div class="btns"><div class="btn btn-ok">Да</div><div class="btn btn-no">Нет</div></div></div></div>'
    $('body').append(wind)
    $('.window').css('display', 'flex')
    $(document).on('click', '.btn-ok', function(){
          $.ajax({
          url: 'delete.php',    
          type: 'POST',
          data: {  
                      event: 'del',
                      elid:id,
                      page:page,
                 },       
          success:function (data) { 
              console.log(data)
          if (data == 'ok')
            { 
            el.closest('tr').remove()
            console.log(el)
            el.closest('.modal').css('display', 'none');
            $('<div id="status">Элемент успешно удален</div>')   
                        .insertAfter('.main')
                        .addClass("success")
                        .fadeIn('fast')
                        .delay(4000)
                        .fadeOut('slow', function() {this.remove();}); 

                }
                  else
                 {
                   $('<div id="status">Запрос завершился ошибкой'+data+'</div>')
                       .insertAfter('.main')
                       .addClass("error")
                       .fadeIn('fast')
                       .delay(4000000)
                       .fadeOut('slow', function() {this.remove();}); 
                        }
                        $('.window').remove()
                    }
               });
          })
  $(document).on('click', '.btn-no', function(){
    $('.window').remove()
  })
    }
function print_attendance(a){
      $.ajax({
        url: 'attendance.php',
        method:'POST',
        type: 'POST',
        data: {
                   idgr:a
               },       
    success:function (data) {
      if (data!='') {
        $('#attendance').html(data)
      } else {
        console.log('error')
      }
    }
  })
}
    $('#okchoicegroup').click(function(){
      val=$('#select-group').val()

      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
                   idgr:val
               },       
        success:function (resp) {
          if (resp != '') {
            resp=$.parseJSON(resp)                                  
            str="<form method='POST' action='#openconfirm'><div class='container'><div class='label'><p>ФИО ученика</p><p>Дата платежа</p><p>Сумма</p><p>Стоимость одного занятия</p><p>Количество занятий</p><p>Способ оплаты</p><p>Тип оплаты</p><p>Начало периода </p></div><div class='input'><input type='hidden' name='namegroup' value="+val+"><select name='user'>"
            for(i=0;i<resp.length;i++) {
            str+="<option value="+resp[i]['id']+">"+resp[i]['fio']+"</option>"
            }
            date=new Date();
            day=date.getDate()
            if (day<10){
              day='0'+day
            }
            mounth=date.getMonth()+1
            if (mounth<10){
              mounth='0'+mounth
            }
            year=date.getFullYear()
            date=year+'-'+mounth+'-'+day
            str+="</select><input type='date' name='datepay' value="+date+"><input type='number' name='sumpay' id='sumpay'><input type='number' name='sumpayone' id='sumpayone'><input type='text' name='countless' id='countless'><select name='way'><option value=N>Наличные</option><option value=B>Безнал</option><option value=Q>QR</option></select><select name='type'><option value=A>Абонемент</option><option value=R>Разовое</option></select><input type='date' name='datebegin'></div></div><input type='submit' value='Добавить' class='btn' name='okaddpay'></form>"
            $('#content-addpay').html(str)
            $("#sumpayone").change(function(){
            countless= $("#sumpay").val()/$("#sumpayone").val();
            $("#countless").val(countless);
            });
              $("#sumpay").change(function(){
            countless= $("#sumpay").val()/$("#sumpayone").val();
            $("#countless").val(countless);
            });
          } else {
            console.log('no')
          }

        }
      });
   print_attendance(val)

    })
  $("#sumpayone").change(function(){
countless= $("#sumpay").val()/$("#sumpayone").val();
$("#countless").val(countless);
});
    $("#sumpay").change(function(){
countless= $("#sumpay").val()/$("#sumpayone").val();
$("#countless").val(countless);
});


$('.group-address').change(function(){
  office = $(this).val();
  $.ajax({
    url: 'request.php',
    method:'POST',
    type: 'POST',
    data: {
               get: 'cabinet',
               office: office
           },       
    success:function (resp) {
      console.log(resp)
      cabinet=$.parseJSON(resp)  
      html = ''
      for (i = 0; i < cabinet.length; i++){
        html += "<option value="+cabinet[i]['id']+">"+cabinet[i]['name'] + "</option>";
      }
      $('select[name=cabinet]').html(html)
    } 
  })
})


  $('#select-group').change(function(){
      val=$('#select-group').val()
      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
                   idgr:val
               },       
    success:function (resp) {
    if (resp != '') {
    resp=$.parseJSON(resp)        
           $('#select-user').html()  
           str=''                 
          for(i=0;i<resp.length;i++) {
          str+="<option value="+resp[i]['id']+">"+resp[i]['fio']+"</option>"
          }    
          $('#select-user').html(str)
          } else {
        console.log('no')
           }

              }
         });


    })
    var idaddedgroup=0;
    $('.closeform').click(function(){
      $(this).closest('.modalform').css('opacity','0')
      $(this).closest('.modalform').css('pointer-events','none')
      $(this).closest('.modalform').css('overflow-y','none')
    })
    $('.addusertogroup').click(function(){
      $('#addusertogroup').css('opacity','1')
      $('#addusertogroup').css('pointer-events','auto')
      $('#addusertogroup').css('overflow-y','auto')
      idaddedgroup=$(this).attr('id');
      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
                   idgr:idaddedgroup,
                   
               },       
    success:function (resp) {
     
      resp=$.parseJSON(resp) 
      console.log(resp)
      str=''
      for (var i = 0; i < resp.length; i++) {
            if(resp[i]!=null){
             str+= '<li id='+resp[i]['id']+'>'+resp[i]['fio']+'<i class="fa fa-close fa-lg" id='+resp[i]['id']+' title="Исключить"></i></li>'
      } else {
        str+= '<li id='+resp[i]['id']+'>'+resp[i]['fio']+'<i class="fa fa-close fa-lg" id='+resp[i]['id']+' title="Исключить"></i></li>'
      }
      }
      $('.listadd ul').html(str)
      $('.listadd ul').attr('id', idaddedgroup)
    }

  })
    })

    added_users=[]
    $('input[name=user]').keyup(function(){
      if ($('input[name=user]').val().length>1) {
        $('.listfind').css('display','block')
      name=$('input[name=user]').val()
      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
                   nameuser:name,
                   
               },       
    success:function (resp) {
      
        resp=$.parseJSON(resp) 
        if(resp.length!=0){
        str='<ul>'
        for (var i in resp) {
          str+='<li id='+resp[i]['id']+'>'+resp[i]['fio']+'</li>'
        }
              str+='</ul>'
              $('.listfind').html(str)
            } else {
              $('.listfind').text('Не найдено')
            }
          }
         });
      }
    })

    $('#input-filter').keyup(function(){

      if ($(this).val().length>1) {  
      name=$(this).val()
      id=$(this).attr('name').split('_')[1].split('-');
      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
                  unknown:name,
                  table: id[0],
                  field: id[1]
                   
               },       
    success:function (resp) {
      $('.listfind').css('display','block')
      console.log(resp)
        resp=$.parseJSON(resp) 
        if(resp.length!=0){
        str=''
        for (var i in resp) {
          str+='<li><a href="index.php?p=addpay&user='+resp[i]['id']+'">'+resp[i]['fio']+'</a></li>'
        }
              str+=''
              $('.listfind ul').html(str)
            } else {
              $('.listfind ul').text('Не найдено')
            }
          }
         });
      }
    })


    $(document).on('click', '.listfind li', function(){
      id=$(this).attr('id')
      if (added_users.indexOf(id)==-1) {
      added_users.push(id)
      $('.listadd ul').append('<li id='+id+'>'+$(this).text()+'<i class="fa fa-close fa-lg" id='+id+' title="Исключить"></i></li>')
      $('.listfind').css('display', 'none')
      }
    })


    $('.btn-addtogroup').click(function(){
      added_users=added_users.join()
      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
                   idsaddgroup:added_users,
                    idaddedgroup:idaddedgroup
               },       
    success:function (resp) {
      
        // resp=$.parseJSON(resp) 
        $('#addusertogroup').css('opacity','0')
      $('#addusertogroup').css('pointer-events','none')
      $('#addusertogroup').css('overflow-y','none')
        if(resp.indexOf('ok')!=-1 || resp.length==0){
            $('#openconfirm').css('opacity','1')
            $('#openconfirm').css('pointer-events','auto')
          $('#openconfirm').css('overflow-y','auto')
        } else {
          $('#openerror').css('opacity','1')
            $('#openerror').css('pointer-events','auto')
          $('#openerror').css('overflow-y','auto')
        }
        setTimeout(function(){window.location.href = 'index.php?p=group'}, 1500)
      }
         });
    })

    $(document).on('click', '.listadd i', function(){
      thisid=$(this).closest('li').attr('id')
      groupid=$(this).closest('ul').attr('id')
      delel=$(this).closest('li')
      if (added_users.indexOf(thisid)!=-1) {
        i=added_users.indexOf(thisid)
        added_users.splice(i,1)
        delel.remove()
      } else {
        $.ajax({
        url: 'delete.php',
        method:'POST',
        type: 'POST',
        data: {
                   delusgr: thisid,
                   groupid: groupid
               },       
    success:function (resp) {
      if (resp=='ok') {
        delel.remove()
      } else {
        $('#openerror').css('opacity','1')
        $('#openerror').css('pointer-events','auto')
        $('#openerror').css('overflow-y','auto')
        setTimeout(function(){
          $('#openerror').css('opacity','0')
        $('#openerror').css('pointer-events','none')
        $('#openerror').css('overflow-y','none')
        }, 1500)
      }
      }
    })
      }
    })

    $('.input-filter').click(function(){
      
      $(this).closest('.inputs').find('.find_filter').toggleClass('open-listfind ')
    })
    // $('input').click(function(){
    //   console.log('click')
    //   $(this).closest('.inputs').find('.find_filter').css('display', 'block')
    // })
    $('.find_filter li').click(function(){
     year = $(this).text()
     $(this).closest('.inputs').find('input').attr('value', year)
     $(this).closest('.inputs').find('.find_filter').css('display', 'none')
    })
    


// Фильтр


$(document).on('change', '.tdedit', function(){

  table = $(this).attr('data-table')? $(this).attr('data-table') : $(this).closest('table').attr('data-table')
  title = $(this).attr('name')
  id = $(this).closest('tr').attr('data-id')
  type = $(this).attr('data-type')
  val = $(this).val()
  console.log(type)
  if (type == 'num') {
    val =  val.replace(/\s/g, '')
    val =  val.replace(/,/g, '.')
  }
  console.log($(this).attr('type'))
   if ($(this).attr('type') == 'date') {
    date = val.split('-');
    val = Date.UTC(date[0], (date[1]-1), date[2])/1000
   }
  $.ajax({
    url: 'request.php',
    method:'POST',
    type: 'POST',
    data: {
          table: table,
          title: title,
          id:id,
          val: val,
          type: 'tdedit'
           },       
success:function (resp) {
  console.log(resp)
  if (resp.indexOf('ok')) {                                                                    
      $('<div id="status">Данные успешно сохранены</div>')   
                .insertAfter('table')
                .addClass("success")
                .fadeIn('fast')
                .delay(4000)
                .fadeOut('slow', function() {this.remove();}); 
        }
          else
        {
          $('<div id="status">Запрос завершился ошибкой</div>')
              .insertAfter('table')
              .addClass("error")
              .fadeIn('fast')
              .delay(4000)
              .fadeOut('slow', function() {this.remove();}); 
        }
    }

})
})
// load select for change
$(document).on('dblclick', '.select-edit', function(){
  console.log('click')
  table = $(this).attr('data-table')
  title = $(this).attr('data-title')
  id = $(this).attr('data-id')
  name = $(this).attr('data-name')
  el = $(this)
  data = {
    table: table,
    title: title,
    id:id,
    type: 'select-get'
    } 

  $.ajax({
    url: 'request.php',
    method:'POST',
    type: 'POST',
    data: data,       
  success:function (resp) {
    //  console.log(resp)
    resp=$.parseJSON(resp) 
    html = "<select name='"+name+"' class='simple-select-edit'>"
    for (i = 0; i < resp.length; i++){
      if (resp[i]['id'] === id){
        html += "<option value="+resp[i]['id']+" selected>"+resp[i]['name']+"</option>"
      } else {
        html += "<option value="+resp[i]['id']+">"+resp[i]['name']+"</option>"
      }
    }
    html += "</select>"
  //   console.log(html)
    el.html(html)
  }
})
})

$(document).on('change', '.simple-select-edit', function(){
table = $(this).closest('table').attr('data-table')
title = $(this).attr('name')
id = $(this).closest('tr').attr('data-id')
val = $(this).val()
selectedText  =  $(this).children('option:selected').text();
el = $(this).closest('td');
console.log(selectedText)
$.ajax({
  url: 'request.php',
  method:'POST',
  type: 'POST',
  data: {
        table: table,
        title: title,
        id:id,
        val: val,
        type: 'tdedit'
         },       
success:function (resp) {
console.log(resp)
if (resp.indexOf('ok')) {                                                                    
    $('<div id="status">Данные успешно сохранены</div>')   
              .insertAfter('table')
              .addClass("success")
              .fadeIn('fast')
              .delay(4000)
              .fadeOut('slow', function() {this.remove();}); 
              el.children('select').remove();
              el.attr('data-id', val);
              el.text(selectedText);
      }
        else
      {
        $('<div id="status">Запрос завершился ошибкой</div>')
            .insertAfter('table')
            .addClass("error")
            .fadeIn('fast')
            .delay(4000)
            .fadeOut('slow', function() {this.remove();}); 
      }
  }

})
})


//   $(document).on('dblclick', '.select-edit', function(){
//     table = $(this).attr('data-table')
//     title = $(this).attr('data-title')
//     id = $(this).attr('data-id')
//     name = $(this).attr('data-name')
//     el = $(this)
//     $.ajax({
//       url: 'request.php',
//       method:'POST',
//       type: 'POST',
//       data: {
//             table: table,
//             title: title,
//             id:id,
//             type: 'select-get'
//             },       
//     success:function (resp) {
//       console.log(resp)
//       resp=$.parseJSON(resp) 
//       html = "<select name='"+name+"' class='simple-select-edit'>"
//       for (i = 0; i < resp.length; i++){
//         if (resp[i]['id'] === id){
//           html += "<option value="+resp[i]['id']+" selected>"+resp[i]['name']+"</option>"
//         } else {
//           html += "<option value="+resp[i]['id']+">"+resp[i]['name']+"</option>"
//         }
//       }
//       html += "</select>"
//       console.log(html)
//       el.html(html)
//     }
//   })
// })

// $(document).on('change', '.simple-select-edit', function(){
//   table = $(this).closest('table').attr('data-table')
//   title = $(this).attr('name')
//   id = $(this).closest('tr').attr('data-id')
//   val = $(this).val()
//   selectedText  =  $("select option:selected").text();
//   el = $(this).closest('td');
//   $.ajax({
//     url: 'request.php',
//     method:'POST',
//     type: 'POST',
//     data: {
//           table: table,
//           title: title,
//           id:id,
//           val: val,
//           type: 'tdedit'
//            },       
// success:function (resp) {
//   console.log(resp)
//   if (resp.indexOf('ok')) {                                                                    
//       $('<div id="status">Данные успешно сохранены</div>')   
//                 .insertAfter('.main')
//                 .addClass("success")
//                 .fadeIn('fast')
//                 .delay(4000)
//                 .fadeOut('slow', function() {this.remove();}); 
//                 el.children('select').remove();
//                 el.attr('data-id', val);
//                 el.text(selectedText);
//                 date = new Date()
//                 day = date.getDate();
//                 day = day<10 ? '0'+day : day;
//                 month = date.getMonth()<9 ? '0'+(date.getMonth()+1) : date.getMonth()+1;
//                 date = day + "-" + month + "-" + date.getFullYear() + ' ' + date.getHours() + ":" + date.getMinutes();
//                 el.closest('tr').children('td:nth-child(9)').text(date)
//         }
//           else
//         {
//           $('<div id="status">Запрос завершился ошибкой</div>')
//               .insertAfter('.main')
//               .addClass("error")
//               .fadeIn('fast')
//               .delay(4000)
//               .fadeOut('slow', function() {this.remove();}); 
//         }
//     }

// })
// })



$('.multiselect_checkbox').click(function(){
	if ($(this).is(':checked')){
    $(this).closest('.multiselect_block').children('.field_select').css('display', 'block')
  } else {
    $(this).closest('.multiselect_block').children('.field_select').css('display', 'none')
  }
})


let multiselect_block = document.querySelectorAll(".multiselect_block");
multiselect_block.forEach(parent => {
    let label = parent.querySelector(".field_multiselect");
    let select = parent.querySelector(".field_select");
    let text = label.innerHTML;
    select.addEventListener("change", function(element) {
        let selectedOptions = this.selectedOptions;
        console.log(this.value)
        label.innerHTML = "";
        for (let option of selectedOptions) {
          option.selected = true
          
            let button = document.createElement("button");
            button.type = "button";
            button.className = "btn_multiselect";
            button.textContent = option.text;
            button.onclick = _ => {
                option.selected = false;
                button.remove();
                if (!select.selectedOptions.length) label.innerHTML = text
            };
            label.append(button);
        }
    })
})


// Фильтрация
$('.field_select').not('.filter_calendar').change(function(){
  data = {}
 for (i = 0; i < $('.field_select').length; i++){
  item = $('.field_select').eq(i)
  data[item.attr('name')] = item.val().join(',')
 }
 console.log($('.filter').attr('id') )
 data['table'] = $('.filter').attr('id') 
 data['type'] = 'filter'
 console.log(data)

 $.ajax({
  url: 'request.php',
  method:'POST',
  type: 'POST',
  headers: {
    'Content-Type': 'applicaton/x/www-forum/unlencoded'
  }, 
  data: JSON.stringify(data),       
  success:function (resp) {
    console.log(resp)
     html=''
     resp=$.parseJSON(resp)
          
     for (i = 0; i < resp.length; i++){
      html+="<a href='index.php?p=attendance&idgr="+resp[i]['id']+"'><div class='groupteg'>"+resp[i]['name']+"</div></a>"
     }
     $('.linegroup').html(html)
  }
})

  
})

$('#date-from, #date-to').change(function(){
  date1 = $('#date-from').val()
  date2 = $('#date-to').val()
  $.ajax({
    url: 'request.php',
    method:'POST',
    type: 'POST',
    data: {
      type: 'sammary-pay',
      date1: date1,
      date2: date2
    },       
    success:function (resp) {
      resp=$.parseJSON(resp) 
     
      month_name = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
      str = ''
      totalSum = 0
      count = 0
      N = 0
      BN = 0
      QR = 0
      site = 0
      $.ajax({
        url: 'request.php',
        method:'POST',
        type: 'POST',
        data: {
          type: 'getWay'
        },       
        success:function (way) {
          way=$.parseJSON(way) 
          wayArray = [];
        for (j=0; j < way.length; j++) {
         wayArray[way[j]['name']] =  0
        }
      for (let i=0; i < resp.length; i++) {
        row = resp[i];
        str += `
        <tr data-id=${row['id']}>
          <td style='cursor:pointer'>${i}</td>
          <td class='leftp'>${new Date(row['date-create']*1000).toLocaleDateString()}</td>
          <td class='leftp'>${row['user']}</td>
          <td class='leftp'>${row['group']}</td>
          <td class='leftp'><input type='text' style='width:120px' name='price' class='tdedit' value='${row['price']}'></td>
          <td class='leftp'>${month_name[row['month']-1]}</td>
          <td class='leftp select-edit' data-table='pay-type' data-title='name' data-id=${row['id-type']} data-name='type'>${row['type']}</td>
          <td class='leftp select-edit' data-table='pay-way' data-title='name' data-id=${row['id-way']} data-name='way'>${row['way']}</td>
          <td class='leftp'>${new Date(row['date_change']*1000).toLocaleDateString()}</td>
          <td><i class='fa fa-trash fa-lg delete' id=pay-${row['id']}></i></td>
        </tr>`
        totalSum+=parseInt(row['price'])
        count++
       
        wayArray[row['way']]++
      }
      wayStr =''
      for (key in wayArray){
        wayStr +=`<div class="item">
        <div class="sammaryCards-value">${wayArray[key]}</div>
        <div class="sammaryCards-explanation">${key}</div>
      </div>`
      }
      document.querySelector('tbody').innerHTML = str;
      document.querySelector('#totalPaySum').innerHTML = totalSum;
      document.querySelector('#countSum').innerHTML = count;
      document.querySelector('#countByWay').innerHTML = wayStr;
    }
  })
    }
  })
})

document.querySelector('#search_for_table').addEventListener('keyup', function (event) {
  if (event.keyCode === 13) {
    search_for_table()
}
})

// Поиск
function search_for_table() {
  // Объявить переменные
  let input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search_for_table");
  filter = input.value.toUpperCase();
  // table = document.querySelector("td");
  // tbody = table.getElementsByTagName('tbody')
  // tr = tbody[0].getElementsByTagName("tr");
   tr = document.getElementsByTagName("tr");
  // Перебирайте все строки таблицы и скрывайте тех, кто не соответствует поисковому запросу
  
 
  for (i = 0; i < tr.length; i++) {
    if (tr[i].querySelectorAll("th").length==0) {
      td = tr[i].querySelectorAll("td");
      flag = false
      if (td) {
        for (j = 0; j < td.length; j++) {
          txtValue = td[j].tagName == 'INPUT' ? td[j].value : td[j].textContent || td[j].innerText || td[j].value;
          if (txtValue) {
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              flag = true
            }
          } 
        }
    }
    if (flag) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
}
}
}
/* Добавление тега */
$('#okaddtag').click(function(){
  $('.attantion_error').remove()
  val = $('#addtag').val()
  if (val) {
      $.ajax({
    url: 'request.php',
    method:'POST',
    type: 'POST',
    data: {
      type: 'addtag',
      val: val,
    },       
    success:function (resp) {
      resp = parseInt(resp)
      console.log(resp)
      
      if (typeof parseInt(resp) == 'number') { 
        $('ul.ks-cboxtags').append(`<li><input type="checkbox" id="checkbox${resp}" value=${resp} name="tags"><label for="checkbox${resp}">${val}</label></li>`)
        $('#addtag').val('')
      }
    }
  })
  } else {
    $('.new_tag').append("<div class='attantion_error'>Не заполнено поле</div>")
  }

})
$(document).on('change', '.tags input[name=tags]', function(){
  id_tag = $(this).val()
  id_course = $(this).closest('ul').attr('data-course')
  ischecked = $(this).is(':checked')
  console.log(id_tag, id_course, ischecked)
  $.ajax({
    url: 'request.php',
    method:'POST',
    type: 'POST',
    data: {
      type: 'addtagforcourse',
      id_tag: id_tag,
      ischecked: ischecked,
      id_course: id_course
    },       
    success:function (resp) {
      console.log(resp)
      
    }
  })
})
$('#save_tag').click(function(){
  window.location = 'index.php?p=course'
})

//Фильтрация

// function filter() {
//   data = {}
//   for (i = 0; i < $('.filter_item').length; i++){
//    item = $('.filter_item').eq(i)
//    if (item.attr('type') !== 'date') {
//        data[item.attr('name')] = item.val().join(',')
//    } else {
//      data[item.attr('name')] = item.val()
//    }
 
//   }
//   data['page'] = $('.filter').attr('id') 
//   console.log(data['page'])
//   data['type'] = 'filter'
//   console.log(data)
//   $.ajax({
//    url: 'request.php',
//    method:'POST',
//    type: 'POST',
//    data: data,       
//    success:function (resp) {
//      console.log(resp)
//      resp=$.parseJSON(resp)
//      html = ''
     
//      for (i = 0; i < resp.length; i++){
       
//        if (data['page'] == 'work_performed'){
//        date = new Date(resp[i]['date_of_completion']*1000)
//        date_val = date.getFullYear()+'-'
//        date_val += date.getMonth() < 10 ? '0'+(date.getMonth()+1)+'-' : (date.getMonth()+1)+'-'
//        date_val += date.getDate() < 10 ? '0'+date.getDate() : date.getDate()
//       html += `<tr data-id=${resp[i]['id']}>
//        <td>${i+1}</td>
//        <td><input type='date' style='width:120px' name='date_of_completion' class='tdedit' value='${date_val}'></td>
//        <td class='leftp select-edit' data-table='employees' data-title='lastname-firstname-patronymic' data-id=${resp[i]['id_employees']} data-name='id_employees'>${resp[i]['name_eployees']}</td>
   
//        <td class='leftp select-edit' data-table='types_of_work' data-title='name' data-id=${resp[i]['id_type_of_work']} data-name='id_types_of _work'>${resp[i]['name']}</td>
//        <td><input type='text' style='width:120px' name='volume' data-type='num' class='tdedit' value='${resp[i]['volume']}'></td>
//        <td><input type='text' style='width:120px' name='hours' data-type='num' class='tdedit' value='${resp[i]['hours']}'></td>
//        <td class='leftp select-edit' data-table='shift' data-title='name' data-id=${resp[i]['id_shift']} data-name='shift'>${resp[i]['shift']}</td>
//        <td><i class='fa fa-trash fa-lg delete' data-table='work_performed' id=${resp[i]['id']}></i></td>
//        </tr>`
//        }
//     }
//     document.querySelector('tbody').innerHTML = html;
//    }
//  })
// }
// $('.filter_item').change(function(){
//   filter()
// }) 