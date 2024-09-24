<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$tmer=time();
/*pull data*/
$finfo=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/fontinfo.csv"));echo "<p>fontinfo.csv ".(time()-$tmer)."s</p>";
$other=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/other.csv"));echo "<p>other.csv ".(time()-$tmer)."s</p>";
$styles=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/styles.csv"));echo "<p>styles.csv ".(time()-$tmer)."s</p>";
$wpu=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/pu.csv"));echo "<p>pu.csv ".(time()-$tmer)."s</p>";
$wkusuli=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/kusuli.csv"));echo "<p>kusuli.csv ".(time()-$tmer)."s</p>";
$wkulili=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/kulili.csv"));echo "<p>kulili.csv ".(time()-$tmer)."s</p>";
$wante=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/ante.csv"));echo "<p>ante.csv ".(time()-$tmer)."s</p>";
$wnamako=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/namako.csv"));echo "<p>namako.csv ".(time()-$tmer)."s</p>";
$wrad=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/radicals.csv"));echo "<p>radicals.csv ".(time()-$tmer)."s</p>";
$glyphs="https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/glyphs/";

/*prepare the different parts of the page*/

$bodystart='<html><head>
<script src="jszip.min.js"></script>

    <style>

    .ucsur{
        background:lightgrey;
    }

.insa td{
        font-family: initial !important;
    font-size: initial !important;
}
        .sp td,.sp th{display:none;}
        .sp th:nth-child(1){display:table-cell !important;}
@media print { 
.noprint{display:none;}
.sp td,.sp th{display:table-cell;}
.sp tr:nth-child(2),#sona tr:nth-child(1),#features tr:nth-child(1),#features tr:nth-child(2){position:initial;}
table.sp{min-width:100%;}

  table tr,
  table tr td,
  table tr th {
    page-break-inside: avoid;
  }
  .sp{
      page-break-after:always;
  }
}

';
$floadcss="";
$fdiscss="    body{padding:1em;}
    .sp th,td{text-align:center;margin-left:2em;padding:.3em;}
    #features td,.sp td,textarea{font-size:2.5em;line-height:1.5em}


";
$ffamilcss="

";
$ftabchcss="

";
$pret="
{
    display:none;
    }

#cvs,.insa td.hand,.insa td.uni,.insa td.serif,.insa td.pxl,.insa td.alt,.insa td.nonsp{display:none !important;}
.hand .insa td.hand,.uni .insa td.uni,.serif .insa td.serif,.pxl .insa td.pxl,.alt .insa td.alt,.nonsp .insa td.nonsp{display:table-cell !important;}

.sp tr:nth-child(2),#sona tr:nth-child(1),#features tr:nth-child(1),#features tr:nth-child(2){
    background:white;
    position:sticky;
    top:0;
}
#features tr:nth-child(2){top:1.25em;}
#features td{white-space: nowrap;}
</style>
<meta charset='iso-8859-1' />
</head><body id=\"body\" class=\"hand uni serif pxl\"><div class=\"noprint\"><p>If this page isn't working, there is a <a href=\"pdf/sp-fonts-comparison-2024-03-18.pdf\">PDF version from 2024-02-14</a> (<a href=\"https://jumpshare.com/s/GiVJ8RrCGjrU0XRpinhs\">alt link</a>). This page was updated ".date("Y-m-d").".</p><ul><li><a href=\"#pu\">pu glyphs</a></li><li><a href=\"#kusuli\">ku suli glyphs</a></li><li><a href=\"#kulili\">ku lili glyphs</a></li><li><a href=\"#ante\">other glyphs</a></li><li><a href=\"#namako\">special characters</a></li><li><a href=\"#rad\">radicals</a></li><li><a href=\"#sona\">font information</a><ul><li><a href=\"#features\">Feature showcase</a></li><li><a href=\"#pana\">Input field</a></li></ul></li></ul></div>
		<table><tbody><tr><th colspan=\"3\" class=\"ucsur\"><a href=\"https://www.kreativekorp.com/ucsur/charts/sitelen.html\" target=\"_blank\">UCSUR</a>-compliant glyphs have a grey background</td></th></tr>
        <tr class=\"noprint\"><th rowspan=\"7\">styles</th><td><label for=\"check1\">handwritten</label></td><td><input autocomplete=\"off\" id=\"check1\" checked type=\"checkbox\" onclick=\"if(document.body.classList.contains('hand')){document.body.classList.remove('hand');}else{document.body.classList.add('hand');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check2\">uniform line weight</label></td><td><input autocomplete=\"off\" id=\"check2\" checked type=\"checkbox\" onclick=\"if(document.body.classList.contains('uni')){document.body.classList.remove('uni');}else{document.body.classList.add('uni');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check3\">alternating line weight</label></td><td><input autocomplete=\"off\" id=\"check3\" checked type=\"checkbox\" onclick=\"if(document.body.classList.contains('serif')){document.body.classList.remove('serif');}else{document.body.classList.add('serif');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check4\">block based</label></td><td><input autocomplete=\"off\" checked id=\"check4\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('pxl')){document.body.classList.remove('pxl');}else{document.body.classList.add('pxl');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check5\">alternative design/<br>sitelen pona inspired</label></td><td><input autocomplete=\"off\" id=\"check5\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('alt')){document.body.classList.remove('alt');}else{document.body.classList.add('alt');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check6\">non-sitelen-pona writing systems</label></td><td><input autocomplete=\"off\" id=\"check6\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('nonsp')){document.body.classList.remove('nonsp');}else{document.body.classList.add('nonsp');}return true;\"></td></tr>
        <tr class=\"noprint\" style=\"display:none;\"><td><label for=\"check7\">definitions</label></td><td><input autocomplete=\"off\" id=\"check7\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('def')){document.body.classList.remove('def');}else{document.body.classList.add('def');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check8\">old font versions</label></td><td><input autocomplete=\"off\" id=\"check8\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('old')){document.body.classList.remove('old');}else{document.body.classList.add('old');}return true;\"></td></tr>
        </tbody></table>";

$tpu='<h2>pu glyphs</h2>
<table class="sp" id="pu">
	<tbody>
        <tr class="noprint insa"><th>style</th>';
$tkusuli='	</tbody>
</table>



<h2>ku suli glyphs</h2>

<table class="sp" id="kusuli"><tbody>
    <tr class="noprint insa"><th>style</th>';
$tkulili='
</tbody></table>
<h2>ku lili glyphs</h2>
<table class="sp" id="kulili"><tbody>
    <tr class="noprint insa"><th>style</th>';
$tante='
</tbody></table>
<h2>other glyphs</h2>
<table class="sp" id="ante"><tbody>
    <tr class="noprint insa"><th>style</th>';
$tnamako='</tbody></table>


<h2>special characters</h2>
<table class="sp" id="namako"><tbody>
    <tr class="noprint insa"><th>style</th>';

$trad='</tbody></table>


<h2>radicals</h2>
<table class="sp" id="rad"><tbody>
    <tr class="noprint insa"><th>style</th>';

$tinfo='</tbody></table>

<div class="noprint"><h2>font information</h2>
<table id="sona"><tbody>';
$tfeature='</tbody></table>
</div>

<h3>Feature showcase</h3>
<table id="features"><tbody>
    <tr><th>font</th><th colspan="2">cartouches</th><th colspan="3">combined glyphs</th><th colspan="2">long pi</th><th>long other glyphs</th></tr>
    <tr><th></th><th>(no extension character)</th><th>(with extension character)</th><th>(scaled)</th><th>(stacked)</th><th>(ZWJ or other)</th><th>(no extension character)</th><th>(with extension character)</th><th>(analogous to long pi)</th></tr>
    ';

$finput='</tbody></table>

<div class="noprint"><h3 id="pana">Input field</h3>
<label for="nasinsitelen"><b>font: </b></label><select autocomplete="off" onchange="document.getElementById(\'jo\').className=\'sp \'+document.getElementById(\'nasinsitelen\').value;" id="nasinsitelen">
    <option value="" selected disabled>select font</option>';
$bodyend='</select><br>
<textarea id=\'jo\' class="sp nasinsitelenpumono" style="min-width:8em;">toki</textarea><br><button type="button" onclick="ucsur();">ASCII to UCSUR/UCSUR to ASCII</button><p>fonts not loading for some reason? try <a href="autofont.html">the other input field</a></p></div>
<script>
    var combin="‍";
    const nimi=["a", "akesi", "ala", "alasa", "ale", "anpa", "ante", "anu", "awen", "e", "en", "esun", "ijo", "ike", "ilo", "insa", "jaki", "jan", "jelo", "jo", "kala", "kalama", "kama", "kasi", "ken", "kepeken", "kili", "kiwen", "ko", "kon", "kule", "kulupu", "kute", "la", "lape", "laso", "lawa", "len", "lete", "li", "lili", "linja", "lipu", "loje", "lon", "luka", "lukin", "lupa", "ma", "mama", "mani", "meli", "mi", "mije", "moku", "moli", "monsi", "mu", "mun", "musi", "mute", "nanpa", "nasa", "nasin", "nena", "ni", "nimi", "noka", "o", "olin", "ona", "open", "pakala", "pali", "palisa", "pan", "pana", "pi", "pilin", "pimeja", "pini", "pipi", "poka", "poki", "pona", "pu", "sama", "seli", "selo", "seme", "sewi", "sijelo", "sike", "sin", "sina", "sinpin", "sitelen", "sona", "soweli", "suli", "suno", "supa", "suwi", "tan", "taso", "tawa", "telo", "tenpo", "toki", "tomo", "tu", "unpa", "uta", "utala", "walo", "wan", "waso", "wawa", "weka", "wile", "namako", "kin", "oko", "kipisi", "leko", "monsuta", "tonsi", "jasima", "kijetesantakalu", "soko", "meso", "epiku", "kokosila", "lanpan", "n", "misikeke", "ku", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "pake", "apeja", "majuna", "powe", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];
    const nanpa=[  "%uDB86%uDD00",  "%uDB86%uDD01",  "%uDB86%uDD02",  "%uDB86%uDD03",  "%uDB86%uDD04",  "%uDB86%uDD05",  "%uDB86%uDD06",  "%uDB86%uDD07",  "%uDB86%uDD08",  "%uDB86%uDD09",  "%uDB86%uDD0A",  "%uDB86%uDD0B",  "%uDB86%uDD0C",  "%uDB86%uDD0D",  "%uDB86%uDD0E",  "%uDB86%uDD0F",  "%uDB86%uDD10",  "%uDB86%uDD11",  "%uDB86%uDD12",  "%uDB86%uDD13",  "%uDB86%uDD14",  "%uDB86%uDD15",  "%uDB86%uDD16",  "%uDB86%uDD17",  "%uDB86%uDD18",  "%uDB86%uDD19",  "%uDB86%uDD1A",  "%uDB86%uDD1B",  "%uDB86%uDD1C",  "%uDB86%uDD1D",  "%uDB86%uDD1E",  "%uDB86%uDD1F",  "%uDB86%uDD20",  "%uDB86%uDD21",  "%uDB86%uDD22",  "%uDB86%uDD23",  "%uDB86%uDD24",  "%uDB86%uDD25",  "%uDB86%uDD26",  "%uDB86%uDD27",  "%uDB86%uDD28",  "%uDB86%uDD29",  "%uDB86%uDD2A",  "%uDB86%uDD2B",  "%uDB86%uDD2C",  "%uDB86%uDD2D",  "%uDB86%uDD2E",  "%uDB86%uDD2F",  "%uDB86%uDD30",  "%uDB86%uDD31",  "%uDB86%uDD32",  "%uDB86%uDD33",  "%uDB86%uDD34",  "%uDB86%uDD35",  "%uDB86%uDD36",  "%uDB86%uDD37",  "%uDB86%uDD38",  "%uDB86%uDD39",  "%uDB86%uDD3A",  "%uDB86%uDD3B",  "%uDB86%uDD3C",  "%uDB86%uDD3D",  "%uDB86%uDD3E",  "%uDB86%uDD3F",  "%uDB86%uDD40",  "%uDB86%uDD41",  "%uDB86%uDD42",  "%uDB86%uDD43",  "%uDB86%uDD44",  "%uDB86%uDD45",  "%uDB86%uDD46",  "%uDB86%uDD47",  "%uDB86%uDD48",  "%uDB86%uDD49",  "%uDB86%uDD4A",  "%uDB86%uDD4B",  "%uDB86%uDD4C",  "%uDB86%uDD4D",  "%uDB86%uDD4E",  "%uDB86%uDD4F",  "%uDB86%uDD50",  "%uDB86%uDD51",  "%uDB86%uDD52",  "%uDB86%uDD53",  "%uDB86%uDD54",  "%uDB86%uDD55",  "%uDB86%uDD56",  "%uDB86%uDD57",  "%uDB86%uDD58",  "%uDB86%uDD59",  "%uDB86%uDD5A",  "%uDB86%uDD5B",  "%uDB86%uDD5C",  "%uDB86%uDD5D",  "%uDB86%uDD5E",  "%uDB86%uDD5F",  "%uDB86%uDD60",  "%uDB86%uDD61",  "%uDB86%uDD62",  "%uDB86%uDD63",  "%uDB86%uDD64",  "%uDB86%uDD65",  "%uDB86%uDD66",  "%uDB86%uDD67",  "%uDB86%uDD68",  "%uDB86%uDD69",  "%uDB86%uDD6A",  "%uDB86%uDD6B",  "%uDB86%uDD6C",  "%uDB86%uDD6D",  "%uDB86%uDD6E",  "%uDB86%uDD6F",  "%uDB86%uDD70",  "%uDB86%uDD71",  "%uDB86%uDD72",  "%uDB86%uDD73",  "%uDB86%uDD74",  "%uDB86%uDD75",  "%uDB86%uDD76",  "%uDB86%uDD77",  "%uDB86%uDD78",  "%uDB86%uDD79",  "%uDB86%uDD7A",  "%uDB86%uDD7B",  "%uDB86%uDD7C",  "%uDB86%uDD7D",  "%uDB86%uDD7E",  "%uDB86%uDD7F",  "%uDB86%uDD80",  "%uDB86%uDD81",  "%uDB86%uDD82",  "%uDB86%uDD83",  "%uDB86%uDD84",  "%uDB86%uDD85",  "%uDB86%uDD86",  "%uDB86%uDD87",  "%uDB86%uDD88",  "%uDB86%uDD89",  "%uDB86%uDD8A",  "%uDB86%uDD8B",  "%uDB86%uDD8C",  "%uDB86%uDD8D",  "%uDB86%uDD8E",  "%uDB86%uDD8F",  "%uDB86%uDD90",  "%uDB86%uDD91",  "%uDB86%uDD92",  "%uDB86%uDD93",  "%uDB86%uDD94",  "%uDB86%uDD95",  "%uDB86%uDD96",  "%uDB86%uDD97",  "%uDB86%uDD98",  "%uDB86%uDD99",  "%uDB86%uDD9A",  "%uDB86%uDD9B",  "%uDB86%uDD9C",  "%uDB86%uDD9D",  "%uDB86%uDD9E",  "%uDB86%uDD9F",  "%uDB86%uDDA0",  "%uDB86%uDDA1",  "%uDB86%uDDA2",  "%uDB86%uDDA3",  "%uDB86%uDDA4",  "%uDB86%uDDA5",  "%uDB86%uDDA6",  "%uDB86%uDDA7",  "%uDB86%uDDA8",  "%uDB86%uDDA9",  "%uDB86%uDDAA",  "%uDB86%uDDAB",  "%uDB86%uDDAC",  "%uDB86%uDDAD",  "%uDB86%uDDAE",  "%uDB86%uDDAF",  "%uDB86%uDDB0",  "%uDB86%uDDB1",  "%uDB86%uDDB2",  "%uDB86%uDDB3",  "%uDB86%uDDB4",  "%uDB86%uDDB5",  "%uDB86%uDDB6",  "%uDB86%uDDB7",  "%uDB86%uDDB8",  "%uDB86%uDDB9",  "%uDB86%uDDBA",  "%uDB86%uDDBB",  "%uDB86%uDDBC",  "%uDB86%uDDBD",  "%uDB86%uDDBE",  "%uDB86%uDDBF",  "%uDB86%uDDC0",  "%uDB86%uDDC1",  "%uDB86%uDDC2",  "%uDB86%uDDC3",  "%uDB86%uDDC4",  "%uDB86%uDDC5",  "%uDB86%uDDC6",  "%uDB86%uDDC7",  "%uDB86%uDDC8",  "%uDB86%uDDC9",  "%uDB86%uDDCA",  "%uDB86%uDDCB",  "%uDB86%uDDCC",  "%uDB86%uDDCD",  "%uDB86%uDDCE",  "%uDB86%uDDCF",  "%uDB86%uDDD0",  "%uDB86%uDDD1",  "%uDB86%uDDD2",  "%uDB86%uDDD3",  "%uDB86%uDDD4",  "%uDB86%uDDD5",  "%uDB86%uDDD6",  "%uDB86%uDDD7",  "%uDB86%uDDD8",  "%uDB86%uDDD9",  "%uDB86%uDDDA",  "%uDB86%uDDDB",  "%uDB86%uDDDC",  "%uDB86%uDDDD",  "%uDB86%uDDDE",  "%uDB86%uDDDF",  "%uDB86%uDDE0",  "%uDB86%uDDE1",  "%uDB86%uDDE2",  "%uDB86%uDDE3",  "%uDB86%uDDE4",  "%uDB86%uDDE5",  "%uDB86%uDDE6",  "%uDB86%uDDE7",  "%uDB86%uDDE8",  "%uDB86%uDDE9",  "%uDB86%uDDEA",  "%uDB86%uDDEB",  "%uDB86%uDDEC",  "%uDB86%uDDED",  "%uDB86%uDDEE",  "%uDB86%uDDEF",  "%uDB86%uDDF0",  "%uDB86%uDDF1",  "%uDB86%uDDF2",  "%uDB86%uDDF3",  "%uDB86%uDDF4",  "%uDB86%uDDF5",  "%uDB86%uDDF6",  "%uDB86%uDDF7",  "%uDB86%uDDF8",  "%uDB86%uDDF9",  "%uDB86%uDDFA",  "%uDB86%uDDFB",  "%uDB86%uDDFC",  "%uDB86%uDDFD",  "%uDB86%uDDFE",  "%uDB86%uDDFF"];
    let jo=document.getElementById(\'jo\');
    function ucsur(){
        var t=jo.value;
        t=t.replace(/ali/g,"ale");
        let l=t.split(//);
        t="";
        for(var i=0;i<l.length;i++){
            if (nimi.includes(l[i])){
                t+=unescape(nanpa[nimi.indexOf(l[i])]);
            }else{
                inew=l[i];
                for(var j=0;j<nanpa.length;j++){
                    inew=inew.split(unescape(nanpa[j])).join(nimi[j]);
                }
                t+=inew;
            }
        }
        
        document.getElementById(\'jo\').value=t;
    }
    function comb(){
        var t=jo.value;
        var font=document.getElementById(\'jo\').className.split(" ").slice(-1)[0];
        var flist=document.getElementById(\'pu\').children[0].children[2].children;
        for(var i=1;i<flist.length;i++){
            if(window.getComputedStyle(flist[i]).getPropertyValue("font-family")==font){
                var findex=i;
                break;
            }
        }
        var chars=[];
        var tabls=["pu","kusuli","kulili","ante"];
        for (i=0;i<tabls.length;i++){
            var tabl=document.getElementById(tabls[i]).children[0].children;
            for(var j=2;j<tabl.length;j++){
                try{chars.push(tabl[j].children[findex].innerHTML.split("<")[0]);}
                catch(e){}
            }
        }
        for(i=0;i<chars.length;i++){
            for (j=0;j<chars.length;j++){
                t+=chars[i]+combin+chars[j]+" ";
            }
        }
        jo.value=t;
    }



function listFonts() {
  let { fonts } = document;
  const it = fonts.entries();

  let arr = [];
  let done = false;

  while (!done) {
    const font = it.next();
    if (!font.done) {
      arr.push(font.value[0].family);
    } else {
      done = font.done;
    }
  }

  // converted to set then arr to filter repetitive values
  return [...new Set(arr)];
}


var c;
var ctx;
var d;

function nimirender(x){
    c=document.createElement("canvas");
    c.id="cvs";
    document.body.appendChild(c);
    c=document.getElementById("cvs") ;
    ctx=c.getContext("2d");
    ctx.textBaseline ="top" ;
    ctx.textAlign="center" ;
    d=document.createElement("div");
    d.id="pokiawen";
    document.body.appendChild(d);
    d=document.getElementById("pokiawen") ;
    var isx=nimid(x);
    if(!(isx)){
        for(var i=0;i<isx.length;i++){
            try{renderglyph(isx[i],x,);}catch(e){console.log(i);}
        }
    }
}

function nimid(x){
    var spt=document.getElementsByTagName("table");
    for (var i=0;i<spt.length;i++){
        if (spt[i].classList.contains("sp")){
            var nimis=spt[i].getElementsByTagName("tr");
            for(var j=2;j<nimis.length;j++){
                var curnimi=nimis[j].getElementsByTagName("th")[0].innerText;
                if (curnimi==x){
                    return nimis[j].getElementsByTagName("td");
                }
            }
        }
    }
    return false;
}

function render(x){
    c=document.createElement("canvas");
    c.id="cvs";
    document.body.appendChild(c);
    c=document.getElementById("cvs") ;
    ctx=c.getContext("2d");
    d=document.createElement("div");
    d.id="pokiawen";
    document.body.appendChild(d);
    d=document.getElementById("pokiawen") ;
    var spt=document.getElementsByTagName("table");
    for (var i=0;i<spt.length;i++){
        if (spt[i].classList.contains("sp")){
            var nimis=spt[i].getElementsByTagName("tr");
            for(var j=2;j<nimis.length;j++){
                var row=nimis[j].getElementsByTagName("td");
                var curnimi=nimis[j].getElementsByTagName("th")[0].innerText;
                for (var k=0;k<row.length;k++){
                    
                    if(k==x){
                        try{renderglyph(row[k],curnimi,nimis[1].children[k+1].innerText);}catch(e){console.log(k);}
                    }
                }
            }
        }

    }
}
function renderglyph(elem,nimini,fontname){
    if(elem.innerText.trim().length === 0){return false;}
    if(window.getComputedStyle(elem,null).getPropertyValue("display")=="none"){return false;}
    c.width=10000;
    c.height=1500;
    var curfont=window.getComputedStyle(elem,null).getPropertyValue("font-family");
    var curtxt=elem.innerText;
    var fsize=300;
    ctx.font=fsize+"px "+curfont;
    /*ctx.textBaseline ="top" ;*/
    ctx.textBaseline ="middle" ;
    /*ctx.textAlign="left" ;*/
    ctx.textAlign="center" ;
    /*ctx.fillText(curtxt,0,fsize*.2) ;*/
    ctx.fillText(curtxt,c.width/2,c.height/2) ;
    try{
        /*cropImageFromCanvas(ctx,w=ctx.measureText(curtxt).width,h=fsize*1.4);*/
        cropImageFromCanvas(ctx);
        var img=c.toDataURL(\'image/png\');
        var p=document.createElement("img");
        p.src=img;
        p.download=fontname+"_"+nimini;
        d.appendChild(p);
    }catch(e){console.log(fontname);}
    ctx.clearRect(0, 0, c.width, c.height);
}
function cropImageFromCanvas(cntx,w=false,h=false) {
  var canvas = cntx.canvas, 
    pix = {x:[], y:[]},
    imageData = cntx.getImageData(0,0,canvas.width,canvas.height),
    x, y, index;
 if(w===false){var w = canvas.width;}else{}
 if(h===false){var h = canvas.height;}else{}
  
  /**/for (y = 0; y < h; y++) {
    for (x = 0; x < w; x++) {
      index = (y * w + x) * 4;
      if (imageData.data[index+3] > 0) {
        pix.x.push(x);
        pix.y.push(y);
      } 
    }
  }
  pix.x.sort(function(a,b){return a-b});
  pix.y.sort(function(a,b){return a-b});
  var n = pix.x.length-1;
  
  w = 1 + pix.x[n] - pix.x[0];
  h = 1 + pix.y[n] - pix.y[0];
  var cut = cntx.getImageData(pix.x[0], pix.y[0], w, h);
  /*var cut = cntx.getImageData(0,0, w, h);*/

  canvas.width = w;
  canvas.height = h;
  cntx.putImageData(cut, 0, 0);
        
  var image = canvas.toDataURL();
}

function downloadz(){
    var lipuawen = new JSZip();
    for (var i=0;i<pokiawen.childElementCount;i++){
        lipuawen.file(pokiawen.children[i].download+".png",pokiawen.children[i].src.replace("data:image/png;base64,",""), {base64: true});
    }
    
    lipuawen.generateAsync({type:"base64"}).then(function (base64) {
        var newz=document.createElement("a");
    newz.href="data:application/zip;base64,"+base64;
    var newzt=document.createTextNode("Download ZIP");
    newz.appendChild(newzt);
    document.body.appendChild(newz);
    });

}

function singlefont(fontname){
    var flist=document.getElementById("pu").children[0].children[1].children;
    var fnum=0;
    for(var i=0;i<flist.length;i++){
        if(fontname==flist[i].innerHTML){fnum=i;break;}
    }
    if (fnum>0){
        var tabs=document.getElementsByClassName("sp");
        var npr=document.getElementsByClassName("noprint");
        for(var n=0;n<npr.length;n++){
            npr[n].style.setProperty("display","none","important");
        }
        document.getElementById("features").style.display="none";
        document.getElementById("features").previousElementSibling.style.display="none";
        for(n=0;n<tabs.length;n++){
            if(tabs[n].tagName!="TABLE"){continue;}
            var tabl=tabs[n];
            var trow=tabl.getElementsByTagName("tr");
            /*trow[0].style.setProperty("display","none","important");*/
            trow[1].style.setProperty("width","100%");
            trow[1].style.setProperty("text-align","center");

            for(var j=1;j<trow.length;j++){
                trow[j].style.display="inline-block";
                tcel=trow[j].children;
                for (var k=0;k<tcel.length;k++){
                    if(k!=fnum){
                        tcel[k].style.setProperty("display","none","important");
                    }else{
                        if(j==1){
                            tcel[k].style.setProperty("width","100%");
                            tcel[k].style.setProperty("display","block");
                        }
                        tcel[k].style.setProperty("margin","0");
                        tcel[k].style.setProperty("padding","0");
                        /*if(window.getComputedStyle(tcel[k]).width.split("px")[0]<10){tcel[k].style.setProperty("display","none");}*/
                    }
                }
                if(window.getComputedStyle(trow[j]).width.split("px")[0]<10){trow[j].style.setProperty("display","none");}
            }
            if(window.getComputedStyle(tabl).height.split("px")[0]<50){
                tabl.previousElementSibling.style.display="none";
                tabl.style.display="none";
            }
        }
    }
}
var q=new URLSearchParams(window.location.search);
if(q.get("singlefont")){singlefont(q.get("singlefont"));}
</script>


<script>
/*  workaround for Chromium by waso Keli

    Chrome has a bug where ligatures aren\'t properly applied at typing-time. for example, if you type "pona", it erroneously shows a p followed by a sideways 6, rather than one smile.
    i work around this by refreshing the textarea after every keystroke.
    i refresh the textarea by changing one property, back and forth between two values that will result in the same appearance on most modern devices.
*/
const textarea = document.querySelector(\'textarea\');
var cssToggle = false;

textarea.addEventListener(\'input\', redrawTextarea);

function redrawTextarea(e) {
  if (cssToggle) {
    textarea.style.fontVariantLigatures = \'normal\';
    cssToggle = false;
  } else {
    textarea.style.fontVariantLigatures = \'common-ligatures\';
    cssToggle = true;
  }
}
</script>

</body></html>';
/*formatting some data*/
$nimipu=[];
$nimikusuli=[];
$nimikulili=[];
$nimiante=[];
$niminamako=[];
$nimirad=[];

foreach ($wpu as $word){
    $nimipu[$word[0]]=$word[1];
}
foreach ($wkusuli as $word){
    $nimikusuli[$word[0]]=$word[1];
}
foreach ($wkulili as $word){
    $nimikulili[$word[0]]=$word[1];
}
foreach ($wante as $word){
    $nimiante[$word[0]]=$word[1];
}
foreach ($wnamako as $word){
    array_push($niminamako,$word[0]);
}
foreach ($wrad as $rad){
    array_push($nimirad,$rad[0]);
}

$globalwords=[];
$globalfonts=[];
$fcount=0;
/*get main font info*/echo "<p>Getting glyphs from fonts</p><p>";
foreach ($finfo as $line){
    $font=$line[0];
    $file=$line[1];

    $author=$line[3];
    $license=$line[4];
    $range=$line[5];
    $prop=$line[6];
    $ucsur=$line[7];
    $ligatures=$line[8];
    $cartouches=$line[9];
    $combos=$line[10];
    $longpi=$line[11];
    $additional=$line[12];
    $notes=$line[13];

    $cartouche1=$line[14];
    $cartouche1c=$line[15];
    $cartouche2=$line[16];
    $cartouche2c=$line[17];
    $comboscal=$line[18];
    $comboscalc=$line[19];
    $combosta=$line[20];
    $combostac=$line[21];
    $comboz=$line[22];
    $combozc=$line[23];
    $pi1=$line[24];
    $pi1c=$line[25];
    $pi2=$line[26];
    $pi2c=$line[27];
    $long=$line[28];
    $longc=$line[29];


    if ($fcount>0){
    /*add fonts as variables*/
        $fontvar=preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($font));
        if(is_numeric(substr($fontvar,0,1))){$fontvar="sp".$fontvar;}
    $floadcss.="    @font-face{
		font-family:".$fontvar.";
        src:url(src/".$file.");
    }
";
    $style=$line[2];
    if(!array_key_exists($style,$globalfonts)){
        $globalfonts[$style]=[];
    }
    array_push($globalfonts[$style],array($font,$fontvar));
    
/*populate the 2 font info tables*/    
if(!ctype_space(" ".$font.$author.$license.$range.$prop.$ucsur.$ligatures.$cartouches.$combos.$longpi.$additional.$notes)){
$tinfo.="<tr><th>".$font."</th><td>".$author."</td><td>".$license."</td><td>".$range."</td><td>".$prop."</td><td>".$ucsur."</td><td>".$ligatures."</td><td>".$cartouches."</td><td>".$combos."</td><td>".$longpi."</td><td>".$additional."</td><td>".$notes."</td></tr>
        ";}
if(!ctype_space(" ".$cartouche1.$cartouche2.$comboscal.$combosta.$comboz.$pi1.$pi2.$long)){
$tfeature.="
    <tr class='".$fontvar."'><th>".$font."</th><td class='".$cartouche1c."'>".$cartouche1."</td><td class='".$cartouche2c."'>".$cartouche2."</td><td class='".$comboscalc."'>".$comboscal."</td><td class='".$combostac."'>".$combosta."</td><td class='".$combozc."'>".$comboz."</td><td class='".$pi1c."'>".$pi1."</td><td class='".$pi2c."'>".$pi2."</td><td class='".$longc."'>".$long."</td></tr>
        ";}
        $glyph=array_map('str_getcsv', file($glyphs.rawurlencode($font).".csv"));echo $font.".csv  ".(time()-$tmer)."s, ";
        foreach($glyph as $cell){
            $globalwords[$cell[0]][explode(" ",$style)[0]][$font]["class"]=$cell[1];
            $chars=[];
            for ($i=2;$i<count($cell);$i++){
                array_push($chars,$cell[$i]);
            }
            $globalwords[$cell[0]][explode(" ",$style)[0]][$font]["char"]=$chars;
        }
        
    }else{
        $fcount=$fcount+1;$tinfo.="<tr><th>".$font."</th><th>".$author."</th><th>".$license."</th><th>".$range."</th><th>".$prop."</th><th>".$ucsur."</th><th>".$ligatures."</th><th>".$cartouches."</th><th>".$combos."</th><th>".$longpi."</th><th>".$additional."</th><th>".$notes."</th></tr>
        ";
    }

}
echo "</p><p>Done.</p>";

uksort($globalwords,"strnatcasecmp");
$words=array_keys($globalwords);
$definitions=array_merge($nimipu,$nimikusuli,$nimikulili,$nimiante);

/*add empty fields for all fonts that don't have the words*/

foreach($words as $word){
    foreach($styles as $style){
        if($style[0]=="no"){break;}
        /*if (!array_key_exists($style[0],$globalwords)){$globalwords[$word][$style[0]]=[];}*/
        if(isset($globalfonts[$style[0]." old"])){
            $globalfontss=array_merge($globalfonts[$style[0]],$globalfonts[$style[0]." old"]);
            sort($globalfontss);
        }
        else{$globalfontss=$globalfonts[$style[0]];}
        foreach($globalfontss as $font){
            if (!array_key_exists($font[0],$globalwords[$word][$style[0]]??[])){
                $globalwords[$word][$style[0]][$font[0]]["char"]=[""];
                $globalwords[$word][$style[0]][$font[0]]["class"]="";
            }
        }
        /*ksort($globalwords[$word][$style[0]])*/;
    }
}

/*font name&style headers for word tables*/
$isfont=[];
foreach($styles as $stylum){
    if($stylum[0]=="no"){
        break;
    }
    $tline='<td colspan="';
    $tpu.=$tline;
    $tkusuli.=$tline;
    $tkulili.=$tline;
    $tante.=$tline;
    $tnamako.=$tline;
    $trad.=$tline;
    if(isset($globalfonts[$stylum[0]." old"])){
        $stfonts=array_merge($globalfonts[$stylum[0]],$globalfonts[$stylum[0]." old"]);
        sort($stfonts);
    }else{
        $stfonts=$globalfonts[$stylum[0]];
    }
    $cpu=0;
    $ckusuli=0;
    $ckulili=0;
    $cante=0;
    $cnamako=0;
    $crad=0;
    foreach($stfonts as $font){
        $cfpu=0;
        $cfkusuli=0;
        $cfkulili=0;
        $cfante=0;
        $cfnamako=0;
        $cfrad=0;
        
        foreach($words as $word){
            if(!ctype_space(" ".$globalwords[$word][$stylum[0]][$font[0]]["char"][0])){
                if(array_key_exists($word,$nimipu)){
                    $cfpu+=1;
                }else if(array_key_exists($word,$nimikusuli)){
                    $cfkusuli+=1;
                }else if(array_key_exists($word,$nimikulili)){
                    $cfkulili+=1;
                }else if(in_array($word,$niminamako)){
                    $cfnamako+=1;
                }else if(in_array($word,$nimirad)){
                    $cfrad+=1;
                }else{
                    $cfante+=1;
                }
            }
        }
        if($cfpu>0){$cpu+=1;$isfont[$font[0]]["pu"]=true;}else{$isfont[$font[0]]["pu"]=false;}
        if($cfkusuli>0){$ckusuli+=1;$isfont[$font[0]]["kusuli"]=true;}else{$isfont[$font[0]]["kusuli"]=false;}
        if($cfkulili>0){$ckulili+=1;$isfont[$font[0]]["kulili"]=true;}else{$isfont[$font[0]]["kulili"]=false;}
        if($cfante>0){$cante+=1;$isfont[$font[0]]["ante"]=true;}else{$isfont[$font[0]]["ante"]=false;}
        if($cfnamako>0){$cnamako+=1;$isfont[$font[0]]["namako"]=true;}else{$isfont[$font[0]]["namako"]=false;}
        if($cfrad>0){$crad+=1;$isfont[$font[0]]["rad"]=true;}else{$isfont[$font[0]]["rad"]=false;}
    }
    $tpu.=$cpu;
    $tkusuli.=$ckusuli;
    $tkulili.=$ckulili;
    $tnamako.=$cnamako;
    $trad.=$crad;
    $tante.=$cante;
    $tline='" class="'.$stylum[0].'">'.$stylum[1]."</td>";
    $tpu.=$tline;
    $tkusuli.=$tline;
    $tkulili.=$tline;
    $tante.=$tline;
    $tnamako.=$tline;
    $trad.=$tline;
}

    $tline="</tr>
            <tr>
                <th>font</th>
                ";
foreach($styles as $stylum){
    if($stylum[0]=="no"){
        break;
    }

    
    if(isset($globalfonts[$stylum[0]." old"])){
        $stfonts=array_merge($globalfonts[$stylum[0]],$globalfonts[$stylum[0]." old"]);
        sort($stfonts);
    }else{
        $stfonts=$globalfonts[$stylum[0]];
    }
    foreach($stfonts as $font){
        $tline.="<th>".$font[0]."</th>
                ";
    }
}

    $tpu.=$tline;
    $tkusuli.=$tline;
    $tkulili.=$tline;
    $tante.=$tline;
    $tnamako.=$tline;
    $trad.=$tline;
    $tline.="</tr>
    ";

/*populate word tables*/
foreach($words as $word){
    if (array_key_exists($word,$definitions)){
        $tline='
        <tr title="'.$definitions[$word].'" alt="'.$word.'"';
    }else{
        $tline='
        <tr';
    }
    $tline.='><th>'.$word.'</th>
    ';
    foreach($styles as $stylum){
        if($stylum[0]=="no"){
            break;
        }
        
    if(isset($globalfonts[$stylum[0]." old"])){
        $stfonts=array_merge($globalfonts[$stylum[0]],$globalfonts[$stylum[0]." old"]);
        sort($stfonts);
    }else{
        $stfonts=$globalfonts[$stylum[0]];
    }
        /*sort($stfonts);*/
        foreach($stfonts as $font){
            if(ctype_space(" ".$globalwords[$word][$stylum[0]][$font[0]]["class"])||[""]==$globalwords[$word][$stylum[0]][$font[0]]["char"]){
                $tline.='<td>';
            }else{
                $tline.='<td class="'.$globalwords[$word][$stylum[0]][$font[0]]["class"].'">';
            }
            $tline.=implode("<br>",$globalwords[$word][$stylum[0]][$font[0]]["char"])."</td>";
        }
    }
    $tline.="</tr>";

    if(array_key_exists($word,$nimipu)){
        $tpu.=$tline;
    }else if(array_key_exists($word,$nimikusuli)){
        $tkusuli.=$tline;
    }else if(array_key_exists($word,$nimikulili)){
        $tkulili.=$tline;
    }else if(in_array($word,$niminamako)){
        $tnamako.=$tline;
    }else if(in_array($word,$nimirad)){
        $trad.=$tline;
    }else{
        $tante.=$tline;
    }
}

/*load fonts not loaded in the tables*/
foreach($other as $line){
    $font=$line[0];
    $file=$line[1];
    $fontvar=str_replace(array(" ","-"),"",strtolower($font));
    $floadcss.="    @font-face{
		font-family:".$fontvar.";
        src:url(src/".$file.");
    }
";
    $style=$line[2];
     if(!array_key_exists($style,$globalfonts)){
        $globalfonts[$style]=[];        
    }
    array_push($globalfonts[$style],array($font,$fontvar));
}

/*add fonts for input field, define font families*/
foreach($styles as $stylum){
    $isno=false;
    if($stylum[0]!="no"){
        $finput.='
        <option value="" disabled>'.$stylum[1].'</option>';
        $ffamilcss.="/*".$stylum[0]."*/
        ";
        
    if(isset($globalfonts[$stylum[0]." old"])){
        $stfonts=array_merge($globalfonts[$stylum[0]],$globalfonts[$stylum[0]." old"]);
        sort($stfonts);
    }else{
        $stfonts=$globalfonts[$stylum[0]];
    }
        foreach($stfonts as $font){
            if(isset($globalfonts[$stylum[0]." old"])&&in_array($font,$globalfonts[$stylum[0]." old"])){
                $stylumm=$stylum[0].".old";
            }else{
                $stylumm=$stylum[0];
            }

            $finput.='
        <option value="'.$font[1].'">'.$font[0].'</option>';
            $fcount+=1;
            $isfont[$font[0]]["number"]=$fcount;
            if($isno){$ffamilcss.=".".$font[1]."{font-family:".$font[1].";}
            ";}
            else{
                $ffamilcss.="textarea.".$font[1].",.".$font[1]." td,.sp td:nth-child(".$fcount."){font-family:".$font[1].";}
            ";
                if ($fcount>2){$fdiscss.=",";}
                $fdiscss.="
.".$stylumm." .sp td:nth-child(".$fcount."),.".$stylumm." .sp th:nth-child(".$fcount.")";
            }
        }
    }else{
        $isno=true;
    }
}
$fdiscss.="
{display:table-cell;}

";

/*not displaying fonts in a table that have no content*/
$copen=true;
foreach ($isfont as $font){
    foreach($font as $tft=>$tval){
        if ($tval==false){
            if($copen){
                $copen=false;
            }else{
                $ftabchcss.=",";
            }
            $ftabchcss.="#".$tft." td:nth-child(".$font["number"]."),#".$tft." th:nth-child(".$font["number"].")";
        }
    }
}


/*put together the page*/
$body=$bodystart.$floadcss.$fdiscss.$ffamilcss.$ftabchcss.$pret.$tpu.$tkusuli.$tkulili.$tante.$tnamako.$trad.$tinfo.$tfeature.$finput.$bodyend;
/*echo $body;*/
file_put_contents(__DIR__ . "/../index.html", iconv('ISO-8859-1', 'UTF-8', $body));
echo "<p><a href='../index.html'>Finished</a> ".(time()-$tmer)."s</p>";
?>
