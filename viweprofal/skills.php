<div class="row" style='    margin: 0;'>

    <div class="col-md-6 col-sm-12 skillsshow" >
        <div class="container">
           
            <?php if ($nuskills > 0) {
            
            ?>
                <table class="table table-dark">
                    <thead>
                        <tr class="tb">
                        <th colspan="3" style="text-align: center; font-size: 22px;">المهارات</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $co = 1;
                        foreach ($skills as $sk) {
                            echo '<tr>
                            <th>' . $co . '</th>
                            <td>' . $sk["skill"] . '</td>
                            <td>' . $sk["experience"] . '</td>
                        </tr>
                        ';
                            $co++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {

                echo '<div class="text-center"><h1> لا يوجد ملفات</h1></div>';
            } ?>
        </div>
    </div>

    <div class="col-md-6 col-sm-12  " >
        <div class="container">

            <?php if ($numpdfs > 0) {
            ?>
                <table class="table table-dark" style="background-color: blueviolet;">
                    <thead>
                        <tr class="tb">
                            <th colspan="3" style="text-align: center; font-size: 22px;">المستنـدات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $co = 1;
                        foreach ($pdfs as $pdf) {
                            echo '<tr>
                            <th>' . $co . '</th>
                            <td><img src="uploads/files/pdf.png" class="img-thumbnail" width="100" height="100" /></td>
                            <td><a  href="uploads/files/' . $pdf["name_file"] . '" class="btn btn-success btn-xs ">عرض الملف</a></td>
                        </tr>
                        ';
                            $co++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {

                echo '<div class="text-center"><h1> لا يوجد ملفات</h1></div>';
            } ?>

        </div>
    </div>
</div>

