<?php 
function UploadTransfer($fupload_name){
   //direktori untuk foto galeri
  $vdir_upload = "foto/bukti-transfer/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}
?>