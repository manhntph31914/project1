<?php

function billcart($id,$id_order,$idpro,$dongia,$soluong,$tensp,$img){
    $sql="insert into order_detail(id,id_order,idpro,dongia,soluong,tensp,img) values('$id','$id_order','$idpro','$dongia','$soluong','$tensp','$img')";
    pdo_execute($sql);
}

function insert_billcart($id,$id_order,$idpro,$dongia,$soluong,$tensp,$img,$tongtien){
    $sql="INSERT INTO order_detail (id, id_order, idpro, dongia, soluong, tensp, img)
    VALUES ($id, $id_order, $idpro, $dongia, $soluong, '$tensp', '$img', $tongtien)";
    pdo_execute($sql);
}

function loadall_billcart(){
    $sql="SELECT*FROM order_detail order by id_order desc";
    $listbillcart= pdo_query($sql);
    return $listbillcart;
}


?>