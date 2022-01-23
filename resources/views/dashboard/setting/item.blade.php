<tr><input type='hidden' name='IDs[]' value="<?=$setting->data['id']?>"/>
<td width="180px;"  class='xtr'> <?=$setting->data['name']?></td>
<td class='xtd'> 
 
   <?if($setting->data['type']==1){?>
        <input class="form-control" type="text" name="value[]" value="<?=$setting->data['value']?>"/>  
   <?}elseif($setting->data['type']==2){?>
       <input    type="text" class="date form-control" name="value[]"  value="<?=$setting->data['value']?>" />  
   <?}elseif($setting->data['type']==3){?>
      <select  class="form-control"   name="value[]"  >  
      <option value="Yes" <?=(( $setting->data['value']=="Yes")?"selected":"")?>><?=$LANG['Yes']?></option>
      <option value="No" <?=(( $setting->data['value']=="No")?"selected":"")?>><?=$LANG['No']?></option>
      </select>
   <?}elseif($setting->data['type']==4){
 	$avs=null;
   if(strrpos($setting->data['availables'],"{")===false){
   	foreach(explode("|",$setting->data['availables']) as $i){
   		$avs[]=array("key"=>$i,"value"=>$i);
   	}
   }else{
   	$sql="select ".str_replace("}","", str_replace("{","",$setting->data['availables']));

   	//$qry=Bll::query($sql);
   	foreach(Bll::query($sql) as $rec){
   		$avs[]=array("key"=>$rec->data['id'],"value"=>$rec->data['name']);
   	}
   	
   }
   ?>
      <select  class="form-control" name="value[]"  >  
   <?foreach($avs as $i){?>
	      <option <?=(( $setting->data['value']==$i['key'])?"selected":"")?> value="<?=$i['key']?>"><?=$i['value']?></option>
   <?}?>
      </select>
      
   <?}elseif($setting->data['type']==5){
   if(strrpos($setting->data['availables'],"{")===false){
   	foreach(explode("|",$setting->data['availables']) as $i){
   		$avs[]=array("key"=>$i,"value"=>$i);
   	}
   }else{
   	$sql="select ".str_replace("}","", str_replace("{","",$setting->data['availables']));
   	
   	$qry=mysql_query($sql);
   	while($rec=mysql_fetch_array($qry)){
   		$avs[]=array("key"=>$rec[0],"value"=>$rec[1]);
   	}
   	
   }
   ?>
      <ul id="chks_<?=$r[id]?>"  >  
   <?foreach($avs as $i){?>
	<li class="checkbox">
               <label>
                   <input <?=(( $setting->data['value']==$i['key'])?"checked":"")?> name="chks_<?=$r[id]?>[]"   value="<?=$i['key']?>" type="checkbox">
                    <span class="text"><?=$i['value']?></span> 
                </label>
 
		</li>
		
		
 
	<?}?>
   </ul>
   <?}elseif($setting->data['type']==6){
       $d=date("Y-m-d H:i:s");
       ?>
       <input   readonly type="text" class="form-control" name="value[]" value="<?=$d?>" /> 
      <?}elseif($setting->data['type']==7){?>
       <textarea class="form-control" name="value[]" ><?=  $setting->data['value'] ?></textarea>  
     <?}elseif($setting->data['type']==8){
 
       ?>

       <textarea class="form-control editor" id="textarea_<?=$setting->data['id']?>" name="value[]" ><?=  $setting->data['value'] ?></textarea>  
		
    <?}?>
 
 </tr>