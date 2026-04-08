<?php
/*ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);*/
$wk=file_get_contents("https://github.com/wasokeli/wasokeli.github.io/raw/refs/heads/main/sp-font-maker/generate%20all%20fonts.bat");
$repo="https://github.com/RetSamys/toki-pona-glyphs/raw/main";
$repo=__DIR__ . "/../toki-pona-glyphs-main";
$finfo=array_map('str_getcsv', file($repo."/sona/fontinfo.csv"));
$fontl=[];$fontfl=[];
foreach($finfo as $line){
    $fontl[]=$line[0];
    $fontfl[]=$line[2];
}
$finfo=array_map('str_getcsv', file($repo."/sona/other.csv"));
foreach($finfo as $line){
    $fontl[]=$line[0];
}
$finfo=array_map('str_getcsv', file($repo."/sona/tuki tiki.csv"));
foreach($finfo as $line){
    $fontl[]=$line[0];
}


echo "<ol>";
$hw=explode("handwrite",$wk);
foreach($hw as $line){
    if(str_contains($line,"--sheet-version")){
        if(str_contains($line,'--filename "')){
            $flname=explode('"',explode('--filename "',$line)[1])[0];
            $fname=$flname;
        }else{
            $flname=explode(' ',explode('--filename ',$line)[1])[0];
            $fname=$flname;
        }
        if(str_contains($line,'--family "')){
            $fname=explode('"',explode('--family "',$line)[1])[0];
        }else if (str_contains($line,'--family ')){
            $fname=explode(' ',explode('--family ',$line)[1])[0];
        }
        if ( in_array(strtolower($fname),array_map('strtolower',$fontl)) || 
        in_array("https://github.com/wasokeli/wasokeli.github.io/raw/refs/heads/main/sp-font-maker/".$flname.".ttf",$fontfl) ||
        in_array("https://github.com/wasokeli/wasokeli.github.io/raw/refs/heads/main/sp-font-maker/".rawurlencode($fname).".ttf",$fontfl) || 
        in_array("https://github.com/wasokeli/wasokeli.github.io/raw/refs/heads/main/sp-font-maker/".str_replace(" ","-",str_replace("%20","-",rawurlencode($fname).".ttf")),$fontfl) ){}else{
        $csvline=[
            $fname,
            str_replace(".ttf.ttf",".ttf",str_replace(" ","-",$fname).".ttf"),
            "https://github.com/wasokeli/wasokeli.github.io/raw/refs/heads/main/sp-font-maker/".rawurlencode($fname).".ttf",
            "https://wasokeli.github.io/sp-font-maker/".str_replace(" ","-",$fname).".html",
            (str_contains($line,"--pixel"))?"pxl":"hand",
            explode('"',explode('--designer "',$line)[1])[0],
            strtoupper(explode(' ',explode('--license ',$line)[1])[0]),
            "almost all ku suli + some more",
            "monospaced","yes","yes","yes","yes","no","","","&amp;#xF1930;&amp;#xF1990;&amp;#xF1917;&amp;#xF1903;&amp;#xF193f;&amp;#xF1908;&amp;#xF196a;&amp;#xF1900;&amp;#xF1991;","ucsur","&amp;#xF1930;&amp;#xF1990;&amp;#xF1917;&amp;#xF1992;&amp;#xF1903;&amp;#xF1992;&amp;#xF193f;&amp;#xF1992;&amp;#xF1908;&amp;#xF1992;&amp;#xF196a;&amp;#xF1992;&amp;#xF1900;&amp;#xF1992;&amp;#xF1991;","ucsur","","","&amp;#xF1914;&amp;#xF1995;&amp;#xF1928;","ucsur","","","","","","","",""

            ];
            echo '<li>"'.implode('","',$csvline).'"</li>';}
    }
}
echo "<hr>";

$sl=explode(".toml",file_get_contents("https://api.github.com/repos/lipu-linku/sona/git/trees/7f0684c30fc8cbfb084b58d2cbedfc5d5a8643d1"));
/*var_dump( $sl);*/
foreach($sl as $titem){
    if(str_contains($titem,'"path"')){
        $fname=end(explode('"',$titem));
        $fname=strtolower($fname);
        if ( in_array(strtolower($fname),array_map('strtolower',$fontl)) ){}else{
            $toml=file_get_contents("https://github.com/lipu-linku/sona/raw/refs/heads/main/fonts/metadata/".rawurlencode($fname).".toml");
            $tfontfl=explode('"',end(explode("fontfile",$toml)))[1];
            if(in_array($tfontfl,$fontfl) || in_array(str_replace(" ","%20",$tfontfl),$fontfl) || in_array(str_replace("%20"," ",$tfontfl),$fontfl)){}else{
                $csvline=[
		            $fname,
                    str_replace("%20","-",str_replace(" ","-",end(explode("/",$tfontfl)))),
                    $tfontfl,
                    (str_contains($toml,"
webpage")?explode('"',end(explode("
webpage",$toml)))[1]:(str_contains($toml,"
repo")?explode('"',end(explode("
repo",$toml)))[1]:"")),
                    (str_contains($toml,"
style")?explode('"',end(explode("
style",$toml)))[1]:"?"),
                    (str_contains($toml,"
author")?explode('"',end(explode("
author",$toml)))[1]:"?"),
                    (str_contains($toml,"
license")?explode('"',end(explode("
license",$toml)))[1]:"?"),
                    "",
                    "?",
                    (str_contains($toml,"
ucsur")?
                     	(str_contains(explode('=',end(explode("
ucsur",$toml)))[1],"false")?"no":
                         	(str_contains(explode('=',end(explode("
ucsur",$toml)))[1],"true")?"yes":"?")
                         )
                     :"?"),
                    "?",
                    "?",
                    "?",
                    "?",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    ""];
                echo '<li>"'.implode('","',$csvline).'"</li>';
            }
        }
    }
}
/*
var_dump($sl);
echo $sl;
echo "<h2>".count($sl["tree"])."</h2>";
for($i=0;i<count($sl["tree"]);$i++){
    $slp=$sl["tree"][$i]["path"];
    $alr=false;
    foreach($fontl as $ff){
        if(str_replace("-","",str_replace(" ","",strtolower($ff)))==str_replace("-","",str_replace(" ","",strtolower(explode(".",$slp)[0])))){
            $alr=true;
            break;
        }
    }
    if($alr){}else{
        $toml=file_get_contents("https://github.com/lipu-linku/sona/raw/refs/heads/main/fonts/metadata/".$slp);
        $tname=explode('"',explode("
name",$toml)[1])[1];
        if (in_array($tname,$fontl)){}else{
            $csvline=[
            $tname,
            str_contains($toml,"
filename") ? explode('"',explode("
filename",$toml)[1])[1] : "",
            str_contains($toml,"
fontfile") ? explode('"',explode("
fontfile",$toml)[1])[1] : "",
            str_contains($toml,"
webpage") ? explode('"',explode("
webpage",$toml)[1])[1] : (str_contains($toml,"
repo") ? explode('"',explode("
repo",$toml)[1])[1] : ""),
            str_contains("
writing_system") ? (str_contains(explode('"',explode("
style",$toml)[1])[1],"sitelen pona") ? (str_contains($toml,"
style") ? explode('"',explode("
style",$toml)[1])[1] : "") : "nonsp") : (str_contains($toml,"
style") ? explode('"',explode("
style",$toml)[1])[1] : ""),
            str_contains($toml,"
creator") ? str_replace("",'"',implode(",",explode('","',str_replace('" ,','",',str_replace(', "',',"',explode(']',explode('[',explode("
creator",$toml)[1])[1])[0]))))) : "",
            str_contains($toml,"
license") ? explode('"',explode("
license",$toml)[1])[1] : "",
            "","",
            str_contains($toml,"
ucsur") ? (str_contains(explode("
ucsur",$toml)[1],"true")?"yes":"no") : "",
            str_contains($toml,"
ligatures") ? (str_contains(explode("
ligatures",$toml)[1],"true")?"yes":"no") : "",
            str_contains(strtolower($toml),"
cartouche") ? "yes" : "no",
            "","","","","","","","","","","","","","","","","","","",""
            ];
            echo '<p>"'.implode('","',$csvline).'"</p>';
        }
    }
}
*/
