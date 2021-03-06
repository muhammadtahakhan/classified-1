<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use backend\models\Category;
use yii\helpers\Url;
$this->title = 'Classified';

?>

<main>

  <section  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="container">
        <div class="category-wrap">
      <aside class="col-lg-3 col-md-3 col-sm-3 col-xs-12 category-left-list">
        <h3>Hoved kategorier</h3>
        <ul> 
            <span style="margin-left: 18px;"><a href="<?= Yii::$app->getUrlManager()->createUrl('site/search&id=3') ?> Alle Annonser</a></span>
              
        <?php
        $category_all = \backend\models\Category::find()->where("parent_id = 0 and status=1")->all();
        ?>            
        <?php     
        foreach($category_all as $category){                
            //echo '<li><a href=""><i class=""></i>' . $category['title'] . '</a></li>';
        ?> <li <?php if($id==$category['id']){?> class="active" <?php } ?> id="<?= $category['id'] ?>"  >
            <a href="#"><?= $category['title'] ?></a>
        </li>
            
       <?php } ?>
        </ul>  
      </aside>
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 category-main">
        <div id="" class="changeloc-box">
          <div class="changeloc-box-inr"><i class="fa fa-map-marker"></i><a href="">All Norge<span>(Velg byen din for å se lokale annonser)</span></a> </div>
        </div>
        <div id="" class="selectedcat-box">
        <?php
          
          $category_id = $id;
          
          $category_name = \backend\models\Category::find()->where("id = $category_id and status=1")->all();
          foreach ($category_name as $main_category){?>    
            <div class="image-box" id="category_image" ><img class="img-responsive" src="<?= Yii::$app->request->baseUrl?>/admin/uploads/<?php echo $main_category['image'] ?>"></div>
          
          
              <h3 id="main_cat_heading"> <?php echo $main_category['title']; ?> </h3>
          
          
          <?php }?>
          
          <b id="total_ads"> <?php echo $ads->getadcount($category_id); ?> Ads</b>
          <span id="m_link"> <a  href="<?= \yii\helpers\Url::to(['site/search', 'id'=>$main_category['id']]) ?>">View all ads >></a></span>
        </div>

        <div id="" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 subcat-box">
          <ul id="categories_list">
             <?php foreach($categories as $cate){ ?>
              <li class="sub" data-toggle="modal" data-target="#myModal" onclick="modal_cat(this)" value="<?= $cate->id ?>" title="<?php echo $cate['title']?>" ><a  id="category_names" ><div class="cat-img-box"><img class="img-responsive"  src="<?= Yii::$app->request->baseUrl?>/admin/uploads/<?php echo $cate['image'] ?>"></div><span> <?php echo $cate['title']?></span></a> <?php //echo $cate['title']?></li>
             <?php } ?>
          </ul>
        </div>

      </div>
        </div><!-- /category-wrap-->
    </div><!-- /container-->
  </section><!-- /-->
    <!--model start-->
   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Modal Header</h4>
        </div>
          <div class="modal-body" id="modal-body">
<!--          <p>
             <img class="img-responsive" src="<?php echo Yii::getAlias('@web') ?>/design/img/loading.gif" />
          </p>-->
              <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
               <ul id="c3">
<!--                <li class=""><a href="">All Ads</a></li>
                <li class="active"><a href="">Property<i class="fa fa-angle-right"></i></a></li>
                <li class=""><a href="">Industry<i class="fa fa-angle-right"></i></a></li>
                <li class=""><a href="">Mall<i class="fa fa-angle-right"></i></a></li>
                <li class=""><a href="">Samfunn<i class="fa fa-angle-right"></i></a></li> 
                <li class=""><a href="">For Sale<i class="fa fa-angle-right"></i></a></li> 
                <li class=""><a href="">Offering<i class="fa fa-angle-right"></i></a></li> 
                <li class=""><a href="">Bid/Auction<i class="fa fa-angle-right"></i></a></li>-->
              </ul>  
            </div>
            <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
                <ul id="cs"  class="hidden" >
                          <p>
             <img class="img-responsive" src="<?php echo Yii::getAlias('@web') ?>/design/img/loading.gif" />
          </p>
              </ul>  
            </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--modal end here-->
  
  <!-- Ads Boxes -->
<!--    <div class="ads-vr-left">Space Available For Ad</div>
    <div class="ads-vr-right">Space Available For Ad</div>-->
  <!-- /Ads Boxes -->
</main>


<script type="text/javascript">

jQuery(document).ready(function($) {
    
        jQuery('ul li a').click(function() {
        jQuery('ul').children().removeClass('active');
        jQuery(this).closest('li').addClass('active');
        jQuery('span').children().removeClass('active');

    });
    
    jQuery('li:not(.sub)').click(function() {
        var id = this.id;
//        window.history.pushState('obj', 'newtitle', '/classified/frontend/web/index.php?r=category%2Fcategories&id='+ this.id);
        
        $.ajax({    //create an ajax request to load_page.php
            type: "GET",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('category/get_all_categories') ?>",
            data: "id="+id,
            dataType: "JSON",   //expect html to be returned                
            success: function(response){
            var category =''
            for (i = 0; i < response.length; i++) {
                category +='<li data-toggle="modal" data-target="#myModal" onclick="modal_cat(this)" value="' + response[i]["id"] +'" title="' + response[i]["title"] +'" id="' + response[i]["id"] +'"><a id="category_names" href="#"><div class="cat-img-box"><img class="img-responsive"  src="<?= Yii::$app->request->baseUrl?>/admin/uploads/'   +response[i]["image"]+'"> </div><span> '+response[i]["title"]+'</span></a></li>';
            }
            $('#categories_list').html(category)
            }
            });
    
        //create an ajax request to change the category images.
        $.ajax({    
            type: "GET",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('category/get_main_category') ?>",
            data: "id="+id,
            dataType: "JSON",   //expect html to be returned                
            success: function(response){
            var category =''
            var cat_image =''
            var  m_link = ''
            for (i = 0; i < response.length; i++) {
                category +='<h3>'+response[i]["title"]+'</h3>';
                cat_image +='<div class="image-box" id="category_image" ><img class="img-responsive" src="<?= Yii::$app->request->baseUrl?>/admin/uploads/'+response[i]["image"]+'"></div>'; 
                m_link +=' <a id="m_link" href="<?= \yii\helpers\Url::to(['site/search']) ?>&id='+response[i]["id"]+'">View all ads >></a>';
            }
            $('#main_cat_heading').html(category);
            $('#category_image').html(cat_image);
            $('#m_link').html(m_link);
            }
            }); 
        
        //This ajax counts the total numbers of category ads.
        $.ajax({    
            type: "GET",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('category/ads_counts') ?>",
            data: "id="+id,
            dataType: "JSON",   //expect html to be returned                
            success: function(response){
            $('#total_ads').html(response + ' Ads');
            }
            });
        
            return false; // prevent default click action from happening!            
            e.preventDefault(); // same thing as above
        });
        });
</script>