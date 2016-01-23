

//DataTables Initialization
$(document).ready(function() {


    $('#extrato').dataTable({

        "sDom":  '<"row"<"col-sm-12"it<"row"<"col-sm-6"<"dataTables_info"l>><"col-sm-6"p>>',
        oLanguage: {
            sLengthMenu: "_MENU_ registros por página",
            sSearch: "Pesquisar",
            sInfo: "Exibindo registros de _START_ a _END_ de _TOTAL_",
            sInfoEmpty: "Exibindo registros de 0 a 0 de 0",
            sZeroRecords: "Nenhum registro encontrado",
            sInfoFiltered: "(filtrado de _MAX_ registros)",
            oPaginate: {
                sPrevious: "Anterior",
                sNext: "Próximo"
            }
        }
    });
});

$('.form_datetime').datepicker({
    language:  'pt-BR',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
});
$('.form_date').datepicker({
    language:  'pt-BR',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
});
$('.form_time').datepicker({
    language:  'pt-BR',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
});

$(function () {
    $('#datepicker8').datepicker({
        language: 'pt-BR',
        autoclose: true
    });
    $('#datepicker9').datepicker({
        language: 'pt-BR',
        autoclose: true
    });
    $("#datepicker8").on("dp.change",function (e) {
        $('#datepicker9').data("DatePicker").setMinDate(e.date);
    });
    $("#datepicker9").on("dp.change",function (e) {
        $('#datepicker8').data("DatePicker").setMaxDate(e.date);
    });
});



