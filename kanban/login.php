<?
include('connect.php');
if (isset($_POST['oklogin'])) { //если нажата кнопка
	$login=$_POST['login']; //сохраняем логин и праоль в переменные
	$pass=$_POST['pass'];
	$result = mysqli_query($link, "SELECT * FROM `admins` WHERE `login`='".$login."'");
 	if (mysqli_num_rows($result)>0) {
		$admins=mysqli_fetch_assoc($result);
		if (password_verify($pass, $admins['password'])) {
			setcookie('id',$admins['id'],time()+60*60*24);
			$new_url='index.php';
			header('Location: '.$new_url);

		} else {
			echo "Пароль не верный";
		}
 	} else {
 		echo "Логин или пароль не верный";
 	}
 }
 if(isset($_GET['logout'])){
				setcookie('id','');
				$new_url='index.php';
			header('Location: '.$new_url);
			}
?>

<!DOCTYPE html>
<html>
<head>
	<title>CRM</title>
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" type="text/css" href="assets/login.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script  charset="utf-8" type="text/javascript" src="assets/js.js"></script>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link rel="stylesheet" href="assets/form.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
	<div class="bg-letters invite"><div class="bg-letters_container invite_bg"><span class="bg-letters_content" style="min-width: 1404px; letter-spacing: 0.1em; padding-left: 1em;">- b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [ - b 2 8 z * 2 . { m \ 9 2 r b [ b a h , d n \ - 6 ] 0 k ? x 9 5 n } ! | { k b * o e f ? b c h x l s x d + 5 / * 9 k g ] v k 1 t 5 5 [ y d ; 5 | } { c ] a ] l z + o = k ? 1 ] t f = e 7 / 2 f + ! p ! l 1 x ! ] , u z ; s = j ! f r d + e 4 z x 9 | 9 . p t g . f z } q d = a h i &amp; - v [ } 0 - 9 ; k t 9 y c m k 8 / , + x e 5 m } 2 ; k f 5 5 9 c 3 g i q q x s k + ; ] d b t 1 } w y e 0 u 7 9 q = / 7 5 t 9 u s g \ [ a t 5 + v m 1 2 3 j \ * . - 8 u w n n w x ; l w e . 2 d k &amp; + } o 2 o | v 6 t f b x 8 ] r z { i / - e &amp; x s s o ; u u j l p 6 8 &amp; p ] . i r i y c m m ? ? w q 1 * + s 3 c t 6 g p \ \ + / q d i } a 4 8 / g u v = ; a ? 5 \ o \ a 1 7 \ ; , w f * d { u d { + c 8 ! c * ! 9 * o - \ u 7 ] ] \ , w m g / d * 9 * 6 d m 2 y [</span></div>
<div  style="height: 100vh; display: flex; justify-content: center;align-items: center;">
<div class="login">
	<form method="POST">
		<h2>Авторизация</h2>
		<input type="text" name="login" placeholder="Введите логин">
		<input type="password" name="pass" placeholder="Введите пароль">
		<input type="submit" name="oklogin" class="oklogin" value="Авторизоваться">
	</form>
</div>
</div>
</body>
</html>