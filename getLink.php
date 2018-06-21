<?php
session_start();
$linkString = "http://i6.cims.nyu.edu/~ksv216/dbAssignments/assmt7/finder.php?";
$col = (str_replace("#","-",$_SESSION["color"]));
$col2 = (str_replace("#","-",$_SESSION["color2"]));
$linkString.= "style=".$_SESSION["style"]."&color=".$col."&color2=".$col2."&shadow1=".$_SESSION["shadow1"]."&shadow2=".$_SESSION["shadow2"]."&shadow3=".$_SESSION["shadow3"]."&xCo=".$_SESSION["xCo"]."&yCo=".$_SESSION["yCo"];
$words = $_SESSION["words"];
$img  = $_SESSION["img"];
$wordString = "";
for($i=0; $i<count($words); $i++) {
  if($i !=0) {
    $wordString.=",";
  }
  $wordString.=$words[$i];
}
$wordString=str_replace(",","-", $wordString);
$linkString.="&words=".$wordString;
$imgString = str_replace(".", "/", $img);
$imgString = str_replace("/","-", $imgString);
$linkString.="&img=".$imgString;

?>
<html>
<head>
<title>get link</title>
<link href="styles/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="givLink">
<p>here's the link to get back to your page:</p>
<textarea>
<?php
echo $linkString ?>
</textarea>
</div>
<div class="footer">
    <a href="imageGiver.html"><img id="logo" src="../../images/keyianLogo.png" alt="keyian vafai" title="keyian vafai" /></a>
</div>
</body>
</html>
<!--NOTES
send words in comma separated string, no spaces
send imgLink parsed by / and ., put into comma separated string, no spaces.
-->
