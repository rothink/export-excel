<?php
$data = [
        0 => [
                'name' => 'Rodrigo',
            'status' => 'Ativo'
        ],
        1 => [
                'name' => 'Joana',
            'status' => 'Ativo'
        ],
        2 => [
                'name' => 'Marguin',
            'status' => 'Inativo'
        ]
];
?>
<html>
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<div>
    <a href="javascript:void(0)" id="export-to-excel">Export to excel</a>
</div>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="export-form">
    <input type="hidden" value='' id='hidden-type' name='ExportType'/>
</form>
<table id="" class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Status</th>
    </tr>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['status'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script  type="text/javascript">
    $(document).ready(function() {
        jQuery('#export-to-excel').bind("click", function() {
            var target = $(this).attr('id');
            switch(target) {
                case 'export-to-excel' :
                    $('#hidden-type').val(target);
                    //alert($('#hidden-type').val());
                    $('#export-form').submit();
                    $('#hidden-type').val('');
                    break
            }
        });
    });
</script>
</html>

<?php
if(isset($_POST["ExportType"]))
{
    switch($_POST["ExportType"])
    {
        case "export-to-excel" :
            // Submission from
            $filename = $_POST["ExportType"] . ".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            ExportFile($data);
            //$_POST["ExportType"] = '';
            exit();
        default :
            die("Unknown action : ".$_POST["action"]);
            break;
    }
}
function ExportFile($records) {
    $heading = false;
    if(!empty($records))
        foreach($records as $row) {
            if(!$heading) {
                // display field/column names as a first row
                echo implode("\t", array_keys($row)) . "\n";
                $heading = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    exit;
}


?>


