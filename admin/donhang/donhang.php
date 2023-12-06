<div class="row">
    <div class="row frmtitle">
        <h1>DANH SÁCH ĐƠN HÀNG</h1>
    </div>
    <div class="row frmcontent">
        <div class="row mb10 frmdsloai">
            <table>
                <tr>
                    <th>ID ORDER</th>
                    <th>ID USER</th>
                    <th>HO TEN</th>
                    <th>name</th>
                    <th>SỐ ĐIỆN THOẠI</th>
                    <th>EMAIL</th>
                    <th>ĐỊA CHỈ</th>
                    <th>TỔNG TIỀN</th>
                    
                    <th>PTTT</th>
                    <th>Trạng thái</th>
                </tr>
                <?php
                    $stt=0;
                    foreach($listtaikhoan as $taikhoan){
                        $stt++;
                        extract($taikhoan);
                      
                        echo '<tr>  
                        <td>'.$id_order.'</td>
                        <td>'.$id_user.'</td>
                        <td>'.$hoten.'</td>
                        <td>'.$name.'</td>
                        <td>'.$sdt.'</td>
                        <td>'.$email.'</td>
                        <td>'.$diachi.'</td>
                        <td>'.$tongtien.'</td>d
                
                        <td>'.$pttt.'</td>
                        <td>'.$trangthai.'
                            <select name="trangthai">
                            <option value="option1">Đang chờ duyệt</option>
                            <option value="option2">Đã xác nhận</option>
                            <option value="option3">Đang vận chuyển</option>
                            <option value="option4">Hoàn thành</option>
                    </select>
                        </td>
                    </tr>';
                
                    }
                ?>
            </table>
        </div>
    </div>
</div>