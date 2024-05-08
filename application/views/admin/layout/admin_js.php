
<script type="text/javascript">


  /*-- Jquery Change Assess  --*/
  $('.custom-file-input').on('change', function(){
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);

  });

  var baseUrl = "<?= base_url();?>";

  /*-- Toastr  --*/
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  <?php if ($this->session->flashdata('success')) {?>
    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
  <?php } else if ($this->session->flashdata('error')) {?>
    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
  <?php } else if ($this->session->flashdata('warning')) {?>
    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
  <?php } else if ($this->session->flashdata('info')) {?>
    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
  <?php }?>


     //Date range picker
     $('#reservation').daterangepicker({
      singleDatePicker : true,
      showDropdowns : true,
      timePicker : true,
      timePicker24Hour: true,
      timePickerSeconds: true,
      // startDate: "2020-01-01 12:00:00",
      startDate : moment().startOf('hour:minute:second'),
      locale: {
        format: 'YYYY-MM-DD HH:mm:ss'
      }
    });

     $('#akhir').daterangepicker({
      singleDatePicker : true,
      showDropdowns : true,
      timePicker : true,
      timePicker24Hour: true,
      timePickerSeconds: true,
      startDate : moment().startOf('hour:minute:second'),
      locale: {
        format: 'YYYY-MM-DD HH:mm:ss'
      }
    });


$(function () {

  'use strict'

  /*-- Make the dashboard widgets sortable Using jquery UI --*/
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.card-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });

  $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  /*-- Select 2 --*/
  $('.select2').select2();

  /*-- Timeout Alert Error form_validation 5sec --*/
  var timeout = 5000; 
  $('.alert').delay(timeout).fadeOut(500);

  /*-- Plugin for edit data mahasiswa --*/
  $('[data-mask]').inputmask();

  /*-- DatePicker Plugin to avoid Confict Wit JQuery --*/
  var datepicker = $.fn.datepicker.noConflict();
  $.fn.bootstrapDP = datepicker;    
  $('#tglLhr .input-group.date').datepicker({


  });

});

function deletesoalUser_jawaban(id_jawaban){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/soaluser_delete')?>",
      method:"post",
      data:{id_jawaban:id_jawaban},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};

function deleteKlaster(id){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/klaster_delete')?>",
      method:"post",
      data:{id:id},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};

function deletejawaban(id){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/jawaban_delete')?>",
      method:"post",
      data:{id:id},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};


function deleteUser(id){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/user_delete')?>",
      method:"post",
      data:{id:id},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};



function deletesubklaster(id){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/subklaster_delete')?>",
      method:"post",
      data:{id:id},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};

function deletesoal(id){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/soal_delete')?>",
      method:"post",
      data:{id:id},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};


function deletechecklist(id){
  swal({
    title: "Apakah Anda Yakin Ingin Menghapus?",
    text: "Anda tidak akan dapat memulihkan data ini!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false

  },

  function(){
    $.ajax({
      url : "<?= base_url('admin/checklist_delete')?>",
      method:"post",
      data:{id:id},
      dataType: 'json',
      success:function(data){

        swal({
          title: "Deleted!",
          text: "Data Berhasil Di Hapus.",
          type: "success",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      },

      error:function(data){
        swal({
          title: "Canceled!",
          text: "Data Tidak Dapat Di Hapus.",
          type: "error",
          showConfirmButton: false,
          timer: 1500
        });
        setInterval('location.reload()', 2000);        

      }

    });
  });
};


var klasterData = $('#klasterData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/klasterData',
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachListKlaster').keyup(function(){
  klasterData.search($(this).val()).draw() ;
});

$id_user_jawaban=$('[name="id_user_jawaban"]').val();
var klasterDataUser_jawaban = $('#klasterDataUser_jawaban').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/klasterDataUser_jawaban/'+ $id_user_jawaban,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachListKlaster_jawaban').keyup(function(){
  klasterDataUser_jawaban.search($(this).val()).draw() ;
});

$id_klaster_jawaban=$('[name="id_klaster_jawaban"]').val();
$id_user_subklaster_jawaban=$('[name="id_user_subklaster_jawaban"]').val();
var subklasterDataUser_jawaban = $('#subklasterDataUser_jawaban').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/subklasterDataUser_jawaban/'+ $id_klaster_jawaban + '/' + $id_user_subklaster_jawaban,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachsubklasterUser_jawaban').keyup(function(){
  subklasterDataUser_jawaban.search($(this).val()).draw() ;
});

$id_subklasteruser_jawaban=$('[name="id_subklasteruser_jawaban"]').val();
$id_usersoal_jawaban=$('[name="id_usersoal_jawaban"]').val();
var soalDataUser_jawaban = $('#soalDataUser_jawaban').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "autoWidth": true,
  "ajax": {
    "url": baseUrl + 'ajax/soalDataUser_jawaban/'+ $id_subklasteruser_jawaban + '/' + $id_usersoal_jawaban ,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachsoaluser_jawaban').keyup(function(){
  soalDataUser_jawaban.search($(this).val()).draw() ;
});

$id_user=$('[name="id_user"]').val();
var SklasterData = $('#SklasterData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/SklasterData/'+ $id_user,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachListSklaster').keyup(function(){
  SklasterData.search($(this).val()).draw() ;
});

var userData = $('#userData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/userData',
    "type": "POST"
  },  
  "responsive": true,
  "columns": [
    {"className": "f1-column"},
    {"className": "f2-column"},
    {"className": "f3-column"},
    {}
  ]
});

$('#seachuser').keyup(function(){
  userData.search($(this).val()).draw() ;
});


$id=$('[name="id"]').val();
var subklasterData = $('#subklasterData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/subklasterData/'+ $id,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachsubklaster').keyup(function(){
  subklasterData.search($(this).val()).draw() ;
});

$id_subklaster=$('[name="id_subklaster"]').val();
$id_user=$('[name="id_user"]').val();
var SsubklasterData = $('#SsubklasterData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "ajax": {
    "url": baseUrl + 'ajax/SsubklasterData/'+ $id_subklaster+'/'+ $id_user,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#searchSsubklaster').keyup(function(){
  SsubklasterData.search($(this).val()).draw() ;
});

$id=$('[name="id_subklaster"]').val();
var soalData = $('#soalData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "autoWidth": true,
  "ajax": {
    "url": baseUrl + 'ajax/soalData/'+ $id,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#seachsoal').keyup(function(){
  soalData.search($(this).val()).draw() ;
});

$id=$('[name="id_soal"]').val();
var checklistData = $('#checklistData').DataTable({
  "sDom": 'lrtip',
  "lengthChange": false,
  "processing": true, 
  "serverSide": true, 
  "order": [],
  "autoWidth": true,
  "ajax": {
    "url": baseUrl + 'ajax/checklistData/'+ $id,
    "type": "POST"
  },
  "headerCallback": function(thead, data, start, end, display) {
     $(thead).find('th:eq(0), th:eq(1)').hide();
  },
  "responsive": true,
  "columns": [
    {"className": "first-column"},
    {}
  ]
});

$('#searchchecklist').keyup(function(){
  checklistData.search($(this).val()).draw() ;
});

</script>