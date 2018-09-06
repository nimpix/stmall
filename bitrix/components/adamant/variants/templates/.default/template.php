<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<? 
//  vardump($arResult['test']);

$cnt =2; //Цвета кнопок

?>
  <div class="container" id="title-cat">
        <div class="row">
            <h3><?=$arResult['other']['title']?></h3>
            <a class="variants-link" href="/vse-trenazhery-dlya-pohudeniya">Варианты</a>
        </div>
    </div>
    <div class="trainer <?=$arResult['other']['align']?>">
        <div class="trainer-img">
            
			<div class="tr-item" style="background:url('<?=$arResult['other']['img']?>') no-repeat center;">
			<a href="<?=$arResult['other']['detail_url'] ?>" class="tr-item-in">
                <a href="<?=$arResult['other']['detail_url'] ?>" class="href-one"><?=$arResult['other']['button_name']?></a>
   			</a>
            </div>
<?
  
        foreach ($arResult['custom_sections'] as $cs){
            ?>
        
            <div class="tr-item">
                <div class="img_wrapper">
                    <a href="<?=$cs['URL']?>">
                        <img src="/upload/<?=$arResult['other']["SUBDIR"][$cs['NAME']]?>/<?=$arResult['other']["FILE_NAME"][$cs['NAME']]?>"/>        
                    </a>
                </div>
                <div class="tr-button-<? print $cnt; $cnt++;?>">
                    <a href="<?=$cs['URL']?>"><?=$cs['NAME']?></a>
                </div>
            </div>
        
        
            <?
        
        }
  ?>


     </div>
        <div style="height:400px;">
        </div>
    </div><?
?>


	
	