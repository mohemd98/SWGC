<div class="text-center rounded mx-auto d-block">
    <table class="table" style="width: 35%; margin-right: 33%; border: 0px solid white; text-align: right;">


        <tr>
            <th scope="col">ايميل</th>
            <th scope="col"><?php echo $user['email']; ?></th>
        </tr>
        <tr>
            <th scope="col">الجنس</th>
            <th scope="col"><?php echo $user['gender']; ?></th>
        </tr>
        <tr>
            <th scope="col">المحافظة</th>
            <th scope="col"><?php echo $user['city']; ?></th>
        </tr>
        <tr>
            <th scope="col">العمر</th>
            <th scope="col"><?php echo $user['age']; ?></th>
        </tr>
        <tr>
            <th scope="col">الجامعه</th>
            <th scope="col"><?php
                            if (isset($profal['colg'])) {
                                echo $profal['colg'];
                            } else {
                                echo 'لايوجد';
                            } ?></th>
        </tr>
        <tr>
            <th scope="col">القسم</th>
            <th scope="col"><?php
                            if (isset($profal['division'])) {
                                echo $profal['division'];
                            } else {
                                echo 'لايوجد';
                            } ?></th>
        </tr>
        <tr>
            <th scope="col">الهاتف</th>
            <th scope="col"><?php
                            if (isset($profal['fonnamber'])) {
                                echo $profal['fonnamber'];
                            } else {
                                echo 'لايوجد';
                            } ?></th>
        </tr>
        <tr>
            <th scope="col">تليغرام</th>
            <th scope="col"><?php
                            if (isset($profal['tergram_id'])) {
                                echo $profal['tergram_id'];
                            } else {
                                echo 'لايوجد';
                            }
                            ?></th>
        </tr>
        <tr>
            <th scope="col">فيس بوك</th>
            <th scope="col"><?php
                            if (isset($profal['facebokc_rul'])) {
                                echo $profal['facebokc_rul'];
                            } else {
                                echo 'لايوجد';
                            } ?></th>
        </tr>
    </table>
</div>
<!-- ------------------------------------------------------------- -->
<div>
    <!-- start gallery -->
    <?php if (isset($im['name_file'])) { ?>
        <div class="gallery">
            <div class="master-img">
                <i class="left skin-background"><a class="fa-solid fa-chevron-left fa-lg"></a></i>
                <i class="right skin-background"><a class="fa-solid fa-chevron-right fa-lg"></a></i>
                <img src="uploads/profal/<?php echo $im['name_file']; ?>" class="img-fluid rounded mx-auto d-block">
            </div>
            <div class="thumbnails">
                <img class="selected" src="uploads/profal/<?php echo $im['name_file']; ?>" alt="">
                <?php
                foreach ($imgs as $img) {
                    echo "<img src='uploads/profal/" . $img['name_file'] . "' >";
                }
                ?>
            </div>
        </div>
    <?php } else {
    ?>
        <div class="text-center">
            <h1>لا يوجد صور</h1>
        </div>
    <?php
    } ?>

    <!-- end gallery -->





</div>


</div>