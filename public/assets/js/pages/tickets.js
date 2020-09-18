var tableTickets
var tableMyTickets

function populateCardsDash(data = null) {
    let dataLoader = {
        totalTickets: 0,
        totalTicketsMonth: 0,
        myTickets: 0,
        myOpenTickets: 0
    }

    if (data)
        dataLoader = data

    $("#totalTickets").text(dataLoader.totalTickets);
    $("#totalTicketsMonth").text(dataLoader.totalTicketsMonth);
    $("#myTickets").text(dataLoader.myTickets);
    $("#openTickets").text(dataLoader.myOpenTickets);
}

function loadCardTickets(monthYear) {
    $.ajax({
        url: `${BASE_URL}/tickets/getcardticket`,
        method: "GET",
        data: {
            monthYear: monthYear,
        },
        dataType: 'JSON',
        success: (data) => {
            populateCardsDash(data)
        },
        beforeSend: (b) => {
            populateCardsDash()
            $("#searchTicket").attr('disabled', true).find("i").removeClass("fa-search").addClass("fa-spinner fa-spin")
        },
        complete: (c) => {
            $('#searchTicket').removeAttr('disabled').find('i').removeClass('fa-spinner fa-spin').addClass('fa-search')
        },
        error: (e) => {
            $('#searchTicket').removeAttr('disabled').find('i').removeClass('fa-spinner fa-spin').addClass('fa-search')
        }
    });
}

function loadChartTickets(monthYear) {
    $.ajax({
        url:  `${BASE_URL}/tickets/getcharttickets`,
        method: "GET",
        data: {
            monthYear: monthYear
        },
        dataType: 'JSON',
        success: (data) => {
            geraChartLine(data.categories, data.data, `Total Tickets Opened per Day`);
        },
        beforeSend: (b) => {},
        complete: (c) => {},
        error: (e) => {
            console.log(e)
        }
    });
}

function loadTableTickets(tableId) {
    
    let url   = `${BASE_URL}/tickets/getmytickets`
    var table = tableMyTickets

    if (tableId == 'tableTickets') {
        url = `${BASE_URL}/tickets/gettickets`
        table = tableTickets
    }
        
    table = $(`#${tableId}`).DataTable({
        sPaginationType: "full_numbers",
        destroy: true,
        searching: true,
        responsive: false,
        language: translateTable(),
        order: [[0, "DESC"]],
        ajax: {
            url: url,
            dataSrc: (data) => {
                return data || []
            },
            dataType: 'JSON',
            cache: true,
            error: (e) => {
                $("#btnSync").removeAttr("disabled").find("i").removeClass("fa-spinner fa-spin").addClass("fa-sync")
            },
            beforeSend: () => {
                $("#btnSync").attr("disabled", true).find("i").removeClass("fa-sync").addClass("fa-spinner fa-spin")
            },
            complete: () => {
                $("#btnSync").removeAttr("disabled").find("i").removeClass("fa-spinner fa-spin").addClass("fa-sync")
            }
        },
        lengthChange: false,
        pageLength: 50,
        columns: [
            {
                data: "id",
            },
            {
                data: "created_date"
            },
            {
                data: "client_name"
            },
            {
                data: "description"
            },
            {
                data: "status",
                class: "text-center",
            },
            {
                data: "priority",
                class: "text-center"
            },
            {
                data: "module_name"
            },
            {
                data: "caller_name",
                class: "text-right",
                render: (data, type, row, meta) => {
                    return (data)
                }
            }
        ],
        dom: "Bfrtip",
        createdRow: function (row, data) {

            $('td', row).eq(5).css('background', '#f64f5c').css('color', '#fff')

            if (data.priority < 3)
                $('td', row).eq(5).css('background', '#79a7d0').css('color', '#fff')

            switch (parseInt(data.andamento)) {
                case 0: $('td', row).eq(4).css('background', '#dc8512').css('color', '#fff'); break
                case 1: $('td', row).eq(4).css('background', '#64738F').css('color', '#fff'); break
                case 2: $('td', row).eq(4).css('background', '#514cf7').css('color', '#fff'); break
                case 3: $('td', row).eq(4).css('background', '#f6c763').css('color', '#fff'); break
                case 4: $('td', row).eq(4).css('background', '#2ecc71').css('color', '#fff'); break
            }
        },
        columnDefs: [
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return data.substring(0, 60)
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    switch (parseInt(data)) {
                        case 0: return "Aguardando Atribuição"
                        case 1: return "Atribuído"
                        case 2: return "Em Execução"
                        case 3: return "Parado"
                        case 4: return "Encerrado"
                    }
                }
            },
            {
                targets: 6,
                render: function (data, type, row, meta) {
                    return data.substring(0, 15)
                }
            }
        ]
    });

    $(`#${tableId} .filtros th`).each(function () {
        $(this).html('<input type="text" style="width: 100% !important;height: 24px !important; margin-bottom: 4px !important; border-radius: 3px !important" class="form-control hidden-xs" placeholder=""/>');
    });

    table.columns().eq(0).each(function (indice) {
        $('input', $('.filtros th')[indice]).on('keyup change', function () {
            table.column(indice).search(this.value).draw();
        });
    });

    $('.dataTables_filter').css('display', 'none');

    $(`#${tableId} tbody`).on('click', 'td', function() {

        let tr  = $(this).closest('tr');
        let row = dtTable.row(tr);
    });
}