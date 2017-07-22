

<a href="/article/add" class="btn btn-success" style="margin-bottom: 10px">添加文章</a>
<a href="/article/recycle" class="btn btn-success" style="margin-bottom: 10px">回收站</a>
<a href="/article/index" class="btn btn-success" style="margin-bottom: 10px">文章列表</a>


<table class="table table-bordered table-responsive text-center">
    <tr>
        <th>ID</th>
        <th>标题</th>
        <th>简介</th>
        <th>分类</th>
        <th>热度</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($data as $v):?>
        <tr>
            <td><?=$v->id?></td>
            <td><?=$v->name?></td>
            <td><?=$v->intro?></td>
            <td><?=$v->categroy->name?></td>
            <td><?=$v->sort?></td>
            <td><?=($v->status)<0?"回收":(($v->status)==0?"隐藏":"正常")?></td>
            <td><?=date('Y-m-d H:m:s',$v->create_time)?></td>
            <td>
                <a href="/article/detail/?id=<?=$v->id?>" class="btn btn-success btn-sm">文章详情</a>

                <a href="/article/edit/?id=<?=$v->id?>" class="btn btn-warning btn-sm">修改</a>

                <a href="<?=($v->status)<0?'restore':'del'?>/?id=<?=$v->id?>" class="btn btn-danger btn-sm"><?=($v->status)<0?'恢复':'删除'?></a>
            </td>
        </tr>

    <?php endforeach;?>
</table>