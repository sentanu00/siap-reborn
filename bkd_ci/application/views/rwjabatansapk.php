<!DOCTYPE html>
<html>

<head>
    <title>
        DAFTAR RIWAYAT PENDIDIKAN SAPK
    </title>
</head>

<body>
    <?php
    // echo $rw."->".$nip_baru;
    // echo 'gajah';
    // echo $hupload;
    ?>


    <?php echo form_open_multipart('rwjabatansapk/cek') ?>
        <div class="mb-3">
            <label class="form-control input-sm">file</label>
            <input type="file" class="form-control" id="FILE_PDF" name="FILE_PDF">
        </div>
        <button type="submit" class="btn btn-primary">cek</button>
    <?php echo form_close() ?>

</body>

</html>