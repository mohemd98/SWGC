<?php
$st = $con->prepare("SELECT * FROM profal WHERE user_id = ?");
$st->execute(array($_SESSION['uid']));
$item = $st->fetch();
?>
<div class=" text-end">
    <div class="row " style='    margin: 0;'>
        <div class=" skill_css col-md-6 col-sm-12" >
            <div class=" table_css">

                <div id="table_data_skills"></div>

                <!-- ------------------------------------------------------------------------------------- -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-2 mt-2 me-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                    اضافه مهارات
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">اضافه مهاره</h5>
                                <button style="    margin-left: 0;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <form name="add_name" id="add_name">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dynamic_field">
                                                <tr>
                                                    <td><input type="text" name="skill[]" placeholder="اسم المهاره" class="form-control name_list" /></td>
                                                    <td> <select name="rang[]" id="cars">
                                                            <option value="قليل">قليل</option>
                                                            <option value="جيد">جيد</option>
                                                            <option value="جيد جدا">جيد جدا</option>
                                                            <option value="ممتاز">ممتاز</option>
                                                        </select></td>
                                                    <td><button type="button" name="add" id="add" class="btn btn-success">اضافه مزيد</button></td>
                                                </tr>
                                            </table>
                                        </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" name="submit" id="submit" class="btn btn-info" value="حفظ" />
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------------------- -->

        </div>

        <!-- *********************************************************************** -->

        <div class=" col-md-6 col-sm-12  col-lg-6 a4">
            <div class="form_all ">
                <form class="row" method="POST" id="edat_form" name="edat_form">
                    <div class="col-md-6 col-sm-12 ">
                        <label for="inputState" class="form-label">كليه او معهد</label>
                        <input type="text" class="form-control" name="n1" value="<?php echo $item['colg'] ?>">
                    </div>
                    <div class="col-md-6 col-sm-12 ">
                        <label for="inputEmail4" class="form-label">قسم</label>
                        <input type="text" class="form-control" name="n2" value="<?php echo $item['division'] ?>">
                    </div>
                    <div class="col-md-12 col-sm-12 ">
                        <label for="exampleFormControlTextarea1" class="form-label">نبذه</label>
                        <textarea class="form-control" name="n3" rows="3"><?php echo $item['boi'] ?></textarea>
                    </div>
                    <div class="col-md-4 col-sm-12 ">
                        <label for="inputZip" class="form-label">رقم الهاتف</label>
                        <input type="text" class="form-control" name="n4" value="<?php echo $item['fonnamber'] ?>">
                    </div>
                    <div class="col-md-4 col-sm-12 ">
                        <label for="inputZip" class="form-label">معرف التليغرام</label>
                        <input type="text" class="form-control" name="n5" value="<?php echo $item['tergram_id'] ?>">
                    </div>
                    <div class="col-md-4 col-sm-12 ">
                        <label for="inputZip" class="form-label"> رابط الفيس بوك</label>
                        <input type="url" class="form-control" name="n6" value="<?php echo $item['facebokc_rul'] ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-2 mb-2" id="edat_send_all">حفظ</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>