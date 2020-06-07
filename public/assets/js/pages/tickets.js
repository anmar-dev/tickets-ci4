var tableTickets;

function loadCardTickets(monthYear) {
    
    $.ajax({
        url: BASE_URL + '/Ticket/getCardTicket',
        type: "GET",
        data: {
            monthYear: monthYear
        },
        dataType: 'JSON',
        success: (d) => {
            if (d.status = 1) {
                populateCardsDash(d.data)
            }
        },
        beforeSend: (b) => {
            
        },
        complete: (c) => {},
        error: (e) => { 
            console.log(e) 
        }
    });
}

function populateCardsDash(data) {
    $("#totalTickets").text(data.totalTickets);
    $("#myTickets").text(data.myTickets);
    $("#openTickets").text(data.myOpenTickets);
}

function loadChartTickets(monthYear) {
    
    $.ajax({
        url: BASE_URL + '/Ticket/getTicket',
        type: "GET",
        data: {
            monthYear: monthYear
        },
        dataType: 'JSON',
        success: (d) => {
            if (d.status = 1) {
                geraChartLine(d.data.categories, d.data.data, `Total Tickets Opened per Day`);
            }
        },
        beforeSend: (b) => {},
        complete: (c) => {},
        error: (e) => { 
            console.log(e) 
        }
    });
}

function loadTableTickets() {
    tableTickets = $(`#tableTickets`).DataTable({
        sPaginationType: "full_numbers",
        destroy: true,
        searching: true,
        responsive: false,
        language: translateTable(),
        order: [[0, "DESC"]],
        ajax: {
            "url": BASE_URL + 'Ticket/getTickets',
            "dataType": "json",
            "cache": false
        },
        lengthChange: false,
        pageLength: 50,
        columns: [
            {
                data: "cod"
            },
            {
                data: "inicio"
            },
            {
                data: "nome_cliente"
            },
            {
                data: "descricao"
            },
            {
                data: "andamento",
                class: "text-center"
            },
            {
                data: "prioridade",
                class: "text-center"
            },
            {
                data: "nome_tipo"
            },
            {
                data: "nome_modulo"
            },
            {
                data: "nome_atendente"
            }
        ],
        dom: "Bfrtip",
        buttons: [{
            extend: 'collection',
            className: "btn btn-primary mt-2",
            text: '<i class="fa fa-cogs"></i>',
            buttons: [
                {
                    extend: "pdfHtml5",
                    download: 'open',
                    className: 'btn btn-default',
                    text: '<i class="fa fa-file-pdf"></i> Exportar PDF',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function (doc) {
                        doc.pageMargins                  = [10, 10, 10, 10];
                        doc.content[1].table.widths      = ['10%', '35%', '20%', '25%', '15%'];
                        doc.styles.tableHeader.alignment = 'left';    
                    }
                }, {
                    extend: "excelHtml5",
                    className: 'btn btn-default',
                    text: '<i class="fa fa-file-excel"></i> Exportar Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ],
        }],
        createdRow: function (row, data) {
            
            if (data.prioridade < 3) {
                $('td', row).eq(5).css('background', '#79a7d0').css('color', '#fff');
            } else {
                $('td', row).eq(5).css('background', '#f64f5c').css('color', '#fff');
            }

            switch (data.andamento) {
                case "0": $('td', row).eq(4).css('background', '#dc8512').css('color', '#fff'); break;
                case "1": $('td', row).eq(4).css('background', '#64738F').css('color', '#fff'); break;
                case "2": $('td', row).eq(4).css('background', '#514cf7').css('color', '#fff'); break;  
                case "3": $('td', row).eq(4).css('background', '#f6c763').css('color', '#fff'); break;
                case "4": $('td', row).eq(4).css('background', '#2ecc71').css('color', '#fff'); break;
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
                    switch (data) {
                        case "0": return "Aguardando Atribuição";
                        case "1": return "Atribuído";
                        case "2": return "Em Execução";
                        case "3": return "Parado";
                        case "4": return "Encerrado";
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

    // Adicionando inputs para pesquisa 
    $('#tableTickets .filtros th').each(function () {
        $(this).html('<input type="text" style="width: 100% !important;height: 24px !important; margin-bottom: 4px !important; border-radius: 3px !important" class="form-control hidden-xs" placeholder=""/>');
    });

    // Aplicando a busca no evento
    tableTickets.columns().eq(0).each(function (indice) {
        $('input', $('.filtros th')[indice]).on('keyup change', function () {
            tableTickets.column(indice).search(this.value).draw();
        });
    });

    $('.dataTables_filter').css('display', 'none');

    $(`#tableTickets tbody`).on('click', 'td', function() {

        let tr  = $(this).closest('tr');
        let row = dtTable.row(tr);
    });
}