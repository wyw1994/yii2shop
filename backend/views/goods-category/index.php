<?php
/* @var $this yii\web\View */
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>名字</th>
        <th>树ID</th>
        <th>左值</th>
        <th>右值</th>
        <th>深度</th>
        <th>父ID</th>
        <th>简介</th>
        <th>操作</th>
    </tr>

    <?php foreach ($data as $v):?>
    <tr>
        <td><?=$v->id?></td>
        <td><?=str_repeat('—',$v->depth).$v->name?></td>
        <td><?=$v->tree?></td>
        <td><?=$v->lft?></td>
        <td><?=$v->rgt?></td>
        <td><?=$v->depth?></td>
        <td><?=$v->parent_id?></td>
        <td><?=$v->intro?></td>
        <td>
            <a href="/goods-category/edit/?id=<?=$v->id?>" class="btn btn-warning btn-sm">修改</a>

            <a href="/goods-category/del/?id=<?=$v->id?>" class="btn btn-danger btn-sm">删除</a>
        </td>
    </tr>

    <?php endforeach;?>


</table>
