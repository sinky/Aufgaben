<?php 
include_once("inc.php");

$result = array();
$error = true;
$action = $_POST['action'];


try {     
  switch ($action) {
  
    case 'addTodo':
      $todoText = $_POST['text'];
      $sql = "INSERT INTO ".DBTABLE." (text, datecreated) VALUES ('".$todoText."', ".time().")";
      $result['rowid'] = $db->query($sql);
      if(is_int($result['rowid']) && $result['rowid'] > 0) {
        $error = false;  
      }
      
      $result['entryTpl'] = listEntry($result['rowid'], $todoText, array('cssclass'=>'new'));           
      break; 
      
    case 'getList':
      $todoStatus = $_POST['status'];
      if(empty($todoStatus)) {$todoStatus = 0;} 
      $result['entryTpl'] = getList('completed', $todoStatus);
      $result['listStatus'] = $todoStatus;
      $error = false; 
      break;  
 
    case 'switchStatusTodo':
      $todoId = $_POST['id'];
      $todoStatus = getEntryStatus($todoId);
      
      if($todoStatus == 0) {
        $sql = "UPDATE ".DBTABLE." SET completed = '1' WHERE id='".$todoId."'";
        $db->query($sql);
        $sql = "UPDATE ".DBTABLE." SET datecompleted = '".time()."' WHERE id='".$todoId."'";
        $db->query($sql);  
      }else{
        $sql = "UPDATE ".DBTABLE." SET completed = '0' WHERE id='".$todoId."'";
        $db->query($sql);
        $sql = "UPDATE ".DBTABLE." SET datecompleted = '0' WHERE id='".$todoId."'";
        $db->query($sql);  
      }
        
      $error = false; 
      break;    
    
    case 'statusTodo':
      $todoId = $_POST['id'];
      $result['status'] = getEntryStatus($todoId);
      if($result['status'] == 0 || $result['status'] == 1){
        $error = false;
      }
      break;     
      
    case 'deleteTodo':
      $todoId = $_POST['id'];
      $sql = "DELETE FROM ".DBTABLE." WHERE id='".$todoId."' LIMIT 1";
      
      if($db->query($sql) == 0){
        $error = false;
      }
      break;
    
    case 'setPriority':
      $todoId = $_POST['id'];
      $todoPriority = $_POST['priority'];
      $sql = "UPDATE ".DBTABLE." SET priority = '".$todoPriority."' WHERE id='".$todoId."'";
      $db->query($sql);


      $error = false;
      break;
      
    case 'edittodo':
      $todoId = $_POST['id'];
      $todoText = $_POST['text'];
      $sql = "UPDATE ".DBTABLE." SET text = '".$todoText."' WHERE id='".$todoId."'";
      $db->query($sql);


      $error = false;
      break;
      
      
      
    default:
			return false;
	}
} catch ( Exception $e) {
			$result['message'] = $e->getMessage();
}

if ($error) {
	$result['result'] = false;
} else {
	$result['result'] = true;
}

echo json_encode($result);

exit();
