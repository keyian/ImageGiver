<?php
$cxn = new mysqli("warehouse", "ksv216", "jhespcnc", "ksv216_image_maker");
//check connection
if ($cxn->connect_error) {
    die("Connection failed: " . $cxn->connect_error);
}
session_start();
header("Content-type: text/css");
//get browser width and height
$wid = $_SESSION["wid"];
$hei = $_SESSION["hei"];
//get style choice. happy and sad both decided; confused is completely random
$style = $_SESSION["style"];
$color = $_SESSION["color"];
$color2 = $_SESSION["color2"];
$shadow1 = $_SESSION["shadow1"];
$shadow2 = $_SESSION["shadow2"];
$shadow3 = $_SESSION["shadow3"];
$xCo = $_SESSION["xCo"];
$yCo = $_SESSION["yCo"];
//add to css the chosen style
$sql = "INSERT INTO css (style, color, shadow1, shadow2, shadow3, xCo, yCo, color2)
VALUES ('$style', '$color', '$shadow1', '$shadow2', '$shadow3', '$xCo', '$yCo', '$color2')";
$cxn->query($sql);
$numShapes = $xCo +$yCo;
//add browser width and height history
$sql = "INSERT INTO user_history (browser_width, browser_height)
VALUES ('$wid', '$hei')";
$cxn->query($sql);

function randomColor() {
  return '#'.dechex(rand(16, 255)).dechex(rand(0, 255)).dechex(rand(0, 255));
}

function borderRadiusString() {
  return rand(0,500)."px ".rand(0,500)."px ".rand(0,500)."px ".rand(0,500)."px / ".rand(0,500)."px ".rand(0,500)."px ".rand(0,500)."px ".rand(0,500)."px;";
}

function randWInBrows() {
  $wid = $_SESSION["wid"];
  return rand(0, $wid);
}
function randHInBrows() {
  $hei = $_SESSION["hei"];
  return rand(0, $hei);
}

function shadowString() {
  $shadow1 = $_SESSION["shadow1"];
  $shadow2 = $_SESSION["shadow2"];
  $shadow3 = $_SESSION["shadow3"];
  $col = randomColor();
  $shad1 = (rand(0,10))*$shadow1;
  $shad2 = (rand(150,200))*$shadow2;
  $shad3 = (rand(0,30))*$shadow3;
  if($style = "confused") {
    $shad3 = (rand(5,10))*$shadow3;
  }
  return $shad1."px ".$shad1."px ".$shad2."px ".$shad3."px ".$col;
}
?>
<?php for($i=0; $i<$numShapes; $i++) : ?>
              <?php print('#s'.$i); ?> {
                border: 20px groove <?php print(randomColor());?>;
                -moz-border-radius: <?php print(borderRadiusString());?>
               -webkit-border-radius: <?php print(borderRadiusString());?>
               border-radius: <?php print(borderRadiusString());?>
               -moz-box-shadow: <?php print(shadowString());?>;
               -webkit-box-shadow: <?php print(shadowString());?>;
               box-shadow: <?php print(shadowString());?>;
               background-color: <?php print(randomColor());?>;
                    padding: 20px;
                    width: <?php print(rand(0,200));?>px;
                    height: <?php print(rand(0,200));?>px;
                    position: relative;
                    margin: <?php echo (randHInBrows()/10);?>px;
                    animation-duration: <?php echo rand(5,20)?>s;
                    -webkit-animation: shapeMove <?php echo rand(5,20)?>s cubic-bezier(.2,.7,.1,.9) 0s infinite alternate;
                    animation: shapeMove <?php echo rand(5,20)?>s cubic-bezier(.2,.7,.1,.9) 0s infinite alternate;
                  }

<?php endfor; ?>

.shape {
    /* Chrome, Safari, Opera */

}

/* Chrome, Safari, Opera */
@-webkit-keyframes shapeMove {
    0%   {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
    25%  {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
    50%  {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
    75%  {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
    100% {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
}

/* Standard syntax */
@keyframes shapeMove {
  0%   {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
  25%  {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
  50%  {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
  75%  {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
  100% {background-color:<?php echo randomColor();?>; left:<?php echo randWInBrows();?>px; bottom:<?php echo randHInBrows();?>px;}
}

* {
  color: <?php echo $color ?>;
  background-color: <?php echo $color2 ?>;
  text-align: center;
  font-family: helvetica, helvetica, serif;
  font-size: 100%;
  margin: auto;
}
#header {
  width: 100%;
}
.shape {

}
select {
  display:inline;
}
option {
  background-color: black;
  color:black;
}
#container {
  text-align: center;
  width: 100%;
}

.shape {
  z-index: 0;
}

.footer {
  margin: auto;
  text-align: center;
  width: 100%;
}
#logo, #menu, .frm, .image, #sent {
  position: fixed;
}

#logo {
  bottom: 0%;
  left: 32%;
  width: 36%;
}


#menu {
  top: 5%;
  width: 80%;
  left:10%;
  height: 2%;
  <!-- font-size: 110%; -->
}
#menu, .menu, li, a, ul {
  background-color: black;
  color: white;
  font-family: helvetica;
}
.menu {
  display: inline;
  margin: 30px;
}

.frm {
  height: 70%;
  top: 15%;
  width: 30%;
  left: 11%;
}


.image, #sent {
  right: 11%;
  width: 60%;
}
#mainImg{
  border: 30px groove <?php print(randomColor());?>;
}


.image {
  width:40%;
  height: 30%;
  top: 20%;
  padding:0px;
  text-align: right;
}

#sent {
  font-weight: 900;
  font-size: 150%;
  max-height: 20%;
  bottom: 12%;
  text-align: right;
}
#wrds {
  text-align: right;
}
#subm {
  margin-top: 10px;
}

ul, li {
  margin: auto;
  padding: 0px;
}

li {
  margin: 50px;
}
