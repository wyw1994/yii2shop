
<a href="/article/add-category" class="btn btn-success" style="margin-bottom: 10px">添加分类</a>
<a href="/article/recycle-category" class="btn btn-success" style="margin-bottom: 10px">回收站</a>
<a href="/article/category" class="btn btn-success" style="margin-bottom: 10px">分类列表</a>


<table class="table table-bordered text-center">
    <tr>
        <th>ID</th>
        <th>文章标题</th>
        <th>文章内容</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($data as $v):?>
    <tr>
        <td><?=$v->id?></td>
        <td><?=$v->name?></td>
        <td><?=$v->intro?></td>
        <td><?=($v->status)<0?"回收":(($v->status)==0?"隐藏":"正常")?></td>
        <td>
            <!--<a href="" class="btn btn-info btn-sm">查看</a>-->
            <a href="edit-category/?id=<?=$v->id?>" class="btn btn-warning btn-sm">修改</a>

            <a href="<?=($v->status)<0?'restore-category':'del-category'?>/?id=<?=$v->id?>" class="btn btn-danger btn-sm"><?=($v->status)<0?'恢复':'删除'?></a>
        </td>
    </tr>

    <?php endforeach;?>


</table>