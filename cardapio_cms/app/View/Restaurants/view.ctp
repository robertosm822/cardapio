<style type="text/css">

/* Spearmint tints > http://inspire.server101.com/bttdb/html/tables/ */

/* table */
table {
	margin: 0 0 1em;
	background: #FFF;
	border-collapse: collapse;
	
}

/* caption = table title/heading */
caption {
	text-align: left;
	font: bold small-caps 120%/1.3 "trebuchet ms",Helvetica,Arial,Sans-Serif;
	color: #363;
	margin: .3em 0;
}

/* reduced font size to save space */
tr { font-size: 90%; }
/* prevent nested tables reducing font size further */
tr tr { font-size: 100%; }

/* tinted rows */
/* in CSS3 selectors: tbody tr:even or tbody tr:nth-child(2n) */
tr.odd {
	background: #DFD;
}

/* table cells */
th, td {
	font-weight: normal;
	padding: .3em .7em;
	text-align: left;
	vertical-align: top;
	background: #FFF;
}

/* borders to separate body sections */
tbody tr:first-child th,
tbody tr:first-child td,
tfoot tr:first-child th,
tfoot tr:first-child td {
	
}

/* tints for column headings */
thead {
	background: #9C9;
	white-space: nowrap;
}

/* tints for totals */
tfoot {
	background: #ADA;
}

/* bold text for totals */
tfoot th,
tfoot td {
	font-weight: bold;
}

</style>
<?php $base_url = Router::url('/');  ?>

<table style="width:50%">
	
		<tbody>
			<tr>
				<td><b>Nome:</b></td>
				<td><h4><?php echo h($restaurant['Restaurant']['name']); ?></h4></td>
				
			</tr>
			<tr>
				<td colspan="2">
					<div style="border: 2px #CCC solid; padding: 5px;  width: 370px;margin:10px;">
						<?php 
						
							if($restaurant['Restaurant']['foto'] == NULL || !isset($restaurant['Restaurant']['foto'])){
									echo $this->Html->image("no_image.jpg", array('style'=>'width:370px;') );
							} else { 
									echo $this->Html->image("../".h($restaurant['Restaurant']['foto']), array('style'=>'width:370px;') );
							}	
						?>
					</div>
				</td>
				
				
			</tr>
			<tr>
				<td><b>Status:</b></td>
				<td><?php echo ($restaurant['Restaurant']['active']==1)?'Ativo':'Inativo'; ?></td>
		
				
			</tr>
			<tr>
				<td><b>Email Restaurante:</b></td>
				<td><?php echo $restaurant['Restaurant']['email']; ?></td>
		
			</tr>
			<tr>
				<td><b>Endereço:</b></td>
				<td><?php echo $restaurant['Restaurant']['endereco']; ?></td>
		
			</tr>
			<tr>
				<td><b>Telefone:</b></td>
				<td><?php echo $restaurant['Restaurant']['telefone']; ?></td>
		
			</tr>
			<tr>
				<td><b>Data Criação:</b></td>
				<td><?php echo date("d/m/Y - H:i:s",strtotime($restaurant['Restaurant']['created'])); ?></td>
		
			</tr>
		</tbody>
	</table>
	
	<button class="btn btn-danger" onclick="javascript:history.back(-1);" type="button">Voltar</button>

