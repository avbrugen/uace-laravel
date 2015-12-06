<!doctype html>
<html lang="uk-UA">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Товарною біржою «Українська агропромислова» створена проста та прозора система електронних торгів, що унеможливлює прояви будь-якої корупції та створює чесні правила на ринку біржової торгівлі."/>
    <title>ТОВАРНА БІРЖА "УКРАЇНСЬКА АГРОПРОМИСЛОВА"</title>
    <link rel="stylesheet" href="//uace.com.ua/static/css/bootstrap.css" />
    <link rel="stylesheet" href="//uace.com.ua/static/css/main.css" />
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,600italic,700,700italic,800,800italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="//uace.com.ua/favicon.ico" type="image/x-icon" />
        
    <!--[if lt IE 9]>
	  <script src="https://www.uace.com.ua/static/js/html5shiv.min.js"></script>
	  <script src="https://www.uace.com.ua/static/js/respond.min.js"></script>
	<![endif]-->
   
   <!-- Новый сервер -->
    
</head>
<body class="lang-ukr">

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-70780724-1', 'auto');
  ga('send', 'pageview');

</script>


<div id="link_to_auction">
    <div class="container">
        <a href="/auctions">СИСТЕМА ЕЛЕКТРОННИХ ТОРГІВ</a>
    </div>
</div>

<header id="top_header">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 col-md-3 col-lg-3">
                <a href="/"><div class="logo"></div></a>
            </div>
            <div class="col-xs-5 col-md-5 col-lg-4 col_info">
                <h1>ТОВАРНА БІРЖА<br>"УКРАЇНСЬКА АГРОПРОМИСЛОВА"</h1>
                <div class="contacts">Україна, Київ, вул. Богдана Хмельницького, 55 оф. 811<br>тел. (096) 493-<span>53-35</span>, (050) 149-<span>53-35</span>, (093) 922-<span>53-35</span><br>E-mail: <a href="/cdn-cgi/l/email-protection#deb7b0b8b19eabbfbdbbf0bdb1b3f0abbf"><span class="__cf_email__" data-cfemail="c9a0a7afa689bca8aaace7aaa6a4e7bca8">[email&#160;protected]</span><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></a></div>
            </div>
            <div class="col-xs-3 col-md-3 col-lg-2 col_social">
                <div class="soc_buttons clearfix">
                    <a href="https://twitter.com/TB_UACE" target="_blank" class="soc_button rss"></a>
                    <a href="https://www.facebook.com/uace.com.ua" target="_blank" class="soc_button fb"></a>
                    <a href="http://vk.com/uace_trade" target="_blank" class="soc_button vk"></a>
                </div>
            </div>
            <div class="col-lg-3 choice_lang">
                <div class="row">
                    <div class="col-xs-4"><a href="https://www.uace.com.ua/lang/ukr" class="lang ukr"><i></i>Укр.</a></div>
                    <div class="col-xs-4"><a href="#" class="lang eng"><i></i>Англ.</a></div>
                    <div class="col-xs-4"><a href="https://www.uace.com.ua/lang/ru" class="lang ru"><i></i>Рус.</a></div>
                </div>
                <form id="search" action="/auction/search" method="get">
                    <input type="text" name="q" placeholder="Пошук..." class="search-input">
                </form>
            </div>
        </div>
    </div>
</header>


<div class="container">
<h3>Відомості про проведені торги</h3>
<?
if ($_POST['uordids']!=""){
$ordid=$_POST['ordid'];
}
?>
<form method=post action=#>
<table><tr><tr>Введіть номер лоту:</td><td><input type=text name=ordid value="<? echo $ordid;?>"></td><td><input type=submit name=uordids value='Отримати'></td></tr></table>
</form>

<?
if ($_POST['uordids']!=""){
$ordid=$_POST['ordid'];
$link=mysql_connect('uace00.mysql.ukraine.com.ua', 'uace00_db', 'WFF7jtgW');
$db_selected = mysql_select_db('uace00_db', $link);
mysql_query("set names 'utf8'");
$row=mysql_query("select * from auctions where id=$ordid");
$res=mysql_fetch_array($row);
$htmltext="<h2>$res[1]</h2>";
$htmltext.="<table><tr>";
if ($res['img']!="") {
$htmltext.="<td valign=top><img src=".$res['img']." width=300></td><td style='width:20px;'></td>";
}
$htmltext.="<td valign=top><table>";
$statusx=$res['status'];
switch ($statusx){

case "0": $status='Не затверджено';break;
case "1": $status='Архів';break;
case "2": $status='Реєстрація учасників';break;
case "3": $status='Відбуваються торги';break;
case "4": $status='Підписання протоколу';break;
case "5": $status='Очікування сплати';break;
case "6": $status='Складання акту';break;
case "7": $status='Торги відбулися';break;
case "8": $status='Торги не відбулися';break;
case "9": $status='Торги зупинені';break;
case "10": $status='Торги припинені';break;
 
}
$statusx=$res['region'];
switch ($statusx){

case "0": $region='';break;
case "1": $region='Вінницька область';break;
case "2": $region='Волинська область';break;
case "3": $region='Дніпропетровська область';break;
case "4": $region='Донецька область';break;
case "5": $region='Житомирська область';break;
case "6": $region='Закарпатська область';break;
case "7": $region='Запорізька область';break;
case "8": $region='Івано-Франківська область';break;
case "9": $region='Київська область';break;
case "10": $region='Кіровоградська область';break;
case "11": $region='Крим';break;
case "12": $region='Луганська область';break;
case "13": $region='Львівська область';break;
case "14": $region='Миколаївська область';break;
case "15": $region='Одеська область';break;
case "16": $region='Полтавська область';break;
case "17": $region='Рівненська область';break;
case "18": $region='Сумська область';break;
case "19": $region='Тернопільська область';break;
case "20": $region='Харківська область';break;
case "21": $region='Херсонська область';break;
case "22": $region='Хмельницька область';break;
case "23": $region='Черкаська область';break;
case "24": $region='Чернігівська область';break;
case "25": $region='Чернівецька область';break;
}
$row1=mysql_query("select * from users where id=$res[3]");
$res1=mysql_fetch_array($row1);
$row2=mysql_query("select * from bets where auction_id=$ordid group by user_id");
$kolvo=mysql_num_rows($row2);

$fio=$res1[2]." ".$res1[4]." ".$res1[3];
$htmltext.="<tr><td>Статус лота</td><td style='padding-left:10px;'>$status</td></tr>";
$htmltext.="<tr><td>Опубліковано на сайті</td><td style='padding-left:10px;'>".$res['updated_at']."</td></tr>";
$htmltext.="<tr><td>Місцезнаходження лота</td><td style='padding-left:10px;'>$region, ".$res['city']."</td></tr>";
$htmltext.="<tr style='font-weight:bold;'><td>Стартова ціна лоту</td><td style='padding-left:10px;'>".$res['starting_price']." грн.</td></tr>";
$htmltext.="<tr><td>Крок аукціону</td><td style='padding-left:10px;'>".$res['bid_price']." грн.</td></tr>";
$htmltext.="<tr style='font-weight:bold;'><td>Замовник торгів/названеплатоспроможного банку</td><td style='padding-left:10px;'><a href=https://uace.com.ua/auctions/profile/$res1[0]/lots>".$fio."</a></td></tr>";
$htmltext.="<tr><td>Дата і час початку прийому заяв учасників</td><td style='padding-left:10px;'>".$res['created_at']."</td></tr>";
$htmltext.="<tr><td>Дата і час закінчення прийому заяв учасників</td><td style='padding-left:10px;'>".$res['created_at']."</td></tr>";
$htmltext.="<tr><td>Дата початку аукціону</td><td style='padding-left:10px;'>".$res['data_start']."</td></tr>";
$htmltext.="<tr><td>Дата закінчення аукціону</td><td style='padding-left:10px;'>".$res['date_end']."</td></tr>";
//$htmltext.="<tr><td>Найвища цінова пропозиція</td><td style='padding-left:10px;'>".$res['final_price']." грн.</td></tr>";
$htmltext.="<tr><td>Кількість учасників аукціону</td><td style='padding-left:10px;'>".$kolvo."</td></tr>";
$counter=0;
$row2=mysql_query("select * from bets where auction_id=$ordid order by bet desc");
while($res2=mysql_fetch_array($row2)){
$counter++;
$rowx=mysql_query("select * from users where id=$res2[2]");
$resx=mysql_fetch_array($rowx);
$fiox=$resx[2]." ".$resx[4]." ".$resx[3];
//$htmltext.="<tr";
if ($counter==1) {$maxbid=$res2[3];
//$htmltext.=" style='font-weight:bold' ";
}
//$htmltext.="><td>$fiox</td><td>$res2[5]</td><td>$res2[3] грн.</td></tr>";
}

$htmltext.="<tr><td>Найвища цінова пропозиція</td><td style='padding-left:10px;'>".$maxbid." грн.</td></tr>";

$htmltext.="</table></td>";
$htmltext.="</tr></table>";
$htmltext.="<h3>Учасникі торгів</h3><table width=80%>
<tr><td align=center><b>ID учасника</td><td align=center><b>Дата та час ставки учасника</td><td align=center><b>Цінова пропозиція</td></tr>";
$row2=mysql_query("select * from bets where auction_id=$ordid order by bet desc");
$counter=0;
while($res2=mysql_fetch_array($row2)){
$counter++;
$rowx=mysql_query("select * from users where id=$res2[2]");
$resx=mysql_fetch_array($rowx);
$fiox=$resx[2]." ".$resx[4]." ".$resx[3];
$htmltext.="<tr";
if ($counter==1) {$maxbid=$res2[3];$htmltext.=" style='font-weight:bold' ";}
$htmltext.="><td align=center>$res2[2]</td><td align=center>$res2[5]</td><td align=center>$res2[3] грн.</td></tr>";
}

$htmltext.="</table>";
print $htmltext;
}
?>

</div>

<footer id="main_footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 col-md-3">
                <div class="logo"></div>
                <div class="copyright">© Права захищені Товарна біржа «Українська агропромислова»</div>
            </div>
            <div class="col-xs-3 col-md-3 visible-lg">
                <div class="col_name">Навігація</div>
                <div class="nav_links">
                    <div class="row">
                        <div class="col-xs-6"><a href="/">Про нас</a><br><a href="/poslugi#c">Послуги</a><br><a href="/contacts#c">Контакти</a><br><a href="/sitemap#c">Карта сайту</a></div>
                        <div class="col-xs-6"><a href="/ogoloshenia#c">Оголошення</a><br><a href="/documents#c">Документи</a><br><a href="/news#c">Новини</a></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-3">
                <div class="col_name">Контакти</div>
                <div class="contacts">
                    <div class="adress"><i></i>Україна, Київ, вул. Богдана Хмельницького, 55 оф. 811</div>
                    <div class="phone"><i></i>(096) 493-<span>53-35</span><br>(050) 149-<span>53-35</span><br>(093) 922-<span>53-35</span></div>
                    <div class="email"><i></i>E-mail: <a href="/cdn-cgi/l/email-protection#0d64636b624d786c6e68236e626023786c"><span class="__cf_email__" data-cfemail="bed7d0d8d1fecbdfdddb90ddd1d390cbdf">[email&#160;protected]</span><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></a></div>
                </div>
            </div>
            <div class="col-xs-3 col-md-3 col_last">
                <a href="/auctions" class="go_auction">СИСТЕМА ЕЛЕКТРОННИХ ТОРГІВ</a><br><br>
                <a href="/public/order/" class="go_auction">Відомості про торги</a>
                <div class="created">Розробка та підтримка:<br><a href="http://lid.labirinth.org/" target="_blank"><img src="/static/images/l.png"></a></div>
            </div>
        </div>
    </div>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter33833349 = new Ya.Metrika({
                    id:33833349,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/33833349" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script type="text/javascript">
/* <![CDATA[ */
(function(){try{var s,a,i,j,r,c,l=document.getElementsByTagName("a"),t=document.createElement("textarea");for(i=0;l.length-i;i++){try{a=l[i].getAttribute("href");if(a&&a.indexOf("/cdn-cgi/l/email-protection") > -1  && (a.length > 28)){s='';j=27+ 1 + a.indexOf("/cdn-cgi/l/email-protection");if (a.length > j) {r=parseInt(a.substr(j,2),16);for(j+=2;a.length>j&&a.substr(j,1)!='X';j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}j+=1;s+=a.substr(j,a.length-j);}t.innerHTML=s.replace(/</g,"&lt;").replace(/>/g,"&gt;");l[i].setAttribute("href","mailto:"+t.value);}}catch(e){}}}catch(e){}})();
/* ]]> */
</script>
</body>
</html>