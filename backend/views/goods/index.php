<?php
/* @var $this yii\web\View */
?>
<a href="/goods/add" class="btn btn-success" style="margin-bottom: 10px">添加商品</a>
<a href="/goods/recycle" class="btn btn-success" style="margin-bottom: 10px">回收站</a>
<a href="/goods/index" class="btn btn-success" style="margin-bottom: 10px">商品列表</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>LOGO图片</th>
        <th>商品分类</th>
        <th>品牌分类</th>
        <th>市场价格</th>
        <th>商品价格</th>
        <th>库存</th>
        <th>是否在售</th>
        <th>状态</th>
        <th>排序</th>
        <th>添加时间</th>
        <!--<th>浏览次数</th>-->
        <th>操作</th>
    </tr>

    <?php foreach ($data as$v):?>
        <tr>
            <td><?=$v->id?></td>
            <td><?=$v->name?></td>
            <td><?=$v->sn?></td>
            <td><img src="<?=$v->logo?>" alt="商品图片" id="logo" width="50px"></td>
            <td><?=$v->goods_category_id?></td>
            <td><?=$v->brand_id?></td>
            <td><?=$v->market_price?></td>
            <td><?=$v->shop_price?></td>
            <td><?=$v->stock?></td>
            <td><?=$v->is_on_sale?></td>
            <td><?=$v->status?></td>
            <td><?=$v->sort?></td>
            <td><?=date('Y-m-d H:m',$v->create_time)?></td>
           <!-- <td><?/*=$v->view_times*/?></td>-->
            <td>
                <a href="/goods/edit/?id=<?=$v->id?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span>&ensp;修改</a>
                <a href="/goods/del/?id=<?=$v->id?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>&ensp;删除</a>
            </td>

        </tr>

    <?php endforeach;?>

</table>



