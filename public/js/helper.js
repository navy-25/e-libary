// function dataTableAjax(class_table, url, params, columns,order = [[]]) {
//     datatable_table = $(class_table);
//     if (datatable_table.length) {
//         datatable = datatable_table.DataTable({
//             searchDelay: 300,
//             processing: true,
//             serverSide: true,
//             destroy: true,
//             order: order,
//             ajax: {
//                 url:url,
//                 data:params
//             },
//             columns: columns,
//             pageLength: 10,
//             lengthMenu: [[5,10, 50, 100, -1], [5, 10, 50, 100, "Semua"]],
//             responsive: true,
//             dom: '<"d-flex justify-content-between align-items-center mx-0 row mb-3 px-0"<"col-12 col-sm-6 col-md-6 px-0"l><"col-12 col-sm-6 col-md-6 px-0"f>>t<"d-flex justify-content-between mx-0 row px-0"<"col-sm-12 col-md-6 px-0"i><"col-sm-12 col-md-6 px-0"p>>',
//             // language: {
//             //     url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json'
//             // },
//         });
//     }
// }
