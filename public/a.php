<div class="row col-12">
                    <div class="m-2 p-2">
                        <div class="container row">
                            <h2>Đồ Uống của bạn</h2>
                            <div class="container row">

                                <?php
                                if (isset($_SESSION['id_user'])) {
                                    if ($douong_users != null) {

                                        foreach ($douong_users as $douong_user) :
                                            $id_douong_user = $douong_user->getId(); ?>
                                            <div class="col-4 p-3">
                                                <?php
                                                $tong = 0;
                                                // $chitiet->getId();
                                                $chitiet1 = $chitietdouong->finddouong($id_douong_user);
                                                $chitiets = $chitietdouong->showdouong($id_douong_user);
                                                // $chitiet2 = $chitiet->showmenu($id);
                                                foreach ($chitiets as $chitiet1) : {
                                                        // code...



                                                ?>
                                                        <?php
                                                        $iddouong =  $douong->find($chitiet1->id_douong); ?>

                                                        <img style="width: 20px;  height: 20px;" src="../img/upload/<?php echo $douong->image; ?>">
                                                        <?php
                                                        echo 'Món:' . $douong->tendouong;
                                                        echo ' : ' . number_format($douong->giadouong) . ' vnđ <br>';
                                                        $gia = $iddouong->giadouong;
                                                        $tong = $tong + $gia;
                                                        ?>
                                                <?php }
                                                endforeach ?>
                                                <p>Tổng Gói: <i class="text-danger"><?php echo $tong; ?></i> vnd</p>
                                                <input type="hidden" name="gia_menu" value="<?php echo $tong ?>">
                                                <a class="btn btn-primary" href="datTiec.php?id_menu=<?php echo $douong_user->getId(); ?>&id_dv=<?php echo $id_dv ?>">Chọn Gói Đồ Uống</a>


                                            </div>
                                        <?php endforeach; ?>
                            </div>
                            <div class="row">
                                <div class="text-uppercase  font-weight-bold"><?php
                                                                                $dv = $douong_user->id_dv;
                                                                                $tendv = $dichvu->find($dv);
                                                                                echo $tendv->ten_dv;

                                                                                ?>
                                </div>


                            </div>


                        <?php } else { ?>
                            <div class="row">
                                <div class="col-12 text-center">
                                    Bạn chưa tạo menu nào trong dịch vụ này!!!
                                </div>

                            </div>

                    <?php }
                                } ?>


                        </div>
                        <form action="addDoUong_User.php" method="post">
                            <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                            <input type="hidden" name="id_user" value="<?php
                                                                        if (isset($_SESSION['id_user'])) {
                                                                            echo $_SESSION['id_user'];
                                                                        }

                                                                        ?>">
                            <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>">




                            <button class="btn btn-primary" type="submit">Thêm Gói Đồ Uống</button>
                        </form>

                    </div>
                </div>
