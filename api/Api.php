<?php 

	require_once '../includes/DbOperation.php';

	function isTheseParametersAvailable($params){
	
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
		
			echo json_encode($response);
			
		
			die();
		}
	}
	
	
	$response = array();
	

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
	
			case 'createmessage':
				
				isTheseParametersAvailable(array('msgTitulo', 'msgTexto', 'msgData', 'msgRemetente'));
				
				$db = new DbOperation();
				
				$result = $db->createMessage(
					$_POST['msgTitulo'],
					$_POST['msgTexto'],
					$_POST['msgData'],
					$_POST['msgRemetente']
				);
				

			
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'Postagem adicionado com sucesso';

					
					$response['posts'] = $db->getMessages();
				}else{

					
					$response['error'] = true; 

				
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				
			break; 
			
		
			case 'getmessages':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['posts'] = $db->getMessages();
			break; 

			case 'getmessagesbydate':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['posts'] = $db->getMessagesByDate();
			break; 
			
			case 'getmessagesbyvotes':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['posts'] = $db->getMessagesByVotes();
			break; 
			
			
			
		
			case 'updatemessage':
				isTheseParametersAvailable(array('msgId','msgTitulo','msgTexto','msgData','msgRemetente'));
				$db = new DbOperation();
				$result = $db->updateMessage(
					$_POST['msgId'],
					$_POST['msgTitulo'],
					$_POST['msgTexto'],
					$_POST['msgData'],
					$_POST['msgRemetente']
				);
				
				if($result){
					$response['error'] = false; 
					$response['message'] = 'Postagem atualizado com sucesso';
					$response['posts'] = $db->getMessages();
				}else{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
			break;

            case 'votepost':
				if(isset($_GET['msgId'])){
					$db = new DbOperation();
					if($db->votarPost($_GET['msgId'])){
						$response['error'] = false; 
						$response['message'] = 'Voto cadastrado com sucesso';
						$response['posts'] = $db->getMessages();
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Não foi possível votar, forneça a id do post por favor';
				}
			break; 
			
			
			case 'deletemessage':

				
				if(isset($_GET['msgId'])){
					$db = new DbOperation();
					if($db->deleteMessage($_GET['msgId'])){
						$response['error'] = false; 
						$response['message'] = 'Postagem excluído com sucesso';
						$response['posts'] = $db->getMessages();
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Não foi possível deletar, forneça um id por favor';
				}
			break; 
		}
		
	}else{
		 
		$response['error'] = true; 
		$response['message'] = 'Chamada de API inválida';
	}
	

	echo json_encode($response);