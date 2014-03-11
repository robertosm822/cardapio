<?php 
    echo $this->Form->create('User');
    
    foreach ($restaurant as $key => $value) {
        $configs = array();
        $configs['type'] = 'checkbox';
        $configs['value'] = $value['Restaurant']['id'];
        $configs['label'] = $value['Restaurant']['name'];
        $configs['hiddenField'] = false;
        
        $checked = '';
        foreach ($user['Restaurant'] as $k=>$v){
            if($v['id'] == $value['Restaurant']['id']){
                $checked = 'checked';
            }
        }
        $configs['checked'] = $checked;
        
        echo $this->Form->input('Restaurant.restaurant_id',$configs);
    }
    
      echo $this->Form->input('id', array('type'=>'hidden'));
    
    echo $this->Form->end('Confirmar');
?>