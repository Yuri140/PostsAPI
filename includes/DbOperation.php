<?php
 
class DbOperation
{
    
    private $con;
 
 
    function __construct()
    {
  
        require_once dirname(__FILE__) . '/DbConnect.php';
 
     
        $db = new DbConnect();
 

        $this->con = $db->connect();
    }
	
	
	function createMessage($title, $text, $date, $sender){
		$stmt = $this->con->prepare("INSERT INTO Mensagem (msgTitulo, msgTexto, msgData, msgRemetente) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("SSSS", $titulo, $text, $date, $sender);
		if($stmt->execute())
			return true; 			
		return false;
	}
	
	function getMessages(){
		$stmt = $this->con->prepare("SELECT msgId, msgTitulo, msgTexto, msgData, msgRemetente, msgVotes FROM Mensagem");
		$stmt->execute();
		$stmt->bind_result($id, $title, $text, $date, $sender, $votes);
		
		$messages = array(); 
		
		while($stmt->fetch()){
			$message  = array();
			$message['msgId'] = $id; 
			$message['msgTitulo'] = $title; 
			$message['msgTexto'] = $text; 
			$message['msgData'] = $date; 
			$message['msgRemetente'] = $sender;
            $message['msgVotes'] = $votes;
			
			array_push($messages, $message); 
		}
		
		return $messages; 
	}
	
	function getMessagesByVotes(){
		$stmt = $this->con->prepare("SELECT msgId, msgTitulo, msgTexto, msgData, msgRemetente, msgVotes FROM Mensagem order by msgVotes DESC ");
		$stmt->execute();
		$stmt->bind_result($id, $title, $text, $date, $sender, $votes);
		
		$messages = array(); 
		
		while($stmt->fetch()){
			$message  = array();
			$message['msgId'] = $id; 
			$message['msgTitulo'] = $title; 
			$message['msgTexto'] = $text; 
			$message['msgData'] = $date; 
			$message['msgRemetente'] = $sender;
            $message['msgVotes'] = $votes;
			
			array_push($messages, $message); 
		}
		
		return $messages; 
	}

	function getMessagesByDate(){
		$stmt = $this->con->prepare("SELECT msgId, msgTitulo, msgTexto, msgData, msgRemetente, msgVotes FROM Mensagem order by msgData DESC");
		$stmt->execute();
		$stmt->bind_result($id, $title, $text, $date, $sender, $votes);
		
		$messages = array(); 
		
		while($stmt->fetch()){
			$message  = array();
			$message['msgId'] = $id; 
			$message['msgTitulo'] = $title; 
			$message['msgTexto'] = $text; 
			$message['msgData'] = $date; 
			$message['msgRemetente'] = $sender;
            $message['msgVotes'] = $votes;
			
			array_push($messages, $message); 
		}
		
		return $messages; 
	}
	
	function pesquisar($text){
		$searchTerm = '%' . $text . '%';
		$stmt = $this->con->prepare("SELECT msgId, msgTitulo, msgTexto, msgData, msgRemetente, msgVotes FROM Mensagem where msgTexto like ? order by msgVotes DESC");
		$stmt->bind_param("s", $searchTerm);
		$stmt->execute();
		$stmt->bind_result($id, $title, $text, $date, $sender, $votes);
		
		$messages = array(); 
		
		while($stmt->fetch()){
			$message  = array();
			$message['msgId'] = $id; 
			$message['msgTitulo'] = $title; 
			$message['msgTexto'] = $text; 
			$message['msgData'] = $date; 
			$message['msgRemetente'] = $sender;
            $message['msgVotes'] = $votes;
			
			array_push($messages, $message); 
		}
		
		return $messages; 
	}
	
	
	function updateMessage($id, $title, $text, $date, $sender){
		$stmt = $this->con->prepare("UPDATE Mensagem SET msgTitulo = ?, msgTexto = ?, msgData = ?, msgRemetente = ? WHERE msgId = ?");
		$stmt->bind_param("SSSSI", $title, $text, $date, $sender, $id);
		if($stmt->execute())
			return true; 
		return false; 
	}

    function votarPost($id){
        $stmt = $this->con->prepare("UPDATE Mensagem SET msgVotes = msgVotes + 1 WHERE msgId = ?");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true; 
		return false; 
    }
	
	
	function deleteMessage($id){
		$stmt = $this->con->prepare("DELETE FROM Mensagem WHERE msgId = ? ");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true; 
		return false; 
	}
	
	
	

}