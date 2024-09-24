<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$tmer=time();
/*pull data*/
$finfo=array_map('str_getcsv', file(("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/tuki%20tiki.csv")));echo "<p>tuki tiki.csv ".(time()-$tmer)."s</p>";
$styles=array_map('str_getcsv', file("https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/styles.csv"));echo "<p>styles.csv ".(time()-$tmer)."s</p>";
$glyphs="https://github.com/RetSamys/toki-pona-glyphs/raw/main/sona/tuki%20tiki/";

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
</head><body id=\"body\" class=\"hand uni serif pxl\"><div class=\"noprint\"><p><a href='index.html'>toki pona fonts</a>. This page was updated ".date("Y-m-d").".</p><ul><li><a href=\"#titi\">glyphs</a></li><li><a href=\"#sona\">font information</a><ul><li><a href=\"#features\">Feature showcase</a></li><li><a href=\"#pana\">Input field</a></li></ul></li></ul></div>
		<table><tbody><tr><th colspan=\"3\" class=\"ucsur\"><a href=\"https://www.kreativekorp.com/ucsur/charts/sitelen.html\" target=\"_blank\">UCSUR</a>-compliant glyphs have a grey background</td></th></tr>
        <tr class=\"noprint\"><th rowspan=\"7\">styles</th><td><label for=\"check1\">handwritten</label></td><td><input autocomplete=\"off\" id=\"check1\" checked type=\"checkbox\" onclick=\"if(document.body.classList.contains('hand')){document.body.classList.remove('hand');}else{document.body.classList.add('hand');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check2\">uniform line weight</label></td><td><input autocomplete=\"off\" id=\"check2\" checked type=\"checkbox\" onclick=\"if(document.body.classList.contains('uni')){document.body.classList.remove('uni');}else{document.body.classList.add('uni');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check3\">alternating line weight</label></td><td><input autocomplete=\"off\" id=\"check3\" checked type=\"checkbox\" onclick=\"if(document.body.classList.contains('serif')){document.body.classList.remove('serif');}else{document.body.classList.add('serif');}return true;\"></td></tr>
        <tr class=\"noprint\"><td><label for=\"check4\">block based</label></td><td><input autocomplete=\"off\" checked id=\"check4\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('pxl')){document.body.classList.remove('pxl');}else{document.body.classList.add('pxl');}return true;\"></td></tr>
        <tr class=\"noprint\" style=\"display:none;\"><td><label for=\"check5\">alternative design/<br>sitelen pona inspired</label></td><td><input autocomplete=\"off\" id=\"check5\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('alt')){document.body.classList.remove('alt');}else{document.body.classList.add('alt');}return true;\"></td></tr>
        <tr class=\"noprint\" style=\"display:none;\"><td><label for=\"check6\">non-sitelen-pona writing systems</label></td><td><input autocomplete=\"off\" id=\"check6\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('nonsp')){document.body.classList.remove('nonsp');}else{document.body.classList.add('nonsp');}return true;\"></td></tr>
        <tr class=\"noprint\" style=\"display:none;\"><td><label for=\"check7\">definitions</label></td><td><input autocomplete=\"off\" id=\"check7\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('def')){document.body.classList.remove('def');}else{document.body.classList.add('def');}return true;\"></td></tr>
        <tr class=\"noprint\" style=\"display:none;\"><td><label for=\"check8\">old font versions</label></td><td><input autocomplete=\"off\" id=\"check8\" type=\"checkbox\" onclick=\"if(document.body.classList.contains('old')){document.body.classList.remove('old');}else{document.body.classList.add('old');}return true;\"></td></tr>
        </tbody></table>";

$ttiti='<h2>glyphs</h2>
<table class="sp" id="titi">
	<tbody>
        <tr class="noprint insa"><th>style</th>';


$tinfo='</tbody></table>

<div class="noprint"><h2>font information</h2>
<table id="sona"><tbody>';
$tfeature='</tbody></table>
</div>

<h3>Feature showcase</h3>
<table id="features"><tbody>
    <tr><th>font</th><th>cartouches</th><th>combined glyphs</th></tr>
    <tr></tr>
    ';

$finput='</tbody></table>

<div class="noprint"><h3 id="pana">Input field</h3>
<label for="nasinsitelen"><b>font: </b></label><select autocomplete="off" onchange="document.getElementById(\'jo\').className=\'sp \'+document.getElementById(\'nasinsitelen\').value;" id="nasinsitelen">
    <option value="" selected disabled>select font</option>';
$bodyend='</select><br>
<textarea id=\'jo\' class="sp tamakatumu" style="min-width:8em;">toki</textarea></div>



<script>
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
$titia=[];

$globalwords=[];
$globalfonts=[];
$fcount=0;
/*get main font info*/echo "<p>Getting glyphs from fonts</p><p>";
foreach ($finfo as $line){
    $font=$line[0];
    $file=$line[1];
    $style=$line[2];
    $author=$line[3];
    $license=$line[4];
    $range=$line[5];
    $prop=$line[6];
    $ucsur=$line[7];
    $ligatures=$line[8];
    $cartouches=$line[9];
    $combos=$line[10];
    $additional=$line[11];
    $notes=$line[12];

    $cartouche1=$line[13];
    $cartouche1c=$line[14];
    $combo1=$line[15];
    $combo1c=$line[16];

    if ($fcount>0){
    /*add fonts as variables*/
        $fontvar=preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($font));
        if(is_numeric(substr($fontvar,0,1))){$fontvar="tt".$fontvar;}
    $floadcss.="    @font-face{
		font-family:".$fontvar.";
        src:url(src/".$file.");
    }
";
    if(!array_key_exists($style,$globalfonts)){
        $globalfonts[$style]=[];
    }
    array_push($globalfonts[$style],array($font,$fontvar));
    
/*populate the 2 font info tables*/    
if(!ctype_space(" ".$author.$license.$range.$prop.$ucsur.$ligatures.$cartouches.$combos.$additional.$notes)){
$tinfo.="<tr><th>".$font."</th><td>".$author."</td><td>".$license."</td><td>".$range."</td><td>".$prop."</td><td>".$ucsur."</td><td>".$ligatures."</td><td>".$cartouches."</td><td>".$combos."</td><td>".$additional."</td><td>".$notes."</td></tr>
        ";}
if(!ctype_space(" ".$cartouche1.$combo1)){
$tfeature.="
    <tr class='".$fontvar."'><th>".$font."</th><td class='".$cartouche1c."'>".$cartouche1."</td><td class='".$combo1c."'>".$combo1."</td></tr>
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
        $fcount=$fcount+1;$tinfo.="<tr><th>".$font."</th><th>".$author."</th><th>".$license."</th><th>".$range."</th><th>".$prop."</th><th>".$ucsur."</th><th>".$ligatures."</th><th>".$cartouches."</th><th>".$combos."</th><th>".$additional."</th><th>".$notes."</th></tr>
        ";
    }

}
echo "</p><p>Done.</p>";

uksort($globalwords,"strnatcasecmp");
$words=array_keys($globalwords);

/*add empty fields for all fonts that don't have the words*/
foreach($words as $word){
    foreach($styles as $style){
        if($style[0]=="no"){break;}
        /*if (!array_key_exists($style[0],$globalwords)){$globalwords[$word][$style[0]]=[];}*/
        if(isset($globalfonts[$style[0]." old"])){
            $globalfontss=array_merge($globalfonts[$style[0]],$globalfonts[$style[0]." old"]);
            sort($globalfontss);
        }
        else{
            if(array_key_exists($style[0],$globalfonts)){
                $globalfontss=$globalfonts[$style[0]];
                }else{
                    $globalfontss=[];
                }
            }
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
    $ttiti.=$tline;
    if(isset($globalfonts[$stylum[0]." old"])){
        $stfonts=array_merge($globalfonts[$stylum[0]],$globalfonts[$stylum[0]." old"]);
        sort($stfonts);
    }else{
        if(array_key_exists($stylum[0],$globalfonts)){
                $stfonts=$globalfonts[$stylum[0]];
                }else{
                    $stfonts=[];
                }
    }
    $ctiti=0;
    foreach($stfonts as $font){
        $cftiti=0;
        foreach($words as $word){
            if(!ctype_space(" ".$globalwords[$word][$stylum[0]][$font[0]]["char"][0])){
                    $cftiti+=1;    
            }
        }
        if($cftiti>0){$ctiti+=1;$isfont[$font[0]]["titi"]=true;}else{$isfont[$font[0]]["titi"]=false;}
    }
    $ttiti.=$ctiti;
    $tline='" class="'.$stylum[0].'">'.$stylum[1]."</td>";
    $ttiti.=$tline;
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
        if(array_key_exists($stylum[0],$globalfonts)){
                $stfonts=$globalfonts[$stylum[0]];
                }else{
                    $stfonts=[];
                }
    }
    foreach($stfonts as $font){
        $tline.="<th>".$font[0]."</th>
                ";
    }
}

    $ttiti.=$tline;
    $tline.="</tr>
    ";

/*populate word tables*/
foreach($words as $word){
    /*if (array_key_exists($word,$definitions)){
        $tline='
        <tr title="'.$definitions[$word].'" alt="'.$word.'"';
    }else{*/
        $tline='
        <tr';
    /*}*/
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
        if(array_key_exists($stylum[0],$globalfonts)){
                $stfonts=$globalfonts[$stylum[0]];
                }else{
                    $stfonts=[];
                }
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

        $ttiti.=$tline;
    
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
if(array_key_exists($stylum[0],$globalfonts)){
                $stfonts=$globalfonts[$stylum[0]];
                }else{
                    $stfonts=[];
                }    }
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
$body=$bodystart.$floadcss.$fdiscss.$ffamilcss.$ftabchcss.$pret.$ttiti.$tinfo.$tfeature.$finput.$bodyend;
/*echo $body;*/
file_put_contents(__DIR__ . "/../tukitiki.html", iconv('ISO-8859-1', 'UTF-8', $body));
echo "<p><a href='../tukitiki.html'>Finished</a> ".(time()-$tmer)."s</p>";
?>
