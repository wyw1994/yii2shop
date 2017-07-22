<div class="container">
    <h1><?=$data->name?></h1>
    <span>发布时间：<?=date('Y-m-d H:m:s',$data->create_time)?></span> |
    <div class="container" style="margin-top: 20px;font-size: 18px;color: black">
        <?=$content->content?>
    </div>
 </div>
