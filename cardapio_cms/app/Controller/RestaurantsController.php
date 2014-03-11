<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author Daniel
 */

class RestaurantsController extends AppController{
    
    public function index(){
        $this->set('restaurants', $this->Restaurant->find('all'));
    }
    
    public function add(){
        if ($this->request->is('post')){
            $this->Restaurant->create();
            
            if ($this->Restaurant->save($this->request->data)){
                       
                
                $this->Session->setFlash('Restaurante criado com sucesso =)');
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('Falha na criação do Restaurante');
            }
	}
    }
    
    public function edit($id = null){
        if(!$id){
            throw new NotFoundException(__('Restaurante Inválido'));
        }
        
        $restaurant = $this->Restaurant->findById($id);
        
        if(!$restaurant){
            throw new NotFoundException(__('Restaurante Inválido'));
        }

        if ($this->request->is('post') || $this->request->is('put')){
            
            $this->Restaurant->id = $id;
            
			//verificar se arquivo de imagem esta vazio 
			if( $this->request->data['Restaurant']['foto']['size'] !== 0){
				//DOWNLOAD DE ARQUIVO NAO VIR COMO ARRAY USANDO O METODO CRIADO DE NOME "upload" vindo do Model Restaurant.php
				//TRATANDO O ARQUIVO DE IMAGEM PARA NAO SER MAIOT QUE 1MB E DO TIPO JPG/PNG ==============================================
				if($this->request->data['Restaurant']['foto']['size'] > 1048576){
					$this->Session->setFlash('Tamanho da imagem não pode ultrapassar 1MB e formato deve ser PNG ou JPG');
					//debug($this->request->data['Restaurant']['foto']);
					
					$this->redirect(array( 'action'=>"edit/".$this->request->data['Restaurant']['id'] ) );
				}
				if($this->request->data['Restaurant']['foto']['type'] == 'image/jpeg' || $this->request->data['Restaurant']['foto']['type'] == 'image/png' || $this->request->data['Restaurant']['foto']['type'] == 'image/PNG'){
					
					if($this->request->data['Restaurant']['foto']['type'] == 'image/jpeg'){	
						$img = imagecreatefromjpeg($this->request->data['Restaurant']['foto']['tmp_name']);
						//debug($img);
						//TRATANDO A VERIFICACAO DE LARGULA DA LOGOMARCA
						if(imagesx($img) > 251){
							$this->Session->setFlash('Largura da logo .jpg marca deve ter no máximo 241 px de largura.');
							$this->redirect(array( 'action'=>"edit/".$this->request->data['Restaurant']['id'] ) );
						}
						
					}
					if($this->request->data['Restaurant']['foto']['type'] == 'image/png'){	
						$img = imageCreateFromPng($this->request->data['Restaurant']['foto']['tmp_name']);
						//VERIFICANDO SE A LARGURA DA LOGOMARCA PNG NAO DEVE SER MAIOR QUE 251pixels
						if(imagesx($img) > 251){
							$this->Session->setFlash('Largura da logo .png marca deve ter no máximo 241 px de largura.');
							$this->redirect(array( 'action'=>"edit/".$this->request->data['Restaurant']['id'] ) );
						}
					}
						//faz o upload da imagem
						$this->request->data['Restaurant']['foto']=$this->Restaurant->upload($this->request->data['Restaurant']['foto'], '/files/restaurant/photo/'.$this->request->data['Restaurant']['id']);
					
				} else {
					$this->Session->setFlash('Erro ao enviar arquivo, deve ser do tipo JPEG ou PNG');
					
					
					$this->redirect(array( 'action'=>"edit/".$this->request->data['Restaurant']['id'] ) );
				}
			} else {
				$ultFoto = $this->Restaurant->query("select * FROM restaurants WHERE `id`=".$this->Restaurant->id." ");
				//debug($ultFoto[0]['restaurants']['foto']);
				//MANTENDO A MESMA FOTO JÁ QUE VEM VAZIA
				$this->request->data['Restaurant']['foto'] = $ultFoto[0]['restaurants']['foto'];
			}
			
			//===== FIM DAS VALIDACOES NA IMAGEM DA LOGO  ==================================================
			
            if ($this->Restaurant->save($this->request->data)){
                $this->Session->setFlash('Restaurante alterado com sucesso.');
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('Restaurante não pode ser alterado.');
            }
        }
        
        if(!$this->request->data){
            $this->request->data = $restaurant;
        }
    }
    
    public function view($id = null){
        if(!$id){
            throw new NotFoundException(__('Restaurante Inválido'));
        }
        
        $restaurant = $this->Restaurant->findById($id);
        
        if (!$restaurant){
            throw new NotFoundException(__('Restaurante Inválido'));
        }
        $this->set('restaurant', $restaurant);
    }
    
    public function inactivate($id = null){
        $this->Restaurant->id = $id;
        
        if (!$this->request->is('post') && !$this->request->is('put')) {
            throw new MethodNotAllowedException();
        }
    
        if (!$this->Restaurant->exists()) {
            throw new NotFoundException(__('Restaurante Inválido'));
        }
    
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Restaurant']['id'] = $id;
            $this->request->data['Restaurant']['active'] = '0';

            if ($this->Restaurant->save($this->request->data)) {
                $this->Session->setFlash('Restaurante inativado com sucesso');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Restaurante não pode ser inativado, tente novamente');
            }
        } 
    }
    
    public function delete($id = null,$cascade = true) {
        $this->Restaurant->id = $id;
        if (!$this->Restaurant->exists()) {
            throw new NotFoundException(__('Restaurante Invalido'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Restaurant->deleteAll()) {
            $this->Session->setFlash(__('Restaurante apagado com sucesso.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Restaurante não pode ser apagado'));
        $this->redirect(array('action' => 'index'));
    }
    
	public function mostraIdRest($idUserOn=NULL){
	
		//pega o ID passado na view e faz a query retornando o ID do Restaurante do Usuario Logado
		if($idUserOn > 0){
			$results = $this->Restaurant->query("SELECT (SELECT name FROM restaurants WHERE id=ru.restaurants_id) as NOME_RESTAURANTE, ru.restaurants_id as ID_RES FROM `users` as u INNER JOIN restaurants_users as ru ON ru.users_id= u.id WHERE u.id =".$idUserOn."");
			$dadosView=array();
				//debug($results);
			if(isset($results[0]['ru']['ID_RES'])){	
				$dadosView['mostraIdRest'] = $results[0]['ru']['ID_RES'];
				//debug($dadosView);
				return $dadosView['mostraIdRest'];
			}
		}
	}
	
    public function activate($id = null){
        $this->Restaurant->id = $id;
        
        if (!$this->request->is('post') && !$this->request->is('put')) {
            throw new MethodNotAllowedException();
        }
    
        if (!$this->Restaurant->exists()) {
            throw new NotFoundException(__('Restaurante Inválido'));
        }
    
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Restaurant']['id'] = $id;
            $this->request->data['Restaurant']['active'] = '1';

            if ($this->Restaurant->save($this->request->data)) {
                $this->Session->setFlash('Restaurante ativado com sucesso');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Restaurante não pode ser ativado, tente novamente');
            }
        } 
    }
}

?>
