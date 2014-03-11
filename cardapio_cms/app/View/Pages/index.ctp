<style>
    .sombra		{
        text-align: center;
        margin-left: 70px;
        background: url(app/webroot/img/sombra.png) no-repeat;
        width: 150px;
        height: 174px;
			}
   .sombra img	{
       position: relative;
			top: -3px;
			left: -3px;}
</style>
Bem vindo ao sistema CMS Cardápio.
<br /><br />

<table style="text-align: center;">
    <tr>
        <td style="text-align: center;">
            <div class="sombra">
            <?php echo $this->Html->image('gerir_user.png', array('alt' => 'Gerenciar Usuários','title'=>'Gerenciar Usuários',
    'url' => array('controller' => 'users', 'action' => 'index')) );?>
            </div>
        </td>
       
        <td style="text-align: center;">
             <div class="sombra">
            <?php echo $this->Html->image('gerir_cardapios.png', array('alt' => 'Gerenciar Cardápios',
                'url' => array('controller' => 'cards', 'action' => 'index')) );?>
             </div>
        </td>
        <td style="text-align: center;">
          <div style="width: 350px;">
           
          </div>
        </td>
        
    </tr>
</table>
