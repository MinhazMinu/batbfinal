     <?php
        session_start();
        ini_set('memory_limit', '1024M');
        //database connection details
        $con = mysqli_connect('localhost', 'root', '', 'bat_ob');
        if (!$con) {
            echo mysqli_error();
        }
        //selecting records from the table

        $startdate = $_POST['datetimepicker1'];
        $enddate = $_POST['datetimepicker2'];
        $treport = $_POST['treport'];

        if ($treport === "client report") {
            $query = "SELECT * FROM `project_trinity_08082021` WHERE `SubmitDate`  between  '$startdate' and '$enddate'";
        } elseif ($treport === "cdr") {

            $query = "SELECT * FROM `project_trinity_08082021` WHERE `SubmitDate`  between  '$startdate' and '$enddate'";
        } elseif ($treport === "unique") {
            $query = "select a.*,b.c from (SELECT * FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by `ConsumerNumber`) as a inner join (SELECT *, count(ConsumerNumber) as c FROM `project_trinity_08082021` WHERE `ContactDate`<='$startdate' group by `ConsumerNumber`) as b on a.ConsumerNumber=b.ConsumerNumber where b.c<2";
        } elseif ($treport === "br_authentication") {
            $query = "SELECT ContactDate,BRCode,3 as 'Target',(sum(case when `firstStatus`<>'' then 1 else 0 end)+sum(case when `SecondStatus`<>'' then 1 else 0 end)+sum(case when `ThirdStatus`<>'' then 1 else 0 end)) as 'Dial',
            ((sum(case when `firstStatus`<>'' then 1 else 0 end)+sum(case when `SecondStatus`<>'' then 1 else 0 end)+sum(case when `ThirdStatus`<>'' then 1 else 0 end))-(sum(case when `firstStatus`='Call received' then 1 else 0 end)+sum(case when `SecondStatus`='Call received' then 1 else 0 end)+sum(case when `ThirdStatus`='Call received' then 1 else 0 end))) As 'Not Reached',

            (sum(case when `firstRemarks`='Mobile Off' then 1 else 0 end)+sum(case when `SecondRemarks`='Mobile Off' then 1 else 0 end)+sum(case when `ThirdRemarks`='Mobile Off' then 1 else 0 end)) as 'Mobile Off',
            (sum(case when `firstRemarks`='No Answer' then 1 else 0 end)+sum(case when `SecondRemarks`='No Answer' then 1 else 0 end)+sum(case when `ThirdRemarks`='No Answer' then 1 else 0 end)) as 'No Answer',
            (sum(case when `firstRemarks`='Invalid Number' AND `SecondRemarks`='Invalid Number' AND `ThirdRemarks`='Invalid Number'then 1 else 0 end)) as 'Invalid_Number',
            (sum(case when `firstStatus`='Call received' then 1 else 0 end)+sum(case when `SecondStatus`='Call received' then 1 else 0 end)+sum(case when `ThirdStatus`='Call received' then 1 else 0 end)) as 'Reached',

            (sum(case when `firstRemarks`='Success' then 1 else 0 end)+sum(case when `SecondRemarks`='Success' then 1 else 0 end)+sum(case when `ThirdRemarks`='Success' then 1 else 0 end)) as 'Success',
            (sum(case when `firstRemarks`='Call Received by Others' then 1 else 0 end)+sum(case when `SecondRemarks`='Call Received by Others' then 1 else 0 end)+sum(case when `ThirdRemarks`='Call Received by Others' then 1 else 0 end)) as 'Call Received by Others',
            (sum(case when `firstRemarks`='Call Later On' then 1 else 0 end)+sum(case when `SecondRemarks`='Call Later On' then 1 else 0 end)+sum(case when `ThirdRemarks`='Call Later On' then 1 else 0 end)) as 'Call Later On',
            (sum(case when `firstRemarks`='Not Interested' then 1 else 0 end)+sum(case when `SecondRemarks`='Not Interested' then 1 else 0 end)+sum(case when `ThirdRemarks`='Not Interested' then 1 else 0 end)) as 'Not Interested',
            sum(case when `Callremarks`='Success' AND `ConductedbyBR`='Yes' then 1 else 0 end) as 'BR Contact within Success Calls',
            sum(case when `Callremarks`='Success' AND `ConductedbyBR`='No' then 1 else 0 end) as 'BR_Not_Contact_within_Success_Calls',


            
            sum(case when `Callremarks`='Success' AND `full_flavoured_somke`='Yes' then 1 else 0 end) as 'full_flavoured_somke(Yes)',
            sum(case when `Callremarks`='Success' AND `full_flavoured_somke`='No' then 1 else 0 end) as 'full_flavoured_somke(No)',
            
            sum(case when `Callremarks`='Success' AND `blueberry_and_lemon_flavour`='Yes' then 1 else 0 end) as 'blueberry_and_lemon_flavour(Yes)',
            sum(case when `Callremarks`='Success' AND `blueberry_and_lemon_flavour`='No' then 1 else 0 end) as 'blueberry_and_lemon_flavour(No)',
            
            sum(case when `Callremarks`='Success' AND `express_thanks`='Yes' then 1 else 0 end) as 'express_thanks(Yes)',
            sum(case when `Callremarks`='Success' AND `express_thanks`='No' then 1 else 0 end) as 'express_thanks(No)'


            FROM `project_trinity_08082021` WHERE `Callstatus`<>'' AND ContactDate BETWEEN '$startdate' and '$enddate' group by BRCode,ContactDate ORDER BY ContactDate,BRCode";
        }

        $header = '';
        $data = '';

        $export = mysqli_query($con, $query) or die("Sql error : " . mysql_error());
        $fields = mysqli_num_fields($export);

        for ($i = 0; $i < $fields; $i++) {
            $header .= mysqli_fetch_field_direct($export, $i)->name . "\t";
        }

        while ($row = mysqli_fetch_row($export)) {
            $line = '';
            foreach ($row as $value) {
                if ((!isset($value)) || ($value == "")) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line) . "\n";
        }
        $data = str_replace("\r", "", $data);

        if ($data == "") {

            echo "<script type='text/javascript'>alert('No records found for selected date !!')</script>";
            mysqli_close($con);
            header("location:project_trinity_08082021_report.php");
            exit;
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=project_trinity_08082021_CDR.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
        mysqli_close($con);

        ?>