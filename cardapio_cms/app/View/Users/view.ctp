<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//debug($user);
?>
<table style="width: 80%;" border="0">
    <thead>
        
        <tr>
            <th style="text-align: center;" colspan="2">
                DADOS DO USUÁRIO
            </th>
            
        </tr>
        <tr>
            <th>
                Nome:
            </th>
            <th>
                E-mail
            </th>
            <th>
                Status
            </th>
        </tr>
        
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $user['User']['username'];?>
            </td>
            <td>
                <?php echo $user['User']['email'];?> 
            </td>
            <td>
                <?php echo ($user['User']['status'] == 1) ? "Ativo" : "Inativo";?> 
            </td>
        </tr>
        <tr>
            <td>
               
            </td>
            <td>
                
            </td>
            <td>
                
            </td>
        </tr>
    </tbody>
</table>
<br />
<button class="btn btn-danger" onclick="javascript:history.back(-1);" type="button">Voltar</button>