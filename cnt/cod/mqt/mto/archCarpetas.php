<?php
/**
 *
 * Desarrollado por Myra
 * 25/03/2014 *
 *
 * presentación de carpetas en módulo de archivero.
 */
$entradas = $arch->relacionaCarpetas();?>
<ul>
	<li>[home]</li>
	<?php 
	pintaArbol($entradas, 0,substr_count($ses->getCarpeta(),"/")+1);?>
</ul>

<?php 
function pintaArbol($entradas,$i,$nivel){
	global $ses;?>
	<ul<?=$i==0?' class="home"':''?>>
	<?php 
	foreach($entradas as $entrada=>$valor){
		$nombre = substr($entrada,strrpos($entrada,'/')+1);?>
		<li data-folder="<?=$entrada?>"<?=$entrada==$ses->getCarpeta()?' class="selected"':''?>><?=caracterRepetido($i).(count($entradas[$entrada])>0?'+':'-').$nombre?></li>
		<?
		if(count($valor)>0){
			pintaArbol($valor,++$i,$nivel);
			--$i;
		}?>
	<?
	}?>
	</ul>
<?php 
}
function caracterRepetido($i){
	$cadena = '';
	$i--;
	for($j=0;$j<=$i+1;$j++){
		$cadena.="&nbsp;&nbsp;";
	}
	return $cadena;
}