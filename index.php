<?php
    session_start();
    include "model/pdo.php";
    include "model/sanpham.php";
    include "model/danhmuc.php";
    include "model/taikhoan.php";
    include "view/header.php";
    include "model/donhang.php";
    include "model/order_detail.php";
    include "global.php";
    
    $spnew=loadall_sanpham_home();
    $dsdm=loadall_danhmuc();
    $dstop10=loadall_sanpham_top10();

    
    if(isset($_GET['act'])&&($_GET['act']!="")){
        $act = $_GET['act'];
        switch($act){
            case 'sanpham':
            if(isset($_POST['kyw'])&&($_POST['kyw'])!=""){
                $kyw=$_POST['kyw'];
            }else{
                $kyw="";
            }
            if(isset($_GET['iddm'])&&($_GET['iddm'])>0){
                $iddm=$_GET['iddm'];
            }else{
                $iddm=0;
            }
            $dssp=loadall_sanpham($kyw,$iddm);
            $tendm=load_ten_dm($iddm);
            include "view/sanpham.php";
            break;
            // if(isset($_POST['listok']) && ($_POST['listok'])){
            //     $kyw=$_POST['kyw'];
            //     $iddm=$_POST['iddm'];

            // }
            // else{
            //     $kyw='';
            //     $iddm=0;
            // }
            // $listdanhmuc=loadall_danhmuc();
            // $listsanpham= loadall_sanpham($kyw,$iddm);
            // include "view/chitiep.php";
            // break;
            case 'chitietsp':
                if(isset($_GET['idsp'])&&($_GET['idsp'])>0){
                    $id=$_GET['idsp'];
                    $onesp=loadone_sanpham($id);
                    extract($onesp);
                    $sp_cung_loai=load_sanpham_cungloai($id,$iddm);
                    $tendm=load_ten_dm($iddm);
                    include "view/chitietsp.php";
                }else{
                    include "view/home.php";
                }
                
                break;
            case 'dangky':
                if(isset($_POST['dangky'])&&($_POST['dangky'])){
                    $email=$_POST['email'];
                    $user=$_POST['user'];
                    $pass=$_POST['pass'];
                    $name=$_POST['name'];
                    $address=$_POST['address'];
                    $tel=$_POST['tel'];
                    insert_taikhoan($email,$user,$pass,$name,$address,$tel);
                    $thongbao = "Đã Đăng Kí Thành Công!. Vui Lòng Đăng Nhập.";
                }
                include "view/taikhoan/dangky.php";
                break;
            case 'edit_taikhoan':
                if(isset($_POST['capnhat'])&&($_POST['capnhat'])){
                    $user=$_POST['user'];
                    $pass=$_POST['pass'];
                    $name=$_POST['name'];
                    $email=$_POST['email'];
                    $address=$_POST['address'];
                    $tel=$_POST['tel'];
                    $idnd=$_POST['idnd'];
    
                    update_taikhoan($idnd,$user,$pass,$name,$email,$address,$tel);
                    $_SESSION['user']=checkuser($user,$pass);
                    header('Location: index.php?act=edit_taikhoan');
                }
                include "view/taikhoan/edit_taikhoan.php";
                break;
            case 'dangnhap': 
                
                if(isset($_POST['dangnhap'])&&($_POST['dangnhap'])){
                    $user=$_POST['user'];
                    $pass=$_POST['pass'];
                    $checkuser=checkuser($user, $pass);
                    if(is_array($checkuser)){
                        $_SESSION['user']=$checkuser;
                        // $thongbao="Bạn Đã Đăng Nhập Thành Công!";
                        header('Location: index.php');
                    
                    }else{
                        $thongbao="Tài Khoản Không Tồn Tại!. Vui Lòng Kiểm Tra Lại";
                    }
                    
                }
                include "view/taikhoan/dangnhap.php";
                break;
            
            case 'quenmk':
                if(isset($_POST['guiemail'])&&($_POST['guiemail'])){
                    $email=$_POST['email'];
                    $checkemail=checkemail($email);
                    if(is_array($checkemail)){
                        $thongbao="Mật Khẩu Của bạn Là : ".$checkemail['pass'];
                    }else{
                        $thongbao="Email Không tồn Tại!";
                    }
                }
                include "view/taikhoan/quenmk.php";
                break;
            
            case 'cart':
                include "view/cart.php";
                break;
            case "listCart":
                if (!empty($_SESSION['cart'])) {
                    $cart = $_SESSION['cart'];
                    $productId = array_column($cart, 'id');
                    $idList = implode(',', $productId);
                    $dataDb = loadone_sanphamCart($idList);
                }
               
                include "view/listCartOrder.php";
                break;
            
            case "order":
                
                if (isset($_SESSION['cart'])) {
                    $cart = $_SESSION['cart'];
                    if (isset($_POST['order_confirm'])) {
                        $txthoten = $_POST['txthoten'];
                        $txttel = $_POST['txttel'];
                        $txtemail = $_POST['txtemail'];
                        $txtaddress = $_POST['txtaddress'];
                        $pttt = $_POST['pttt'];
                        
                        if (isset($_SESSION['user'])) {
                            $id_user = $_SESSION['user']['id'];
                        } else {
                            $id_user = 0;
                        }
                        $idBill = addOrder($id_user, $txthoten, $txttel, $txtemail, $txtaddress, $_SESSION['resultTotal'], $pttt);
                        foreach ($cart as $item) {
                            addOrderDetail($idBill, $item['id'], $item['price'], $item['quantity'], $item['price'] * $item['quantity']);
                        }
                        unset($_SESSION['cart']);
                        $_SESSION['success'] = $idBill;
                        header("Location: index.php?act=success");
                    }
                    include "view/order.php";
                } else {
                    header("Location: index.php?act=listCart");
                }
                break;  
                
                    
            case "success":
                if (isset($_SESSION['success'])) {
                    include 'view/success.php';
                } else {
                    header("Location: index.php");
                }
                break;
            case 'billconfirm':
                
                include "view/billconfirm.php";
                break;
            case 'bill':
                
                include "view/bill.php";
                break;
            case 'checkout':
                $listbillcart=loadall_billcart();
                include "view/checkout.php";
                break;
            case 'thoat':
                session_unset();
                header('Location: index.php');
                break;
            case "about":
                include "view/about.php";
                break;
            case "about":
                include "view/about.php";
                break;
            case "blog":
                include "view/blog.php";
                break;
            case "contact":
                include "view/contact.php";
                break;
            default:
                include "view/home.php";
        }
    }else{
        include "view/home.php";
    }
    include "view/footer.php";
?>