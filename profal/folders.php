<?php
$st = $con->prepare("SELECT * FROM profal WHERE user_id = ?");
$st->execute(array($_SESSION['uid']));
$item = $st->fetch();
?>
<div class=" text-end ">

    <div class="row folderscss ">
        <div class="col-sm-6 col-lg-6 a1">

            <div class="pdf_css">
                <div id="pdf_get" ></div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-2 fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    اظافه ملف
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">مستندات</h5>
                                <button style="margin-left: 0;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form id="uploadForm" method="post" enctype="multipart/form-data">
                                    <div class="col-md-4">
                                        <input name="pdf[]" type="file" multiple />
                                    </div>
                                    <div class="col-md-4">
                                        <input name="title" type="hidden" />
                                    </div>
                                    <!-- -------------------------------------------------------- -->
                                   
                               

                            </div>
                            <div class="modal-footer"> 
                                                                       <input type="submit" value="حفظ" class="btn btn-info" />

                            </div> 
                        </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6  col-lg-6 a2">
            <div>
                <div class="table-responsive" id="image_profal">
                </div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary fs-5 mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                    اضافه صور
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">اضافه صور</h5>
                                <button style="margin-left: 0;"  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">


                                <!-- <form method="post" id="upload_multiple_images" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" name="image[]" id="image" multiple accept=".jpg, .png, .pdf ">
                        </div>
                        <br />
                        <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
                    </form> -->

                                <input type="file" name="multiple_files" id="multiple_files" multiple />


                            </div>
                            <div class="modal-footer" >
                                                               <input type="submit" id="uuuuu" class="btn btn-info" value="حفظ">

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>