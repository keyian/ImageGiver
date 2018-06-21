<?php
$cxn = new mysqli("warehouse", "ksv216", "jhespcnc", "ksv216_image_maker");
//check connection
if ($cxn->connect_error) {
    die("Connection failed: " . $cxn->connect_error);
}
session_start();
//for use throughout php to determine whether to display old page/ error page or to make new img
$_SESSION['newImg'] = false;
//if get is empty, then this isnt a request for a new image
if(!(count($_GET)>0)) {
  $_SESSION['newImg']=true;
  //query for random image!
  $query= "SELECT link from images ORDER BY RAND() LIMIT 1;";
  $result = $cxn->query($query);
  $fetch = $result->fetch_assoc();
  $imgLink = $fetch['link'];
  $_SESSION["img"] = $imgLink;
  //get the word choices
  $wordC1 = $_POST['word1'];
  $wordC2 = $_POST['word2'];
  $wordC3 = $_POST['word3'];
  $wordC4 = $_POST['word4'];
  $wordC5 = $_POST['word5'];
  $wordC6 = $_POST['word6'];
  $wordC7 = $_POST['word7'];
  $wordC8 = $_POST['word8'];
  $word_choices = array($wordC1, $wordC2, $wordC3, $wordC4, $wordC5, $wordC6, $wordC7, $wordC8);
  //record each word into array $words
  $words = array();
  for($i=0; $i<count($word_choices); $i++) {
    $query= "SELECT word FROM words WHERE pos LIKE '%".$word_choices[$i]."%' ORDER BY RAND() LIMIT 1;";
    $result = $cxn->query($query);
    $fetch = $result->fetch_assoc();
    array_push($words, $fetch['word']);
  }
  //add to history all of the chosen words and the chosen image
  $sql = "INSERT INTO history (word1, word2, word3, word4, word5, word6, word7, word8, href) VALUES ('$words[0]', '$words[1]', '$words[2]', '$words[3]', '$words[4]', '$words[5]', '$words[6]', '$words[7]', '$imgLink')";
  $cxn->query($sql);

  $style = $_POST["style"];
  if($style == "happy") {
    $color = '#55AB68';
    $color2 = '#D2EBB4';
    $shadow1 = 5;
    $shadow2 = 10;
    $shadow3 = 15;
    $xCo = 1;
    $yCo = 2;
  } else if ($style == "sad") {
    $color = '#8197C7';
    $color2 = '#214080';
    $shadow1 = 10;
    $shadow2 = 15;
    $shadow3 = 5;
    $xCo = 3;
    $yCo = 4;
  } else {
    $color = '#'.dechex(rand(16, 255)).dechex(rand(0, 255)).dechex(rand(0, 255));
    $color2 = '#'.dechex(rand(16, 255)).dechex(rand(0, 255)).dechex(rand(0, 255));
    $shadow1 = rand(0, 100);
    $shadow2 = rand(0, 100);
    $shadow3 = rand(0, 100);
    $xCo = rand(1, 20);
    $yCo = rand(1, 20);
  }
}
// else if $_get has the proper amount of elements
else if (count($_GET)==10) {
// set styles
  $style = $_GET["style"];
  $color = str_replace("-","#",$_GET["color"]);
  $color2 = str_replace("-","#",$_GET["color2"]);
  $shadow1 = $_GET["shadow1"];
  $shadow2 = $_GET["shadow2"];
  $shadow3 = $_GET["shadow3"];
  $xCo = $_GET["xCo"];
  $yCo = $_GET["yCo"];
// set words
  $words = explode("-", $_GET["words"]);
//set image
  if(isset($_GET["img"])) {
  $imgParts = explode("-", $_GET["img"]);
}
  $imgLink = "";
  for($i=0; $i<count($imgParts); $i++) {
    if ($i==0) {
      $imgLink.= $imgParts[$i];
    }
    else if($i != (count($imgParts)-1)) {
      $imgLink.= "/".$imgParts[$i];
    } else {
      $imgLink .= ".".$imgParts[$i];
    }
  }

//if $_GET doesn't have the exact right amount of variables, go to error page
} else {
  header( "Location: error.html" );
}
$_SESSION["style"] = $style;
$_SESSION["color"] = $color;
$_SESSION["color2"] = $color2;
$_SESSION["shadow1"] = $shadow1;
$_SESSION["shadow2"] = $shadow2;
$_SESSION["shadow3"] = $shadow3;
$_SESSION["xCo"] = $xCo;
$_SESSION["yCo"] = $yCo;

//only change session width and height if new ones have been posted
if(isset($_POST["wid"])) {
$wit = $_POST["wid"];
$hit = $_POST["hei"];
$_SESSION["wid"] = $wit;
$_SESSION["hei"] = $hit;
}
 ?>

<html>
<script type="text/javascript">
// function sendDims() {
// var w = window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth;
// var h = window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight;
// var dub = document.getElementById("w");
// var hi = document.getElementById("h");
// dub.setAttribute("value", w);
// hi.setAttribute("value", h);
// }
</script>
<head>
<title>each morning</title>
<link rel="stylesheet" type="text/css" href="styles/styleMaker.php?" />
<script type="text/javascript">
function sendDims() {
   var w = window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth;
   var h = window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight;
  document.getElementById("w").setAttribute("value", w);
  document.getElementById("h").setAttribute("value", h);
  document.getElementById("wi").setAttribute("value", w);
  document.getElementById("he").setAttribute("value", h);
}
</script>
</head>
<body onload="sendDims();">
<div id="container">
<div id="menu">
  <ul>
    <li class="menu"><a href="imageGiver.php">start over</a></li>
    <li class="menu"><a href="getLink.php">get link</a></li>
    <br />
    <li class="menu"><a href="http://www.wikipedia.com">i meant to go to wikipedia!</a></li>
  </ul>
</div>
      <form class="frm" action="finder.php" method="post">
      <p>syntax:</p>
      <?php
        $query= "SELECT DISTINCT pos from words order by pos asc";
        $result = $cxn->query($query);
        $dropdown = "";
        while($row = $result->fetch_assoc()) {
          $p = $row['pos'];
          $dropdown.='<option value="'.$p.'">'.$p.'</option>';
        }
        //for loop for select/option statements
        for($i=1; $i<9; $i++) : ?>
          <select name="word<?php echo $i?>">
            <?php echo $dropdown?>
          </select>
        <?php endfor; ?>
      <br /><br />
      <p>style:</p>
      <select id="styl" name="style">
        <option value="happy">happy</option>
        <option value="sad">sad</option>
        <option value="confused">confused</option>
      </select>
      <br />
      <input type="hidden" name="wid" id="w" value="aasdfasd">
      <input type="hidden" name="hei" id="h" value="asdfasdfas">
      <input id="subm" type="submit" name="submit" value="again!" onclick="sendDims();"/>
      </form>
    <div class="image"><img id="mainImg"src="<?php echo $imgLink;?>"/></div>
    <div id="sent">
    <h1 id="wrds">
    <?php
    $_SESSION["words"] = $words;
      for($i=0; $i<count($words); $i++) {
        echo $words[$i]." ";
      } ?>
    </h1>
  </div>
    <?php
    $numShapes = $xCo +$yCo;
    for($i=0; $i<$numShapes; $i++) {
      echo "<div><p class='shape' id='s".$i."'></p></div>";
    }
      ?>
</div>


<div class="footer">
  <a href="imageGiver.html"><img id="logo" src="../../images/keyianLogo.png" alt="keyian vafai" title="keyian vafai" /></a>
</div>

</div>
</body>
</html>
