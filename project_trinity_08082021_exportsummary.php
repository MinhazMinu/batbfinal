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
        $treport = $_POST['treport'];

        if ($treport === "Dashboard") {
            $query = "select (SELECT count(distinct `BRCode`) FROM `project_trinity_08082021` where `ContactDate`='$startdate') as 'UniqueBRCount',(select count(a.BRCode) from (SELECT `BRCode`, count(`BRCode`) as B FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by `BRCode`) as A where a.b<20) as 'IncompleteBRcount', (select sum(final.co) from (select a.brcode, Count(A.BRcode) as co from (SELECT ConsumerNumber, BRcode, LENGTH(`ConsumerNumber`) AS L,left(ConsumerNumber,3) as Lef, `firstRemarks`,`SecondRemarks`,`ThirdRemarks` FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by ConsumerNumber) as A where (A.firstRemarks ='Invalid Number' AND A.SecondRemarks ='Invalid Number' AND A.ThirdRemarks ='Invalid Number') or A.L<>10 AND (A.lef<>11 or A.lef<>15 or A.lef<>16 or A.lef<>17 or A.lef<>18 or A.lef<>19) group by a.brcode) as final) as 'InvalidNumber', (select count(final.co) from (select a.brcode, Count(A.BRcode) as co from (SELECT ConsumerNumber, BRcode, LENGTH(`ConsumerNumber`) AS L,left(ConsumerNumber,3) as Lef, `firstRemarks`,`SecondRemarks`,`ThirdRemarks` FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by ConsumerNumber) as A where (A.firstRemarks ='Invalid Number' AND A.SecondRemarks ='Invalid Number' AND A.ThirdRemarks ='Invalid Number') or A.L<>10 AND (A.lef<>11 or A.lef<>15 or A.lef<>16 or A.lef<>17 or A.lef<>18 or A.lef<>19) group by a.brcode) as final) as 'InvalidBR', (select sum(Duptable.ee) from (select d.brcode, count(d.consumernumber) as ee from (select a.*,b.c from (SELECT * FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by `ConsumerNumber`) as a inner join (SELECT *, count(ConsumerNumber) as c FROM `project_trinity_08082021` WHERE `ContactDate`<='$startdate' group by `ConsumerNumber`) as b on a.ConsumerNumber=b.ConsumerNumber where b.c>1) as d  group by d.brcode) as Duptable) as Duplicate, (select count(Duptable.ee) from (select d.brcode, count(d.consumernumber) as ee from (select a.*,b.c from (SELECT * FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by `ConsumerNumber`) as a inner join (SELECT *, count(ConsumerNumber) as c FROM `project_trinity_08082021` WHERE `ContactDate`<='$startdate' group by `ConsumerNumber`) as b on a.ConsumerNumber=b.ConsumerNumber where b.c>1) as d  group by d.brcode) as Duptable) as 'Duplicate BR Count'";
        } elseif ($treport === "BRreport") {
            $query = "select tbl_br_dup.*,tbl_invalid.Invalid_Count from (select br_table.BRCode, 20 as 'Target',br_table.Shared_Contact,duplicate_table.Duplicate_Count,br_table.Sample,br_table.Fake from (SELECT `BRCode`, count(BRCode) as 'Shared_Contact', count(CASE WHEN Callstatus<>'' THEN 1 End) as Sample, count(CASE WHEN Callstatus<>'' AND ConductedbyBR='No' THEN 1 End) as Fake FROM `project_trinity_08082021` where `ContactDate`='$startdate' group by BRCode) As br_table left join (select d.brcode, count(d.consumernumber) as 'Duplicate_Count' from (select a.*,b.c from (SELECT * FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by `ConsumerNumber`) as a inner join (SELECT *, count(ConsumerNumber) as c FROM `project_trinity_08082021` WHERE `ContactDate`<='$startdate' group by `ConsumerNumber`) as b on a.ConsumerNumber=b.ConsumerNumber where b.c>1) as d  group by d.brcode) as duplicate_table on br_table.BRCode=duplicate_table.BRCode) as tbl_br_dup left join (select a.brcode, Count(A.BRcode) as 'Invalid_Count' from (SELECT ConsumerNumber, BRcode, LENGTH(`ConsumerNumber`) AS L,left(ConsumerNumber,3) as Lef, `firstRemarks`,`SecondRemarks`,`ThirdRemarks` FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by ConsumerNumber) as A where (A.firstRemarks ='Invalid Number' AND A.SecondRemarks ='Invalid Number' AND A.ThirdRemarks ='Invalid Number') or A.L<>10 AND (A.lef<>11 or A.lef<>15 or A.lef<>16 or A.lef<>17 or A.lef<>18 or A.lef<>19) group by a.brcode) as tbl_invalid on tbl_br_dup.BRCode=tbl_invalid.brcode";
        } elseif ($treport === "RawInvalid") {
            $query = "select project_trinity_08082021.* from project_trinity_08082021 inner join (select a.ConsumerNumber from (SELECT ConsumerNumber, BRcode, LENGTH(`ConsumerNumber`) AS L,left(ConsumerNumber,3) as Lef, `firstRemarks`,`SecondRemarks`,`ThirdRemarks` FROM `project_trinity_08082021` WHERE ContactDate='$startdate' group by ConsumerNumber) as A where (A.firstRemarks ='Invalid Number' AND A.SecondRemarks ='Invalid Number' AND A.ThirdRemarks ='Invalid Number') or A.L<>10 AND (A.lef<>11 or A.lef<>15 or A.lef<>16 or A.lef<>17 or A.lef<>18 or A.lef<>19)) as table2 on project_trinity_08082021.ConsumerNumber= table2.ConsumerNumber AND project_trinity_08082021.ContactDate='$startdate'";
        } elseif ($treport === "RawDuplicate") {
            $query = "select mastertable.* from (select * from project_trinity_08082021 WHERE `ContactDate`='$startdate') as mastertable inner join (select a.ConsumerNumber from (SELECT * FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' group by `ConsumerNumber`) as a inner join (SELECT *, count(ConsumerNumber) as c FROM `project_trinity_08082021` WHERE `ContactDate`<='$startdate' group by `ConsumerNumber`) as b on a.ConsumerNumber=b.ConsumerNumber where b.c>1) as rawtable on mastertable.ConsumerNumber=rawtable.ConsumerNumber";
        } elseif ($treport === "RawFake") {
            $query = "SELECT * FROM `project_trinity_08082021` WHERE `ContactDate`='$startdate' AND `ConductedbyBR`='No'";
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
            header("location:project_trinity_08082021_reportsummary.php");

            exit;
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Star_Dashboard.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
        mysqli_close($con);

        ?>

   