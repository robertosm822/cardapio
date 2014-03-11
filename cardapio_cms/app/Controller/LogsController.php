<?php

class LogsController extends AppController {

    public $helpers = array ('Html','Form');
    public $name = 'Logs';
	
	public function retornaData($data){
		return implode("-",array_reverse(explode("/",$data)));
	}
    
	//visualizador de todos os posts vindos do banco
    public function listar($perIni=NULL, $perFim=NULL) {
	
		$this->set('logs');
        /* INICIADO sucesso de Paginar a listagem
        LIMITANDO A CONTIDADE DE PAGINAS */
        
		$perIni = (isset($_GET['inicio']))? self::retornaData($_GET['inicio']): "";
		$perFim = (isset($_GET['fim']))? self::retornaData($_GET['fim']): "";
        /* ACRESCENTANDO UMA LISTAGEM DO ULTIMOS 30 DIAS */
		$inicio = date("Y-m-d",strtotime("-30 days")); //voltando 30 dias da data atual
		$fim = date('Y-m-d',strtotime("+1 days"));
		if($perIni == "" || $perFim == ""){
			$perIni = $inicio;
			$perFim = $fim;
		}
		
		$this->paginate['Log']['conditions'] = "(Log.created BETWEEN '".$perIni."' AND '".$perFim."')";
        $this->paginate['Log']['limit'] = 25;
		$this->set('logs', $this->paginate() );
		//$this->set('logs', $this->Log->find('all'));
    }
    
}
?>
