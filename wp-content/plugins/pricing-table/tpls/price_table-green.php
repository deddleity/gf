 <?php   
    $data = get_post_meta($pid, 'pricing_table_opt',true);
    $featured=  get_post_meta($pid, 'pricing_table_opt_feature',true);  
    
?>
<div style="clear: both;"></div>
 
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/pricing-table/tpls/css/style.css">
  

 
  
    
    <div id="shaon-pricing-table">
    <div class="pricing-table" >
        <div class="col1">
            <div class="featureTitle">
            <span>FEATURE</span></div>
            
            <div class="feature-content">
                <ul>
                <?php
    $pkeys=array_keys($data);
    foreach($pkeys as $pk){
           $tp .= $data[$pk]['Price'];
           $td .= $data[$pk]['Detail'];
    }
    
    if(trim($tp)==''){ foreach($pkeys as $pk){ unset($data[$pk]['Price']); } }
    if(trim($td)==''){ foreach($pkeys as $pk){ unset($data[$pk]['Detail']); } }
    
    $fkeys=array_keys($data[$pkeys[0]]); 
     
     for($i=0;$i<count($fkeys);$i++){
         if(strtolower($fkeys[$i])!="button url" && strtolower($fkeys[$i])!="button text")    
         echo "<li>".$fkeys[$i]."</li>";
     }
?>

                </ul>
            </div>

                        
        </div>
        
        <?php
    foreach($data as $key=> $value){
?>
        
        <div class="col1">
            <?php if($featured==$key){?>
            <div class="selectedpriceTitle">
            <div class="offer-tag"><img src="<?php echo plugins_url(); ?>/pricing-table/tpls/images/offer-tag.png"></div>
            <span><?php echo $key;?></span></div>
            <div class="selectePrice-content"> 
             <?php }else{
              ?>
              <div class="priceTitle"><span><?php echo $key;?></span></div>
              <div class="price-content">
              <?php   
             }
             ?>
              
                <ul>
                
                <?php foreach($value as $key1=>$value1){
                    if( strtolower($key1)!="button url" && strtolower($key1)!="button text"){                      
                        $value1 = explode("|",$value1);    
                        if($value1[1]!='')
                        echo "<li><a href='#' class='wppttip' title='{$value1[1]}'>".$value1[0]."</a></li>";                                         
                        else
                        echo "<li>".$value1[0]."</li>";                                         
                    }
                }
                ?>
               
                
                </ul>     
                <?php
 
?>           
                <a class="signup" href="<?php echo $value['Button URL']?>"><?php echo $value['Button Text']?></a>
                
                
            </div>
            
        </div>
        <?php } ?>
        
        
  <div style="clear: both;"></div>   
    </div>  
     <div style="clear: both;"></div>   
    </div>  
        
     
 
  
  
   <!-- end pt -->