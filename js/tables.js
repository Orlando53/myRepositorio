/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Paginación tablas
 */
$(document).ready(function() {
    var table = $('#tabla').DataTable({
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true,
        "order": [
            // [0, 'desc'],
            [1, 'asc']
        ]
    });
    $('#search').keyup(function() {
        table.search(this.value).draw();
    });
});