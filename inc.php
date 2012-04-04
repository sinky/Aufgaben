<?php 
include_once("db.php");
define('DBTABLE', 'aufgaben');


$db = new Database();
$db->connect('<DB_SERVER>', '<DB_NAME>', '<DB_USER>', '<DB_PASS>');

$entryTpl = <<<EOD
<li class="entry:cssClass:" id="todo_:id:" data-id=":id:" data-completed=":completed:">
  <div>
    <span class="checkbox"><img src="img/check_48.png" alt="Completed" border="0"/></span>
    <span class="text">:text:</span>
  </div>
  <div class="more">
    <span class="right">
      <div class="datecreated">Erstellt: :datecreated:</div>
      <div class="datecompleted">Erledigt: :datecompleted:</div>
    </span>
    <span class="left">
      
      <div class="setpriority">
        <span class="low lk">1 - low</span>
        <span class="normal lk">2 - normal</span>
        <span class="high lk">3 - high</span>
      </div>
      <span class="edittodo lkO">Bearbeiten</span> <span class="deletetodo lk">L&ouml;schen</span>
      
    </span>
  </div>
</li>
EOD;

//array('id'=>$id, 'priority'=>$priority, 'completed'=>$completed, 'datecreated'=>$datecreated, 'datecompleted'=>$datecompleted )
function listEntry($id, $text, $vars=array()) { //$id, $text, $priority=2, $completed=0, $datecreated='leer', $datecompleted=0) {
  global $entryTpl;
  $defaults = array('priority'=>2, 'completed'=>0, 'datecreated'=>'leer', 'datecompleted'=>0, 'cssclass'=>'');  
  $vars = array_merge($defaults, $vars);  
  
  if( $vars['completed'] == 1 ){$cssClass .= " completed";}
  if( !empty($vars['cssclass']) ){$cssClass .= " ".$vars['cssclass'];}
  switch ($vars['priority']) {
    case 1:
        $cssClass .= " low";
        break;
    case 2:
        $cssClass .= " normal";
        break;
    case 3:
        $cssClass .= " high";
        break;
  }
  if( $vars['datecreated'] == "leer" ){$vars['datecreated'] = time();}         
  if( $vars['datecreated'] <= 0 ) { $vars['datecreated'] = "-"; }else{
    $vars['datecreated'] = '<time datetime="'.date("c", $vars['datecreated']).'">'.date("d.m.Y H:i", $vars['datecreated']).'</time>';  
  }
  if($vars['datecompleted'] <= 0) { $vars['datecompleted'] = "-"; }else{
    $vars['datecompleted'] = '<time datetime="'.date("c", $vars['datecompleted']).'">'.date("d.m.Y H:i", $vars['datecompleted']).'</time>';
  }
  
  // taken from here: http://stackoverflow.com/questions/1242733/make-links-clickable-with-regex
  $text = trim($text);
  while ($text != stripslashes($text)) { $text = stripslashes($text); }    
  $text = strip_tags($text,"<b><i><u>");
  $text = preg_replace("/(?<!http:\/\/)www\./","http://www.",$text);
  $text = preg_replace( "/((http|ftp)+(s)?:\/\/[^<>\s]+)/i", "\\0\ <a href=\"\\0\" target=\"_blank\"><img src=\"img/link_32.png\" height=\"16\" width=\"16\"></a>",$text);
  
  $trans = array(":id:" => $id, ":text:" => $text, ":completed:" => $vars['completed'], ":datecreated:" => $vars['datecreated'], ":datecompleted:" => $vars['datecompleted'], ":cssClass:" => $cssClass);
  return strtr($entryTpl, $trans);
}

function getList($where='completed', $whereVal='0') {
  global $db;
  $sql = "SELECT * FROM ".DBTABLE." WHERE $where='$whereVal' ORDER BY priority DESC, datecreated DESC";
  $db->query($sql);
  while($db->nextRecord()){
    $output .= listEntry($db->Record['id'], $db->Record['text'], array('priority'=>$db->Record['priority'], 'completed'=> $db->Record['completed'], 'datecreated'=> $db->Record['datecreated'], 'datecompleted'=> $db->Record['datecompleted']));
  }
  return $output;  
}

function getEntry() {
  
}

function getEntryStatus($id) {
  global $db;
  $sql = "SELECT * FROM ".DBTABLE." WHERE id='$id'";
  $db->query($sql);
  $db->singleRecord();
  return $db->Record['completed'];  
}