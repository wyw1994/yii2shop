
<a href="/brand/add" class="btn btn-success" style="margin-bottom: 10px">添加</a>
<a href="/brand/recycle" class="btn btn-success" style="margin-bottom: 10px">回收站</a>
<a href="brand/index" class="btn btn-success" style="margin-bottom: 10px">品牌列表</a>

<table  class="table table-bordered" style="text-align: center;">
    <tr >
        <th>ID</th>
        <th>品牌名</th>
        <th>描述</th>
        <th>LOGO</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($data as $v):?>
    <tr>
        <td><?=$v->id?></td>
        <td><?=$v->name?></td>
        <td><?=$v->intro?></td>
        <td><img src="<?=$v->logo?>" alt="" width="50px"></td>
        <td><?=($v->status)<0?"回收":(($v->status)==0?"隐藏":"正常")?></td>
        <td>
            <!--<a href="" class="btn btn-info btn-sm">查看</a>-->
            <a href="/brand/edit/?id=<?=$v->id?>" class="btn btn-warning btn-sm">修改</a>

           <a href="/brand/<?=($v->status)<0?'restore':'del'?>/?id=<?=$v->id?>" class="btn btn-danger btn-sm"><?=($v->status)<0?'恢复':'删除'?></a>
        </td>
    </tr>
    <?php endforeach;?>

</table>