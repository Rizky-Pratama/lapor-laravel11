// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable').DataTable({
        columnDefs: [{orderable: false, searchable: false, targets: 'notext'}]
    });
});
