<?php
$cxn = new mysqli("warehouse", "ksv216", "jhespcnc", "ksv216_image_maker");
//check connection
if ($cxn->connect_error) {
    die("Connection failed: " . $cxn->connect_error);
}
session_start();
?>
<html>
<head>
<title>each morning</title>
<link href="styles/main.css" type="text/css" rel="stylesheet" />

</head>
<body>
<div id="container">
  <script type="text/javascript">
  function sendDims() {
     var w = window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth;
     var h = window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight;
    document.getElementById("w").setAttribute("value", w);
    document.getElementById("h").setAttribute("value", h);
    console.log("iworked");
  }
  </script>
<div id="content">
<!-- use get to get whatever finder returns, but use post to post to finder-->
<div id="intro">
<p>hello loved one.
  you have stumbled upon an organism meant to offer the frontal lobe a mere tickle</p>
  <p>you may offer a syntax and style, but what you will receive will be a splash in return</p>
  <p>for what? of what? who could know? use me for a mere stepping stone, a thought-suggester,
    or perhaps, consider me...</p>
    <h1>THE IMAGE GIVER</h1>
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
    <select name="style">
      <option value="happy">happy</option>
      <option value="sad">sad</option>
      <option value="confused">confused</option>
    </select>
    <br />
    <input type="hidden" name="wid" id="w" value="aasdfasd">
    <input type="hidden" name="hei" id="h" value="asdfasdfas">
    <input type="submit" name="submit" value="let me see" onclick="sendDims();"/>
    </form>


</div>

<div class="footer">
    <a href="imageGiver.html"><img id="logo" src="../../images/keyianLogo.png" alt="keyian vafai" title="keyian vafai" /></a>
</div>

</div>
</body>
</html>
