<?php echo $this->Html->css('pay', null, array('inline' => false)) ?>
<?php echo $this->Html->script('pay', ['inline' => false])?>

<adiv class="about_box_wrap">
    <div class="about_box">
        <h1>ご支援ありがとうございました</h1>
</div>

<?php 
//echo $_SESSION['aws']; 
//echo "<br>";
//echo $_SESSION['id_s']; 
//echo "<br>";
//echo $_SESSION['cid']; 
?>

<?php
//echo <<<EOM
//<script>
//var _CIDN = "cid";
//var _PMTV = "5cf60753426c2";
//var _PRICE = {$_SESSION['aws'] };
//var _ARGS = {$_SESSION['id_s'] };
//var _PT = {$_SESSION['p_id'] };
//var _TRKU = "https://hornet-m.net/asp/track.php?p=" + _PMTV + "&t=5cf60753&price=" + _PRICE + "&args=" + _ARGS + "&pt=" + _PT;
//var _cks = document.cookie.split("; ");
//for(var i = 0; i < _cks.length; i++){ var _ckd = _cks[i].split( "=" ); if(_ckd[0] == "CL_" + _PMTV && _ckd[1].length > 1){ _TRKU += "&" + _CIDN + "=" + _ckd[1]; break; }}
//img = document.body.appendChild(document.createElement("img"));
//img.src = _TRKU;
//</script>
//EOM;
?>


<?php
if($_SESSION['p_id'] == '6'){
echo <<<EOM
<script>
var _CIDN = "cid";
var _PMTV = "5cec86bde9f26";
var _PRICE = {$_SESSION['aws'] };
var _ARGS = {$_SESSION['id_s'] };
var _PT = {$_SESSION['p_id'] };
var _TRKU = "https://hornet-m.net/asp/track.php?p=" + _PMTV + "&t=5cec86bd&price=" + _PRICE + "&args=" + _ARGS + "&pt=" + _PT;
var _cks = document.cookie.split("; ");
for(var i = 0; i < _cks.length; i++){ var _ckd = _cks[i].split( "=" ); if(_ckd[0] == "CL_" + _PMTV && _ckd[1].length > 1){ _TRKU += "&" + _CIDN + "=" + _ckd[1]; break; }}
img = document.body.appendChild(document.createElement("img"));
img.src = _TRKU;
</script>
EOM;

};


if($_SESSION['p_id'] == '17'){
echo <<<EOM
<script>
var _CIDN = "cid";
var _PMTV = "5ce4e100843c6";
var _PRICE = {$_SESSION['aws'] };
var _ARGS = {$_SESSION['id_s'] };
var _PT = {$_SESSION['p_id'] };
var _TRKU = "https://hornet-m.net/asp/track.php?p=" + _PMTV + "&t=5ce4e100&price=" + _PRICE + "&args=" + _ARGS + "&pt=" + _PT;
var _cks = document.cookie.split("; ");
for(var i = 0; i < _cks.length; i++){ var _ckd = _cks[i].split( "=" ); if(_ckd[0] == "CL_" + _PMTV && _ckd[1].length > 1){ _TRKU += "&" + _CIDN + "=" + _ckd[1]; break; }}
img = document.body.appendChild(document.createElement("img"));
img.src = _TRKU;
</script>
EOM;

};


if($_SESSION['p_id'] == '13'){
echo <<<EOM
<script>
var _CIDN = "cid";
var _PMTV = "5ce38b836e4f8";
var _PRICE = {$_SESSION['aws'] };
var _ARGS = {$_SESSION['id_s'] };
var _PT = {$_SESSION['p_id'] };
var _TRKU = "https://test.yarimizu.co/asp/track.php?p=" + _PMTV + "&t=5ce38b83&price=" + _PRICE + "&args=" + _ARGS + "&pt=" + _PT;
var _cks = document.cookie.split("; ");
for(var i = 0; i < _cks.length; i++){ var _ckd = _cks[i].split( "=" ); if(_ckd[0] == "CL_" + _PMTV && _ckd[1].length > 1){ _TRKU += "&" + _CIDN + "=" + _ckd[1]; break; }}
img = document.body.appendChild(document.createElement("img"));
img.src = _TRKU;
</script>
EOM;

};

?>


<script>
/////////////////////////////////
setTimeout("redirect()", 25000);
function redirect(){
    location.href='/';
}
////////////////////////2500
</script>
